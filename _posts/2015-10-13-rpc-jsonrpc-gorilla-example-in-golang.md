---
layout: post
title: RPC, JSON-RPC examples in Golang
---

I discussed about [RPC for message passing](/2015/10/12/rpc-for-message-passing-in-distributed-systems) in last post. Here we take a practical look at it using golang, my favorite language nowadays.

Source code of all examples described here is available at <a href="https://github.com/haisum/rpcexample" rel="nofollow">https://github.com/haisum/rpcexample</a>. Documentation for Go net/rpc is available at [godocs for net/rpc](https://godoc.org/net/rpc). Documentation for gorilla rpc/json package is available at [http://www.gorillatoolkit.org/pkg/rpc/json](http://www.gorillatoolkit.org/pkg/rpc/json).

## Examples:
- [Defining service object and method](#rpc-object)
- [RPC server using Golang net/rpc package](#rpc-server)
- [RPC client using Golang net/rpc package](#rpc-client)
- [JSON-RPC server using Golang gorilla/rpc/json package](#jrpc-server)
- [JSON-RPC client using Golang gorilla/rpc/json package](#jrpc-client)
- [JSON-RPC client using Python](#jrpc-client-python)

### <a name="rpc-object"> Defining service object and method </a>

Golang registers rpc service with an Object with a method that satisfies following conditions:

	1- The method is exported.
	2- The method has two arguments, both exported (or builtin) types.
	3- The method's second argument is a pointer.
	4- The method has return type error.

Name of the service is object's type.

Let's define such object.

{% highlight go %}
//Represents Arith service for RPC
type Arith int
//Arith service has procedure Multiply which takes numbers A, B as arguments and returns error or stores product in reply
func (t *Arith) Multiply(args *Args, reply *int) error {
        *reply = args.A * args.B
        return nil
}
{% endhighlight %}

We need to define an Args type struct which holds arguments passed to method

{% highlight go %}
type Args struct {
    A, B int
}
{% endhighlight %}

Let's move all this code to a package so we can re-use it in examples.

{% highlight go %}

package rpcexample

import (
	"log"
)

//Holds arguments to be passed to service Arith in RPC call
type Args struct {
	A, B int
}

//Representss service Arith with method Multiply
type Arith int

//Result of RPC call is of this type
type Result int

//This procedure is invoked by rpc and calls rpcexample.Multiply which stores product of args.A and args.B in result pointer
func (t *Arith) Multiply(args Args, result *Result) error {
	return Multiply(args, result)
}

//stores product of args.A and args.B in result pointer
func Multiply(args Args, result *Result) error {
	log.Printf("Multiplying %d with %d\n", args.A, args.B)
	*result = Result(args.A * args.B)
	return nil
}
{% endhighlight %}

### <a name="rpc-server">RPC server using Golang net/rpc package </a>

{% highlight go %}

package main

import (
	"github.com/haisum/rpcexample"
	"log"
	"net"
	"net/http"
	"net/rpc"
)

func main() {
	//register Arith object as a service
	arith := new(rpcexample.Arith)
	err := rpc.Register(arith)
	if err != nil {
		log.Fatalf("Format of service Arith isn't correct. %s", err)
	}
	rpc.HandleHTTP()
	//start listening for messages on port 1234
	l, e := net.Listen("tcp", ":1234")
	if e != nil {
		log.Fatalf("Couldn't start listening on port 1234. Error %s", e)
	}
	log.Println("Serving RPC handler")
	err = http.Serve(l, nil)
	if err != nil {
		log.Fatalf("Error serving: %s", err)
	}
}
{% endhighlight %}

### <a name="rpc-client"> RPC client using Golang net/rpc </a>

{% highlight go %}
package main

import (
	"github.com/haisum/rpcexample"
	"log"
	"net/rpc"
)

func main() {
	//make connection to rpc server
	client, err := rpc.DialHTTP("tcp", ":1234")
	if err != nil {
		log.Fatalf("Error in dialing. %s", err)
	}
	//make arguments object
	args := &rpcexample.Args{
		A: 2,
		B: 3,
	}
	//this will store returned result
	var result rpcexample.Result
	//call remote procedure with args
	err = client.Call("Arith.Multiply", args, &result)
	if err != nil {
		log.Fatalf("error in Arith", err)
	}
	//we got our result in result
	log.Printf("%d*%d=%d\n", args.A, args.B, result)
}
{% endhighlight %}

### <a name="jrpc-server"> JSON RPC server using gorilla rpc/json </a>

Gorilla kit has rpc package to simplify default net/rpc/jsonrpc package. Slight difference form standard golang `net/rpc` is that it requires method signature to accept *Request object as first argument and changes Args parameter to pointer *Args.

In `net/rpc` our Multiply method looks like `func (t *Arith) Multiply(args Args, result *Result) error`. For gorilla it should look like `func (t *Arith) Multiply(r *http.Request, args *Args, result *Result) error`.

{% highlight go %}
package main

import (
	"github.com/gorilla/mux"
	"github.com/gorilla/rpc"
	"github.com/gorilla/rpc/json"
	"log"
	"net/http"
)

type Args struct {
	A, B int
}

type Arith int

type Result int

func (t *Arith) Multiply(r *http.Request, args *Args, result *Result) error {
	log.Printf("Multiplying %d with %d\n", args.A, args.B)
	*result = Result(args.A * args.B)
	return nil
}

func main() {
	s := rpc.NewServer()
	s.RegisterCodec(json.NewCodec(), "application/json")
	s.RegisterCodec(json.NewCodec(), "application/json;charset=UTF-8")
	arith := new(Arith)
	s.RegisterService(arith, "")
	r := mux.NewRouter()
	r.Handle("/rpc", s)
	http.ListenAndServe(":1234", r)
}

{% endhighlight %}

### <a name="jrpc-client"> JSON RPC client using gorilla rpc/json</a>

This one's tricky. Gorilla doesn't give us proper client implementation. It just gives us methods to encode and decode json rpc messages. So we have to take care of making HTTP requests ourselves. I know this is dirty code, but you can re-factor it for your needs.

{% highlight go %}
package main

import (
	"bytes"
	"github.com/gorilla/rpc/json"
	"github.com/haisum/rpcexample"
	"log"
	"net/http"
)

func main() {
	url := "http://localhost:1234/rpc"
	args := &rpcexample.Args{
		A: 2,
		B: 3,
	}
	message, err := json.EncodeClientRequest("Arith.Multiply", args)
	if err != nil {
		log.Fatalf("%s", err)
	}
	req, err := http.NewRequest("POST", url, bytes.NewBuffer(message))
	if err != nil {
		log.Fatalf("%s", err)
	}
	req.Header.Set("Content-Type", "application/json")
	client := new(http.Client)
	resp, err := client.Do(req)
	if err != nil {
		log.Fatalf("Error in sending request to %s. %s", url, err)
	}
	defer resp.Body.Close()

	var result rpcexample.Result
	err = json.DecodeClientResponse(resp.Body, &result)
	if err != nil {
		log.Fatalf("Couldn't decode response. %s", err)
	}
	log.Printf("%d*%d=%d\n", args.A, args.B, result)
}
{% endhighlight %}

### <a name="jrpc-client-python"> JSON RPC client using Python</a>

We can call JSON-RPC server written with gorilla rpc/json in golang from python.

{% highlight python %}
import urllib2
import json


def rpc_call(url, method, args):
	data = json.dumps({
	    'id': 1,
	    'method': method,
	    'params': [args]
	}).encode()
	req = urllib2.Request(url, 
		data, 
		{'Content-Type': 'application/json'})
	f = urllib2.urlopen(req)
	response = f.read()
	return json.loads(response)

url = 'http://localhost:1234/rpc'
args = {'A': 1, 'B': 2}
print rpc_call(url, "Arith.Multiply", args)
{% endhighlight %}