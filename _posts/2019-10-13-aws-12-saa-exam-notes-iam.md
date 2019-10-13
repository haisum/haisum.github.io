---
layout: post
title: AWS Solutions Architect Certification Exam Notes - IAM, Organization, Cognito, Active Directory, Identity Federation
---


Role: Can be associated with resources like
EC2/Cloudformation. Or assumed by user when they’re using Federation,
SAML.

User: User with access key, secret key and
password.

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

**What is web identity federation?**

Web identity federation allows you to create AWS-powered mobile apps that use public identity providers (such as [Amazon Cognito](https://aws.amazon.com/cognito/), [Login](http://login.amazon.com/) with Amazon, [Facebook](https://www.facebook.com/about/login), [Google](https://developers.google.com/+/), or any [OpenID Connect](http://openid.net/connect/)-compatible provider) for authentication.


### Organizations

AWS Organizations offers policy-based management for multiple AWS accounts. With Organizations, you can create groups of accounts, automate account creation, apply and manage policies for those groups. Organization enables you to centrally manage policies across multiple accounts, without requiring custom scripts and manual processes. Using AWS Organizations, you can create Service Control Policies (SCPs) that centrally control AWS service use across multiple AWS accounts. You can also use Organizations to help automate the creation of new accounts through APIs. Organization helps simplify the billing for multiple accounts by enabling you to set up a single payment method for all the accounts in your organization through consolidated billing. AWS Organizations is available to all AWS customers at no additional charge.

#### Difference between a service control policy and an IAM policy?

AWS Organizations lets you use service control policies (SCPs) to allow or deny access to particular AWS services for individual AWS accounts, or for groups of accounts within an organizational unit (OU). The specified actions from an attached SCP affect all IAM users, groups, and roles for an account, including the root account identity.

When you apply an SCP to an OU or an individual AWS account, you choose to either **enable** (whitelist), or **disable** (blacklist) the specified AWS service. Access to any service that isn’t explicitly allowed by the SCPs associated with an account, its parent OUs, or the master account is **denied** to the AWS accounts or OUs associated with the SCP.

When an SCP is applied to an OU, it is inherited by all of the AWS accounts in that OU.

IAM policies let you allow or deny access to AWS services (such as Amazon S3), individual AWS resources (such as a specific S3 bucket), or individual API actions (such as s3:CreateBucket). An IAM policy can be applied only to IAM users, groups, or roles, and it can never restrict the root identity of the AWS account.

### Web Identity Federation and Cognito

Cognito gives web identity federation service in AWS. It allows you to sign in and sign up. Acts as broker so you don’t need to write code. Synchronizes data between different devices. Recommended for all mobile applications. It maps a role from open id to AWS IAM Role and gives temporary access to resources

AWS supports identity federation with SAML 2.0, an open standard that many identity providers (IdPs) use. This feature enables federated single sign-on (SSO), so users can log into the AWS Management Console or call the AWS APIs without you having to create an IAM user for everyone in your organization. By using SAML, you can simplify the process of configuring federation with AWS, because you can use the IDP service instead of writing custom identity proxy code.

Web identity federation is primarily used to let users sign in via a well-known external identity provider (IdP), such as Login with Amazon, Facebook, Google. It does not utilize Active Directory.

### Cognito

When it comes to mobile and web apps, you can use Amazon Cognito so that you don’t have to manage a back-end solution to handle user authentication, network state, storage, and sync. Amazon Cognito generates unique identifiers for your users. Those identifiers can be referenced in your access policies to enable or restrict access to other AWS resources on a per-user basis. Amazon Cognito provides temporary AWS credentials to your users, allowing the mobile application running on the device to interact directly with AWS Identity and Access Management (IAM)-protected AWS services. For example, using IAM you can restrict access to a folder in an S3 bucket to a particular end user.

#### User Pool

User pools are used for users logging in. Successful auth generates JWT. Users can also login directly in User Pools.

Say you were creating a new web or mobile app and you were thinking about how to handle user registration, authentication, and account recovery. This is where Cognito User Pools would come in. Cognito User Pool handles all of this and as a developer you just need to use the SDK to retrieve user related information.

#### Identity Pool

Identity pools provide temporary access to AWS resources.

Cognito monitors different devices you use. It then uses SNS to push updates to all devices. Cognito Identity Pool (or Cognito Federated Identities) on the other hand is a way to authorize your users to use the various AWS services. Say you wanted to allow a user to have access to your S3 bucket so that they could upload a file; you could specify that while creating an Identity Pool. And to create these levels of access, the Identity Pool has its own concept of an identity (or user). The source of these identities (or users) could be a Cognito User Pool or even Facebook or Google.

### AWS Directory Service

-   AWS Managed Microsoft AD is best for current AD or LDAP
-   Deployed to two AZ and connected to your VPC
-   Fully managed, no access to powershell or ssh/rdp.
-   A VPC with at least 2 subnets required
-   Seamless domain join can be used for connecting EC2 instance to your AD at launch time
-   Trust relationship to sync between on premise and AWS AD

#### Simple AD

Fully managed, mini AD with smaller feature set but good for use when needed for simple AD features. Based on Samba 4. Does not have MFA, Trust Relations, Powershell cmdlets.

#### Amazon Cloud Directory

Allows storage of hierarchical objects with relations and schema. Can organize in multiple hierarchies.

#### AD Connector

Helps connect existing AD on premise to AWS

### Exam Tips

-   Service Accounts = Roles. No federation even if it’s on premises.
-   IAM trust policy allows EC2 instances to assume a role
-   IAM policy or S3 Bucket policy allows get/put from buckets in S3. Note: No S3 Trust Policy. Also IAM trust policy is required but it’s not required for S3.
-   IAM Certificate Store and Certificate Manager let you manage SSL certs

### References

[https://tutorialsdojo.com/aws-cheat-sheet-aws-identity-and-access-management-iam/](https://tutorialsdojo.com/aws-cheat-sheet-aws-identity-and-access-management-iam/)

[https://tutorialsdojo.com/aws-cheat-sheet-aws-directory-service/](https://tutorialsdojo.com/aws-cheat-sheet-aws-directory-service/)

[http://jayendrapatil.com/aws-iam-overview/](http://jayendrapatil.com/aws-iam-overview/)



[https://docs.aws.amazon.com/autoscaling/ec2/userguide/control-access-using-iam.html](https://docs.aws.amazon.com/autoscaling/ec2/userguide/control-access-using-iam.html)

[https://aws.amazon.com/premiumsupport/knowledge-center/iam-policy-service-control-policy/](https://aws.amazon.com/premiumsupport/knowledge-center/iam-policy-service-control-policy/)

[https://aws.amazon.com/organizations/getting-started/](https://aws.amazon.com/organizations/getting-started/)

[https://docs.aws.amazon.com/organizations/latest/userguide/orgs\_manage\_policies\_scp.html](https://docs.aws.amazon.com/organizations/latest/userguide/orgs_manage_policies_scp.html)