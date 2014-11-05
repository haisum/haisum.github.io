---
layout: post
title: Bitter Truth - There's no such thing as SEO
---

I have worked for some big web development companies and search engine optimization for them and their clients seems to be a holy playground where they spend most of time and resources in. Approach mostly focuses on generating keyword focused content by either crawling from others and paraphrasing or asking team of writers to write useless content. Many classified, coupons, B2B, and C2C sites have dumped content from other sites which is paraphrased so that they could get away with content duplication penalty by search engines. Moreover, this dumped content gives them some more weightage in search results due to more targeted content.

These arguably black hat SEO approaches look good temporarily but lead to many problems in the long run if you are planning for a big scalable website. As you grow, it becomes harder to distinguish between geniune user generated content and your own fake dumped data. Since dumped data doesn't necessarily have all necessary attributes available, it becomes a nightmare for developers and database admins to manage.

As an example of such nightmares developed by such data, lets assume we have a tables company and country such as:

{% highlight sql %}
CREATE TABLE `country` (
  `country` varchar(255) NOT NULL DEFAULT '',
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `iso2` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `company`(
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`company_name` varchar(255) NOT NULL DEFAULT '',
	`country_id` int(10) NOT NULL ,
	PRIMARY KEY (`id`)
)  ENGINE=InnoDB DEFAULT CHARSET=latin1;
{% endhighlight %}

Now we dump this csv data crawled from different sources in company table:

```
Sample Company 1, 230
Sample Company 2,
Sample Company 3, 34
Sample Company 4,
```

Note that company 2 and company 4 has missing country. More than often you would encounter cases where crawled data has important missing fields.

 *To be continued ...*