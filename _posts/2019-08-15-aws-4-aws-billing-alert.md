---
layout: post
title: AWS - Part 4 - Creating A Billing Alert with Amazon Cloud Watch
---

In this post I will document how to create a billing alert on AWS before we proceed to stuff that costs to use like using S3 or EC2.

First go to your billing dashboard from top navigation.

![Billing-Enable-1](/public/images/aws/Billing-Enable-1.png)

Then click billing preference in left menu.

![Billing-Enable-2](/public/images/aws/Billing-Enable-2.png)

Now click Receive Billing Alerts then click Save Preferences.

![Billing-Enable-3](/public/images/aws/Billing-Enable-3.png)

From services, select CloudWatch.

![CloudWatch-Billing-1.png](/public/images/aws/CloudWatch-Billing-1.png)

From left menu click Billing then click on create alarm.

![CloudWatch-Billing-2.png](/public/images/aws/CloudWatch-Billing-2.png)

Scroll down and select preferred options then put amount. I put 10$ for me.

![CloudWatch-Billing-3.png](/public/images/aws/CloudWatch-Billing-3.png)

Next, create new topic and put your email address in new topic. You will need to click on a link in your email to subscribe to these notifications.

![CloudWatch-Billing-4.png](/public/images/aws/CloudWatch-Billing-4.png)

Once topic is created click next and name your alarm.

![CloudWatch-Billing-5.png](/public/images/aws/CloudWatch-Billing-5.png)

Finally verify all your information, scroll all the way down and click Create alarm.

![CloudWatch-Billing-6.png](/public/images/aws/CloudWatch-Billing-6.png)

Your alarm should be active now.

![CloudWatch-Billing-7.png](/public/images/aws/CloudWatch-Billing-7.png)

