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

### Cloudwatch

Cloudwatch enhanced metrics vs Cloud watch default metrics vs Custom Agent installed on EC2 vs Modifying application so it sends metrics itself were all tested in different scenarios.

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

Got some scenario based questions on using Bastion Host. Got one question on VPN. VPC and NAT Gateway came in a lot of scenario based questions. So you really want to know your VPC and related services.

### Gateway and Interface Endpoints

Know that Gateway endpoints are used for DynamoDB and S3. Interface endpoints for rest. Also, understand their functionality. I got at least two questions on these two.

### ALB server access logs and Cloudwatch metrics

One question required understanding of Access Logs for ALB vs Cloudwatch metrics for ALB. Understand difference between two. What would you use if you wanted connection counts vs access requests?

### SNI and ALB/NLB SSL certificate setup

Got a question on registering multiple domains on load balancer. Another required undertsnading of complete in-transit SSL and SSL setup on ALB and Network load balancer.

### VM Import/Export

One question involved VM import/export from on premises DC to VPC.

### Cross Region Aurora and RDS Auth

I got questions on when we should use Aurora. Also got one question regarding IAM DB Auth. RDS read replicas, snapshots, daily backups were asked about during exam.

### Elasticache Auth with Redis

One question was about how you would authenticate requests with Redis so that's good to know.

### Dynamodb

Dynamodb was covered more than any other serverless technologies. Good to know Cross region dynamodb features. Know about global indexes/secondary indexes. WCU and RCU. Dynamic Scaling vs Manual throughput provisioning.

### EBS Volume Types

General purpose SSD, Provisioned IOPs, Throughput optimized HDD, Cold HDD are covered in several scenario based questions so know when to use which. I got one about Cold HDD and another about provisioned IOPs.

### Disaster recovery

Read disaster recovery whitepaper. Know difference between RPO, RTO. Also understand Multi Site vs Pilot Light vs Warm Standby. I got couple of questions from this whitepaper.

### Lambda@Edge

Just understand what it is and it's use case. I got a straight forward scenario based question and selected this answer.

### Kinesis

Kinesis was covered in much more detail. A lot of scenario based questions had Kinesis as one of options. Know the difference between Firehose vs Data Streams. Also understand where can kinesis store data. Kinesis was also compared with FIFO and Standard SQS for sequential data processing of large sized queues so it's important that you understand differences.

### SQS vs Lambda for fault tolerant systems

A lot of scenarios required understanding difference between SQS and Lambda for fault tolerant and asynchronous systems. So knowing when to use which is important.

### Conclusion

Even though we need to cover a lot and at times it seems overwhelming, exam doesn't really go in depth for any of the topics. You do need to understand S3, EC2, VPC, SQS in a bit of depth but Lambda, API Gateway, Kinesis Elasticache, Cloudformation just required knowing what each of they do and when to use them. I studied all of them in a lot of depth which I felt was a little too much effort.