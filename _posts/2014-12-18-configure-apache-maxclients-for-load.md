---
layout: post
title: Configuring Apache MaxClients setting for load
---

## Update 10 Oct 2015

I found a really good post about Apache and MaxClients at servercheck.in. [https://servercheck.in/blog/3-small-tweaks-make-apache-fly](https://servercheck.in/blog/3-small-tweaks-make-apache-fly). It contains very good explanation of how maxclients works and how to calculate your settings. I recommend you check it out instead of reading this post.


### Following post is obsolete. A much better explanation is given in link mentioned above

Setting up some tools, properly on Linux distributions can save you a lot of resources and boost performace. Apache is no exception. Properly configuring it is important.

[Read apache docs](http://httpd.apache.org/docs/2.0/mod/mpm_common.html) for explanation of config parameteres discussed here (MaxClients and KeepAlive).

Apache on a server I was managing kept on going down randomly for a few minutes and getting back up several times in a day. There was no graceful restart message in logs. After some  googling I found this command on some forum.

{% highlight bash %}
	grep -i "maxclients" /usr/local/apache/logs/error.log
{% endhighlight %}

This command showed this message:

*MaxClients limit reached consider updating your maxclients setting*

Seems like this was our problem.


So I opened WHM, apache config editor and checked maxclients setting, that's a lot, but keepalive timeout, another setting was too high (set to 30 secs). That's what was causing problems. So I tweaked some stuff and set the config as following:

![Apache WHM maxclient Settings](/public/images/apache-whm-maxclients-settings.png)

Then restarted apache and voillaa! No more maxclients error and apache runs much smoothly with much lower memory consumption. 

Moral is read documentation of software you use and think and reason about configuration values you set. Don't just put random numbers in configuration. You will sooner or later face a disaster.