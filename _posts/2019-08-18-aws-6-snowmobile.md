---
layout: post
title: AWS - Part 6 - Amazon Snowmobile and Snowball
---

AWS Snowmobile and Snowball are craziest AWS services that I know of. Sometimes it's cheaper and faster for people to just carry your data from your premises to AWS data center. Amazon Snowball and Snowmobile address exactly that. 

Snowball is a device which Amazon sends you by mail. It's capable of storing petabytes of data. You attach this device to your data center, transfer all your data to device and mail it back to Amazon. Amazon attaches this device to their network and transfer it to S3 for you. This is much faster and cheaper than uploading Terabytes of data via internet. For example, uploading 100 TB of data will take more than 100 days to transfer on dedicated 100 MB connection. That same transfer can be accomplished with Snowmobile within a week. Bandwidth costs of large transfer can also easily expand to thousands of dollars. Snowmobile enables that transfer at 1/5th of the original cost. Refer to (Amazon Snowball)(https://aws.amazon.com/snowball/) page for more details.

AWS snowmobile is crazier than Snowball. It enables you to transfer 100 PB of data to Amazon S3. Amazon sends a truck with a container to your data center with people. They setup a switch and connect that between your data center and container. It is then driven back to Amazon where data is transferred to S3. It can optionally include security personnel, GPS tracking, alarm monitoring, 24/7 video surveillance and escort security vehicle in transit. See (Amazon Snowmobile)[https://aws.amazon.com/snowmobile/] page for details.
