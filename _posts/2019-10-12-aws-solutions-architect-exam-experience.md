---
layout: post
title: My Experience Giving AWS Solutions Architect Associate Exam
---

I gave exam on Oct, 09, 2019 and passed with 924/1000 score. I would like to share kind of questions I got here. I can't go into specifics about it since it may violate exam code of conduct but I guess I could still share what areas I got questions from so future candidates for exam can focus more on those areas.

### IAM

I got some questions on Roles. IAM DB Authentication for RDS also came in exam. There weren't any policy related questions I can recall. IAM was often mixed with other services so there weren't a lot of questions dedicated to IAM.

### S3 

Make sure you know what are differences between S3 Standard, S3 IA, S3 IA One Zone, Glacier and Deep archive. I got questions on transitioning between these storage classes using lifecycle policies.

I got at least one question regarding S3 encryption. So you should know KMS, Server Side and Client Side encryption.

I got questions on versioning as well as cross region replication.

S3 is major part of exam and should be covered in detail.

One question gave a scenario with static website and asked whether I should choose Lambda and AI Gateway or S3 static website hosting.

### Lambda

Despite people saying Lambda is big part of exam, I surprisingly didn't get a lot of questions on it. Most questions on Lambda required just basic understanding of what it is and how it works with API gateway and when will you use it. Most questions about lambda gave choice between SQS, Kinesis, S3 static website and Lambda based on scenarios.

### EC2 Tenancy Options

A lot of questions gave choices between Spot, Reserved and On Demand instances so you should be very well versed in usage scenarios of these tenancy options. These questions were mixed with Auto Scaling so read up on that too.

### Cloudfront origins

Got questions on cloudfront, signed URLs and setting origins so Cloudfront was also covered in exam.

### Route 53 vs ALB 

Route 53 was really not part of exam. I do remember one question giving choice between ALB and Route 53 so you should know when to use either of those services.

### Autoscaling types Scheduled vs Step 

Step scaling, target tracking scaling and scheduled scaling came up in couple of scenario questions. So do know what are differences between these.

### Cloudformation and ElasticBeanStalk

Elastic Beanstalk came in at least couple of questions. One question wanted me to pick between two for VPC automation. Another gave choice between importing VM or using Elastic Beanstalk. So you should know when can we use it. Cloudformation didn't come in detail. As long as you know what it is and its' use cases, you should be fine.

### Redshift

Redshift came a lot. I got at least 5 questions with redshift as choice. Know Redshift Spectrum use cases and that Redshift is great for datawarehousing and OLAP workloads. Cross region replication of cluster and S3 async backup for redshift also came in exam.

### VPC, NAT Gateway, and Bastion Host

Got some scenario based questions on using Bastion Host. Got one question on VPN. VPC and NAT Gateway came in a lot of scenario based questions.


### Gateway and Interface Endpoints


### ALB server access logs and Cloudwatch metrics


### SNI and ALB/NLB SSL certificate setup


### VM Import/Export


### Cross Region Aurora and RDS Auth


### Elasticache Auth with Redis


### Dynamodb

### EBS Volume Types


### Disaster recovery


### Lambda@Edge


### Kinesis

### SQS vs Lambda for fault tolerant systems