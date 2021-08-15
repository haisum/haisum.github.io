---
layout: post
title: Finding errors in Go's http client
---

In Go, errors are values. Rob Pike has a [Go blog post](https://blog.golang.org/errors-are-values) explaining the reasons behind this. Regardless of whether someone likes this decision or opposes it, the people who have spent significant time programming in Golang would agree distinguishing between different types of errors is a huge PITA. Yes, you can type cast, find out underlying nested error type, and perform some action based on that but that requires much more code and added complexity than a language like Java where you could just catch the exceptions you are interested in. Also, it is completely upto the author of library if they even want to declare a dedicated type for error. They could just create a generic error with string and call it a day. Then it is on user to perform actions based on string returned in error.

Recently while writing code for a Kubernetes Operator interacting with an external API, I was asked to only retry in specific scenarios such as DNS lookup failure and timeouts. Since many things can go wrong in DNS, the net package may return different error messages depending on what exactly happened. In this situation, one either has to collect a list of all strings returned due to DNS by digging down in core library or do something like the following: 

```go
switch err.(type) {
	case *url.Error:
		nestedErr := err.(*url.Error).Err
		switch nestedErr.(type) {
		case *net.OpError:
			opError := nestedErr.(*net.OpError).Err
			switch opError.(type) {
			case *net.AddrError:
			case *net.DNSError:
				notfound := strconv.FormatBool(opError.(*net.DNSError).IsNotFound)
				// do something more here
			case *net.InvalidAddrError:
			case *net.ParseError:
			case *net.UnknownNetworkError:
			case *os.SyscallError:
			}
		}
}
```

This is not even an exhaustive list. What about errors which are not exposed such as `*http.httpError` or `addrinfoErrno` or `*timeoutError` or the errors which do not have an underlying type at all and are just strings.

To help with this situation, I came up with this function:

```go
func getErrorWithType(err, wrappedErr error) (error, error) {
	if wrappedErr == nil {
		wrappedErr = err
	}
	switch err.(type) {
	case *net.DNSError:
		wrappedErr = fmt.Errorf("%T;notfound=%t: %w", err, err.(*net.DNSError).IsNotFound, wrappedErr)
	default:
		wrappedErr = fmt.Errorf("%T: %w", err, wrappedErr)
	}
	if nestedErr := errors.Unwrap(err); nestedErr != nil {
		return getErrorWithType(nestedErr, wrappedErr)
	}
	return err, wrappedErr
}
```

Or an even simpler version of the above function:

```go
func getErrorWithType(err, wrappedErr error) (error, error) {
	if wrappedErr == nil {
		wrappedErr = err
	}
	wrappedErr = fmt.Errorf("%T: %w", err, wrappedErr)
	if nestedErr := errors.Unwrap(err); nestedErr != nil {
		return getErrorWithType(nestedErr, wrappedErr)
	}
	return err, wrappedErr
}
```

This outputs something like this:

```
*net.DNSError;notfound=false: *net.OpError: *url.Error: Get "https://httpstat.us/200?sleep=5000" no route to host

OR

*http.httpError: *url.Error: Get "https://httpstat.us/200?sleep=5000": context deadline exceeded (Client.Timeout exceeded while awaiting headers)

```

It is a recursive function which keeps unwrapping an error until it reaches the root error. Then it returns the final error in the chain alongwith a wrapper error which contains type information for all the types encountered along the way. Now, to retry on all DNS errors, just check for presence of `*net.DNSError` substr in wrapperErr.Error(). If specific information from nested error is required, as I did for DNS Error, a dedicated switch case cane be used in above function without any nested switch because eventually code will reach the level of that error and catch it. If no additional information is required, switch can completely be replaced with one line: `wrappedErr = fmt.Errorf("%T: %w", err, wrappedErr)`

Once exact type and some metadata like in case of DNS error is known, something like following can be written:

```go
retriableErrors = []string{"tls:", "i/o timeout", "*os.SyscallError", "*net.DNSError;notfound=false"}

_, wrapperErr := getErrorWithType(err, nil)
shouldRetry :=  anyStrMatches(retriableErrors, wrapperErr.Error())
fmt.Printf("shouldRetry: %t\n", shouldRetry)

func anyStrMatches(list []string, searchStr string) bool {
	for _, v := range list {
		if strings.Contains(searchStr, v) {
			return true
		}
	}
	return false
}
```

A check on a parent error like `*os.SyscallError` would catch all children of it. It also catches the errors which do not have a type at all. This ended up working really well for my needs. A full example of above code is available in this Go Playground : [https://play.golang.org/p/lutUKBNIwnH](https://play.golang.org/p/lutUKBNIwnH).