---
layout: post
title: AWS SAA Certification Exam Notes - ELB
---

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

[https://acloud.guru/learn/aws-application-loadbalancer](https://www.google.com/url?q=https://acloud.guru/learn/aws-application-loadbalancer&sa=D&ust=1570987253694000) 

[https://tutorialsdojo.com/aws-cheat-sheet-aws-elastic-load-balancing-elb/](https://www.google.com/url?q=https://tutorialsdojo.com/aws-cheat-sheet-aws-elastic-load-balancing-elb/&sa=D&ust=1570987253694000) [https://tutorialsdojo.com/aws-cheat-sheet-ec2-instance-health-check-vs-elb-health-check-vs-auto-scaling-and-custom-health-check-2/](https://www.google.com/url?q=https://tutorialsdojo.com/aws-cheat-sheet-ec2-instance-health-check-vs-elb-health-check-vs-auto-scaling-and-custom-health-check-2/&sa=D&ust=1570987253694000)

[https://docs.aws.amazon.com/elasticloadbalancing/latest/classic/elb-backend-instances.html](https://www.google.com/url?q=https://docs.aws.amazon.com/elasticloadbalancing/latest/classic/elb-backend-instances.html&sa=D&ust=1570987253695000) 
