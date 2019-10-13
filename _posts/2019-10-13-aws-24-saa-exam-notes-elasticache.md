---
layout: post
title: AWS SAA Certification Exam Notes - Elasticache
---


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

