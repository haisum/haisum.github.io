---
layout: post
title: AWS - Part 7 - Amazon CloudFront
---

CloudFront is CDN service offerred by Amazon. I will not go into detail of what CDN is, there should be a lot of resources on web describing what it is and reader should read them. In short, it's one or more servers distributed accross the globe which cache content so users can reach data with least network hops. In terms of CloudFront, these servers are called Edge Locations. There are many more Edge locations than Regions or Zones.

CloudFront provides more functionality than a typical CDN. For example, being an Amazon product, it's integrated well with other services such as S3, ELB, EC2. It can act as transfer accelerator for file uploads. So if somebody is in Australia and wants to upload a file for service hosted in Virginia, they can upload it to Sydney Edge location which will then route that request on optimal network path to Virginia at much faster speed. You can also use Lambda@Edge to run custom code closer to your users and customize user experience. It can also be used for DDoS mitigation with AWS Shield.

Here are some terms that we should be faimilar with:

### Origin

Origin is location where your primary content is available. This may be your S3 bucket, EC2 instance or third party hosted service. When a request is sent to edge location, it fetches content from origin then serves it. On later requests, request is directly served from cached content at edge location. You can also setup redundant origins so if one origin is not available, requests can fallback to another origin.

### Distribution

Using AWS console or API calls, we can register S3 bucket as origin for static files and EC2 instance as origin for dynamic content. We can also define time to live (TTL) and other rules. Once done, we create a "distribution". Once distribution is created, we get a URL such as "abc123.cloudfront.net". This is called distribution domain name.


To be continued...