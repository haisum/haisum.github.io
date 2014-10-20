---
layout: post
title: How I used Jekyll and Github to make this simple blog
---

I had heard a lot of buzz on internet about [Jekyll](http://jekyll.rb) and how simple it was, but for some reason didn't have enough time or reason to explore it. On last weekend I finally decided to give it a try and I must say I am very very impressed with the simplicity of Jekyll and awesomeness of [github pages](https://pages.github.com/).

It might seem hectic in setting up, but trust me when you set it up succesfully you will realize how simple all this really is, so go ahead:

### For Pros

Here's what I did to put together this blog:

- Install necessary tools (I was using ubuntu so here's what I needed):
	{% highlight bash %}

		sudo apt-get install git
		sudo apt-get install ruby ruby-dev

	{% endhighlight %}
- Follow instructions for setting up repository on [github pages](https://pages.github.com/)
- Follow [Using jekyll with GitHub pages](https://help.github.com/articles/using-jekyll-with-pages/) guide.
- Use awesome [Lanyon](https://github.com/poole/lanyon) theme for jekyll.

### For Dummies

If all these intructions are jumble to you here's an easier set:

 - Install git on your system. (Google is your friend if you want to know how to)
 - Follow instructions at [github pages](https://pages.github.com/) (You can do it)
 - Clone your git repo in your local system by either running `git clone https://github.com/username/username.github.io.git` where *username* is your username or using [windows github client](https://windows.github.com/).
 - Download my repository in zip format from [this link](https://github.com/haisum/haisum.github.io/archive/master.zip).
 - Extract all contents of my repository to your repository's folder.
 - cd to your repository's folder and run these:
 	{% highlight bash %}

	 	rm *.*
	 	git add -A
	 	git commit . -m "Adding templates and first Jekyll post"
	 	git push origin master
 	
 	{%endhighlight%}
 - It might ask you password/email and username so do provide it if asked.
 - Once push is succesfull, you will be able to see my blog on yourusername.github.io
 - Edit files in _layout, _includes and about.md to add your own details
 - Make/Remove files in _posts folder with year-month-date-post-name.md format to add posts
 - Details of .md format can be found at [Kramdown](http://kramdown.gettalong.org/quickref.html)