---
layout: post
title: Problems with using crawled or auto generated content for SEO
---

I have worked for some big web development companies and search engine optimization for them and their clients seems to be a holy playground where they spend most of time and resources in. Approach mostly focuses on generating keyword focused content by either crawling from others and paraphrasing or asking team of writers to write useless content. Many classified, coupons, B2B, and C2C sites have dumped content from other sites which is paraphrased so that they could get away with content duplication penalty by search engines. Moreover, this dumped content gives them some more weightage in search results due to more targeted content.

These arguably black hat SEO approaches look good temporarily but lead to many problems in the long run if you are planning for a big scalable website. As you grow, it becomes harder to distinguish between geniune user generated content and your own fake dumped data. Since dumped data doesn't necessarily have all necessary attributes available, it becomes a nightmare for developers and database admins to manage.

### Architectural (Programming and database) problems with crawled content 

As an example of nightmares developed by such data, lets assume we have a tables company and country such as:

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

Now lets say if someone searches `Sample Company` in site's search box and listing page has this code:

{% highlight php %}
<?php
$offer_ids = search_in_search_engine("Sample Company");
$query = "SELECT * FROM company WHERE id IN ($offer_ids)";
//... continue other code for search listing page
?>
{% endhighlight %}

and it outputs all dumped data we earlier dumped and user clicks Sample Company 2 so we take them to detail page of Sample Company 2 which has to show company name and other necessary details specific to the company and has following code:

{% highlight php %}
<?php
$query = "SELECT * FROM company cp JOIN country co ON co.id = cp.country_id  WHERE cp.id = " . intval($id);
?>
{% endhighlight %}

Now code is absolutely correct, but if someone sees Sample Company 2 in search listing and clicks it, they will be given a 404 on detail page due to missing entry on country resulting in no data return.

Your developers will hate you and so will your database admins, and finding these bugs would be sometimes very tricky and will make you scratch your head. No matter how much you take care in dumped data, you will eventually create problems in database.

A good solution would be to enforce foreign key relations but MySQL based websites seldom have them enforced. This takes foreign key option out because you wouldn't do that on a live running project, it would require you to correct all previous data. If you are starting from scratch and using InnoDB with MySQL or any other database you must enforce proper relations it will save you from a lot of unexpected behavior.

### Search Engine Algorithm updates

Google and other search engines are becoming smarter day by day. See the [log of Google Updates](https://www.websiteplanet.com/blog/ultimate-beginners-guide-google-analytics/). Many sites are hit by these updates and their rankings are blown off to bottom. Panda update was specifically designed to flushing low quality content sites. No wonder if half of your data is dumped and not unqiue, you will be penalized no matter how much you paraphrase. You can check [Google ngrams](https://books.google.com/ngrams) to have an idea of how Google can catch paraphrased content.

A good site structure with proper seo friendly URLs is a good and white hat approach for getting ranking. But be careful, too much linking may lead to making multiple urls to same content and hence getting penalized for duplicate content. Google's Penguin update was rolled out to tackle low quality links.

### A better way to get traffic

Best and only sane way to get ranking and not getting penalized is to focus on your users rather than on search engines. Retain your users, focus on usability of your site and how users use it rather than crawl rates of crawlers. Build communities. Best sites today are successful because of community they have. This community shall then be encouraged to generate content of their own. Once you have a good community, regular users and they know way through your site, you will have content generated by them. User generated content is way more juicy to search engines than low quality generated content. And most of all, that content is reliable, you can sleep in peace that you will never be penalized for that content. And more content will take you further up in rankings. 

Building community and user generated content is slow procedure, you may have to be patient but that's the only reliable way of SEO. Don't do SEO and build sites for crawlers, make sites for users you will get more happy crawlers there.