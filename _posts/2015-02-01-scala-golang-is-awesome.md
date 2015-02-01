---
layout: post
title: Golang, programming language made in heavens
---

In past few months, I have been learning a lot of stuff. First I started learning Scala from coursera, but due to its functional style and strong Java like feeling it didn't interest me much and bored me so I left out for something more interesting to explore. Next in my list of to be explored things was Google's golang. 

What a beautiful craft by engineers at Google! One of brains behind Go is [Ken Thompson](http://en.wikipedia.org/wiki/Ken_Thompson), original designer and implementor of Unix. He also created B language which was inspiration for C language by Dennis Ritchie. Simplicity was inevitable as the creator of Unix himself was designing the language. The moment I landed on home page of golang I knew I would stick around much longer than I sticked to scala. Go felt like all good parts of modern languages plus the power of C/C++ in one language.

Official [Tour of Go](http://tour.golang.org/) is step by step interactive guide for language. It was easy and very very interesting to follow. I finished it in a few hours.

As an example of simplicity and power of language consider this code, which creates simple web server and listens for requests:

```go
package main

import (
	"fmt"
	"log"
	"net/http"
)

type Hello struct{}

func (h Hello) ServeHTTP(
	w http.ResponseWriter,
	r *http.Request) {
	fmt.Fprint(w, "Hello!")
}

func main() {
	var h Hello
	err := http.ListenAndServe("localhost:4000", h)
	if err != nil {
		log.Fatal(err)
	}
}

```

Standard library is very good and comprehensive. Documentation is awesome and plugin SublimeGo tightly integrates with sublime text to fill in the gaps of a robust IDE.

Two things impress me the most about language, one is ability to compile code into binaries. Distributing applications with requirements such as specific versions of Python, Ruby or PHP and their pakcages, is frustrating. Go, on the other hand, compiles code in binary and binds all libararies statically so you have one file that runs all on its own on any OS for which it is compiled.

Second is how ridiculously easy Go makes us use the power of concurrent programming. Write "go" before any statement in golang and it runs in a separate go routine (an optimized form of thread). Channels make it even easier to communicate between separate parallel routines. To checkout Go's power of concurrent programming follow great series of articles at [Go By Example](https://gobyexample.com/goroutines).

Other awesome golang features are:


- Static typing (This actually makes you write better code)
- Static library linking and no requirement for binary distribution
- Good package manager (go get)
- Official code formatting tool (so we don't have dozens of formatting standards)
- Big growing community and awesome docs

When I learn new technology, I try to find what others are doing with those with that technology. And best place to find what people are doing in a particular programming language is [github trending](https://github.com/trending?l=go) page for languages. Go follow that link and see how many diverse and interesting projects beyond mainstream web apps are being built with Golang. In my research for Go, I landed on Docker. It was another amazing technology that I learnt, we will talk about Docker some other day. Till then, learn Go. It's really really good.