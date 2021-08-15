---
layout: post
title: Finding errors in Go's http client
---

Recently while writing code for a Kubernetes Operator interacting with an external API, I was asked to only retry in specific scenarios such as DNS lookup failure and timeouts. Since many things can go wrong in DNS, the net package may return different error messages depending on what exactly happened.

Here is the error hierarchy I could find by digging into `net` package in core libs:

```go
	*url.Error:
		*net.OpError:
			*net.AddrError:
			*net.DNSError:
				// do something more here
			*net.InvalidAddrError:
			*net.ParseError:
			*net.UnknownNetworkError:
			*os.SyscallError:
				// syscall errors
```

This is not even an exhaustive list. What about errors which are not exposed such as `*http.httpError` or `addrinfoErrno` or `*timeoutError` or the errors which do not have an underlying type at all and are just strings.

To help with determining nested types and retrying on specific ones, I created a function which checks status code, error content and type to determine whether error is retriable or not:

```go
func apiError(err error, response *http.Response) error {
	statusCode := 0
	if response != nil {
		statusCode = response.StatusCode
	}
	retry := anyStrMatches(retriableErrors, err.Error()) || intContains(retriableStatusCodes, statusCode)
	if !retry {
		var dnsErr *net.DNSError
		if errors.As(err, &dnsErr) {
			retry = true
		}
	}
	var apiErr error
	apiErr = &ApiErr{
		err,
		statusCode,
		response,
	}
	if retry {
		apiErr = fmt.Errorf("retriable error: %w", &RetriableErr{apiErr})
	}
	return fmt.Errorf("%w", apiErr)
}
```

This relies on Go 1.13's `errors.As` function to see if err has DNSError wrapped somewhere in the hierarchy. It also matches error message with given substrs and check if status code is in list of retriable status codes.

Here is example usage of this function:

```go
client := http.Client{
		Timeout: 1 * time.Second,
	}
resp, err := client.Get("https://httpstat.us/200?sleep=5000")
err = apiError(err, resp)
fmt.Println(err)
var retriableErr *RetriableErr
if errors.As(err, &retriableErr) {
	fmt.Println("you should retry")
}
```

This ended up working really well for my needs. A full example of above code is available in this Go Playground : [https://play.golang.org/p/z1kr9c0isF-](https://play.golang.org/p/z1kr9c0isF-).