---
layout: post
title: AWS SAA Certification Exam Notes - AWS Systems Manager
---

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

[https://tutorialsdojo.com/aws-cheat-sheet-aws-systems-manager/](https://tutorialsdojo.com/aws-cheat-sheet-aws-systems-manager/) 

Well Architected Framework whitepaper - Operational
Excellence
