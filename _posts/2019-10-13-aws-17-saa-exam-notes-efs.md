---
layout: post
title: AWS SAA Certification Exam Notes - EFS
---

- NFS share mount
- Can be mounted to multiple EC2 instances unlike EBS which can only be used on one at a time - Stores data in Multi AZ
- Can mount to on-premise using Direct Connect and VPN 
- To access your EFS file system in a VPC, you create one or more mount targets in the VPC. A mount target provides an IP address for an NFSv4 endpoint.
- You can create one mount target in each Availability Zone in a region.
- You mount your file system using its DNS name, which will resolve to the IP address of the EFS mount target. Format of DNS is File-system-id.efs.aws-region.amazonaws.com 
- Up to thousands of EC2 instances, from multiple AZs, can connect concurrently to a file system. - On Windows, can’t be mounted as drive. But can be mounted as folder.

### Exam Tips

- EFS \!= S3. Don’t select EFS when asked for S3 enabled service.

### References

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-efs/](https://www.google.com/url?q=https://tutorialsdojo.com/aws-cheat-sheet-amazon-efs/&sa=D&ust=1570987253674000) 

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-s3-vs-ebs-vs-efs/](https://www.google.com/url?q=https://tutorialsdojo.com/aws-cheat-sheet-amazon-s3-vs-ebs-vs-efs/&sa=D&ust=1570987253674000)