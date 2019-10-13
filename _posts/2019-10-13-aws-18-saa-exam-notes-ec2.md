---
layout: post
title: AWS SAA Certification Exam Notes - EC2
---

### Exam tips

- Pricing only for Spot, On demand and Reserved instances. No Dedicated.
- If instance shutdown behavior is set to terminate, then instance will terminate regardless of whether termination protection is on.
- EC2 items to monitor
- CPU utilization, Network utilization, Disk performance, Disk Reads/Writes using EC2 metrics
- Memory utilization, disk swap utilization, disk space utilization, page file utilization, log collection using a monitoring agent/CloudWatch Logs
- You can pass two types of user data to EC2: shell scripts and cloud-init directives.
- User data is limited to 16 KB.
- If you stop an instance, modify its user data, and start the instance, the updated user data is not executed when you start the instance.
- Retrieve user data from within a running instance at http://169.254.169.254/latest/user-data 
- AMI = hardware type + OS. Notice: No Licenses
- Instance Type = Storage + CPU + Memory
- When user receives InsufficientInstanceCapacity Error, while launching Ec2, it means that AWS does not currently have enough available capacity to service user request. User can try later or use different AZ.
- Stopping and Starting instance fixes status checker errors because unless you have dedicated instance, it usually starts on a different AWS hardware.
- EC2 is limited to 20 instances for new accounts. Use form for increasing. - Keep Spot instances primary and on demand secondary. On demand only provision when the spot are gone to save costs.

### Instance Types

#### On Demand

fix rate by hour or second

#### Reserved

contract terms 1 or 3 years. provides discount and capacity reservation

#### Spot

Bid on instance capacity. Greater saving for when there's no fix start or end time.

not charged if it's terminated in partial hour by AWS. But if you terminate it, you will be charged

#### Dedicated Host

Can help in using server based license or regulation saying you cant use virtualization

Three tenancy options:

Dedicated Instance

Shared Tenancy

Dedicated Host

### Security Groups

- security group changes are effective immediately
- security groups are stateful i.e outbound and inbound rules apply
- ACLs are stateless they need to be added for both inbound and outbound traffic
- can attach one or more security groups to an instance
- all inbound is blocked
- all outbound is allowed
- Can't block specific IP addresses. Need to use ACLs to do that
- You can allow rules but can't deny rules using security groups

roles are easier to manage and dont store on ec2

are recommended instead of using access key and secret
key

roles are universal

instance store is ephemeral storage. You cant stop
Instance Store volumes, you lose data when it terminates

meta data is available on
169.254.169.254/latest/meta-data 


EFS: shared file system between ec2 instances. Can grow
based on usage. Supports NFSv4. Need to configure security groups
between instances and EFS volume.

### EC2 Placement groups

- Exam tip: Use enhanced networking instances for placement groups

#### Clustered group 

- all instances in one rack
- Low network latency high throughput cant be in multiple AZ
- recommended same instance types

#### Spread group 

- put all instances in different racks
- individual crtical instances can be in multiple AZ

#### Partitioned group

mix of above two. Put N instances on one rack and N on other

can be in multiple AZ


can't merge placement groups and can't move existing
instance to placement group. You can create AMI and then launch instance
in placement group

useful for HDFS/HFS/Cassandra

### References

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-elastic-compute-cloud-amazon-ec2/](https://www.google.com/url?q=https://tutorialsdojo.com/aws-cheat-sheet-amazon-elastic-compute-cloud-amazon-ec2/&sa=D&ust=1570987253682000) 

[https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/building-shared-amis.html](https://www.google.com/url?q=https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/building-shared-amis.html&sa=D&ust=1570987253682000) 

[https://aws.amazon.com/blogs/security/new-attach-an-aws-iam-role-to-an-existing-amazon-ec2-instance-by-using-the-aws-cli/](https://www.google.com/url?q=https://aws.amazon.com/blogs/security/new-attach-an-aws-iam-role-to-an-existing-amazon-ec2-instance-by-using-the-aws-cli/&sa=D&ust=1570987253683000) 

[https://aws.amazon.com/blogs/security/easily-replace-or-attach-an-iam-role-to-an-existing-ec2-instance-by-using-the-ec2-console/](https://www.google.com/url?q=https://aws.amazon.com/blogs/security/easily-replace-or-attach-an-iam-role-to-an-existing-ec2-instance-by-using-the-ec2-console/&sa=D&ust=1570987253683000) 

[https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ec2-instance-metadata.html](https://www.google.com/url?q=https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ec2-instance-metadata.html&sa=D&ust=1570987253684000)

[https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ec2-instance-lifecycle.html](https://www.google.com/url?q=https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ec2-instance-lifecycle.html&sa=D&ust=1570987253684000) 