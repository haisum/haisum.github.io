---
layout: post
title: AWS SAA Certification Exam Notes - Cloudfront
---

- CDN service for Amazon
- Uses Edge Locations
- When user request comes, it serves from lowest latency edge location
- Cloudfront distribution is for telling cloudfront which origin servers to fetch objects from and whether it should be enabled as soon as it’s creation. A distribution is then sent to all edge locations.
- You can use lambda@edge to modify content at edge location and perform different operations.
- Can use signed URLs or signed cookies
- Cloudfront origin group can be used for origin failover. You can choose a combination of HTTP 4xx/5xx status codes that, when returned from the primary origin, trigger the failover to the backup origin.
- Cached for 24 hours by default but you can invalidate. Invalidation has charges. First 1000 invalidations are free.
- It’s a global service so to enable logs in Cloudtrail you must enable global services
- With origin access identity feature you can restrict access to S3 so it would only be accessible from cloudfront.
- Field Level Encryption allows users to upload sensitive info like cc numbers to your origin securely with cloudfront.
- Max file size that can be served is 20 GB.
- Can use zone APEX with help of route 53 Alias record.
- You can integrate your CloudFront distribution with AWS WAF, a web application firewall that helps protect web applications from attacks by allowing you to configure rules based on IP addresses, HTTP headers, and custom URI strings. Using these rules, AWS WAF can block, allow, or monitor (count) web requests for your web application. Please see AWS WAF Developer Guide for more information.
- S3 Transfer acceleration can be used to upload faster using cloudfront edge locations
- Signed URLs and Signed Cookies can be used for temporary access to cloudfront urls
- OAI: Origin access identity so users can’t access S3 bucket directly. They can only do so via cloudfront.
- You have to use an Application Load Balancer instead or a CloudFront web distribution to allow the SNI feature.
- Can set failover origins. Can also use cloudfront for on-premises origin.

### References

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-cloudfront/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-cloudfront/)

[https://s3-accelerate-speedtest.s3-accelerate.amazonaws.com/en/accelerate-speed-comparsion.html ](https://s3-accelerate-speedtest.s3-accelerate.amazonaws.com/en/accelerate-speed-comparsion.html )

[https://tutorialsdojo.com/aws-cheat-sheet-s3-pre-signed-urls-vs-cloudfront-signed-urls-vs-origin-access-identity-oai/](https://tutorialsdojo.com/aws-cheat-sheet-s3-pre-signed-urls-vs-cloudfront-signed-urls-vs-origin-access-identity-oai/)

[https://aws.amazon.com/cloudfront/features/ ](https://aws.amazon.com/cloudfront/features/ )

[https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/PrivateContent.html ](https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/PrivateContent.html )

[https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/private-content-signed-urls.html ](https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/private-content-signed-urls.html )

[https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/private-content-signed-cookies.html](https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/private-content-signed-cookies.html)
