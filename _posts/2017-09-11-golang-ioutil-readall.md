---
layout: post
title: Be careful with ioutil.ReadAll in Golang
---

[ioutil.ReadAll](https://golang.org/pkg/io/ioutil/#ReadAll) is a useful io utility function for reading all data from a io.Reader until EOF. It's often used to read data such as HTTP response body, files and other data sources which implement io.Reader interface. Be careful though because a lot can go wrong if you don't take care while using this small seemingly harmless function.

Here's a function which serves a file in response to a http request:

{% highlight go %}

func handle(r *http.Request, w http.ResponseWriter) {
	file, err := os.Open("my_file.zip")
	// error checks...
	b, err := ioutil.ReadAll(file)
	// error checks
	fmt.FPrintf(w, b)
}

{% endhighlight %}

Above looks good, but what if my_file is a big file? You will be loading it all in memory if you used ioutil.ReadAll. Situation becomes even worse when above file is being requested by multiple users in parallel. You will endup with multiple copies of file in memory and will eventually crash due to insufficient memory.

Here's a better version:


{% highlight go %}

func handle(r *http.Request, w http.ResponseWriter) {
	file, err := os.Open("my_file.zip")
	// error checks...
	io.Copy(w, file)
}

{% endhighlight %}

We used [io.Copy](https://golang.org/pkg/io/#Copy) to copy from file which implements io.Reader interface to w ResponseWriter which implements io.Writer interface. io.Copy uses fixed 32KB buffer to copy from reader to writer until EOF. So no matter how big the source is, you'll always just use 32KB to copy it to destination.

[Github search for ioutil.ReadAll in Go code](https://github.com/search?l=Go&q=ioutil.ReadAll&type=Code&utf8=%E2%9C%93) yields 218,674 results at time of this writing. A lot of them are time bombs until they are hit with big reader.

When you have a reader and are going to write to to a io.Writer, prefer io.Copy over ioutil.ReadAll. Some other examples are reading json from db and serving it to HTTP client and fetching file from remote URL and saving it locally. Both these can skip loading every byte in memory before writing it.

I learnt above the hard way after crashing a not so critical in house proxy server. Be careful, and this might save you from crashing something critical.