---
layout: post
title: Finding errors in Go's http client
---

In Go, errors are values. Rob Pike has a [Go blog post](https://blog.golang.org/errors-are-values) explaining the reasons behind this. Regardless of whether someone likes this decision or opposes it, the people who have spent significant time programming in Golang would agree distinguishing between different types of errors is a huge PITA. Yes, you can type cast, find out underlying nested error type, and perform some action based on that but that requires much more code and added complexity than a language like Java where you could just catch the exceptions you are interested in. Also, it is completely upto the author of library if they even want to declare a dedicated type for error. They could just create a generic error with string and call it a day. Then it is on user to perform actions based on string returned in error.

Recently while writing code for a Kubernetes Operator interacting with an external API, I was asked to only retry in specific scenarios such as DNS lookup failure and timeouts. Unfortunately, the errors returned from http.Client are not documented so I had to dig down in code to see what errors it returned and boy what a wild ride it was! Here's what I ultimately came up with:

```go
errMsg = err.Error()
switch err.(type) {
	case *url.Error:
		err += " url.Error"
		nestedErr := e.Err.(*url.Error).Err
		switch nestedErr.(type) {
		case *net.OpError:
			err += "net.OpError"
			opError := nestedErr.(*net.OpError).Err
			switch opError.(type) {
			case *net.AddrError:
				err += "net.AddrError"
			case *net.DNSError:
				err += "net.DNSError;"
				err += "notfound=" + strconv.FormatBool(opError.(*net.DNSError).IsNotFound)
			case *net.InvalidAddrError:
				err += "net.InvalidAddrError"
			case *net.ParseError:
				err += "net.ParseError"
			case *net.UnknownNetworkError:
				err += "net.UnknownNetworkError"
			case *os.SyscallError:
				err += "os.SyscallError"
			}
		}
}
return errMsg
```

Once I have exact type and some metadata like in case of DNS error, I can write something like following:

```go
retriableErrors      := []string{"tls:", "i/o timeout", "net.DNSError;notfound=false", "net.UnknownNetworkError", "os.SyscallError"}
retriableStatusCodes = []int{
		429, 502, 503, 504,
	}

errMsg := getExtendedError(err)
shouldRetry := anyStrMatches(retriableErrors, errMsg) || intContains(retriableStatusCodes, resp.StatusCode)

....


func anyStrMatches(list []string, substr string) bool {
	for _, v := range list {
		if strings.Contains(v, substr) {
			return true
		}
	}
	return false
}

func intContains(list []int, n int) bool {
	for _, v := range list {
		if v == n {
			return true
		}
	}
	return false
}
```

Some errors do not have a concrete exported type so we have to rely on string matching. For example, i/o timeout is represented as *net.timeoutError in net package so it is unexported. I may have missed a few exported errors from above but it does give me more details than were provided by errors returned by default.