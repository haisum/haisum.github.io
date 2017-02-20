---
layout: post
title: Using RPC for message passing in distributed systems
---

My last post discussed about [distributed systems and their problems](/posts/2015/10/08/problems-and-classification-of-distributed-systems). The most important and fundamental requirement in distributed systems is message passing between different processes so they can coordinate on a single task. We want such communication to happen in an standardized and reliable way. Fortunately, because of years of research and real world usage we have a number of reliable protocols to meet our needs. SOAP, Thrift, REST APIs, message queues such as RabbitMQ, key value stores such as Etcd are examples of tools and protocols we may use to enable two processes to communicate. One of reliable and frequently used protocols is RPC. 

## Introduction to RPC

Remote procedure calls aka RPC, as name suggests calls a procedure inside another process running on same or different server by using raw tcp socket or http protocol. Basically, we write a function such that it accepts arguments, does some operation and returns result if it succeeded or error message if  it failed. Then we write some RPC woodoo (read on, we'll discuss *rpc woodoo* later) in our code and register this function as an RPC service. When we start this program it listens and waits for messages on some port. This program will be called our RPC server.

We write another program called client which sends function name and function parameters as a message to IP and Port on which our server is listening. Server receives message, passes arguments, invokes function and returns the result to client. This client may be running *remotely* on any other server, mobile or other device and may connect to server process by network. Hence the client does *remote procedure call*.

Note that RPC and all other protocols for message passing I named earlier, are language independent, it's possible and is frequently found in real world code that client and server processes are programmed in different programming languages. Message passing protocols enable processes written in different programming languages to communicate with each other.

## RPC message formats

Messages we pass from server to client and vice versa need to be in a format such that client and server can both decode and encode data passed from each other. Popular message formats for RPC are JSON and XML. Such communication is called JSON-RPC and XML-RPC for RPC that uses JSON and XML respectively.

### JSON-RPC

In JSON-RPC all messages sent from server or client are valid JSON objects. Client must send JSON object with following keys:

- `method` - Name of method/service
- `params` - Array of arguments to be passed
- `id` - Id is usually integer and makes it easier for client to know which request it got response to, if RPC calls are done asynchroneously.

Server may reply with JSON object with following keys:

- `result` - Contains return value of method called. It's null if error ocurred.
- `error` - If error occurred, this will indicate error code or error message, otherwise it's null
- `id` - The id of the request it is responding to.

Example:

Request: 

`{"method": "Arith.Multiply", "params": [{A: 2, B: 3}], "id": 1}`

Response: 

`{"result": 6, "error": null, "id": 1}`

JSON-RPC v2 adds support for batch queries and notifications (calls which don't require response).

### XML-RPC

XML-RPC was created by a Microsoft employ in 1998. It evolved and became SOAP. It's hard to elaborate it's specifics in this blog post so I recommend you checkout <a href="https://en.wikipedia.org/wiki/XML-RPC" rel="nofollow">XML-RPC wikipedia article</a>. Basic XML-RPC is as simple as JSON-RPC. Our above example for JSON-RPC will look like this in XML-RPC:

Request:

{% highlight xml %}
<?xml version="1.0"?>
<methodCall>
  <methodName>Airth.Multiply</methodName>
  <params>
    <param>
        <value><int>2</int></value>
    </param>
    <param>
        <value><int>3</int></value>
    </param>
  </params>
</methodCall>
{% endhighlight	%}

Response:

{% highlight xml %}

<?xml version="1.0"?>
<methodResponse>
  <params>
    <param>
        <value><int>6</int></value>
    </param>
  </params>
</methodResponse>

{% endhighlight %}


## Other RPC message formats

Other message formats include `SOAP`, which is XML-RPC on steroids. It has support for service discovery which lets clients know what methods are available on RPC server despite having no prior knowledge. `Java RMI` (Remote method invocation) is optimized protocol for message passing within two JVM based programs. Google's `protocol buffers` are optimized protocol for message passing. It reduces size of messages and decreases time it takes for client and server to decode and encode messages, which results in faster response and lower battery/power consumption in mobile devices and web.

List of RPC message formats can be found at <a href="https://en.wikipedia.org/wiki/Remote_procedure_call#Other_RPC_analogues" rel="nofollow">Wikipedia article about RPC</a>. Go ahead, read about each of them. It's cool stuff.