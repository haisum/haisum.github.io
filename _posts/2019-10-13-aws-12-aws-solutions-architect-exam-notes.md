---
layout: post
title: My Notes for AWS Solutions Architect SAA-01 Exam
---

# Services

## IAM

Role: Can be associated with resources like
EC2/Cloudformation. Or assumed by user when they’re using Federation,
SAML.

User: User with access key, secret key and password.


Group: Group of users

### Policy

Permissions for groups of users or roles. Policy can be
of two types: Permission Policy and Permission Boundary. Permission
Policy is permissions which are assigned to user or resource. This
includes identity based, resource based and ACLs. Permission Boundary is
for max permissions an object can have,



To access resources in own account we need identity
based policies. For cross account permissions we need resource based
policies.



By default all requests are denied. If there’s allow,
then it’s allowed. Permission Boundary overrides allow. An explicit deny
anywhere overrides allow.

### Exam tips

IAM is eventually consistent.

What is web identity federation?

Web identity federation allows you to create AWS-powered mobile
apps that use public identity providers (such
as[ ](https://aws.amazon.com/cognito/&sa=D&ust=1570987253629000)[Amazon
Cognito](https://aws.amazon.com/cognito/&sa=D&ust=1570987253629000),[ ](http://login.amazon.com/&sa=D&ust=1570987253629000)[Login](http://login.amazon.com/&sa=D&ust=1570987253629000) with
Amazon,[ ](https://www.facebook.com/about/login&sa=D&ust=1570987253629000)[Facebook](https://www.facebook.com/about/login&sa=D&ust=1570987253630000),[ ](https://developers.google.com/%2B/&sa=D&ust=1570987253630000)[Google](https://developers.google.com/%2B/&sa=D&ust=1570987253630000),
or
any[ ](http://openid.net/connect/&sa=D&ust=1570987253630000)[OpenID
Connect](http://openid.net/connect/&sa=D&ust=1570987253630000)-compatible
provider) for authentication





### Organizations

AWS Organizations offers policy-based management for
multiple AWS accounts. With Organizations, you can create groups of
accounts, automate account creation, apply and manage policies for those
groups. Organization enables you to centrally manage policies across
multiple accounts, without requiring custom scripts and manual
processes. Using AWS Organizations, you can create Service Control
Policies (SCPs) that centrally control AWS service use across multiple
AWS accounts. You can also use Organizations to help automate the
creation of new accounts through APIs. Organization helps simplify the
billing for multiple accounts by enabling you to set up a single payment
method for all the accounts in your organization through consolidated
billing. AWS Organizations is available to all AWS customers at no
additional charge.

#### Difference between a service control policy and an IAM policy?

AWS Organizations lets you use service control policies
(SCPs) to allow or deny access to particular AWS services for individual
AWS accounts, or for groups of accounts within an organizational unit
(OU). The specified actions from an attached SCP affect all IAM users,
groups, and roles for an account, including the root account
identity.

When you apply an SCP to an OU or an individual AWS account, you
choose to either enable
(whitelist), or disable
(blacklist) the specified AWS service. Access to any
service that isn’t explicitly allowed by the SCPs associated with an
account, its parent OUs, or the master account is
denied to the AWS
accounts or OUs associated with the SCP.

When an SCP is applied to an OU, it is inherited by all
of the AWS accounts in that OU.

IAM policies let you allow or deny access to AWS
services (such as Amazon S3), individual AWS resources (such as a
specific S3 bucket), or individual API actions (such as
s3:CreateBucket). An IAM policy can be applied only to IAM users,
groups, or roles, and it can never restrict the root identity of the AWS
account. 



### Web Identity Federation and Cognito

Cognito gives web identity federation service in AWS.
It allows you to sign in and sign up. Acts as broker so you don’t need
to write code. Synchronizes data between different devices. Recommended
for all mobile applications. It maps a role from open id to AWS IAM Role
and gives temporary access to resources



AWS supports identity federation with SAML 2.0, an open
standard that many identity providers (IdPs) use. This feature enables
federated single sign-on (SSO), so users can log into the AWS Management
Console or call the AWS APIs without you having to create an IAM user
for everyone in your organization. By using SAML, you can simplify the
process of configuring federation with AWS, because you can use the IDP
service instead of writing custom identity proxy code.

Option 1 is incorrect because web identity federation
is primarily used to let users sign in via a well-known external
identity provider (IdP), such as Login with Amazon, Facebook, Google. It
does not utilize Active Directory.





### Cognito

When it comes to mobile and web apps, you can use
Amazon Cognito so that you

don’t have to manage a back-end solution to handle user
authentication, network

state, storage, and sync. Amazon Cognito generates
unique identifiers for your users.

Those identifiers can be referenced in your access
policies to enable or restrict access

to other AWS resources on a per-user basis. Amazon
Cognito provides temporary AWS

credentials to your users, allowing the mobile
application running on the device to

interact directly with AWS Identity and Access
Management (IAM)-protected AWS

services. For example, using IAM you can restrict
access to a folder in an S3 bucket to a

particular end user.

#### User Pool

User pools are used for users logging in. Successful
auth generates JWT. Users can also login directly in User Pools.

Say you were creating a new web or mobile app and you
were thinking about how to handle user registration, authentication, and
account recovery. This is where Cognito User Pools would come in.
Cognito User Pool handles all of this and as a developer you just need
to use the SDK to retrieve user related information.

#### Identity Pool

Identity pools provide temporary access to AWS
resources.

Cognito monitors different devices you use. It then
uses SNS to push updates to all devices.

Cognito Identity Pool (or Cognito Federated Identities)
on the other hand is a way to authorize your users to use the various
AWS services. Say you wanted to allow a user to have access to your S3
bucket so that they could upload a file; you could specify that while
creating an Identity Pool. And to create these levels of access, the
Identity Pool has its own concept of an identity (or user). The source
of these identities (or users) could be a Cognito User Pool or even
Facebook or Google.

### AWS Directory Service

  - AWS Managed Microsoft AD is best for current AD or
    LDAP
  - Deployed to two AZ and connected to your VPC
  - Fully managed, no access to powershell or
    ssh/rdp.
  - A VPC with at least 2 subnets required
  - Seamless domain join can be used for connecting EC2
    instance to your AD at launch time
  - Trust relationship to sync between on premise and
    AWS AD

#### Simple AD

Fully managed, mini AD with smaller feature set but
good for use when needed for simple AD features. Based on Samba 4. Does
not have MFA, Trust Relations, Powershell cmdlets. 

#### Amazon Cloud Directory

Allows storage of hierarchical objects with relations
and schema. Can organize in multiple hierarchies.

#### AD Connector

Helps connect existing AD on premise to AWS

### Exam Tips

  - Service Accounts = Roles. No federation even if
    it’s on premises.
  - IAM trust policy allows EC2 instances to assume a
    role
  - IAM policy or S3 Bucket policy allows get/put from
    buckets in S3. Note: No S3 Trust Policy. Also IAM trust policy is
    required but it’s not required for S3.
  - IAM Certificate Store and Certificate Manager let
    you manage SSL certs

### References

[https://tutorialsdojo.com/aws-cheat-sheet-aws-identity-and-access-management-iam/](https://tutorialsdojo.com/aws-cheat-sheet-aws-identity-and-access-management-iam/&sa=D&ust=1570987253637000)

[https://tutorialsdojo.com/aws-cheat-sheet-aws-directory-service/](https://tutorialsdojo.com/aws-cheat-sheet-aws-directory-service/&sa=D&ust=1570987253637000)

[http://jayendrapatil.com/aws-iam-overview/](http://jayendrapatil.com/aws-iam-overview/&sa=D&ust=1570987253637000) 



[https://docs.aws.amazon.com/autoscaling/ec2/userguide/control-access-using-iam.html](https://docs.aws.amazon.com/autoscaling/ec2/userguide/control-access-using-iam.html&sa=D&ust=1570987253638000) 

[https://aws.amazon.com/premiumsupport/knowledge-center/iam-policy-service-control-policy/](https://aws.amazon.com/premiumsupport/knowledge-center/iam-policy-service-control-policy/&sa=D&ust=1570987253638000)

[https://aws.amazon.com/organizations/getting-started/](https://aws.amazon.com/organizations/getting-started/&sa=D&ust=1570987253638000) 

[https://docs.aws.amazon.com/organizations/latest/userguide/orgs\_manage\_policies\_scp.html](https://docs.aws.amazon.com/organizations/latest/userguide/orgs_manage_policies_scp.html&sa=D&ust=1570987253639000)

## S3

### Buckets

  - Name must be unique globally
  - Can create 100 buckets in one account.
  - Can’t change region or name once created
  - Fomat: Host Style:
    [http://bucket.s3-aws-region.amazonaws.com](http://bucket.s3-aws-region.amazonaws.com&sa=D&ust=1570987253640000)
  - Format: Path Style:
    [http://s3-aws-region.amazonaws.com/bucket](http://s3-aws-region.amazonaws.com/bucket&sa=D&ust=1570987253640000) 

### Consistency

  - Read After Write for new PUTS
  - Eventual for overwrite PUTS and DELETES in all
    regions

### Storage Classes

S3 Standard: For general purpose. Highly redundant and
available 99.99% of the time. Durability: 11 9s.

S3 RRS: Reduced redundancy but not recommended because
S3 Standard is cheaper.

S3 IA: Infrequently Accessed Data. Available
99.9%

S3 IA One Zone: Same as S3 IA but redundancy only in
one AZ. Available 99.5%. Durable 11 9s but in one Zone.

These two are good for objects that are more than 128
KB and can be stored for a minimum of 30 days. Otherwise Amazon charges
you for one month and 128 KB.

Glacier: For archival. Can not specify glacier at
object creation time. Must use lifecycle transition with 0 days to
immediately transition. Must be at least 6 months storage. That’s what
AWS charges for minimum.

Glacier Retrieval Options:

Expedited: Available within 1-5 Minutes

Standard: Retrieves within 3-5 hours

Bulk: Within 5-12 hours.

Minimum 3 AZ used for standard,d IA and glacier.

### Transfer Acceleration

Transfer Acceleration enables fast, easy, and secure transfers of
files over long distances between your client and an S3 bucket. It takes
advantage of Amazon CloudFront’s globally distributed
edge locations.

Transfer Acceleration cannot be disabled, and can only
be suspended.

### Objects

  - You can upload and copy objects of up to
    5 GB in size in a single
    operation. For objects greater than 5 GB up to
    5 TB, you must use the
    multipart upload API
  - You can associate up to 10 tags with an object.
    Tags associated with an object must have unique tag keys.

### Security

Bucket Policies

  - Provides centralized access
    control to buckets and objects based on a
    variety of conditions, including S3 operations, requesters,
    resources, and aspects of the request (e.g., IP address).
  - Can either add or deny
    permissions across all (or a subset) of
    objects within a bucket.
  - IAM users need additional permissions from root
    account to perform bucket operations.
  - Bucket policies are limited to 20 KB in
    size.
  - Can restrict based on time of day, CIDR block
    range, and by IP address.

Access Control Lists

  - A list of grants identifying grantee and permission
    granted.
  - ACLs use an S3–specific XML schema.
  - You can grant permissions only to other AWS
    accounts, not to users in your account.
  - You cannot grant conditional permissions, nor
    explicitly deny permissions.
  - Object ACLs are limited to 100 granted permissions
    per ACL.
  - The only recommended use case for the bucket ACL is to grant
    write permissions to the
    S3 Log Delivery group

### Versioning

  - Need to explicitly enable it
  - When you delete, a  delete marker is created
  - Can’t disable versioning
  - Can enable MFA delete

### Notifications

Can notify on create/delete or loss of object in RRS to
following:

  - SNS 
  - SQS
  - Lambda

### Cross Region Replication

  - Both source and destination buckets must have
    versioning enabled.
  - S3 must have permissions to replicate objects from
    the source bucket to the destination bucket on your behalf.
  - If the owner of the source bucket doesn’t own the
    object in the bucket, the object owner must grant the bucket owner
    READ and READ\_ACP permissions with the object ACL.
  - Only copies Objects created after you add a
    replication configuration.
  - Objects created with server-side encryption using
    customer-provided (SSE-C) encryption keys are not replicated
  - Objects created with server-side encryption using
    AWS KMS–managed encryption (SSE-KMS) keys are not replicated by
    default. You must enable it.
  - You can replicate objects from a source bucket to
    only one destination
    bucket.
  - Deletes are not replicated. You must delete
    versions in both regions. A delete marker is replicated.



### Encryption

  - Server-side Encryption using

<!-- end list -->

  - Amazon S3-Managed Keys (SSE-S3)
  - AWS KMS-Managed Keys (SSE-KMS)
  - Customer-Provided Keys (SSE-C)

<!-- end list -->

  - Client-side Encryption using

<!-- end list -->

  - AWS KMS-managed customer master key
  - client-side master key
  - S3 supports either S3 supplied encryption key or
    client provided encryption key. For Client provided, user must send
    encryption key for each API call. S3 never stores client provided
    key.

### Exam Tips

  - Objects in S3 are stored in different partitions
    based on name from left to right. To improve performance add random
    characters at the start of object name to put it in different
    partitions to improve performance.
  - Domain used for s3 bucket: amazonaws.com
  - [http://mynewbucket.s3-aws-region.amazonaws.com](http://mynewbucket.s3-aws-region.amazonaws.com&sa=D&ust=1570987253648000) 
  - [http://s3-aws-region.amazonaws.com/mynewbucket](http://s3-aws-region.amazonaws.com/mynewbucket&sa=D&ust=1570987253648000) 
  - Headers have x-amz-\* headers. Note: no
    x-aws
  - Here are the prerequisites for routing traffic to a
    website that is hosted in an Amazon S3 Bucket:
  - - An S3 bucket that is configured to host a static
    website. The bucket must have the same name as your domain or
    subdomain. For example, if you want to use the subdomain
    portal.tutorialsdojo.com, the name of the bucket must be
    portal.tutorialsdojo.com.
  - - A registered domain name. You can use Route 53 as
    your domain registrar, or you can use a different registrar.
  - - Route 53 as the DNS service for the domain. If
    you register your domain name by using Route 53, we automatically
    configure Route 53 as the DNS service for the domain.

<!-- end list -->

  - Objects must be stored at least 30
    days in the current storage class before you
    can transition them to STANDARD\_IA or ONEZONE\_IA. For example, you
    cannot create a lifecycle rule to transition objects to the
    STANDARD\_IA storage class one day after you create them. Amazon S3
    doesn't transition objects within the first 30 days because newer
    objects are often accessed more frequently or deleted sooner than is
    suitable for STANDARD\_IA or ONEZONE\_IA storage. 
  - If you are transitioning noncurrent objects (in
    versioned buckets), you can transition only objects that are at
    least 30 days noncurrent to STANDARD\_IA or ONEZONE\_IA
    storage.
  - 

### References

A Cloud Guru — S3 Masterclass
[https://acloud.guru/learn/s3-masterclass](https://acloud.guru/learn/s3-masterclass&sa=D&ust=1570987253650000) 

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-s3/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-s3/&sa=D&ust=1570987253650000) 

[https://docs.aws.amazon.com/AmazonS3/latest/dev/ObjectVersioning.html](https://docs.aws.amazon.com/AmazonS3/latest/dev/ObjectVersioning.html&sa=D&ust=1570987253650000)



[https://docs.aws.amazon.com/AmazonS3/latest/dev/crr-what-is-isnot-replicated.html](https://docs.aws.amazon.com/AmazonS3/latest/dev/crr-what-is-isnot-replicated.html&sa=D&ust=1570987253651000) 



[https://aws.amazon.com/solutions/cross-region-replication-monitor/](https://aws.amazon.com/solutions/cross-region-replication-monitor/&sa=D&ust=1570987253651000) 



[https://docs.aws.amazon.com/general/latest/gr/rande.html\#s3\_region](https://docs.aws.amazon.com/general/latest/gr/rande.html%23s3_region&sa=D&ust=1570987253652000) 



[https://docs.aws.amazon.com/AmazonS3/latest/dev/crr-add-config.html](https://docs.aws.amazon.com/AmazonS3/latest/dev/crr-add-config.html&sa=D&ust=1570987253652000) 



## Cloudfront

  - CDN service for Amazon
  - Uses Edge Locations
  - When user request comes, it serves from lowest
    latency edge location
  - Cloudfront distribution is for telling cloudfront
    which origin servers to fetch objects from and whether it should be
    enabled as soon as it’s creation. A distribution is then sent to all
    edge locations.
  - You can use lambda@edge to modify content at edge
    location and perform different operations.
  - Can use signed URLs or signed cookies
  - Cloudfront origin group can be used for origin
    failover. You can choose a combination of HTTP 4xx/5xx status codes
    that, when returned from the primary origin, trigger the failover to
    the backup origin.
  - Cached for 24 hours by default but you can
    invalidate. Invalidation has charges. First 1000 invalidations are
    free.
  - It’s a global service so to enable logs in
    Cloudtrail you must enable global services
  - With origin access identity feature you can
    restrict access to S3 so it would only be accessible from
    cloudfront.
  - Field Level Encryption allows users to upload
    sensitive info like cc numbers to your origin securely with
    cloudfront.
  - Max file size that can be served is 20 GB.
  - Can use zone APEX with help of route 53 Alias
    record.
  - You can integrate your CloudFront distribution
    with[ ](https://aws.amazon.com/waf/&sa=D&ust=1570987253654000)[AWS
    WAF](https://aws.amazon.com/waf/&sa=D&ust=1570987253654000),
    a web application firewall that helps protect web applications from
    attacks by allowing you to configure rules based on IP addresses,
    HTTP headers, and custom URI strings. Using these rules, AWS WAF can
    block, allow, or monitor (count) web requests for your web
    application. Please
    see[ ](http://docs.aws.amazon.com/console/waf&sa=D&ust=1570987253654000)[AWS
    WAF Developer
    Guide](http://docs.aws.amazon.com/console/waf&sa=D&ust=1570987253654000) for
    more information.
  - S3 Transfer acceleration can be used to upload
    faster using cloudfront edge locations
  - Signed URLs and Signed Cookies can be used for
    temporary access to cloudfront urls
  - OAI: Origin access identity so users can’t access
    S3 bucket directly. They can only do so via cloudfront.
  - You have to use an Application Load Balancer
    instead or a CloudFront web distribution to allow the SNI
    feature.



[https://tutorialsdojo.com/aws-cheat-sheet-amazon-cloudfront/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-cloudfront/&sa=D&ust=1570987253655000)

[https://s3-accelerate-speedtest.s3-accelerate.amazonaws.com/en/accelerate-speed-comparsion.html](https://s3-accelerate-speedtest.s3-accelerate.amazonaws.com/en/accelerate-speed-comparsion.html&sa=D&ust=1570987253655000) 



[https://tutorialsdojo.com/aws-cheat-sheet-s3-pre-signed-urls-vs-cloudfront-signed-urls-vs-origin-access-identity-oai/](https://tutorialsdojo.com/aws-cheat-sheet-s3-pre-signed-urls-vs-cloudfront-signed-urls-vs-origin-access-identity-oai/&sa=D&ust=1570987253655000) 



[https://aws.amazon.com/cloudfront/features/](https://aws.amazon.com/cloudfront/features/&sa=D&ust=1570987253655000) 



[https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/PrivateContent.html](https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/PrivateContent.html&sa=D&ust=1570987253656000) 



[https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/private-content-signed-urls.html](https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/private-content-signed-urls.html&sa=D&ust=1570987253656000) 



[https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/private-content-signed-cookies.html](https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/private-content-signed-cookies.html&sa=D&ust=1570987253656000) 



[https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/private-content-restricting-access-to-s3.html](https://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/private-content-restricting-access-to-s3.html&sa=D&ust=1570987253657000) 

## AWS Shield

  -  AWS Shield Standard is free of cost
  - Enterprise is cool but needs business support contract. Also
    gives you access to DDoS response team.

[https://tutorialsdojo.com/aws-cheat-sheet-aws-shield/](https://tutorialsdojo.com/aws-cheat-sheet-aws-shield/&sa=D&ust=1570987253658000)

## Storage Gateway

AWS Storage Gateway AWS Storage Gateway is a hybrid
storage service that enables your on-

premises applications to seamlessly use AWS cloud
storage. You can use the service for backup and archiving, disaster
recovery, cloud data processing, storage tiering, and migration. Your
applications connect to the service through a virtual machine or
hardware gateway appliance using standard storage protocols, such as
NFS, SMB and iSCSI. The gateway connects to AWS storage services, such
as Amazon S3, Amazon Glacier, and Amazon EBS,

providing storage for files, volumes, and virtual tapes
in AWS. The service includes a highly-optimized data transfer mechanism,
with bandwidth management, automated network resilience, and efficient
data transfer, along with a local cache for low-latency on-premises
access to your most active data.



The service stores files as native S3 objects, archives
virtual tapes in Amazon Glacier, and stores EBS Snapshots generated by
the Volume Gateway with Amazon EBS.

### File Gateway

Supports a file interface into S3 and combines a
service and a virtual software appliance.

With a file gateway, you can do the following:

  - You can store and retrieve files directly using the
    NFS version 3 or 4.1 protocol.
  - You can store and retrieve files directly using the
    SMB file system version, 2 and 3 protocol.
  - You can access your data directly in S3 from any
    AWS Cloud application or service.
  - You can manage your S3 data using lifecycle
    policies, cross-region replication, and versioning.

File Gateway now supports Amazon S3 Object Lock,
enabling write-once-read-many (WORM) file-based systems to store and
access objects in Amazon S3.

Any modifications such as file edits, deletes or
renames from the gateway’s NFS or SMB clients are stored as new versions
of the object, without overwriting or deleting previous versions.

Gateway-Cached and File Gateway volumes retain a copy
of frequently accessed data subsets locally

### Volume Gateway

Provides cloud-backed storage volumes that
you can mount as iSCSI devices from your on-premises application
servers.

#### Cached volumes

You store your data in S3 and retain a copy of
frequently accessed data subsets locally. Cached volumes can range from
1 GiB to 32 TiB in size and must be rounded to the nearest GiB. Each
gateway configured for cached volumes can support up to 32
volumes

#### Stored volumes

If you need low-latency access to your
entire dataset, first configure your on-premises gateway to store all
your data locally. Then asynchronously back up point-in-time snapshots
of this data to S3. 

### Tape Gateway

Archive backup data in Amazon Glacier. Has a virtual
tape library (VTL) interface to store data on virtual tape cartridges
that you create. Deploy your gateway on an EC2 instance to provision
iSCSI storage volumes in AWS.

### References

[https://tutorialsdojo.com/aws-storage-gateway/](https://tutorialsdojo.com/aws-storage-gateway/&sa=D&ust=1570987253661000) 

[https://aws.amazon.com/storagegateway/faqs/](https://aws.amazon.com/storagegateway/faqs/&sa=D&ust=1570987253661000) 

## EBS

  - New EBS volumes receive their maximum performance
    the moment that they are available and do not require initialization
    (formerly known as pre-warming). However, storage blocks on volumes
    that were restored from snapshots must be initialized (pulled down
    from Amazon S3 and written to the volume) before you can access the
    block.
  - Termination protection is turned off by default and
    must be manually enabled (keeps the volume/data when the instance is
    terminated)
  - Different types of storage
    options: General Purpose
    SSD (gp2),
    Provisioned IOPS SSD (io1),
    Throughput Optimized HDD (st1),
    and Cold HDD (sc1) volumes up
    to 16 TiB in
    size.
  - Volumes are created in a specific AZ, and can then
    be attached to any instances in that same AZ. To make a volume
    available outside of the AZ, you can create a snapshot and restore
    that snapshot to a new volume anywhere in that region.
  - You can detach an EBS volume from an instance
    explicitly or by terminating the instance. However, if the instance
    is running, you must first unmount the volume from the
    instance.
  - You can use AWS Backup, an automated and
    centralized backup service, to protect EBS volumes and your other
    AWS resources. AWS Backup is integrated with Amazon DynamoDB, Amazon
    EBS, Amazon RDS, Amazon EFS, and AWS Storage Gateway to give you a
    fully managed AWS backup solution.

### Types of EBS Volumes

#### General Purpose SSD (gp2)

  - Base performance of 3 IOPS/GiB, with the ability to
    burst to 3,000 IOPS for extended periods of time.
  - Support up to 10,000 IOPS and 160 MB/s of
    throughput.

#### Provisioned IOPS SSD (io1)

  - Designed for I/O-intensive workloads, particularly
    database workloads, which are sensitive to storage performance and
    consistency.
  - Allows you to specify a consistent IOPS rate when
    you create the volume
  - Max IOPS: 32000



An io1 volume can range in size from 4 GiB to 16 TiB. You can
provision from 100 IOPS up to 64,000 IOPS per volume
on[ ](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/instance-types.html%23ec2-nitro-instances&sa=D&ust=1570987253664000)[Nitro
system](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/instance-types.html%23ec2-nitro-instances&sa=D&ust=1570987253664000) instance
families and up to 32,000 on other instance families. The maximum ratio
of provisioned IOPS to requested volume size (in GiB) is 50:1.

For example, a 100 GiB volume can be provisioned with
up to 5,000 IOPS. On a supported instance type, any volume 1,280 GiB in
size or greater allows provisioning up to the 64,000 IOPS maximum (50 ×
1,280 GiB = 64,000).

An io1 volume provisioned with up to 32,000 IOPS
supports a maximum I/O size of 256 KiB and yields as much as 500 MiB/s
of throughput. With the I/O size at the maximum, peak throughput is
reached at 2,000 IOPS. A volume provisioned with more than 32,000 IOPS
(up to the cap of 64,000 IOPS) supports a maximum I/O size of 16 KiB and
yields as much as 1,000 MiB/s of throughput.

Therefore, for instance, a 10 GiB volume can be provisioned with
up to 500 IOPS. Any
volume 640 GiB in size or greater allows provisioning up to a maximum of
32,000 IOPS (50 × 640 GiB = 32,000).

#### Throughput Optimized HDD (st1)

  - Low-cost magnetic storage that focuses on
    throughput rather than IOPS.
  - Throughput of up to 500 MiB/s.

#### Cold HDD (sc1)

  - Low-cost magnetic storage that focuses on
    throughput rather than IOPS.
  - Throughput of up to 250 MiB/s.

### Monitoring

  - Volume status checks provide you the information
    that you need to determine whether your EBS volumes are impaired,
    and help you control how a potentially inconsistent volume is
    handled. List of statuses include:

<!-- end list -->

  - Ok – normal volume
  - Warning – degraded volume
  - Impaired – stalled volume
  - Insufficient-data –  insufficient data

### RAID



Some EC2 instance types can drive more I/O throughput
than what you can provision for a single EBS volume. You can join
multiple gp2, io1, st1, or sc1 volumes together in a RAID 0
configuration to use the available bandwidth for these instances.



For greater I/O performance than you can achieve with a
single volume, RAID 0 can stripe multiple volumes together; for
on-instance redundancy, RAID 1 can mirror two volumes together.

#### Creating Snapshots of Volumes in a RAID Array

If you want to back up the data on the EBS volumes in a
RAID array using snapshots, you must ensure that the snapshots are
consistent. This is because the snapshots of these volumes are created
independently. To restore EBS volumes in a RAID array from snapshots
that are out of sync would degrade the integrity of the array.

To create a consistent set of snapshots for your RAID array,
use[ ](https://docs.aws.amazon.com/AWSEC2/latest/APIReference/API_CreateSnapshots.html&sa=D&ust=1570987253667000)[EBS
multi-volume
snapshots](https://docs.aws.amazon.com/AWSEC2/latest/APIReference/API_CreateSnapshots.html&sa=D&ust=1570987253667000).
Multi-volume snapshots allow you to take point-in-time, data
coordinated, and crash-consistent snapshots across multiple EBS volumes
attached to an EC2 instance. You do not have to stop your instance to
coordinate between volumes to ensure consistency because snapshots are
automatically taken across multiple EBS volumes.

### Amazon DLM

You can use Amazon Data Lifecycle Manager (Amazon DLM)
to automate the creation, retention, and deletion of snapshots taken to
back up your Amazon EBS volumes.

### Exam Tips



Take note that HVM AMIs are required to take advantage
of enhanced networking and GPU processing.

Although the Enhanced Networking feature can provide
higher I/O performance and lower CPU utilization to your EC2 instance,
you have to use an HVM AMI instead of PV AMI.



You can perform live migration as long as instance root
volume is EBS. Instance store can’t migrate.

Decreasing the size of an EBS volume is not
supported.

To attach volume attached in one instance to other,
detach and attach to other.

Instance Type = hardware capacity. Instance type has
memory, cpu and storage. OS and software loaded is decided by AMI

Max Volume Size for magnetic tape = 1 TB. for SSD it’s
16 TB.



Instance started with EBS is faster than instance
store. Instance store requires all parts retrieved from S3. EBS only
requires stuff for boot before instance is available.



To avoid initial performance we must warm up volume by
reading all blocks



when you create an EBS volume in an Availability Zone,
it is automatically replicated within that zone only to prevent data
loss due to a failure of any single hardware component. After you create
a volume, you can attach it to any EC2 instance in the same Availability
Zone. Note: EBS is single AZ and can tolerate hardware failures but not
AZ failure.



### Encryption

encrypt root volumes:

- take snapshot

- copy snapshot and encrypt

- create image of snapshot

- then launch ami

- can encrypt at startup

- can share only if volume is unencrypted



There is no direct way to encrypt an existing
unencrypted volume, or to remove encryption from an encrypted volume.
However, you can migrate data between encrypted and unencrypted
volumes.

### References

[https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/raid-config.html\#ebs-snapshots-raid-array](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/raid-config.html%23ebs-snapshots-raid-array&sa=D&ust=1570987253670000) 



[https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ebs-creating-snapshot.html](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ebs-creating-snapshot.html&sa=D&ust=1570987253670000) 



[https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/raid-config.html](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/raid-config.html&sa=D&ust=1570987253671000) 



[https://tutorialsdojo.com/aws-cheat-sheet-amazon-ebs/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-ebs/&sa=D&ust=1570987253671000) 



[https://aws.amazon.com/blogs/aws/new-infrequent-access-storage-class-for-amazon-elastic-file-system-efs/](https://aws.amazon.com/blogs/aws/new-infrequent-access-storage-class-for-amazon-elastic-file-system-efs/&sa=D&ust=1570987253672000) 



[https://docs.aws.amazon.com/efs/latest/ug/limits.html](https://docs.aws.amazon.com/efs/latest/ug/limits.html&sa=D&ust=1570987253672000) 

## EFS

  - NFS share mount
  - Can be mounted to multiple EC2 instances unlike EBS
    which can only be used on one at a time
  - Stores data in Multi AZ
  - Can mount to on-premise using Direct Connect and
    VPN
  - To access your EFS file system in a VPC, you create one or
    more mount
    targets in the VPC. A mount target provides
    an IP address for an NFSv4 endpoint.
  - You can create one mount target in each
    Availability Zone in a region.
  - You mount your file system using its DNS name, which will
    resolve to the IP address of the EFS mount target. Format of DNS
    is  
    File-system-id.efs.aws-region.amazonaws.com
  - Up to thousands of EC2 instances, from multiple
    AZs, can connect concurrently to a file system.
  - On Windows, can’t be mounted as drive. But can be
    mounted as folder.

### Exam Tips

  - EFS \!= S3. Don’t select EFS when asked for S3
    enabled service.

### References

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-efs/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-efs/&sa=D&ust=1570987253674000) 

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-s3-vs-ebs-vs-efs/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-s3-vs-ebs-vs-efs/&sa=D&ust=1570987253674000)

## EC2

### Exam tips

  - Pricing only for Spot, On demand and Reserved
    instances. No Dedicated.
  - If instance shutdown behavior is set to terminate,
    then instance will terminate regardless of whether termination
    protection is on.
  - EC2 items to monitor

<!-- end list -->

  - CPU utilization, Network utilization, Disk
    performance, Disk Reads/Writes using EC2 metrics
  - Memory utilization, disk swap utilization, disk
    space utilization, page file utilization, log collection using a
    monitoring agent/CloudWatch Logs

<!-- end list -->

  - You can pass two types of user data to EC2: shell
    scripts and cloud-init directives.
  - User data is limited to 16 KB.
  - If you stop an instance, modify its user data, and
    start the instance, the updated user data is not executed when you
    start the instance.
  - Retrieve user data from within a running instance
    at[ ](http://169.254.169.254/latest/user-data&sa=D&ust=1570987253676000)[http://169.254.169.254/latest/user-data](http://169.254.169.254/latest/user-data&sa=D&ust=1570987253676000)
  - AMI = hardware type + OS. Notice: No
    Licenses
  - Instance Type = Storage + CPU + Memory
  - When user receives InsufficientInstanceCapacity
    Error, while launching Ec2, it means that AWS does not currently
    have enough available capacity to service user request. User can try
    later or use different AZ.
  - Stopping and Starting instance fixes status checker
    errors because unless you have dedicated instance, it usually starts
    on a different AWS hardware.
  - EC2 is limited to 20 instances for new accounts.
    Use form for increasing.
  - Keep Spot instances primary and on demand secondary. On demand
    only provision when the spot are gone to save costs.

### Instance Types

#### On Demand

fix rate by hour or second

#### Reserved

contract terms 1 or 3 years. provides discount and
capacity reservation

#### Spot

Bid on instance capacity. Greater saving for when
there's no fix start or end time.

not charged if it's terminated in partial hour by AWS.
But if you terminate it, you will be charged

#### Dedicated Host

Can help in using server based license or regulation
saying you cant use virtualization



Three tenancy options:

Dedicated Instance

Shared Tenancy

Dedicated Host

### Security Groups

- security group changes are effective
immediately

- security groups are stateful i.e outbound and inbound
rules apply

- ACLs are stateless they need to be added for both
inbound and outbound traffic

- can attach one or more security groups to an
instance

- all inbound is blocked

- all outbound is allowed

- Can't block specific IP addresses. Need to use ACLs
to do that

- You can allow rules but can't deny rules using
security groups



roles are easier to manage and dont store on ec2

are recommended instead of using access key and secret
key

roles are universal



instance store is ephemeral storage. You cant stop
Instance Store volumes, you lose data when it terminates



meta data is available on
169.254.169.254/latest/meta-data or /user-data



EFS: shared file system between ec2 instances. Can grow
based on usage. Supports NFSv4. Need to configure security groups
between instances and EFS volume.



### EC2 Placement groups



Exam tip: Use enhanced networking instances for
placement groups

Clustered group all instances in one rack

Low network latency high throughput

cant be in multiple AZ

recommended same instance types



Spread group put all instances in different
racks

individual crtical instances

can be in multiple AZ



Partitioned group mix of above two. Put N instances on
one rack and N on other

can be in multiple AZ



can't merge placement groups and can't move existing
instance to placement group. You can create AMI and then launch instance
in placement group

HDFS/HFS/Cassandra

### References

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-elastic-compute-cloud-amazon-ec2/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-elastic-compute-cloud-amazon-ec2/&sa=D&ust=1570987253682000) 



[https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/building-shared-amis.html](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/building-shared-amis.html&sa=D&ust=1570987253682000) 



[https://aws.amazon.com/blogs/security/new-attach-an-aws-iam-role-to-an-existing-amazon-ec2-instance-by-using-the-aws-cli/](https://aws.amazon.com/blogs/security/new-attach-an-aws-iam-role-to-an-existing-amazon-ec2-instance-by-using-the-aws-cli/&sa=D&ust=1570987253683000) 



[https://aws.amazon.com/blogs/security/easily-replace-or-attach-an-iam-role-to-an-existing-ec2-instance-by-using-the-ec2-console/](https://aws.amazon.com/blogs/security/easily-replace-or-attach-an-iam-role-to-an-existing-ec2-instance-by-using-the-ec2-console/&sa=D&ust=1570987253683000) 



[https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ec2-instance-metadata.html](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ec2-instance-metadata.html&sa=D&ust=1570987253684000)

[https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ec2-instance-lifecycle.html](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ec2-instance-lifecycle.html&sa=D&ust=1570987253684000) 

## Auto Scaling 

### Features

  - Launch or terminate EC2 instances in an Auto
    Scaling group.
  - Enable a DynamoDB table or a global secondary index
    to increase or decrease its provisioned read and write capacity to
    handle increases in traffic without throttling.
  - Dynamically adjust the number of Aurora read
    replicas provisioned for an Aurora DB cluster to handle changes in
    active connections or workload.

### Dynamic Vs Predictive Scaling

  - Use Dynamic
    Scaling to add and remove capacity for
    resources to maintain resource utilization at the specified target
    value.
  - Use Predictive
    Scaling to forecast your future load demands
    by analyzing your historical records for a metric. It also allows
    you to schedule scaling actions that proactively add and remove
    resource capacity to reflect the load forecast, and control maximum
    capacity behavior. Only available for EC2 Auto Scaling
    groups.

### EC2 Auto Scaling

  - Ensuring you have the correct number of EC2 instances
    available to handle your application load using
    Auto Scaling
    Groups.

<!-- end list -->

  - You specify the minimum, maximum and desired number
    of instances in each Auto Scaling group.
  - Launch Configuration: Your group uses a
    launch
    configuration as a template for its EC2
    instances. When you create a launch configuration, you can specify
    information such as the AMI ID, instance type, key pair, security
    groups, and block device mapping for your instances.
  - Lifecycle: Pending, In-Service, Detached,
    Terminated
  - You can add a lifecycle
    hook to your Auto Scaling group to perform
    custom actions when instances launch or terminate.
  - The cooldown
    period is a configurable setting that helps
    ensure to not launch or terminate additional instances before
    previous scaling activities take effect. 
  - You can create launch templates
    that specifies instance configuration
    information when you launch EC2 instances, and allows you to have
    multiple versions of a template.
  - A launch
    configuration is an instance configuration
    template that an Auto Scaling group uses to launch EC2 instances,
    and you specify information for the instances.
  - CloudWatch Events – Auto Scaling can submit events
    to CloudWatch Events when your Auto Scaling groups launch or
    terminate instances, or when a lifecycle action occurs.
  - SNS notifications – Auto Scaling can send Amazon
    SNS notifications when your Auto Scaling groups launch or terminate
    instances.
  - Auto Scaling Group:  Launches instances based on
    config provided

<!-- end list -->

  - Can provision new when instance terminates. Check
    type: EC2
  - Can provision new if ELB Health check fails. Check
    type: ELB
  - Launch Configuration: Configuration of EC2 instances in auto
    scaling group

### Instance Termination Policy

  - If Multi A-Z, select AZ with most instances
  - Find instance with oldest launch config
  - If multiple instances have oldest, then pick one
    near billing hour
  - If still, multiple then pick randomly



### Exam Tips

Auto Scaling Lifecycle Hook, didn’t know before today’s
exam, so please have a look by googling it. 

The default termination policy is designed to help
ensure that your network architecture spans Availability Zones evenly.
With the default termination policy, the behavior of the Auto Scaling
group is as follows:

1. If there are instances in multiple Availability
Zones, choose the Availability Zone with the most instances and at least
one instance that is not protected from scale in. If there is more than
one Availability Zone with this number of instances, choose the
Availability Zone with the instances that use the oldest launch
configuration.

2. Determine which unprotected instances in the
selected Availability Zone use the oldest launch configuration. If there
is one such instance, terminate it.

3. If there are multiple instances to terminate based
on the above criteria, determine which unprotected instances are closest
to the next billing hour. (This helps you maximize the use of your EC2
instances and manage your Amazon EC2 usage costs.) If there is one such
instance, terminate it.

4. If there is more than one unprotected instance
closest to the next billing hour, choose one of these instances at
random.

Amazon Autoscaling, please note that there
are 4 Autoscaling plans namely, Main Current Instance Levels, Manual
Scaling, Scheduled Scaling, and Dynamic Scaling. Remember if you want AS
to launch different AMI’s than the one set up please remember you can’t
modify Launch Configuration, which is the template for AS you
must create new LC and
then assign it to your AS, all the new instances will be launched with
new AMI and all the previous one will still be running. 

  - Dedicated host = complete host, non virtualized for
    customer
  - Dedicated instance = dedicated isolated instance
    running on hardware. More instances for same customer can run on
    this host.
  - Use time based and load based scaling to have
    optimum and cost effective performance. There’s no price based or
    vendor based scaling.

### References

[https://tutorialsdojo.com/aws-cheat-sheet-aws-auto-scaling/](https://tutorialsdojo.com/aws-cheat-sheet-aws-auto-scaling/&sa=D&ust=1570987253689000) 

## ELB

  - Slow Start Mode gives targets time to
    warm up before the load balancer sends them a full share of
    requests.

### Application Load Balancer

  - Enable cross zone load balancing to start load
    balancing between cross zones
  - Path patterns: Can route traffic based on path in
    URL
  - Targets: EC2 instances or Auto Scaling group to
    load balance traffic to
  - When you create a load balancer, you must specify
    one public subnet from at least two Availability Zones. You can
    specify only one public subnet per Availability Zone.
  - Can do sticky sessions with load balancer generated
    cookies

### Network Load Balancer

  - Functions at the fourth
    layer of the Open Systems Interconnection
    (OSI) model. Uses TCP connections.
  - At least 1 subnet must be specified when creating
    this type of load balancer, but the recommended number is 2.
  - In the event that your Network load balancer is
    unresponsive, integration with Route 53 will remove the unavailable
    load balancer IP address from service and direct traffic to an
    alternate Network Load Balancer in another region.
  - Can work with 1 public subnet but 2 recommended

### Classic Load Balancer

  - For use with EC2 classic only.
  - Support for sticky sessions using
    application-generated cookies

### Http Headers

  - Application Load Balancers and Classic Load Balancers support
    X-Forwarded-For,
    X-Forwarded-Proto, and
    X-Forwarded-Port headers.



### Exam Tips

  - X-ForwardedFor has user’s ip address
  - ELB Faq for classic load balancer is must and
    others. They come in exam a lot

<!-- end list -->

  - Disable sticky sessions if traffic is always going
    to one instance
  - Reliability: It is what it is
  - Durability: Stored
  - Availability: Available when needed
  - Resiliency: In case of failures, recovers
  - AutoScaling, CloudWatch, EC2 Instances used for
    scalability. EFS is not required for it.
  - Perfect Forward Secrecy is a feature that provides
    additional safeguards against the eavesdropping of encrypted data,
    through the use of a unique random session key. This prevents the
    decoding of captured data, even if the secret long-term key is
    compromised.
  - CloudFront and Elastic Load Balancing are the two
    AWS services that support Perfect Forward Secrecy.
  - You have to use an Application Load Balancer
    instead or a CloudFront web distribution to allow the SNI
    feature.
  - Amazon EC2 Auto Scaling supports the following
    types of scaling policies:
  - Target tracking scaling -
    Increase or decrease the current capacity of
    the group based on a target value for a specific metric. This is
    similar to the way that your thermostat maintains the temperature of
    your home – you select a temperature and the thermostat does the
    rest.
  - Step scaling - Increase or decrease
    the current capacity of the group based on a set of scaling
    adjustments, known as step
    adjustments, that vary based on the size of
    the alarm breach.
  - Simple scaling - Increase
    or decrease the current capacity of the group based on a single
    scaling adjustment.
  - 

### Load Balancers in a VPC

  - To ensure that your load balancer can scale
    properly, verify that each subnet for your load balancer has a CIDR
    block with at least a /27 bitmask (for example,10.0.0.0/27) and has
    at least 8 free IP addresses. Your load balancer uses these IP
    addresses to establish connections with the instances.
  - ClassicLink enables your EC2-Classic instances to communicate
    with VPC instances using private IP addresses, provided that the VPC
    security groups allow it. If you plan to register linked EC2-Classic
    instances with your load balancer, you must enable ClassicLink for
    your VPC, and then create your load balancer in the
    ClassicLink-enabled VPC.

### References

[https://acloud.guru/learn/aws-application-loadbalancer](https://acloud.guru/learn/aws-application-loadbalancer&sa=D&ust=1570987253694000) 

[https://tutorialsdojo.com/aws-cheat-sheet-aws-elastic-load-balancing-elb/](https://tutorialsdojo.com/aws-cheat-sheet-aws-elastic-load-balancing-elb/&sa=D&ust=1570987253694000) [https://tutorialsdojo.com/aws-cheat-sheet-ec2-instance-health-check-vs-elb-health-check-vs-auto-scaling-and-custom-health-check-2/](https://tutorialsdojo.com/aws-cheat-sheet-ec2-instance-health-check-vs-elb-health-check-vs-auto-scaling-and-custom-health-check-2/&sa=D&ust=1570987253694000)

[https://docs.aws.amazon.com/elasticloadbalancing/latest/classic/elb-backend-instances.html](https://docs.aws.amazon.com/elasticloadbalancing/latest/classic/elb-backend-instances.html&sa=D&ust=1570987253695000) 

## ECS

  - When using the EC2 launch type, then your clusters are a group
    of container instances you manage. These clusters can contain
    multiple different container instance types, but each container
    instance may only be part of one cluster at a time.

### Components

Containers and Images: Your application components must
be architected to run in containers. Containers are created from a
read-only template called an image.

#### Task Components

  - Task definitions specify various
    parameters for your application. It is a text file, in JSON format,
    that describes one or more containers, up to a maximum of ten, that
    form your application

### Fargate

AWS Fargate is a compute engine for Amazon ECS that
allows you to run containers without having to manage servers or
clusters.



Amazon ECS has two modes: Fargate launch type and EC2
launch type. With Fargate launch type, all you have to do is package
your application in containers, specify the CPU and memory requirements,
define networking and IAM policies, and launch the application. EC2
launch type allows you to have server-level, more granular control over
the infrastructure that runs your

container applications.

  - Fargate only supports container images hosted on
    Elastic Container Registry (ECR) or Docker Hub.

### References

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-elastic-container-service-amazon-ecs/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-elastic-container-service-amazon-ecs/&sa=D&ust=1570987253697000)

## AWS Systems Manager

### Overview

  - Create logical groups of resources such as
    applications, different layers of an application stack, or
    production versus development environments.

<!-- end list -->

  - You can select a resource group and view its recent
    API activity, resource configuration changes, related notifications,
    operational alerts, software inventory, and patch compliance
    status.

<!-- end list -->

  - Provides a browser-based interactive shell and CLI
    for managing Windows and Linux EC2 instances, without the need to
    open inbound ports, manage SSH keys, or use bastion hosts. 
  - SSM Agent is the tool that
    processes Systems Manager requests and configures your machine as
    specified in the request. SSM Agent must be installed on each
    instance you want to use with Systems Manager. On some instance
    types, SSM Agent is installed by default. On others, you must
    install it manually.



Systems Manager provides predefined automation
documents for common operational tasks, such as stopping and restarting
an EC2 instance, that you can customize to your own specific use cases.
Systems Manager also has built-in safety controls, allowing you to
incrementally roll out new changes and automatically halt the roll-out
when errors occur.

With Systems Manager, you can view detailed system
configurations, operating system patch levels, software installations,
application configurations, and other details about your environment
through the Systems Manager dashboard. 

With AWS Systems Manager, you can manage servers
running on AWS and in your on-premises data center through a single
interface. Systems Manager securely communicates with a lightweight
agent installed on your servers to execute management tasks.

### Exam Tips

Amazon ECS enables you to inject sensitive data into
your containers by storing your sensitive data in either AWS Secrets
Manager secrets or AWS Systems Manager Parameter Store parameters and
then referencing them in your container definition. This feature is
supported by tasks using both the EC2 and Fargate launch types.

### References

[https://tutorialsdojo.com/aws-cheat-sheet-aws-systems-manager/](https://tutorialsdojo.com/aws-cheat-sheet-aws-systems-manager/&sa=D&ust=1570987253699000) 

Well Architected Framework whitepaper - Operational
Excellence

## Databases

[https://aws.amazon.com/products/databases/](https://aws.amazon.com/products/databases/&sa=D&ust=1570987253700000) 

### RDS

  - RDS is all OLTP and comes in six different DBs.
    Postgres, MySql, Mariadb, MSSQL, Oracle, Aurora
  - You can get high availability with a primary
    instance and a synchronous secondary instance that you can fail over
    to when problems occur. 
  - Provisioned storage limits restrict the maximum
    size of a MySQL table file to 16 TB.
  - The Point-In-Time Restore and snapshot restore
    features of Amazon RDS for MySQL require a crash-recoverable storage
    engine and are supported for the InnoDB storage engine only.
  - InnoDB is the recommended and supported storage
    engine for MySQL DB instances on Amazon RDS.
  - You can now create Amazon RDS for Oracle database
    instances with up to 64 TiB of storage (32 TiB originally) and
    provisioned I/O performance of up to 80,000 IOPS.
  - Max SQL Server: 16 TB
  - You can’t stop an Amazon RDS for SQL
    Server DB instance in a Multi-AZ
    configuration.
  - MySQL and PostgreSQL both support IAM
    database authentication.

<!-- end list -->

  - Restored RDS has new endpoint url so you need to
    change that
  - Take note that there are certain differences
    between CloudWatch and Enhanced Monitoring Metrics.  CloudWatch
    gathers metrics about CPU utilization from the hypervisor for a DB
    instance, and Enhanced Monitoring gathers its metrics from an agent
    on the instance. As a result, you might find differences between the
    measurements, because the hypervisor layer performs a small amount
    of work. 
  - Enhanced Monitoring metrics are useful when you
    want to see how different processes or threads on a DB instance use
    the CPU.
  - When zone is gone, it fails over automatically and
    updates dns it's not for performance.

<!-- end list -->

  - For performance, we need read replicas

<!-- end list -->

  - can force failover by rebooting rds instance
  - CloudWatch gathers metrics about CPU utilization
    from the hypervisor for a DB
    instance, and Enhanced Monitoring gathers its metrics
    from an agent on the
    instance.
  - RDS Performance
    Insights monitors your DB instance load so
    that you can analyze and troubleshoot your database performance. You
    can visualize the database load and filter the load by waits, SQL
    statements, hosts, or users.
  - DB Security groups are used in Classic EC2. VPN
    security groups are used in RDS.
  - By default, customers are allowed to have up to a
    total of 40 Amazon RDS DB instances. Of those 40, up to 10 can be
    Oracle or SQL Server DB instances under the "License Included"
    model. All 40 can be used for Amazon Aurora, MySQL, MariaDB,
    PostgreSQL and Oracle under the "BYOL" model.
  - Amazon RDS reserved instances are purchased for a
    Region rather than for a specific Availability Zone. 
  - You can
    use[ ](https://aws.amazon.com/config/&sa=D&ust=1570987253703000)[AWS
    Config](https://aws.amazon.com/config/&sa=D&ust=1570987253703000) to
    continuously record configurations changes to Amazon RDS DB
    Instances, DB Subnet Groups, DB Snapshots, DB Security Groups, and
    Event Subscriptions and receive notification of changes
    through[ ](https://aws.amazon.com/sns/&sa=D&ust=1570987253703000)[Amazon
    Simple Notification Service
    (SNS)](https://aws.amazon.com/sns/&sa=D&ust=1570987253704000).

#### Backups

  - By default, Amazon RDS enables automated backups of
    your DB Instance with a 7 day retention period. Free backup storage
    is limited to the size of your provisioned database and only applies
    to active DB Instances. 
  - There is no I/O suspension for Multi-AZ DB
    deployments, since the backup is taken from the standby.

##### VPC

  - A DB Subnet Group is a collection of subnets that
    you may want to designate for your RDS DB Instances in a VPC. Each
    DB Subnet Group should have at least one subnet for every
    Availability Zone in a given Region. When creating a DB Instance in
    VPC, you will need to select a DB Subnet Group.

##### Automatic Backups

  - The automated backup feature of Amazon RDS enables
    point-in-time recovery of your DB instance. When automated backups
    are turned on for your DB Instance, Amazon RDS automatically
    performs a full daily snapshot of your data (during your preferred
    backup window) and captures transaction logs (as updates to your DB
    Instance are made). 

<!-- end list -->

  - Amazon RDS retains backups of a DB Instance for a
    limited, user-specified period of time called the retention period,
    which by default is 7 days but can be set to up to 35 days. You can
    initiate a point-in-time restore and specify any second during your
    retention period, up to the Latest Restorable Time.

##### DB Snapshots

  - DB Snapshots are user-initiated and enable you to
    back up your DB instance in a known state as frequently as you wish,
    and then restore to that specific state at any time. 

#### Encryption

  - At rest and in-transit.
  - Manage keys used for encrypted DB instances using
    the AWS KMS. KMS encryption keys are specific to the region that
    they are created in.
  - You can’t have an encrypted Read Replica of an
    unencrypted DB instance or an unencrypted Read Replica of an
    encrypted DB instance.
  - You can’t restore an unencrypted backup or snapshot
    to an encrypted DB instance.
  - Amazon RDS supports encryption at rest for all database
    engines, using keys you manage
    using[ ](https://aws.amazon.com/kms/&sa=D&ust=1570987253706000)[AWS
    Key Management Service
    (KMS)](https://aws.amazon.com/kms/&sa=D&ust=1570987253706000).
    On a database instance running with Amazon RDS encryption, data
    stored at rest in the underlying storage is encrypted, as are its
    automated backups, read replicas, and snapshots.

#### Enhanced Metrics

CloudWatch gathers metrics about CPU utilization from
the hypervisor for a DB instance, and Enhanced Monitoring gathers its
metrics from an agent on the instance.



In RDS, the Enhanced Monitoring metrics shown in the
Process List view are organized as follows:

-RDS child processes – Shows a
summary of the RDS processes that support the DB instance

-RDS processes – Shows a
summary of the resources used by the RDS management agent, diagnostics
monitoring processes, and other AWS processes that are required to
support RDS DB instances.

-OS processes – Shows a summary
of the kernel and system processes, which generally have minimal impact
on performance.

#### References

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-relational-database-service-amazon-rds/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-relational-database-service-amazon-rds/&sa=D&ust=1570987253708000) 



[https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/Overview.DBInstance.Modifying.html](https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/Overview.DBInstance.Modifying.html&sa=D&ust=1570987253708000) 



[https://aws.amazon.com/rds/faqs/\#reserved-instances](https://aws.amazon.com/rds/faqs/%23reserved-instances&sa=D&ust=1570987253708000) 



[https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/Overview.RDSSecurityGroups.html](https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/Overview.RDSSecurityGroups.html&sa=D&ust=1570987253708000)



RDS Cloud Guru Course:
[https://acloud.guru/learn/aws-rds](https://acloud.guru/learn/aws-rds&sa=D&ust=1570987253709000) 

### Aurora

  - Starts with 10GB and scales upto 64 TB in 10 GB
    increments
  - Can scale upto 32 CPU and 244 GB RAM
  - 2 copies of data in each AZ min 3 AZ. So 6 copies
    of data. Only available with 3 AZ regions.
  - Super high availability.
  - Low latency replication.
  - Backups don’t impact db performance
  - Snapshots also don’t impact db performance
  - To migrate mysql to aurora, create read replica
    then promote it
  - compatible with both postgres and mysql
  - Aurora Serverless is Serverless
  - Amazon Aurora is up to five times faster than
    standard MySQL databases and three times faster than standard
    PostgreSQL databases. Amazon Aurora features a distributed,
    fault-tolerant, self-healing storage system that auto-scales up to
    64TB per database instance. It delivers high performance and
    availability with up to 15 low-latency read replicas, point-in-time
    recovery, continuous backup to Amazon S3, and replication across
    three Availability Zones (AZs).
  - Amazon Aurora Multi-Master is a new feature of the
    Aurora MySQL-compatible edition that adds the ability to scale out
    write performance across multiple Availability Zones, allowing
    applications to direct read/write workloads to multiple instances in
    a database cluster and operate with higher availability.
  - [Amazon Aurora
    Serverless](https://aws.amazon.com/rds/aurora/serverless/&sa=D&ust=1570987253710000) is
    an on-demand, autoscaling configuration for the MySQL-compatible and
    PostgreSQL-compatible editions of Amazon Aurora. An Aurora
    Serverless DB cluster automatically starts up, shuts down, and
    scales capacity up or down based on your application's needs. Aurora
    Serverless provides a relatively simple, cost-effective option for
    infrequent, intermittent, or unpredictable workloads.
  - Cluster endpoint – connects
    to the current primary DB instance for a DB cluster. This endpoint
    is the only one that can perform write operations.
  - Reader endpoint – connects
    to one of the available Aurora Replicas for that DB cluster. Each
    Aurora DB cluster has one reader endpoint. The reader endpoint
    provides load-balancing support for read-only connections to the DB
    cluster. Use the reader endpoint for read operations, such as
    queries. You can’t use the reader endpoint for write
    operations.
  - Custom endpoint –
    represents a set of DB instances that you choose. When you connect
    to the endpoint, Aurora performs load balancing and chooses one of
    the instances in the group to handle the connection.
  - Instance endpoint –
    connects to a specific DB instance within an Aurora cluster. 
  - Aurora MySQL parallel
    query is an optimization that parallizes
    some of the I/O and computation involved in processing
    data-intensive queries.

#### References

[https://tutorialsdojo.com/amazon-aurora/](https://tutorialsdojo.com/amazon-aurora/&sa=D&ust=1570987253711000) 

[https://aws.amazon.com/rds/aurora/faqs/](https://aws.amazon.com/rds/aurora/faqs/&sa=D&ust=1570987253711000) 

### DynamoDB

  - NoSQL
  - Stored on SSD
  - Spread across 3 regions
  - eventually consistent (within 1 second)
  - Can do strongly consistent
  - Provides on-demand backup capability as well as enable
    point-in-time recovery for your DynamoDB tables. With point-in-time
    recovery, you can restore that table to any point in time during the
    last 35 days.
  - You can create tables that are automatically
    replicated across two or more AWS Regions, with full support for
    multi-master writes.
  - Primary Key – uniquely
    identifies each item in the table, so that no two items can have the
    same key. Must be scalar.

<!-- end list -->

  - Partition key – a simple
    primary key, composed of one attribute.
  - Partition key and sort
    key (composite primary
    key) – composed of two attributes.
  - DynamoDB uses the partition key value as input to
    an internal hash function. The output from the hash function
    determines the partition in which the item will be stored. All items
    with the same partition key are stored together, in sorted order by
    sort key value. If no sort key is used, no two items can have the
    same partition key value.

<!-- end list -->

  - DynamoDB Streams – an
    optional feature that captures data modification events in DynamoDB
    tables. 
  - Stream records have a lifetime of 24 hours; after
    that, they are automatically removed from the stream.
  - You can use DynamoDB Streams together with AWS Lambda to
    create a trigger,
    which is a code that executes automatically whenever an event of
    interest appears in a stream.
  - Throttling prevents your
    application from consuming too many capacity units. DynamoDB can
    throttle read or write requests that exceed the throughput settings
    for a table, and can also throttle read requests exceeds for an
    index.
  - When a request is throttled, it fails with an
    HTTP 400 code (Bad Request) and
    a
    ProvisionedThroughputExceededException.
  - You create a scaling
    policy for a table or a global secondary index. The
    scaling policy specifies whether you want to scale read capacity or
    write capacity (or both), and the minimum and maximum provisioned
    capacity unit settings for the table or index. The scaling policy
    also contains a target
    utilization, which is the percentage of
    consumed provisioned throughput at a point in time.
  - You can use the
    UpdateItem operation to
    implement an atomic
    counter – a numeric attribute that is
    incremented, unconditionally, without interfering with other write
    requests.
  - DynamoDB optionally supports conditional writes for these
    operations: PutItem, UpdateItem,
    DeleteItem. A conditional write will succeed
    only if the item attributes meet one or more expected
    conditions.
  - Conditional writes can be
    idempotent if the
    conditional check is on the same attribute that is being updated.
    DynamoDB performs a given write request only if certain attribute
    values in the item match what you expect them to be at the time of
    the request.
  - Encrypts your data at rest using an AWS Key
    Management Service (AWS KMS) managed encryption key for
    DynamoDB.
  - Encryption at rest can be enabled only when you are
    creating a new DynamoDB table.
  - DynamoDB Accelerator
    (DAX) delivers microsecond response times
    for accessing eventually consistent data.
  - An item collection is all
    the items in a table and its local secondary indexes that have the
    same partition key. No item collection can exceed 10 GB, so it's
    possible to run out of space for a particular partition key
    value.

### Best Practices

  - Provisioned capacity can be increased as long as
    one partition key doesn’t exceed 3000 RCUs or 1000 WCUs.
  - Burst capacity is capacity reserved for 5 minutes
    when you’re not using your full capacity.
  - Partition keys should be distinct. More keys you
    access while retrieving data, more distributed your load will
    be.
  - Sharding Using Random Suffixes: One strategy for
    distributing loads more evenly across a partition key space is to
    add a random number to the end of the partition key values. Then you
    randomize the writes across the larger space.
  - Sharding Using Calculated Suffixes: A randomizing
    strategy can greatly improve write throughput. But it's difficult to
    read a specific item because you don't know which suffix value was
    used when writing the item. To make it easier to read individual
    items, you can use a different strategy. Instead of using a random
    number to distribute the items among partitions, use a number that
    you can calculate based upon something that you want to query
    on.
  - Composite keys should represent one to many
    relationships.
  - In Secondary indexes,  Avoid projecting attributes
    that you know will rarely be needed in queries. Every time you
    update an attribute that is projected in an index, you incur the
    extra cost of updating the index as well. You can still retrieve
    non-projected attributes in a Query at a higher provisioned
    throughput cost, but the query cost may be significantly lower than
    the cost of updating the index frequently
  -  Consider projecting fewer attributes to minimize
    the size of items written to the index. However, this only applies
    if the size of projected attributes would otherwise be larger than a
    single write capacity unit (1 KB). For example, if the size of an
    index entry is only 200 bytes, DynamoDB rounds this up to 1 KB. In
    other words, as long as the index items are small, you can project
    more attributes at no extra cost.
  - Adjacency List Pattern is dope
  - Overload global secondary indexes for more swag
    (See best practices documentation. It’s awesome.)

#### Scan and Query Operation Optimization

  - Scan operations read full items and have to read
    all items. A scan can consume upto 1MB or 1 data page so 1MB / 4KB /
    2 = 128 RCU. A strongly consistent scan will consume 256 RCUs. It
    can cause throttling to partition.

Reduce page size

Because a Scan operation reads an entire page (by
default, 1 MB), you can reduce the impact of the scan operation by
setting a smaller page size. The Scan operation provides a Limit
parameter that you can use to set the page size for your request. Each
Query or Scan request that has a smaller page size uses fewer read
operations and creates a "pause" between each request. For example,
suppose that each item is 4 KB and you set the page size to 40 items. A
Query request would then consume only 20 eventually consistent read
operations or 40 strongly consistent read operations. A larger number of
smaller Query or Scan operations would allow your other critical
requests to succeed without throttling.

Isolate scan operations

DynamoDB is designed for easy scalability. As a result,
an application can create tables for distinct purposes, possibly even
duplicating content across several tables. You want to perform scans on
a table that is not taking "mission-critical" traffic. Some applications
handle this load by rotating traffic hourly between two tables—one for
critical traffic, and one for bookkeeping. Other applications can do
this by performing every write on two tables: a "mission-critical"
table, and a "shadow" table.



A parallel scan can be the right choice if the
following conditions are met:

• The table size is 20 GB or larger.

• The table's provisioned read throughput is not being
fully used.

• Sequential Scan operations are too slow.

#### Secondary Indexes

Global secondary index—An index
with a partition key and a sort key that can be different from those on
the base table. A global secondary index is considered "global" because
queries on the index can span all of the data in the base table, across
all partitions. A global secondary index has no size limitations and has
its own provisioned throughput settings for read and write activity that
are separate from those of the table.

Local secondary index—An index
that has the same partition key as the base table, but a different sort
key. A local secondary index is "local" in the sense that every
partition of a local secondary index is scoped to a base table partition
that has the same partition key value. As a result, the total size of
indexed items for any one partition key value can't exceed 10 GB. Also,
a local secondary index shares provisioned throughput settings for read
and write activity with the table it is indexing.



Each table in DynamoDB is limited to 20 global
secondary indexes (default limit) and 5 local secondary indexes.

#### Exam Tips

  - If you enable DynamoDB Streams on a table, you can
    associate the stream ARN with a Lambda function that you write.
    Immediately after an item in the table is modified, a new record
    appears in the table's stream. AWS Lambda polls the stream and
    invokes your Lambda function synchronously when it detects new
    stream records. The Lambda function can perform any actions you
    specify, such as sending a notification or initiating a
    workflow.
  - Indexes are sparse and only contain items from
    table which applies to index. They can be useful to limit the size
    and cost of reads. Regardless of what attributes are read, read
    costs are for the full item.
  - Each read is 4 KB, Writes are 1 KB. One RCU = 2
    reads per second. Once RCU = 8 kbs data read per second. Eventual
    consistency reads are half the cost.
  - DynamoDB allows for the storage of large text and
    binary objects, but there is a limit of 400 KB. 
  - Headers sent to DynamoDB API:

<!-- end list -->

  - X-Amz-Target
  - X-Amz-Date
  - Host
  - Authorization

<!-- end list -->

  - Headers received in response:

<!-- end list -->

  - x-Amz-RequestID
  - x-amz-crc32

#### Limits

  - One read capacity unit = one strongly consistent
    read per second, or two eventually consistent reads per second, for
    items up to 4 KB in size.
  - One write capacity unit = one write per second, for
    items up to 1 KB in size.
  - Transactional read requests require two read
    capacity units to perform one read per second for items up to 4
    KB.
  - Transactional write requests require two write
    capacity units to perform one write per second for items up to 1
    KB.
  - 20 Global Secondary Indexes
  - 40000 max RCUs and WCUs per table
  - 80000 RCUs/WCUs per account
  - Total number of non key attributes must not exceed
    100. Same attribute in GSI is counted twice.
  - For every distinct partition key value, the total
    sizes of all table and index items cannot exceed 10 GB.
  - A transaction cannot contain more than 25 unique
    items.
  - A transaction cannot contain more than 4 MB of
    data.

#### Encryption

 AWS owned CMK – Default encryption type. The key is
owned by DynamoDB (no additional charge).

 AWS managed CMK – The key is stored in your account
and is managed by AWS KMS (AWS KMS charges apply).

#### Pricing

##### Provisioned throughput (write):

One write capacity unit (WCU) provides up to one write
per second of upto 1 KB data or 2 WCUs for 1 KB transactional write,
enough for 2.5 million writes per month. As low as $0.47 per month per
WCU.

##### Provisioned throughput (read)

One read capacity unit (RCU) provides up to two reads
per second with eventual consistency and one read per second for
strongly consistent read, enough for 5.2 million reads per month. As low
as $0.09 per RCU.

##### Indexed data storage

DynamoDB charges an hourly rate per GB of disk
space

that your table consumes. As low as $0.25 per
GB.

#### References

[https://acloud.guru/learn/aws-dynamodb](https://acloud.guru/learn/aws-dynamodb&sa=D&ust=1570987253722000) 

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-dynamodb/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-dynamodb/&sa=D&ust=1570987253722000)

[https://aws.amazon.com/dynamodb/faqs/](https://aws.amazon.com/dynamodb/faqs/&sa=D&ust=1570987253723000) 

[https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/HowItWorks.ReadWriteCapacityMode.html](https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/HowItWorks.ReadWriteCapacityMode.html&sa=D&ust=1570987253723000) 

[https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/HowItWorks.ReadConsistency.html](https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/HowItWorks.ReadConsistency.html&sa=D&ust=1570987253723000) 

[https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/CapacityUnitCalculations.html](https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/CapacityUnitCalculations.html&sa=D&ust=1570987253724000) 

See
[https://www.youtube.com/watch?v=HaEPXoXVf2k](https://www.youtube.com/watch?v%3DHaEPXoXVf2k&sa=D&ust=1570987253724000) 

And
[https://www.youtube.com/watch?v=jzeKPKpucS0](https://www.youtube.com/watch?v%3DjzeKPKpucS0&sa=D&ust=1570987253724000) 



### Redshift

  - 1000$ per TB per year
  - Single Node 160 GB or Multi node
  - Leader node handles client connections and queries
    and compute nodes handle work. Can have upto 128 compute
    nodes.
  - Backups are default to 1 day retention
    period
  - maintains at least three copies. One your master
    then replica on compute nodes and then on S3
  - Can snapshot data to s3 async
  - Charged per compute node hour
  - Only available in one AZ at a time
  - Max backup retention is 35 days
  - Redshift spectrum can be used to query exabytes of
    data in S3.
  - Node Type

<!-- end list -->

  - Dense storage (DS) node
    type – for large data workloads and use hard disk drive (HDD)
    storage.
  - Dense compute (DC) node
    types – optimized for performance-intensive workloads. Uses SSD
    storage.

#### Exam Tips

  - No Auto Scaling. Nodes can be added as read only
    while cluster remains in service.

#### References

Check out this Amazon Redshift Cheat Sheet:

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-redshift/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-redshift/&sa=D&ust=1570987253726000)

Redshift Course on A Cloud Guru:

[https://acloud.guru/learn/aws-redshift-table-design](https://acloud.guru/learn/aws-redshift-table-design?_ga%3D2.185317354.293153258.1569076828-1085153524.1565615946%26_gac%3D1.52816602.1565740621.Cj0KCQjwv8nqBRDGARIsAHfR9wASkgeX73eLo-ebaaOo4Kd5M9XshDJeDLL-idsrRBfpuEtKSbOCGVsaAkmLEALw_wcB&sa=D&ust=1570987253727000)



[https://aws.amazon.com/redshift/faqs/](https://aws.amazon.com/redshift/faqs/&sa=D&ust=1570987253727000) 



### Elasticache

  - Memsql scales horizontally and has multi threaded
    performance. It doesn’t support Multi AZ
  - Redis doesn’t scale horizontally but has a lot of
    features.
  - Can do backup and restores of Redis but not of
    memsql
  - Cache is used to increase db/web
    performance.
  - Can be placed between RDS and Application to cache
    queries

<!-- end list -->

  - Can have upto 15 replicas
  - Can failover automatically to read replica

#### ElastiCache Redis

  - Automatic detection and recovery from cache node
    failures.
  - Multi-AZ with automatic failover of a failed
    primary cluster to a read replica in Redis clusters that support
    replication.
  - Redis (cluster mode enabled) supports partitioning
    your data across up to 90 shards.
  - Redis supports in-transit and at-rest encryption
    with authentication so you can build HIPAA-compliant
    applications.
  - Flexible Availability Zone placement of nodes and
    clusters for increased fault tolerance.
  - Data is persistent.
  - Auth by providing redis auth header

#### Memcached

  - Automatic discovery of nodes within a cluster
    enabled for automatic discovery, so that no changes need to be made
    to your application when you add or remove nodes.
  - Flexible Availability Zone placement of nodes and
    clusters.
  - ElastiCache Auto
    Discovery feature for Memcached lets your
    applications identify all of the nodes in a cache cluster and
    connect to them.
  - ElastiCache node access is restricted to
    applications running on whitelisted EC2 instances. You can control
    the instances that can access your cluster by using subnet groups or
    security groups.
  - It is not persistent.
  - Supports large nodes with multiple cores or
    threads.
  - Does not support multi-AZ failover or
    replication

#### Caching Strategies

Lazy Loading – a caching
strategy that loads data into the cache only when necessary.

Write Through – adds data or
updates data in the cache whenever data is written to the
database.

  - Data in the cache is never stale.

By adding a time to live (TTL) value to each write, we
are able to enjoy the advantages of each strategy and largely avoid
cluttering up the cache with superfluous data.

#### References

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-elasticache/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-elasticache/&sa=D&ust=1570987253730000)

### Athena

Amazon Athena is an interactive query service
that

makes it easy for you to analyze data in Amazon S3
using standard SQL. Athena is

serverless, so there is no infrastructure to manage,
and you pay only for the queries

that you run.

See
[https://aws.amazon.com/athena/faqs/](https://aws.amazon.com/athena/faqs/&sa=D&ust=1570987253731000) 

### Elastic Search

  - Amazon ES lets you search, analyze, and visualize your data
    in real-time. This
    service manages the capacity, scaling, patching, and administration
    of your Elasticsearch clusters for you, while still giving you
    direct access to the Elasticsearch APIs.
  - The service offers open-source Elasticsearch APIs, managed
    Kibana, and integrations with Logstash and other AWS Services. This
    combination is often coined as the ELK
    Stack.
  - An Amazon ES
    domain is synonymous
    with an Elasticsearch cluster. Domains are clusters with the
    settings, instance types, instance counts, and storage resources
    that you specify.
  - Kibana, an open-source
    analytics and visualization platform. Kibana is automatically
    deployed with your Amazon Elasticsearch Service domain.
  - You can load streaming data from the following
    sources using AWS Lambda event handlers:

<!-- end list -->

  - Amazon S3
  - Amazon Kinesis Data Streams and Data
    Firehose
  - Amazon DynamoDB
  - Amazon CloudWatch
  - AWS IoT

<!-- end list -->

  - Amazon ES uses Amazon
    Cognito to offer username and password
    protection for Kibana. (Optional feature)
  - You can deploy your Amazon ES instances across multiple AZs
    (up to three).
    
  - Even if you select two Availability Zones when configuring
    your domain, Amazon ES automatically distributes dedicated master
    nodes across three Availability
    Zones. This distribution helps prevent
    cluster downtime if a zone experiences a service disruption. It also
    assists in electing a new master node through a quorum between the
    two remaining nodes.
  - Use Cases

<!-- end list -->

  - Log Analytics
  - Real-Time Application Monitoring
  - Security Analytics
  - Full Text Search
  - Clickstream Analytics

#### References

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-elasticsearch-amazon-es/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-elasticsearch-amazon-es/&sa=D&ust=1570987253734000)

## Route 53

### Alias Records

  - You can create special Route 53 records, called
    alias records, that
    route traffic to S3 buckets, CloudFront distributions, and other AWS
    resources.
  - Queries to Alias records are provided at no
    additional cost to current Route 53 customers when the records are
    mapped to the following AWS resource types:

<!-- end list -->

  - Elastic Load Balancers
  - Amazon CloudFront distributions
  - AWS Elastic Beanstalk environments
  - Amazon S3 buckets that are configured as website
    endpoints
  - Alias with type A possible for domains. Alias with
    type AAAA for ipv6. No Alias with type CNAME.

### Exam tips

  - ELB doesn’t have ipv4 address. We always need a DNS
    record to resolve to it. More about it in ELB section.
  - Alias Record vs CNAME: Can't have cname for naked
    domain name like acloud.guru. CNAME must be some subdomain.
  - When given the choice between Alias Record vs CNAME
    always choose Alias Record.
  - When creating a record in Route 53 to other AWS
    resources, including ALB's, you should use Alias records where
    available. 
  - Route 53 has a security feature that prevents
    internal DNS from being read by external sources. The work around is
    to create a EC2 hosted DNS instance that does zone transfers from
    the internal DNS, and allows itself to be queried by external
    servers. 

### DNS record types

  - SOA =\> TTL, zone, administrator of zone, current
    version of data file
  - NS =\> which name server is primary
  - A Record =\> A record resolves to ip
  - CNAME =\> Alias to other domain
  - MX Records =\> mail
  - PTR Records =\> Reverse of A record, resolves name
    of ip

### Simple Routing Policy

  - One record with multiple ip address
  - All IP addresses are returned in random order to
    user

### Weighted Routing Policy

  - Split traffic based on weight
  - 10% to EAST 1 and 90% to WEST
  - Health checks can help eliminate unhealthy
    instances. Can also setup SNS notifications

### Latency Based Routing

  - Routes based on how much latency will user face
    when connecting to a server. So if user is in London, he will get
    Irish web server.

### Failover Policy

  - It fails over to passive server depending on health
    check

### Geolocation Routing Policy

  - Routes to specific ips depending on where the user
    is coming from. A default must be set otherwise all requests with no
    geolocation record set will fail.

### Geo proximity Routing

  - Can route traffic based on the locations of your
    users as well as resources. You must use Route 53 Traffic Flow for
    this. Not tested in exam.

### Multivalue Answer Policy

  - Same as Simple Routing policy but you can put
    health checks so only healthy ips will be given to the
    client.



Keep in mind AWS use
ALIAS record for zone
apex (naked domain) not CNAME.

### References

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-route-53/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-route-53/&sa=D&ust=1570987253739000) 

[https://aws.amazon.com/route53/faqs/](https://aws.amazon.com/route53/faqs/&sa=D&ust=1570987253739000) 

## VPC

The first four IP addresses and the last IP address in each subnet
CIDR block are not available for you to use, and cannot be assigned to
an instance.

Route table, ACL, and Network Security group when you
create new VPC

No subnet or internet gateway

one subnet = one AZ



Availability zones are randomized



One internet gateway per VPC. Can't attach
multiple



Security groups are specific to VPC



Amazon reserves 5 ip addresses in your subnet



If there is more than one rule for a specific port, we
apply the most permissive rule. For example, if you have a rule that
allows access to TCP port 22 (SSH) from IP address 203.0.113.1 and
another rule that allows access to TCP port 22 from everyone, everyone
has access to TCP port 22.



  - AWS PrivateLink enables you
    to privately connect your VPC to supported AWS services, services
    hosted by other AWS accounts (VPC endpoint services), and supported
    AWS Marketplace partner services. You do not require an internet
    gateway, NAT device, public IP address, AWS Direct Connect
    connection, or VPN connection to communicate with the service.
    Traffic between your VPC and the service does not leave the Amazon
    network.
  - You can create a VPC peering
    connection between your VPCs, or with a VPC
    in another AWS account, and enable routing of traffic between the
    VPCs using private IP addresses. You cannot create a VPC peering
    connection between VPCs that have overlapping CIDR blocks.



### NAT instance vs NAT Gateway

NAT instance is single instance and Gateway is multiple
highly available instances

Must disable src and dst ip check for nat
instance

NAT instance is behind a security group

Must be route out of private subnet to nat instance to
allow traffic

If bottleneck, increase instance size



### Instance Gateways 

Gateway is managed by amazon

Redundant among an AZ. Can be made multi AZ

Starts at 5 GBps and can scale upto 45 GBPs

Not associate with security group

### Network ACLS

New network ACL denies everything



Deny must be before allow for a ip range

One subnet has one ACL but one ACL can be associated
with many subnets

Network ACLs are first and then security groups
come



Default ACL comes with VPC and it allows all  
If you dont associate an ACL to subnet, it goes to default ACL



Network ACLs run lowest number rule first and return
when first rule matches

Stateless, so need to do it for both inbound and
outbound.

### Load Balancers and Custom VPC

We need at least two public facing subnets to create a
load balancer.

### Flow logs

Can’t enable flow logs for VPN which is peered to your
VPC unless peered VPC is in your account

Can’t tag a flow log.

Once flow log is created, you can’t modify its
configuration

Amazon DNS traffic is not monitored

Traffic to 169.254.169.254 is not monitored

DHCP is not monitored

Traffic to default VPC router is not monitored

Flow logs on VPC, subnet and network interface
level

### Bastion Host

Bastions are used to administer EC2 instances and are
the only way to get in the cluster. They are created to reduce surface
area of attack. Can’t use NAT gateway as bastion



### Direct Connect

Directly connects your data center to aws

Useful for high throughput

If you need stable and reliable connection

For VPN question dropping, use Direct Connect



VPC Endpoints

Allow you to connect to Amazon Services without needing
NAT or Internet gateway.

Two types:

Interface Endpoints

Elastic Network Interface with private IP which can be
used to reach other amazon services



VPC endpoints are enabled by PrivateLink

5vpc per region



Routes/Internet Gateway must be before launching
instance

NAT instance must be in public subnet and route of
private subnet has a rule saying 0.0.0.0/0 will go through NAT
gateway



Interface endpoints

Attach ENI with private IP to instance

Gateway Endpoints

They’re supported for dynamodb and S3 currently



To ensure that only you can bring your address range to
your AWS account, you must authorize Amazon to advertise the address
range and provide proof that you own the address range.

A Route Origin Authorization
(ROA) is a document that you can create through
your Regional internet registry (RIR), such as the American Registry for
Internet Numbers (ARIN) or Réseaux IP Européens Network Coordination
Centre (RIPE). It contains the address range, the ASNs that are allowed
to advertise the address range, and an expiration date. 

### ENI

An elastic network interface (ENI) is a logical
networking component in a VPC that represents a virtual network card.
You can attach a network interface to an EC2 instance in the following
ways:

1.  When it's running (hot attach)
2.  When it's stopped (warm attach)
3.  When the instance is being launched (cold
    attach).

### Exam Tips

  - Please know if an instance is configured properly
    on custom VPC with Internet Gateway routing the traffic to internet
    in public subnet and Security Group and Network ACLs defining right
    ports for connection and still not able to connect to your instance
    consider assigning Public IP/Elastic IP.
  - Please know how Virtual Private Network (VPN) connection works
    and Direct Gateway for private
    connections, don’t mix with PRIVATE SUBNET,
    you can use public subnet with VPN. 
  - While if you using a NAT instance and you have configured it
    all correct but when connecting your private subnet instance to
    internet for outbound traffic it’s connecting, but WHY? You forgot
    to Disable Source/Destination checks flag, exactly this was question
    on my exam. Wait do you know what we can use other than NAT instance
    and NAT gateway to give secure outbound internet connect to our
    private subnet, that’s bastion host or call it jump server, and it
    resides in public
    subnet, got 2 questions on this single point
    with different scenarios.
  - AWS provides instances launched in a non-default
    VPC with private DNS hostname and possibly a public DNS hostname,
    depending on the DNS attributes you specify for the VPC and if your
    instance has a public IPv4 address.
  - Set VPC attributes enableDnsHostnames
    and
    enableDnsSupport to
    true so that your instances receive a public DNS hostname and
    Amazon-provided DNS server can resolve Amazon-provided private DNS
    hostnames.

<!-- end list -->

  - If you use custom DNS domain names defined in a private hosted
    zone in Route 53, the
    enableDnsHostnames and
    enableDnsSupport attributes
    must be set to true.

<!-- end list -->

  - Max 5 VPC per region
  - 200 Subnets per VPC
  - Once a VPC is set to Dedicated hosting, it can be
    changed back to default hosting via the CLI, SDK or API. Note that
    this will not change hosting settings for existing instances, only
    future ones. Existing instances can be changed via CLI, SDK or API
    but need to be in a stopped state to do so. Note dedicated VPC \!=
    Dedicated EC2 tenancy
  - NAT instances are for internet. They have nothing
    to do with VPN.
  - Direct Connect is carrier, but VPN still needs to
    be configured. Assign ASN for VPN.

### VPC Endpoints

  - Privately connect your VPC to supported AWS
    services and VPC endpoint services powered by PrivateLink without
    requiring an internet gateway, NAT device, VPN connection, or AWS
    Direct Connect connection.
  - Endpoints are virtual devices.

Interface Endpoints: An elastic
network interface with a private IP address that serves as an entry
point for traffic destined to a supported service.

Gateway Endpoints: A gateway
that is a target for a specified route in your route table, used for
traffic destined to a supported AWS service.

  - You can create multiple endpoints in a single VPC,
    for example, to multiple services. You can also create multiple
    endpoints for a single service, and use different route tables to
    enforce different access policies from different subnets to the same
    service.

  - Endpoints support IPv4 traffic only.

  - #### ClassicLink: Allows you to link an EC2-Classic instance to a VPC in your account, within the same region. This allows you to associate the VPC security groups with the EC2-Classic instance, enabling communication between your EC2-Classic instance and instances in your VPC using private IPv4 addresses.

Remember that for S3 and DynamoDB service, you have to use a
Gateway VPC Endpoint and not an
Interface VPC Endpoint.

### References

FAQ
[https://aws.amazon.com/vpc/faqs/](https://aws.amazon.com/vpc/faqs/&sa=D&ust=1570987253751000) 

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-vpc/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-vpc/&sa=D&ust=1570987253751000)

 

[https://docs.aws.amazon.com/vpc/latest/userguide/VPC\_Subnets.html](https://docs.aws.amazon.com/vpc/latest/userguide/VPC_Subnets.html&sa=D&ust=1570987253752000) 



[https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/TroubleshootingInstancesConnecting.html](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/TroubleshootingInstancesConnecting.html&sa=D&ust=1570987253752000) 



[https://aws.amazon.com/blogs/security/securely-connect-to-linux-instances-running-in-a-private-amazon-vpc/](https://aws.amazon.com/blogs/security/securely-connect-to-linux-instances-running-in-a-private-amazon-vpc/&sa=D&ust=1570987253753000) 



[https://docs.aws.amazon.com/vpc/latest/userguide/VPC\_NAT\_Instance.html](https://docs.aws.amazon.com/vpc/latest/userguide/VPC_NAT_Instance.html&sa=D&ust=1570987253753000) 



[https://docs.aws.amazon.com/vpc/latest/userguide/vpc-network-acls.html\#nacl-ephemeral-ports](https://docs.aws.amazon.com/vpc/latest/userguide/vpc-network-acls.html%23nacl-ephemeral-ports&sa=D&ust=1570987253754000) 



[https://docs.aws.amazon.com/vpn/latest/s2svpn/VPC\_VPN.html](https://docs.aws.amazon.com/vpn/latest/s2svpn/VPC_VPN.html&sa=D&ust=1570987253754000) 



[https://docs.aws.amazon.com/directconnect/latest/UserGuide/direct-connect-gateways.html](https://docs.aws.amazon.com/directconnect/latest/UserGuide/direct-connect-gateways.html&sa=D&ust=1570987253755000) 



[https://docs.aws.amazon.com/directconnect/latest/UserGuide/Colocation.html](https://docs.aws.amazon.com/directconnect/latest/UserGuide/Colocation.html&sa=D&ust=1570987253755000) 



VPC labs:
[https://learn.acloud.guru/labs/search?service=VPC](https://learn.acloud.guru/labs/search?service%3DVPC&sa=D&ust=1570987253756000) 

## SQS

  - Is a queue. It can store upto 256KB of text. Can
    scale upto 2 GB but data is stored in S3 Standard and FIFO
    queues

<!-- end list -->

  - Standard queues guarantee delivery but may deliver
    more than once occasionally. They give almost unlimited transactions
    per second

<!-- end list -->

  - FIFO queues are strictly ordered and always deliver
    once
  - Can store messages from 1 minute to 14 days.
    Default retention period is 4 day. 
  - Visibility timeout is time a message is invisible
    in queue after reader picks it up. Provided a reader completes task
    and acknowledges, messages is then deleted. If readers doesn’t
    acknowledge in time, then messages reappears and is delivered to a
    reader which can result in duplicate message delivery.
  - Visibility timeout is max 12 hours
  - Long poll doesn’t return until a message arrives or
    long poll timeouts
  - SQS is pull based. 
  - Note message must be deleted before visibility
    timeout
  - Amazon MQ can serve multiple subscribers at once.
    SQS can’t.

<!-- end list -->

  - You can include structured metadata (such as timestamps,
    geospatial data, signatures, and identifiers) with messages using
    message
    attributes.
  - Message timers let you
    specify an initial invisibility period for a message added to a
    queue. The default (minimum) invisibility period for a message is 0
    seconds. The maximum is 15 minutes.
  - You can configure an existing SQS queue to trigger
    an AWS Lambda function when new messages arrive in a queue. 
  - You can delete all the messages in your queue by
    purging them.
  - SQS supports dead-letter
    queues, which other queues can target for
    messages that can’t be processed successfully.
  - Delay queues let you
    postpone the delivery of new messages to a queue for a number of
    seconds.
  - Send, receive, or delete messages in
    batches of up to 10
    messages or 256KB.

### Limits

  - 256 kb batch limit
  - 10 messages batch limit
  - One request = 64 KB
  - Charges per million requests
  - Default delay for queue is 0 minutes, Max is
    15.
  - Fifo queues name must end with .fifo
  - Queue names can’t be more than 80 chars
  - Max 10 attributes per message
  - Standard queue has unlimited TPS
  - FIFO supports 3000 messages per second with batch
    or 300 without batch
  - Visibility timeout max is 12 hours
  - Longpoll max timeout is 20 seconds

### References

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-sqs/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-sqs/&sa=D&ust=1570987253760000)



[https://docs.aws.amazon.com/AWSSimpleQueueService/latest/SQSDeveloperGuide/sqs-how-it-works.html](https://docs.aws.amazon.com/AWSSimpleQueueService/latest/SQSDeveloperGuide/sqs-how-it-works.html&sa=D&ust=1570987253760000) 

## SWF



SWF is workflow service. You can have flows consisting
of code =\> service calls =\> humans =\> scripts. SWF is used by Amazon
in Order processing



SWF flows can last upto 1 year 

  
SWF Actors 

  - WOrkflow starters =\> Application that can start a
    workflow
  - Deciders =\> Control flow. Decides what to do when
    a workflow is finished or failed
  - Activity Workers =\> Do the actual work

## SNS

Can push notifications to SQS, Mobile Devices. Can send
SMS or emails. Or call any HTTP endpoint



A SNS topic is way to organize multiple recipients.
Topic can be subscribed to by recipients

SNS is push based

SNS vs SQS

SNS is push based SQS is pull based

Can filter subscription based on message
attribute



Direct addressing allows you
to deliver notifications directly to a single endpoint, rather than
sending identical messages to all subscribers of a topic. This is useful
if you want to deliver precisely targeted messages to each
recipient.

SMS messages that are of high priority to your business should be
marked as
Transactional. This
ensures that messages such as those that contain one-time passwords or
PINs get delivered over routes with the highest delivery
reliability.

SMS messages that carry marketing messaging should be marked
Promotional. Amazon SNS
ensures that such messages are sent over routes that have a reasonable
delivery reliability but are substantially cheaper than the most
reliable routes.

### Limits

  - A single SMS message can contain a maximum of 140
    bytes of information.
  - With the exception of SMS messages, SNS messages
    can contain up to 256 KB of text data.

## Elastic Transcoder

It converts your media files to other format. Images
not supported. Only audio + Video

## KINESIS

Streaming data. Stock Market, Games, Social Network
data, Geospatial data like Uber, iOT sensor data.

Kinesis is a place to send your streaming data to in
AWS.



Kinesis has three types:

### Kinesis Streams

Shards are 5 transactions per second for reads. Can
read upto 2 MB data per second. Can write 1000 records per second and
max 1 MB write.



Stores data from 24 hours to 24 x 7. Data is sharded.
Then shards are analyzed by EC2 Consumers. Then EC2 can store it in
separate places like s3/redshift,dynamodb.



One shard can ingest up to 1000 data records per
second, or 1MB/sec. Add more shards to increase your ingestion
capability.

You will specify the number of shards needed when you
create a stream and can change the quantity at any time.

A single shard can ingest up to 1 MiB of data per
second (including partition keys) or 1,000 records per second for
writes.

Each shard can support up to five read transactions per
second.

Shards = Streams

### Kinesis Firehose

Firehose = Streams but not persistent

No persistent storage. It triggers lambda as soon as
data comes. Lambda can then send it to S3 and redshift. 

Kinesis Data Firehose can convert the format of your
input data from JSON to Apache Parquet or Apache ORC before storing the
data in S3. Parquet and ORC are columnar data formats that save space
and enable faster queries compared to row-oriented formats like
JSON.

  - Data delivery format:

<!-- end list -->

  - For data delivery to S3,
    Kinesis Data Firehose concatenates multiple incoming records based
    on buffering configuration of your delivery stream. It then delivers
    the records to S3 as an S3 object.
  - For data delivery to Redshift, Kinesis
    Data Firehose first delivers incoming data to your S3 bucket in the
    format described earlier. Kinesis Data Firehose then issues a
    Redshift
    COPY command to
    load the data from your S3 bucket to your Redshift cluster.
  - For data delivery to
    ElasticSearch, Kinesis Data Firehose buffers
    incoming records based on buffering configuration of your delivery
    stream. It then generates an Elasticsearch bulk request to index
    multiple records to your Elasticsearch cluster.
  - For data delivery to
    Splunk, Kinesis Data Firehose concatenates
    the bytes that you send.

<!-- end list -->

  - Data delivery frequency

<!-- end list -->

  - The frequency of data delivery to S3 is determined by the
    S3 Buffer size and
    Buffer
    interval value that you configured for your
    delivery stream.
  - The frequency of data COPY
    operations from S3 to Redshift is determined by how
    fast your Redshift cluster can finish the
    COPY
    command.
  - The frequency of data delivery to ElasticSearch is determined
    by the Elasticsearch Buffer
    size and Buffer
    interval values that you configured for your
    delivery stream.
  - Kinesis Data Firehose buffers incoming data before
    delivering it to Splunk. The buffer size is 5 MB, and the buffer
    interval is 60 seconds.

<!-- end list -->

  - By default, each account can have up to 50 Kinesis
    Data Firehose delivery streams per Region.
  - The maximum size of a record sent to Kinesis Data
    Firehose, before base64-encoding, is 1,000 KiB.
  - 

### Kinesis Analytics

  - Works with firehose and streams. It can analyze
    data in realtime then can store it in S3 or ElasticSearch
    cluster.
  - You can quickly build SQL queries and Java
    applications using built-in templates and operators for common
    processing functions to organize, transform, aggregate, and analyze
    data at any scale.
  - SQL applications in Kinesis Data Analytics support
    two types of inputs:

<!-- end list -->

  - A streaming data
    source is continuously generated data that
    is read into your application for processing.
  - A reference data
    source is static data that your application
    uses to enrich data coming in from streaming sources.

<!-- end list -->

  - Uses Apache Flink for data stream analytics
  - An in-application data
    stream is an entity that continuously stores
    data in your application for you to perform processing.
  - Kinesis Data Analytics provisions capacity in the form of
    Kinesis Processing Units
    (KPU). A single KPU provides you with the
    memory (4 GB) and corresponding computing and networking.
  - Kinesis Data Analytics for Java applications
    provides your application 50 GB of running application storage per
    Kinesis Processing Unit. Kinesis Data Analytics scales storage with
    your application.
  - The SQL code in an application is limited to 100
    KB.

### References

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-kinesis/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-kinesis/&sa=D&ust=1570987253769000)

## Elastic Beanstalk

Can easily deploy applications in AWS without worrying
about any infrastructure details.

You can use environment properties to pass secrets,
endpoints, debug settings, and other information to your
application.

You can configure your environment to use
Amazon SNS to notify you
of important events that affect your application.

Your environment is available to users at a
subdomain of
elasticbeanstalk.com. When you create an
environment, you can choose a unique subdomain that represents your
application.

## LightSail vs Beanstalk

Lightsail is like godaddy or cpanel. It’s easier to
manage things. You don’t need to know anything. Beanstalk is like
heroku. It’s cloudformation template behind the scenes and creates
stacks for you like RDS+EC2+Load Balancers.

## Serverless / Lambda

  - Lambda scales out. 1 event = 1 function. It is
    serverless.
  - You choose the amount of memory you want to
    allocate to your functions and AWS Lambda allocates proportional CPU
    power, network bandwidth, and disk I/O.
  - Supports the following languages:

<!-- end list -->

  - Node.js
  - Java
  - C\#
  - Go
  - Python

<!-- end list -->

  - Lambda supports
    synchronous and
    asynchronous invocation of a
    Lambda function. You can control the invocation type only when you
    invoke a Lambda function (referred to as
    on-demand
    invocation).
  - An event
    source is the entity that publishes events,
    and a Lambda function is the custom code that processes the
    events.
  - Each Lambda function receives 500MB of
    non-persistent disk space in its own /tmp directory.
  - AWS Lambda functions can be configured to run up to
    15 minutes per execution. You can set the timeout to any value
    between 1 second and 15 minutes.

### Lambda@Edge

  - Lets you run Lambda functions to customize content
    that CloudFront delivers, executing the functions in AWS locations
    closer to the viewer. The functions run in response to CloudFront
    events, without provisioning or managing servers.

<!-- end list -->

  - You can use Lambda functions to change CloudFront
    requests and responses at the following points:

<!-- end list -->

  - After CloudFront receives a request from a viewer
    (viewer request)
  - Before CloudFront forwards the request to the
    origin (origin request)
  - After CloudFront receives the response from the
    origin (origin response)
  - Before CloudFront forwards the response to the
    viewer (viewer response)

<!-- end list -->

  - You can automate your serverless application’s
    release process using AWS CodePipeline and AWS CodeDeploy.

### Deployment Types

If you're using the AWS Lambda compute platform, you
must choose one of the following deployment configuration types to
specify how traffic is shifted from the original AWS Lambda function
version to the new AWS Lambda function version:

  - -Canary: Traffic is shifted
    in two increments. You can choose from predefined canary options
    that specify the percentage of traffic shifted to your updated
    Lambda function version in the first increment and the interval, in
    minutes, before the remaining traffic is shifted in the second
    increment.
  - -Linear: Traffic is shifted
    in equal increments with an equal number of minutes between each
    increment. You can choose from predefined linear options that
    specify the percentage of traffic shifted in each increment and the
    number of minutes between each increment.
  - -All-at-once: All traffic
    is shifted from the original Lambda function to the updated Lambda
    function version at once.



### Exam Tips

  - RDS is not serverless. Dynamodb is serverless.
    Aurora is serverless. Functions can trigger other functions. AWS
    Xray allows you to debug serverless functions.
  - High availability question + cost effective = serverless
    
  - Each application is packaged with an AWS Serverless
    Application Model (SAM) template that defines the AWS resources
    used.
  - Also encryption of ENV vars is done by using KMS
    and encryption helpers

### Pricing

Duration is calculated from the time your code begins
executing until it returns or otherwise terminates, rounded up to the
nearest 100 milliseconds. The price depends on the amount of memory you
allocate to your function.

• Free Tier: 1 million requests per month, 400,000
GB-seconds of compute time per month

• $0.20 per 1 million requests thereafter, or
$0.0000002 per request

Duration pricing

• 400,000 GB-seconds per month free, up to 3.2 million
seconds of compute time

• $0.00001667 for every GB-seco

### References

[https://docs.aws.amazon.com/lambda/latest/dg/env\_variables.html\#env\_encrypt](https://docs.aws.amazon.com/lambda/latest/dg/env_variables.html%23env_encrypt&sa=D&ust=1570987253776000) 

Serverless/ Lambda:
[https://acloud.guru/learn/aws-lambda](https://acloud.guru/learn/aws-lambda?_ga%3D2.47847015.1515388834.1568847627-1085153524.1565615946%26_gac%3D1.53277402.1565740621.Cj0KCQjwv8nqBRDGARIsAHfR9wASkgeX73eLo-ebaaOo4Kd5M9XshDJeDLL-idsrRBfpuEtKSbOCGVsaAkmLEALw_wcB&sa=D&ust=1570987253776000)

[https://acloud.guru/learn/serverless-for-beginners](https://acloud.guru/learn/serverless-for-beginners&sa=D&ust=1570987253777000)

With GCP and Azure: More advanced

[https://acloud.guru/learn/the-complete-serverless-course](https://acloud.guru/learn/the-complete-serverless-course&sa=D&ust=1570987253777000) 

See this cheatsheet:
[https://tutorialsdojo.com/aws-cheat-sheet-aws-lambda/](https://tutorialsdojo.com/aws-cheat-sheet-aws-lambda/&sa=D&ust=1570987253778000) 

FAQ page:
[https://aws.amazon.com/lambda/faqs/](https://aws.amazon.com/lambda/faqs/&sa=D&ust=1570987253778000) 

## API Gateway

  - Caching capabilities
  - Scales automatically
  - Can throttle traffic
  - Can enable CORS
  - Can log requests to cloudwatch
  - Together with Lambda, API Gateway forms the
    app-facing part of the AWS serverless infrastructure.

<!-- end list -->

  - API Gateway can execute Lambda code in your
    account, start Step Functions state machines, or make calls to
    Elastic Beanstalk, EC2, or web services outside of AWS with publicly
    accessible HTTP endpoints.
  - API Gateway helps you define plans that meter and
    restrict third-party developer access to your APIs.
  - API Gateway helps you manage traffic to your
    backend systems by allowing you to set throttling rules based on the
    number of requests per second for each HTTP method in your
    APIs.
  - You can set up a cache with customizable keys and
    time-to-live in seconds for your API data to avoid hitting your
    backend services for each request.
  - API Gateway lets you run multiple versions of the same API
    simultaneously with API
    Lifecycle.
  - After you build, test, and deploy your APIs, you
    can package them in an API Gateway usage plan and sell the plan as a
    Software as a Service (SaaS) product through AWS Marketplace.
  - API Gateway offers the ability to create, update,
    and delete documentation associated with each portion of your API,
    such as methods and resources.

<!-- end list -->

  - All of the APIs created expose HTTPS
    endpoints only. API Gateway does not support
    unencrypted (HTTP) endpoints.
  - In Amazon API Gateway, stages are similar to tags.
    They define the path through which the deployment is accessible. For
    example, you can define a development stage and deploy your cars API
    to it. The resource will be accessible at
    https://www.myapi.com/dev/cars. 
  - Stage variables let you define key/value pairs of
    configuration values associated with a stage. These values,
    similarly to environment variables, can be used in your API
    configuration. For example, you could define the HTTP endpoint for
    your method integration as a stage variable, and use the variable in
    your API configuration instead of hardcoding the endpoint – this
    allows you to use a different endpoint for each stage (e.g. dev,
    beta, prod) with the same API configuration.
  - Amazon API Gateway saves the history of your
    deployments. At any point, using the Amazon API Gateway APIs or the
    console, you can roll back a stage to a previous deployment.

### Security and Authorization

When setting up a method to require authorization you
can leverage AWS Signature Version 4 or Lambda authorizers to support
your own bearer token auth strategy.

#### Signature v4

You can use AWS credentials - access and secret keys -
to sign requests to your service and authorize access like other AWS
services. The signing of an Amazon API Gateway API request is managed by
the custom API Gateway SDK generated for your service. You can retrieve
temporary credentials associated with a role in your AWS account using
Amazon Cognito.

#### Lambda Authorizers

Lambda authorizers are AWS Lambda functions. With
custom request authorizers, you will be able to authorize access to APIs
using a bearer token auth strategy such as OAuth. When an API is called,
API Gateway checks if a Lambda authorizer is configured, API Gateway
then calls the Lambda function with the incoming authorization token.
You can use Lambda to implement various authorization strategies (e.g.
JWT verification, OAuth provider callout) that return IAM policies which
are used to authorize the request. If the policy returned by the
authorizer is valid, API Gateway will cache the policy associated with
the incoming token for up to 1 hour.

### API Endpoint Types

  - Edge-optimized API
    endpoint: The default host name of an API
    Gateway API that is deployed to the specified region while using a
    CloudFront distribution to facilitate client access typically from
    across AWS regions. API requests are routed to the nearest
    CloudFront Point of Presence.
  - Regional API endpoint: The
    host name of an API that is deployed to the specified region and
    intended to serve clients, such as EC2 instances, in the same AWS
    region. API requests are targeted directly to the region-specific
    API Gateway without going through any CloudFront
    distribution.

<!-- end list -->

  - ### You can apply latency-based routing on regional endpoints to deploy an API to multiple regions using the same regional API endpoint configuration, set the same custom domain name for each deployed API, and configure latency-based DNS records in Route 53 to route client requests to the region that has the lowest latency.

<!-- end list -->

  - Private API endpoint:
    Allows a client to securely access private API resources inside a
    VPC. Private APIs are isolated from the public Internet, and they
    can only be accessed using VPC endpoints for API Gateway that have
    been granted access.

### Usage Plans

For web applications that offer personalized services,
you can leverage API Gateway usage plans as well as Amazon Cognito user
pools in order to scope what different sets of users have access
to

A usage
plan specifies who can access one or more
deployed API stages and methods — and also how much and how fast they
can access them. 

Provides selected API clients with access to one or
more deployed APIs. You can use a usage plan to configure throttling and
quota limits, which are enforced on individual client API keys.

### References

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-api-gateway/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-api-gateway/&sa=D&ust=1570987253782000)

[https://aws.amazon.com/api-gateway/faqs/](https://aws.amazon.com/api-gateway/faqs/&sa=D&ust=1570987253783000)

[https://docs.aws.amazon.com/apigateway/api-reference/](https://docs.aws.amazon.com/apigateway/api-reference/&sa=D&ust=1570987253783000) 

Lambda course

[https://acloud.guru/learn/aws-lambda](https://acloud.guru/learn/aws-lambda?_ga%3D2.185317354.293153258.1569076828-1085153524.1565615946%26_gac%3D1.52816602.1565740621.Cj0KCQjwv8nqBRDGARIsAHfR9wASkgeX73eLo-ebaaOo4Kd5M9XshDJeDLL-idsrRBfpuEtKSbOCGVsaAkmLEALw_wcB&sa=D&ust=1570987253783000)

## Cloud Formation

  - CloudFormation allows you to model your entire infrastructure
    in a text file called a
    template. You can use JSON or
    YAML to describe what AWS resources you want to create and
    configure. If you want to design visually, you can use
    AWS CloudFormation
    Designer.
  - You can use Rollback
    Triggers to specify the CloudWatch alarm
    that CloudFormation should monitor during the stack creation and
    update process. If any of the alarms are breached, CloudFormation
    rolls back the entire stack operation to a previous deployed
    state.
  - CloudFormation Change
    Sets allow you to preview how proposed
    changes to a stack might impact your running resources.
  - AWS StackSets lets you
    provision a common set of AWS resources across multiple accounts and
    regions with a single CloudFormation template.
  - CloudFormation
    artifacts can include a stack template
    file, a template configuration file, or both. AWS CodePipeline uses
    these artifacts to work with CloudFormation stacks and change
    sets.

<!-- end list -->

  - Stack Template File –
    defines the resources that CloudFormation provisions and configures.
    You can use YAML or JSON-formatted templates.
  - Template Configuration
    File – a JSON-formatted text file that can
    specify template parameter values, a stack policy, and tags. Use
    these configuration files to specify parameter values or a stack
    policy for a stack.

<!-- end list -->

  - Drift detection enables you
    to detect whether a stack’s actual configuration differs, or has
    drifted from its expected configuration. Use CloudFormation to
    detect drift on an entire stack, or on individual resources within
    the stack.

### Elements of Cloudformation template

AWS CloudFormation templates are JSON or YAML-formatted
text files that are comprised of five types of elements:

1. An optional list of template parameters (input
values supplied at stack creation time)

2. An optional list of output values (e.g. the complete
URL to a web application)

3. An optional list of data tables used to lookup
static configuration values (e.g., AMI names)

4. The list of AWS resources and their configuration
values

5. A template file format version number

#### Template Parameters

With parameters, you can customize aspects of your
template at run time, when the stack is built. For example, the Amazon
RDS database size, Amazon EC2 instance types, database and web server
port numbers can be passed to AWS CloudFormation when a stack is
created. Each parameter can have a default value and description and may
be marked as “NoEcho” in order to hide the actual value you enter on the
screen and in the AWS CloudFormation event logs. When you create an AWS
CloudFormation stack, the AWS Management Console will automatically
synthesize and present a pop-up dialog form for you to edit parameter
values.

#### Output Values

Output values are a very convenient way to present a
stack’s key resources (such as the address of an Elastic Load Balancing
load balancer or Amazon RDS database) to the user via the AWS Management
Console, or the command line tools. You can use simple functions to
concatenate string literals and value of attributes associated with the
actual AWS resources.

### References

Cloudformation:
[https://acloud.guru/learn/intro-aws-cloudformation](https://acloud.guru/learn/intro-aws-cloudformation&sa=D&ust=1570987253786000) 

Cloudformation labs:
[https://learn.acloud.guru/labs/search?vendor=AWS\&service=CloudFormation](https://learn.acloud.guru/labs/search?vendor%3DAWS%26service%3DCloudFormation&sa=D&ust=1570987253787000) 

Cloudformation course:

[https://acloud.guru/learn/intro-aws-cloudformation](https://acloud.guru/learn/intro-aws-cloudformation&sa=D&ust=1570987253787000) 

[https://acloud.guru/learn/aws-advanced-cloudformation](https://acloud.guru/learn/aws-advanced-cloudformation&sa=D&ust=1570987253788000) 

[https://docs.aws.amazon.com/AWSCloudFormation/latest/UserGuide/template-anatomy.html](https://docs.aws.amazon.com/AWSCloudFormation/latest/UserGuide/template-anatomy.html&sa=D&ust=1570987253788000) 

Cheatsheet:
[https://tutorialsdojo.com/aws-cheat-sheet-aws-cloudformation/](https://tutorialsdojo.com/aws-cheat-sheet-aws-cloudformation/&sa=D&ust=1570987253788000) (
Recommended to do a course on cloudformation or do labs for clearing
concepts. A Cloud Guru, introduction to cloudformation course is pretty
good)

## CloudWatch

cloudwatch monitors performance

cloudwatch monitors events every 5 minutes on
EC2

cloudwatch alarm can create notifications

#### Metrics – represents a time-ordered set of data points that are published to CloudWatch.

  - Exists only in the region in which they are
    created.
  - Cannot be deleted, but they automatically expire
    after 15 months if no new data is published to them.
  - As new data points come in, data older than 15
    months is dropped.
  - By default, several services provide free metrics for
    resources. You can also enable detailed
    monitoring, or publish your own application
    metrics.
  - Metric math enables you to
    query multiple CloudWatch metrics and use math expressions to create
    new time series based on these metrics.

Dimensions – a name/value pair that uniquely identifies
a metric.

  - You can assign up to 10 dimensions to a
    metric.
  - Whenever you add a unique dimension to one of your
    metrics, you are creating a new variation of that metric.

Statistics – metric data aggregations over specified
periods of time.

#### Alarms – watches a single metric over a specified time period, and performs one or more specified actions, based on the value of the metric relative to a threshold over time.

You can create an alarm for monitoring CPU usage and
load balancer latency, for managing instances, and for billing
alarms.

When an alarm is on dashboard, it turns red when it is in the
ALARM state.

Alarms invoke actions for sustained state changes
only.

Alarm States

  - OK—The metric or expression is within the defined
    threshold.
  - ALARM—The metric or expression is outside of the
    defined threshold.
  - INSUFFICIENT\_DATA—The alarm has just started, the
    metric is not available, or not enough data is available for the
    metric to determine the alarm state.

When you create an alarm, you specify three
settings:

  - Period is the length of time to evaluate the metric
    or expression to create each individual data point for an alarm. It
    is expressed in seconds.
  - Evaluation Period is the number of the most recent
    periods, or data points, to evaluate when determining alarm
    state.
  - Data Points to Alarm is the number of data points
    within the evaluation period that must be breaching to cause the
    alarm to go to the ALARM state

All dashboards are
global, not
region-specific.

5 actions per alarm max

10 dimensions max per metric



[https://tutorialsdojo.com/aws-cheat-sheet-amazon-cloudwatch/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-cloudwatch/&sa=D&ust=1570987253791000) 



CloudWatch Agent vs  SSM Agent vs Custom Daemon
Scripts:

[https://tutorialsdojo.com/aws-cheat-sheet-cloudwatch-agent-vs-ssm-agent-vs-custom-daemon-scripts/](https://tutorialsdojo.com/aws-cheat-sheet-cloudwatch-agent-vs-ssm-agent-vs-custom-daemon-scripts/&sa=D&ust=1570987253792000)

## CloudTrail

cloudtrail is audit based

cloudtrail monitors api calls like source ip/user of a
call



View events in Event
History, where you can view, search, and
download the past 90 days of activity in your AWS account.

  - Types

<!-- end list -->

  - A trail that applies to all
    regions – CloudTrail records events in each
    region and delivers the CloudTrail event log files to an S3 bucket
    that you specify. This is the default option when you create a trail
    in the CloudTrail console.
  - A trail that applies to one region –
    CloudTrail records the events in the region
    that you specify only. This is the default option when you create a
    trail using the AWS CLI or the CloudTrail API.

<!-- end list -->

  - You can create a organization
    trail that will log all events for all AWS
    accounts in an organization created by AWS Organizations.
    Organization trails must be created in the master account.

5 trails per region max. 

### References



[https://tutorialsdojo.com/aws-cheat-sheet-aws-cloudtrail/](https://tutorialsdojo.com/aws-cheat-sheet-aws-cloudtrail/&sa=D&ust=1570987253794000) 

## AWS Data Pipeline

AWS Data Pipeline is a web service that helps you
reliably process and move

data between different AWS compute and storage
services, as well as on-premises data sources, at specified intervals.
With AWS Data Pipeline, you can regularly access your data where it’s
stored, transform and process it at scale, and efficiently transfer the
results to AWS services such as Amazon S3, EMR, Redshift.

## AWS Step Functions

AWS Step Functions lets you coordinate multiple AWS
services into serverless workflows so you can build and update apps
quickly. Using Step Functions, you can design and run workflows that
stitch together services such as AWS  Lambda and Amazon ECS into
feature-rich applications. Workflows are made up of a series of steps,
with the output of one step acting as input into the next.



  - AWS Step Functions is a web service that provides
    serverless
    orchestration for modern applications. It
    enables you to coordinate the components of distributed applications
    and microservices using visual workflows.
  - Concepts

<!-- end list -->

  - Step Functions is based on the concepts of
    tasks and
    state
    machines.

<!-- end list -->

  - A task performs work by using an activity or an AWS
    Lambda function, or by passing parameters to the API actions of
    other services.
  - A finite state machine can express an algorithm as
    a number of states, their relationships, and their input and
    output.

<!-- end list -->

  - You define state machines using the
    JSON-based Amazon States
    Language.

Step Functions = Visual Workflow + State
Machines

SWF = Tasks, deciders and Actions

## AWS Cost Explorer

AWS Cost Explorer has an easy-to-use interface that
lets you visualize,

understand, and manage your AWS costs and usage over
time. Get started

quickly by creating custom reports (including charts
and tabular data) that

analyze cost and usage data, both at a high level
(e.g., total costs and usage

across all accounts) and for highly-specific requests
(e.g., m2.2xlarge costs

within account Y that are tagged “project:
secretProject”).



  - Forecasts are for three months in future.

## AWS Budgets

AWS Budgets gives you the ability to set custom budgets
that alert you when

your costs or usage exceed (or are forecasted to
exceed) your budgeted

amount. You can also use AWS Budgets to set RI
utilization or coverage

targets and receive alerts when your utilization drops
below the threshold you

Define.

## AWS Trust Advisor

Trusted Advisor checks the following four
categories

  - Cost Optimization
  - Security
  - Fault Tolerance
  - Performance
  - Service limits
  - NOTICE: No HA or Access Control





## KMS

Check out this AWS Key Management Service (KMS)
Cheat Sheet:

[https://tutorialsdojo.com/aws-cheat-sheet-aws-key-management-service-aws-kms/](https://tutorialsdojo.com/aws-cheat-sheet-aws-key-management-service-aws-kms/&sa=D&ust=1570987253798000)

## AWS WAF

  - A web application firewall that helps protect web applications
    from attacks by allowing you to configure rules that
    allow, block, or monitor (count) web
    requests based on conditions that you
    define.
  - These conditions include:

<!-- end list -->

  - IP addresses
  - HTTP headers
  - HTTP body
  - URI strings
  - SQL injection
  - cross-site scripting.

WAF lets you create rules to filter web traffic based
on conditions that include IP addresses, HTTP headers and body, or
custom URIs.

You can also create rules that block common web
exploits like SQL injection and cross site scripting.

  - Regular rules – use only
    conditions to target specific requests.
  - Rate-based rules – are
    similar to regular rules, with a rate limit. Rate-based rules count
    the requests that arrive from a specified IP address every five
    minutes. The rule can trigger an action if the number of requests
    exceed the rate limit.

[https://tutorialsdojo.com/aws-cheat-sheet-aws-waf/](https://tutorialsdojo.com/aws-cheat-sheet-aws-waf/&sa=D&ust=1570987253800000) 

[http://docs.aws.amazon.com/waf/latest/developerguide/getting-started.html\#getting-started-wizard-create-web-acl](http://docs.aws.amazon.com/waf/latest/developerguide/getting-started.html%23getting-started-wizard-create-web-acl&sa=D&ust=1570987253800000) 



## AWS Systems Manager

SSM Agent is the tool that
processes Systems Manager requests and configures your machine as
specified in the request. SSM Agent must be installed on each instance
you want to use with Systems Manager. On some instance types, SSM Agent
is installed by default. On others, you must install it manually.

Can work with containers too. 

Parameter Store

  - Provides secure, hierarchical storage for
    configuration data and secrets management.
  - You can store values as plain text or encrypted
    data.
  - Parameters work with Systems Manager capabilities
    such as Run Command, State Manager, and Automation.

### References

[https://tutorialsdojo.com/aws-systems-manager/](https://tutorialsdojo.com/aws-systems-manager/&sa=D&ust=1570987253801000) 

## AWS Config

  - A fully managed service that provides you with an
    AWS resource inventory, configuration history, and configuration
    change notifications to enable security and governance.
  - Provides you pre-built rules to evaluate your AWS
    resource configurations and configuration changes, or create your
    own custom rules in AWS Lambda that define your internal best
    practices and guidelines for resource configurations.
  - Config records details of
    changes to your AWS resources to provide you with a configuration
    history, and automatically deliver it to an S3 bucket you
    specify.
  - Receive a notification whenever a resource is
    created, modified, or deleted.
  - Config enables you to record software configuration
    changes within your EC2 instances and servers running on-premises,
    as well as servers and Virtual Machines in environments provided by
    other cloud providers. You gain visibility into:

<!-- end list -->

  - operating system configurations
  - system-level updates
  - installed applications
  - network configuration

<!-- end list -->

  - Max number of AWS Config rules per region in your
    account is 50
  - You can choose a retention period between a minimum
    of 30 days and a maximum of 7 years (2557 days).

## Snowball Vs Snowball Edge

Although an AWS Snowball device costs less than AWS
Snowball Edge, it cannot store 80 TB of data in one device. Take note
that the storage capacity is different from the usable capacity for
Snowball and Snowball Edge. Remember that an 80 TB Snowball appliance
and 100 TB Snowball Edge appliance only have 72 TB and 83 TB of usable
capacity respectively.

# WhitePapers

[https://tutorialsdojo.com/aws-well-architected-framework-five-pillars/](https://tutorialsdojo.com/aws-well-architected-framework-five-pillars/&sa=D&ust=1570987253803000) 

[https://tutorialsdojo.com/aws-well-architected-framework-design-principles/](https://tutorialsdojo.com/aws-well-architected-framework-design-principles/&sa=D&ust=1570987253803000) 

## Well Architected Framework

### Operational Excellence

#### Design Principles

Perform operations as code

Annotate Documentation

Make frequent, small, reversible changes

Refine Operations Procedures frequently

Anticipate failure

Learn from operation failures





#### Key AWS Services

CloudFormation

Three areas in operational excellence:

• Prepare: AWS Config and AWS Config rules can be used
to create standards for

workloads and to determine if environments are
compliant with those standards

before being put into production.

• Operate: Amazon CloudWatch allows you to monitor the
operational health of a

Workload. The key AWS service that helps you automate
response to events is AWS Lambda.

AWS Systems Manager is a collection of capabilities
that helps you automate management tasks on your EC2 instances and
systems in hybrid environments.

• Evolve: Amazon Elasticsearch Service (Amazon ES)
allows you to analyze your log

data to gain actionable insights quickly and
securely.

### Security

The AWS Shared Responsibility Model enables
organizations that adopt the cloud

to achieve their security and compliance goals.



#### Best Practices

Identity and Access Management: Use IAM and give least
privilege. For API calls, prefer temporary tokens or roles.

Infrastructure protection: Use hardened AMIs and
VPC

Data Protection: Use S3 with versioning. Use encryption
at rest. SSL can be used in transit and can be terminated at ELB.

Incident Response: Collect logs of important stuff and
Using cloudformation make clean room and isolate affected
instances



#### Key Services

 Identity and Access Management: IAM

Detective Controls:

Cloudtrail for audit and recording API calls. AWS
Config for details of infrastructure config change. Cloudwatch can
trigger events to automate security responses.

Amazon GuardDuty is a managed threat detection service
that continuously monitors for malicious or unauthorized
behavior.



#### Infrastructure Protection

VPC, Use AWS Shield with Cloudfront to enable DDos
Protection. AWS WAF is firewall which can protect against common web
exploits.

#### Data protection

Encryption capability in all storage services. AWS
Macie automatically discovers, classifies and protects sensitive data
while KMS makes it easy to manage and create keys for encryption

#### Incident Response

IAM should be used to give authorization to incident
response teams. Cloudformation can be used to provision a trusted
environment for conducting investigation. Cloudwatch events can trigger
automatic responses including calling Lambda functions.

#### AWS Shared Responsibility Model

AWS and customer work together towards security objectives. AWS
provides secure infrastructure and services, while you, the customer,
are responsible for secure operating systems, platforms, and
data.

### Reliability

#### Foundations

IAM , VPC, AWS Trusted Advisor provides visibility into
service limits. AWS Shield is a managed Distributed Denial of Service
(DDoS) protection service that safeguards web applications running on
AWS.

#### Change Management

Cloudtrail, AWS Config, Amazon Auto Scaling, Cloudwatch
logs and metrics

Failure Management

AWS Cloudformation provides templates for creation of
AWS resouces. S3 durable for backup services. Glacier for archival. KMS
for key management. 



### Performance Efficiency

#### Best Practices

##### Selection

Selection depends on the type of resource.

###### Compute

Instances, Containers and Functions. Take advantage of
elasticity mechanisms. 

###### Storage

Use S3, move between hDD to SSD in seconds. 

###### Database

Redshift, Dynamo, RDS.

##### Network

Consider location. Enhanced Networking, Amazon EBS
optimized instances, S3 transfer acceleration, Dynamic Cloudfront.
Network features: Route 53 latency based routing, VPC endpoints, Direct
Connect.

##### Monitoring

Cloudwatch for metrics and trigger actions through
kinesis, SQS and Lambda



##### Trade Offs

Amazon DynamoDB Accelerator (DAX) provides a
read-through/write-through distributed caching tier in front of Amazon
DynamoDB, supporting the same API, but providing sub-millisecond latency
for entities that are in the cache.

### Cost Optimization

#### Expenditure Awareness

You can use Cost explorer to track where you spend, get
insights. Using AWS Budgets you can get alerts of expenses increase
forecast. You can tag resources to get further insight into which units
you’re spending more on.

#### Cost Effective Resources

Use appropriate instances and resources. On-Demand
Instances

allow you to pay for compute capacity by the hour, with
no minimum commitments

required. Reserved Instances allow you to reserve
capacity and offer savings of up

to 75% off On-Demand pricing. With Spot Instances, you
can leverage unused Amazon EC2 capacity and offer savings of up to 90%
off On-Demand pricing. Spot Instances are appropriate where the system
can tolerate using a fleet of servers where individual servers can come
and go dynamically, such as stateless web servers, batch processing, or
when using HPC and big data. Use AWS Cost Explorer and Trust Advisor to
regularly review usage.



Match Supply and Demand by auto scaling

#### Optimize over time

Keep an eye out for new features and improvements.
Running RDS can be less expensive than running EC2 based db. Aurora can
reduce cost. 

#### Key services

Key service is Cost Explorer. Use Amazon CloudWatch and
Trusted Advisor to help right size your resources. You can use Amazon
Aurora on RDS to remove database licensing costs.

AWS Direct Connect and Amazon CloudFront can be used to
optimize data transfer. 



[https://tutorialsdojo.com/aws-well-architected-framework-disaster-recovery/](https://tutorialsdojo.com/aws-well-architected-framework-disaster-recovery/&sa=D&ust=1570987253813000) 

## AWS Best Practices

### Stateless Applications

Consider putting only unique session identifier in HTTP
cookie and store more detailed information on the server side. You can
store this information in DynamoDB.

Store large files in shared storage like S3 or EFS to
avoid introducing stateful code.

A complex multi-step workflow is another example where
you must track the

current state of each execution. You can use AWS Step
Functions to centrally store

execution history and make these workloads
stateless.

### Stateful Applications

#### Session Affinity

Use sticky sessions feature of Amazon Application Load
Balancer. If you control client, then you can implement health checks
and use service discovery to let clients connect to the same
server.

### Distributed Processing

Offline batch processing can be done with the help of
AWS Batch, AWS Glue, and Apache Hadoop. Amazon EMR can run a load on
multiple EC2 instances without operational overload. For realtime
processing use Kinesis which shards data and can be consumed by EC2 and
Lambda. 

### Disposable Resources Instead of Fixed

With AWS, prefer starting new instance/new resource
with updated configuration and problem fixes than update existing one.
This ensures there’s no configuration drift. You should have immutable
infrastructure. Once a server is launched it’s never updated, just
replaced. This makes rollbacks easier and enables software which is in
consistent state.

#### Golden Images

Prefer creating AMIs over boot scripts or puppet/chef.
This enables to launch instances faster. Golden images can also be
created for RDS, EBS.

#### Containers

AWS Elastic Beanstalk, Amazon ECS and Amazon Fargate
let you deploy and manage multiple containers on cluster of EC2
instances. You can build docker images and manage them using ECS
Container Registry. EKS can be used to use Kubernetes. 

#### Hybrid

Beanstalk follows hybrid setup where it starts from
Golden AMIs but gives you control on bootstrapping using  .ebextensions
configuration files. Environment variables can also be used in Beanstalk
to parameterize environment differences.

### Serverless Management and Deployment

AWS CodePipeline, AWS CodeBuild, and AWS CodeDeploy
support the automation of

the deployment of these processes.

#### Amazon EC2 auto recovery

You can create an Amazon CloudWatch alarm that monitors
an EC2 instance and automatically recovers it if it becomes impaired. A
recovered instance is identical to the original instance, including the
instance ID, private IP addresses, Elastic IP addresses, and all
instance metadata. However, this feature is only available for
applicable instance configurations.



See AWS Systems Manager

#### Auto Scaling

You can use Auto Scaling to help make sure that you are
running the desired

number of healthy EC2 instances across multiple
Availability Zones. Auto Scaling can

also automatically increase the number of EC2 instances
during demand spikes to maintain performance and decrease capacity
during less busy periods to optimize costs.



### Alarms and Events

Cloudwatch can send alarm if a metric goes beyond a
threshold for specified time. This alarm is sent via SNS and SNS can
kick off Lambda, add message to SQS or perform HTTP, HTTPS requests to
endpoints.



Cloudwatch events can be routed to one or more targets
such as lambda functions, Kinesis Streams or SNS topics.

### Loose Coupling

See API Gateway

#### Service Discovery

ELB can be used to access a stable endpoint. This can
be abstracted using Route 53 so ELB hostname can be abstracted and
modified at any time. Amazon Route 53 supports auto naming to make it
easier to provision instances for microservices. Auto naming lets you
automatically

create DNS records based on a configuration you
define.

#### Asynchronous Integration

The two components do not integrate through direct
point-to-point interaction but usually

through an intermediate durable storage layer, such as
an SQS queue or a streaming

data platform such as Amazon Kinesis, cascading Lambda
events, AWS Step Functions,

or Amazon Simple Workflow Service.

  - Multiple heterogeneous systems use AWS Step
    Functions to communicate the flow of work between them without
    directly interacting with each other.

<!-- end list -->

  - Lambda functions can consume events from a variety
    of AWS sources, such as Amazon DynamoDB update streams and Amazon S3
    event notifications. You don’t have to worry about implementing a
    queuing or other asynchronous integration method because Lambda
    handles this for you.

### Serverless Architectures

See Cognito and Athena

### Databases

RDS scales up and you can create read replicas.
Failover takes a while before instance is available. Multi AZ is
synchronous while read replicas are asynchronous. Amazon Aurora provides
multi-master capability to enable reads and writes to be scaled across
Availability Zones and also supports cross-Region replication.



For high writes application, consider NoSQL database.
For normalized data and data with complex joins, use RDS. Large binary
files should be in S3.

### Search

On AWS, you can choose between Amazon CloudSearch and
Amazon Elasticsearch Service (Amazon ES). Amazon CloudSearch is a
managed service that requires little configuration and will scale
automatically. Amazon ES offers an open-source API and gives you more
control over the configuration details. Amazon ES has also evolved to
become more than just a search solution. It is often used as an
analytics engine for use cases such as log analytics, real-time
application monitoring, and clickstream analytics. Both Amazon
CloudSearch and Amazon ES use data partitioning and replication to scale
horizontally. The difference is that with Amazon CloudSearch, you don’t
need to worry about how many partitions and replicas you need because
the service automatically handles that.

### Graph Database

Amazon Neptune is a fully-managed graph database
service.

### Cost Optimization

Plan to implement Auto Scaling for as many Amazon EC2
workloads as possible, so that you horizontally scale up when needed and
scale down and automatically reduce your spending when you don’t need
that capacity anymore. In addition, you can automate turning off
non-production workloads when not in use. Ultimately, consider which
compute workloads you could implement on AWS Lambda so that you never
pay for idle or redundant resources. Where possible, replace Amazon EC2
workloads with AWS managed services that either don’t require you to
make any capacity decisions (such as ELB, Amazon CloudFront, Amazon SQS,
Amazon Kinesis Firehose, AWS Lambda, Amazon SES, Amazon CloudSearch, or
Amazon EFS) or enable you to easily modify capacity as and when need
(such as Amazon DynamoDB, Amazon RDS, or Amazon ES).

### Security

With AWS Config rules you also know if a resource was
out of compliance even for a brief period of time, making both
point-in-time and period-in-time audits very effective. You can
implement extensive logging for your applications (using Amazon
CloudWatch Logs) and for the actual AWS API calls by enabling AWS
CloudTrail.

## AWS Overview of Services

Information saved in services sections of relevant
services.

### Exam tips

AWS Managed services let you reduce time to market and
lower cost and complexity. Note: no service specialization.

## AWS Serverless Lens

Too much detail about Lambda. Good paper for review but
may have to come back to it during Developer Associate
Certification.

## Security on AWS

## AWS Risk and Compliance

Use AWS Artifact to access compliance reports. SOC1,
SOC2, SOC3 reports can be requested and accessed on demand.

## AWS Disaster Recovery

### Recovery Time Objective (RTO) and Recovery Point Objective (RPO)

RTO is the time it takes to restore system after a
disruption. RPO is acceptable amount of data loss measured in time. The
amount of data loss a business can tolerate usually determines the
desired recovery time objective.

### Backup  and Restore

This is slowest option and may not meet RTO. Can be
cheapest though.

### The Pilot Light Disaster Recovery Method

Requires storing critical systems as a template within
database. In event of disaster, resources can be scaled out from around
our ‘pilot light’. Instances can be launched using AMIs.



The term pilot light is often used to describe a DR
scenario in which a minimal version of an environment is always running
in the cloud. The idea of the pilot light is an analogy that comes from
the gas heater. In a gas heater, a small flame that’s always on can
quickly ignite the entire furnace to heat up a house. This scenario is
similar to a backup-and-restore scenario.

For example, with AWS you can maintain a pilot light by
configuring and running the most critical core elements of your system
in AWS. When the time comes for recovery, you can rapidly provision a
full-scale production environment around the critical core.

### Warm Standby

Warm standby is a method of redundancy in which the
scaled-down secondary system runs in the background of the primary
system. Doing so would not optimize your savings as much as running a
pilot light recovery since some of your services are always running in
the background.

### Multi Site

Multi-site is the most expensive solution out of
disaster recovery solutions. You are trying to save monthly costs so
this should be the least probable choice for you.

### References

[https://d1.awsstatic.com/whitepapers/aws-disaster-recovery.pdf](https://d1.awsstatic.com/whitepapers/aws-disaster-recovery.pdf&sa=D&ust=1570987253821000)

[https://tutorialsdojo.com/aws-cheat-sheet-backup-and-restore-vs-pilot-light-vs-warm-standby-vs-multi-site/](https://tutorialsdojo.com/aws-cheat-sheet-backup-and-restore-vs-pilot-light-vs-warm-standby-vs-multi-site/&sa=D&ust=1570987253821000) 

# References

[http://jayendrapatil.com/tag/cheat-sheet/](http://jayendrapatil.com/tag/cheat-sheet/&sa=D&ust=1570987253821000) 



AWS Cert prepare Guide:
 

[https://acloud.guru/forums/aws-certified-solutions-architect-associate/discussion/-Kgy6EyakT-cTLL6mhOo/how\_can\_you\_score\_highest\_in\_e](https://acloud.guru/forums/aws-certified-solutions-architect-associate/discussion/-Kgy6EyakT-cTLL6mhOo/how_can_you_score_highest_in_e&sa=D&ust=1570987253823000) 



Udemy Practice Exam
[https://www.udemy.com/aws-certified-solutions-architect-associate-amazon-practice-exams/](https://www.udemy.com/aws-certified-solutions-architect-associate-amazon-practice-exams/&sa=D&ust=1570987253823000) 

