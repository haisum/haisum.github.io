---
layout: post
title: AWS - Part 2 - Regions, Zones and Edge Locations
---

Services in AWS are divided in Regions, Zones and Edge Locations. It's important to know difference between them when using AWS for deploying our services.

A region is a geographical location. Two regions may be far apart in same country or they may be in different countries or continents. For example, AWS has US east region which is located in Northern Virginia and a West region which is in California. Another region is in Ohio. Purpose for having distant regions is having redundancy so for example of a Hurricane hits in Northern Virginia, then services can continue functioning from California region. Regions may also be selected based on their proximity to customers of our service. If all customers of a service are in Europe then may be having services hosted in Frankfurt make more sense then having them in US regions.

If you do not explicitly specify an endpoint, the US West (Oregon) endpoint is the default.

All regions have multiple Availability Zones. You can think of Availability Zone as a data center. Each region has two or more data centers and each may be only a few miles apart or within a couple hundred feet from each other. Availability zones are isolated from each other to create redundancy within a region. So for example, if you wanted to load balance a database so it won't go down if data center goes down, then you may do so by placing a passive instance in another availability zone in same region.

Edge locations are basically locations for CDN. As of today, there are 68 Edge locations listed on Amazon Cloud Front documentation at: [https://aws.amazon.com/cloudfront/features/](https://aws.amazon.com/cloudfront/features/). Edge locations are used for serving static content so they aren't full fledge data centers. There are many more edge locations than regions and availability zones.

There were 19 Regions and 57 Availability Zones as of 2018. We don't need to know about all of them but it's nice to know which ones are near your location. Here's link from AWS documentation which describes regions and zones in more detail. It also lists down current regions/zones for RDS: [https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/Concepts.RegionsAndAvailabilityZones.html](https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/Concepts.RegionsAndAvailabilityZones.html).