---
layout: post
title: AWS SAA Certification Exam Notes - S3
---

### Buckets

-   Name must be unique globally
-   Can create 100 buckets in one account.
-   Can’t change region or name once created
-   Fomat: Host Style: http://bucket.s3-aws-region.amazonaws.com
-   Format: Path Style: http://s3-aws-region.amazonaws.com/bucket

### Consistency

-   Read After Write for new PUTS
-   Eventual for overwrite PUTS and DELETES in all regions

### Storage Classes

#### S3 Standard

For general purpose. Highly redundant and available 99.99% of the time. Durability: 11 9s.

#### S3 RRS 

Reduced redundancy but not recommended because S3 Standard is cheaper.

#### S3 IA
Infrequently Accessed Data. Available 99.9%.

#### S3 IA One Zone

Same as S3 IA but redundancy only in one AZ. Available 99.5%. Durable 11 9s but in one Zone.

These two are good for objects that are more than 128 KB and can be stored for a minimum of 30 days. Otherwise Amazon charges you for one month and 128 KB.

#### Glacier
For archival. Can not specify glacier at object creation time. Must use lifecycle transition with 0 days to immediately transition. Must be at least 6 months storage. That’s what AWS charges for minimum.

##### Glacier Retrieval Options

**Expedited**: Available within 1-5 Minutes
**Standard**: Retrieves within 3-5 hours
**Bulk**: Within 5-12 hours.

Minimum 3 AZ used for standard,d IA and glacier.

### Transfer Acceleration

Transfer Acceleration enables fast, easy, and secure transfers of files over long distances between your client and an S3 bucket. It takes advantage of Amazon CloudFront’s globally distributed edge locations.
Transfer Acceleration cannot be disabled, and can only be suspended.

### Objects

- You can upload and copy objects of up to 5 GB in size in a single operation. For objects greater than 5 GB up to 5 TB, you must use the multipart upload API
- You can associate up to 10 tags with an object. Tags associated with an object must have unique tag keys.

### Security

#### Bucket Policies

- Provides centralized access control to buckets and objects based on a variety of conditions, including S3 operations, requesters, resources, and aspects of the request (e.g., IP address).
- Can either add or deny permissions across all (or a subset) of objects within a bucket.
- IAM users need additional permissions from root account to perform bucket operations.
- Bucket policies are limited to 20 KB in size.
- Can restrict based on time of day, CIDR block range, and by IP address.

#### Access Control Lists

-   A list of grants identifying grantee and permission granted.
-   ACLs use an S3–specific XML schema.
-   You can grant permissions only to other AWS accounts, not to users in your account.
-   You cannot grant conditional permissions, nor explicitly deny permissions.
-   Object ACLs are limited to 100 granted permissions per ACL.
-   The only recommended use case for the bucket ACL is to grant write permissions to the S3 Log Delivery group

### Versioning

-   Need to explicitly enable it
-   When you delete, a delete marker is created
-   Can’t disable versioning
-   Can enable MFA delete
-   For cross region, both sides must have versioning enabled.

### Notifications

Can notify on create/delete or loss of object in RRS to following:

-   SNS
-   SQS
-   Lambda

### Cross Region Replication

-   Both source and destination buckets must have versioning enabled.
-   S3 must have permissions to replicate objects from the source bucket to the destination bucket on your behalf.
-   If the owner of the source bucket doesn’t own the object in the bucket, the object owner must grant the bucket owner READ and READ_ACP permissions with the object ACL.
-   Only copies Objects created after you add a replication configuration.
-   Objects created with server-side encryption using customer-provided (SSE-C) encryption keys are not replicated
-   Objects created with server-side encryption using AWS KMS–managed encryption (SSE-KMS) keys are not replicated by default. You must enable it.
-   You can replicate objects from a source bucket to only one destination bucket.
-   Deletes are not replicated. You must delete versions in both regions. A delete marker is replicated.

### Encryption

-   Server-side Encryption using
    -   Amazon S3-Managed Keys (SSE-S3)
    -   AWS KMS-Managed Keys (SSE-KMS)
    -   Customer-Provided Keys (SSE-C)
-   Client-side Encryption using
    -  AWS KMS-managed customer master key
    -  client-side master key
    -  S3 supports either S3 supplied encryption key or client provided encryption key. For Client provided, user must send encryption key for each API call. S3 never stores client provided key.

### Exam Tips

-   Objects in S3 are stored in different partitions based on name from left to right. To improve performance add random characters at the start of object name to put it in different partitions to improve performance.
-   Domain used for s3 bucket: amazonaws.com
    - http://mynewbucket.s3-aws-region.amazonaws.com
    - http://s3-aws-region.amazonaws.com/mynewbucket
-   Headers have x-amz-\* headers. Note: no x-aws
-   Here are the prerequisites for routing traffic to a website that is hosted in an Amazon S3 Bucket:
    - An S3 bucket that is configured to host a static website. 
    - The bucket must have the same name as your domain or subdomain. For example, if you want to use the subdomain portal.tutorialsdojo.com, the name of the bucket must be portal.tutorialsdojo.com.
    - A registered domain name. You can use Route 53 as your domain registrar, or you can use a different registrar.
    - Route 53 as the DNS service for the domain. If you register your domain name by using Route 53, aws automatically configures Route 53 as the DNS service for the domain.
-   Objects must be stored at least 30 days in the current storage class before you can transition them to STANDARD\_IA or ONEZONE\_IA. For example, you cannot create a lifecycle rule to transition objects to the STANDARD\_IA storage class one day after you create them. Amazon S3 doesn't transition objects within the first 30 days because newer objects are often accessed more frequently or deleted sooner than is suitable for STANDARD\_IA or ONEZONE\_IA storage.
-   If you are transitioning noncurrent objects (in versioned buckets), you can transition only objects that are at least 30 days noncurrent to STANDARD\_IA or ONEZONE\_IA storage.

### References

A Cloud Guru — S3 Masterclass [https://acloud.guru/learn/s3-masterclass](https://acloud.guru/learn/s3-masterclass)

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-s3/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-s3/)

[https://docs.aws.amazon.com/AmazonS3/latest/dev/ObjectVersioning.html](https://docs.aws.amazon.com/AmazonS3/latest/dev/ObjectVersioning.html)

[https://docs.aws.amazon.com/AmazonS3/latest/dev/crr-what-is-isnot-replicated.html](https://docs.aws.amazon.com/AmazonS3/latest/dev/crr-what-is-isnot-replicated.html)

[https://aws.amazon.com/solutions/cross-region-replication-monitor/](https://aws.amazon.com/solutions/cross-region-replication-monitor/)

[https://docs.aws.amazon.com/general/latest/gr/rande.html\#s3\_region](https://docs.aws.amazon.com/general/latest/gr/rande.html#s3_region)

[https://docs.aws.amazon.com/AmazonS3/latest/dev/crr-add-config.html](https://docs.aws.amazon.com/AmazonS3/latest/dev/crr-add-config.html)

