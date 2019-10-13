---
layout: post
title: AWS SAA Certification Exam Notes - Autoscaling
---

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
