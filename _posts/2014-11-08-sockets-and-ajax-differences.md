---
title: Sockets and Ajax
layout: post
---
A friend asked me following questions so I replied with my understanding about sockets and ajax. It might be useful for others too:

###Sockets vs Ajax.. what are non obvious differences?

- First websockets are not HTTP, http is stateless, classics such as sessions, cookies, put, push, file uploads are done via http. Http is simpler more common easier to understand protocol, ajax is just an http request. 

- Coding is simpler and any modern server would support it, you don't need special language/code to do ajax. Sockets have dependencies and learning curve and maintainability nightmares

###Why exactly do we need sockets if everything can be achieved by ajax?

- Not everything can be achieved without sockets... as a rule of thumb: Always use sockets when there are multiple clients and an act by one client affects ui of other client... Long polling using ajax on classic servers such as apache or nginx is very costly 

- Everything can be achieved with sockets that can be done by ajax, but.. lets say I want to log user clicks on page for analytics, I do it via sockets it will keep the socket open until page closes (I can close after request but that kills the point of a socket). Means even though there's no need to maintain connection I still do maintain it. Imagine I have 1000 users reading different pages on my site I will have to maintain 1000 connections. On other hand, ajax requests come and finish. 1000 connections are worth it, if connection 3rd's state would be altered by connection 998ths actions.

###Why are there so many frontend frameworks like backbone, ember and angular supporting REST and not sockets

- Frontend webframeworks do not care if you use web sockets or ajax (they do bias towards one at a point but u can override that).. These frameworks help us organize our Javascript which gets messy in no time. 

- They support REST, rest is really good way of developing modern web apps. Ideally, rest would be HTTP based, but with some tweaks even sockets can be used. Check https://github.com/scttnlsn/backbone.io . Take an example, backbone sends this request on rest via ajax:
{% highlight js %}
method: "post"
data : {"message" : "hello"}
{% endhighlight %}
With sockets we might send this message:
{% highlight js %}
{"method": "post", "message" : "hello"}
{% endhighlight %}

We can then write a middleware in server code for sockets which strips out method and passes it as http method to classic code and returns response. Easy peasy.. so js frameworks dont relate with ajax or socket io they are meant to organize and help u write better code.

###My Personal Preferences

- Coding in node.js (javascript actually) feels like hipsters. You can't test the code, follow UML models, organize it properly and nobody has made a very big app on top of it. If you discover node.js apps or developers who praise it you will see they develop such tiny apps with fancy user interfaces. It feels as if you want to look cooler use node.js without caring much for what to use when. It's not bad, it's awesome but just know when u have to use it and when not. 
- There are so many ways of doing one thing in javascript that there seems to be no way of standardizing anything. Think of a name, search on google, you will find a javascript library with that name. I won't  be doing big project that's based on small libraries by various individuals. I would rather have one big consistent library from a vendor.

I have similar feelings for ruby, but I doubt I am wrong in that but anyways, that's for another time....