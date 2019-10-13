---
layout: post
title: AWS SAA Certification Exam Notes - Databases
---


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



