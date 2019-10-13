---
layout: post
title: AWS SAA Certification Exam Notes - EBS
---

- New EBS volumes receive their maximum performance the moment that they are available and do not require initialization (formerly known as pre-warming). However, storage blocks on volumes that were restored from snapshots must be initialized (pulled down from Amazon S3 and written to the volume) before you can access the block.
- Termination protection is turned off by default and must be manually enabled (keeps the volume/data when the instance is terminated)
- Different types of storage options: General Purpose SSD (gp2), Provisioned IOPS SSD (io1), Throughput Optimized HDD (st1), and Cold HDD (sc1) volumes up to 16 TiB in size.
- Volumes are created in a specific AZ, and can then be attached to any instances in that same AZ. To make a volume available outside of the AZ, you can create a snapshot and restore that snapshot to a new volume anywhere in that region.
- You can detach an EBS volume from an instance explicitly or by terminating the instance. However, if the instance is running, you must first unmount the volume from the instance.
- You can use AWS Backup, an automated and centralized backup service, to protect EBS volumes and your other AWS resources. AWS Backup is integrated with Amazon DynamoDB, Amazon EBS, Amazon RDS, Amazon EFS, and AWS Storage Gateway to give you a fully managed AWS backup solution.

### Types of EBS Volumes

#### General Purpose SSD (gp2)

- Base performance of 3 IOPS/GiB, with the ability to burst to 3,000 IOPS for extended periods of time.
- Support up to 10,000 IOPS and 160 MB/s of throughput.

#### Provisioned IOPS SSD (io1)

- Designed for I/O-intensive workloads, particularly database workloads, which are sensitive to storage performance and consistency.
- Allows you to specify a consistent IOPS rate when you create the volume
- Max IOPS: 32000

An io1 volume can range in size from 4 GiB to 16 TiB. You can provision from 100 IOPS up to 64,000 IOPS per volume on Nitro system instance families and up to 32,000 on other instance families. The maximum ratio of provisioned IOPS to requested volume size (in GiB) is 50:1.

For example, a 100 GiB volume can be provisioned with up to 5,000 IOPS. On a supported instance type, any volume 1,280 GiB in size or greater allows provisioning up to the 64,000 IOPS maximum (50 × 1,280 GiB = 64,000).

An io1 volume provisioned with up to 32,000 IOPS supports a maximum I/O size of 256 KiB and yields as much as 500 MiB/s of throughput. With the I/O size at the maximum, peak throughput is reached at 2,000 IOPS. A volume provisioned with more than 32,000 IOPS (up to the cap of 64,000 IOPS) supports a maximum I/O size of 16 KiB and yields as much as 1,000 MiB/s of throughput.

Therefore, for instance, a 10 GiB volume can be provisioned with up to 500 IOPS. Any volume 640 GiB in size or greater allows provisioning up to a maximum of 32,000 IOPS (50 × 640 GiB = 32,000).

#### Throughput Optimized HDD (st1)

- Low-cost magnetic storage that focuses on throughput rather than IOPS.
- Throughput of up to 500 MiB/s.
- Cold HDD (sc1)
- Low-cost magnetic storage that focuses on throughput rather than IOPS.
- Throughput of up to 250 MiB/s.


### Monitoring

Volume status checks provide you the information that you need to determine whether your EBS volumes are impaired, and help you control how a potentially inconsistent volume is handled. List of statuses include:
- Ok – normal volume
- Warning – degraded volume
- Impaired – stalled volume
- Insufficient-data –  insufficient data

### RAID

Some EC2 instance types can drive more I/O throughput than what you can provision for a single EBS volume. You can join multiple gp2, io1, st1, or sc1 volumes together in a RAID 0 configuration to use the available bandwidth for these instances.

For greater I/O performance than you can achieve with a single volume, RAID 0 can stripe multiple volumes together; for on-instance redundancy, RAID 1 can mirror two volumes together.

### Creating Snapshots of Volumes in a RAID Array

If you want to back up the data on the EBS volumes in a RAID array using snapshots, you must ensure that the snapshots are consistent. This is because the snapshots of these volumes are created independently. To restore EBS volumes in a RAID array from snapshots that are out of sync would degrade the integrity of the array.

To create a consistent set of snapshots for your RAID array, use EBS multi-volume snapshots. Multi-volume snapshots allow you to take point-in-time, data coordinated, and crash-consistent snapshots across multiple EBS volumes attached to an EC2 instance. You do not have to stop your instance to coordinate between volumes to ensure consistency because snapshots are automatically taken across multiple EBS volumes.

### Amazon DLM
You can use Amazon Data Lifecycle Manager (Amazon DLM) to automate the creation, retention, and deletion of snapshots taken to back up your Amazon EBS volumes.

### Exam Tips

- Take note that HVM AMIs are required to take advantage of enhanced networking and GPU processing.
- Although the Enhanced Networking feature can provide higher I/O performance and lower CPU utilization to your EC2 instance, you have to use an HVM AMI instead of PV AMI.
- You can perform live migration as long as instance root volume is EBS. Instance store can’t migrate.
- Decreasing the size of an EBS volume is not supported.
- To attach volume attached in one instance to other, detach and attach to other.
- Instance Type = hardware capacity. Instance type has memory, cpu and storage. OS and software loaded is decided by AMI
- Max Volume Size for magnetic tape = 1 TB. for SSD it’s 16 TB.
- Instance started with EBS is faster than instance store. Instance store requires all parts retrieved from S3. EBS only requires stuff for boot before instance is available.
- To avoid initial performance we must warm up volume by reading all blocks
- When you create an EBS volume in an Availability Zone, it is automatically replicated within that zone only to prevent data loss due to a failure of any single hardware component. After you create a volume, you can attach it to any EC2 instance in the same Availability Zone. Note: EBS is single AZ and can tolerate hardware failures but not AZ failure.

### Encryption

how to encrypt root volumes:
- take snapshot
- copy snapshot and encrypt
- create image of snapshot
- then launch ami
- can encrypt at startup
- can share only if volume is unencrypted

There is no direct way to encrypt an existing unencrypted volume, or to remove encryption from an encrypted volume. However, you can migrate data between encrypted and unencrypted volumes.

### References

[https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/raid-config.html#ebs-snapshots-raid-array](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/raid-config.html#ebs-snapshots-raid-array)

[https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ebs-creating-snapshot.html](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ebs-creating-snapshot.html)

[https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/raid-config.html](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/raid-config.html)

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-ebs/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-ebs/)

[https://aws.amazon.com/blogs/aws/new-infrequent-access-storage-class-for-amazon-elastic-file-system-efs/](https://aws.amazon.com/blogs/aws/new-infrequent-access-storage-class-for-amazon-elastic-file-system-efs/)
[https://docs.aws.amazon.com/efs/latest/ug/limits.html](https://docs.aws.amazon.com/efs/latest/ug/limits.html)
