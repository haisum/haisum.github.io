---
layout: post
title: AWS SAA Certification Exam Notes - ECS
---

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

[https://tutorialsdojo.com/aws-cheat-sheet-amazon-elastic-container-service-amazon-ecs/](https://tutorialsdojo.com/aws-cheat-sheet-amazon-elastic-container-service-amazon-ecs/)
