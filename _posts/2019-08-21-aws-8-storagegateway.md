---
layout: post
title: AWS - Part 8 - Amazon Storage Gateway
---

Storage Gateway is a hybrid service. It gives you on-premise access to cloud storage. Your application will connect to service through a VM or hardware appliance via common file access protocols such as NFS/SMB/iSCI. Gateway then connects to AWS to provide storage for files, volumes and tapes on S3, Glacier, EBS and AWS Backup. Gateway service includes highly optimized data transfer mechanism and has resilience built in for network issues. Data in cloud is cached on premises for low latency access. Transfers to cloud happen in background so applications can continue to function as if they're working on premises while having data stored on cloud.

Gateway service provides three kinds of gateways, [Tape Gateway](https://aws.amazon.com/storagegateway/vtl/), [File Gateway](https://aws.amazon.com/storagegateway/file/), and [Volume Gateway](https://aws.amazon.com/storagegateway/volume/).

### Tape Gateway

The Tape Gateway configuration is a cloud-based virtual tape library (VTL) that serves as a drop-in replacement for tape backup systems.

### Volume Gateway

With a Volume Gateway configuration, you can take snapshots of your local volumes and store those snapshots in Amazon EBS. Those snapshots can be the starting point for an Amazon EBS volume, which you can then attach to an Amazon EC2 instance. In the event of a local site disaster simply set up your applications in the cloud or in a different datacenter, and restore your snapshot to keep running.

### Additional Resources:

- [FAQ Page for Storage Gateway](https://aws.amazon.com/storagegateway/faqs/)
- [Storage Gateway Home](https://aws.amazon.com/storagegateway/)