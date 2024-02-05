## Challenges
Scaling a system to handle 10 times the traffic is not without its challenges. Here are some potential issues we might encounter:

1. **Data Consistency:** If we decide to distribute our data across multiple databases through sharding, maintaining data consistency could become a challenge. We'd need to ensure that all parts of the system have the same view of the data. However, given our current setup with a single table and no updates to existing records, **this isn't a significant concern for now**. When we insert subscribers, we also replicate this data to the cache, further ensuring read consistency. For more details on the database setup, see the [Database Layer](#database-layer) section.

2. **Handling Failures:** With more traffic and more components in our system, the likelihood of failures increases. We need robust error handling and retry mechanisms, especially in our queue system and database operations.
What happens if the database crashes between a transaction?
we are using transactions.

3. **Managing Costs:** Scaling up our infrastructure will inevitably increase costs. We need to find a balance between performance and cost-effectiveness. This might involve using spot instances, reserved instances, or other cost-saving measures in our cloud infrastructure.

> To store 100GB of subscribers (13M+) we would possibly have the estimation cost below. While managing costs is a challenge we need to consider, it's important to see that the costs do not grow exponentially with our data needs.

> | Service               | Instance Type   | On-Demand Cost per Month (€)   | Reserved Instance Cost per Month (€) | Reference |
> |-----------------------|-----------------|--------------------------------|-------------------------------------|-----------|
> | Amazon RDS (MySQL)    | db.m5.large     | €125.00                        | €71.00                               | [RDS Pricing](https://aws.amazon.com/rds/mysql/pricing/) |
> | AWS Elastic Beanstalk | m5.large EC2    | €63.00                         | €36.00                               | [EC2 Pricing](https://aws.amazon.com/ec2/pricing/on-demand/) |
> | Amazon CloudFront     | N/A             | €8.30                          | €8.30  (N/A)                         | [CloudFront Pricing](https://aws.amazon.com/cloudfront/pricing/) |
> | Elastic Load Balancer | N/A             | €15.30                         | €15.30 (N/A)                         | [ELB Pricing](https://aws.amazon.com/elasticloadbalancing/pricing/) |
> | ElastiCache for Redis | cache.r5.large  | €65.50                         | €65.50 (N/A)                         | [ElastiCache Pricing](https://aws.amazon.com/elasticache/pricing/) |
> | **Total**             |                 | **€277.10**                     | **€195.90 (with reserved instances)** | |


4. **Monitoring and Alerting:** With a larger and more complex system, monitoring becomes more challenging. We need to have a comprehensive monitoring and alerting system in place to quickly detect and respond to any issues.
> - Regular health checks should be conducted on all systems and load balancers to ensure their optimal functioning and uptime.
> - Services such as AWS CloudWatch or Datadog can be utilized for monitoring system metrics and establishing alerts. These tools provide comprehensive insights into the operation of our system, facilitating the detection of anomalies and enabling a timely response.

- **Database Write Load:** As our system is write-heavy, the database could become a bottleneck. We need to ensure our database can handle the increased write load, which might involve sharding, optimizing our database configuration, or upgrading our database hardware.
> This is addresses in the [Database Layer](#database-layer) section.

---------

## Considerations about how to scale this project

Considering that we are now dealing with 10x imes traffic (10+ millions of requests per minute). I'd follow these practices to make each layer more performant and scalable:


#### Load Balancer layer: 
- Given that our application is **stateless**, session persistence isn't necessary. This means that any server can handle any request, simplifying our scaling and load balancing strategy. 
- While a **round-robin** approach could be used, it would be more beneficial to use a **least connections strategy**. 
This strategy would prefer servers with fewer active connections, especially good for write operations. 
- AWS Elastic Load Balancer would be my option to go, since it has both strategies and it's easy to set up and configure.


#### Application layer
- Since each application (frontend and backend) are dockerized, we can deploy and scale them properly and independently. I'd use a basic ElasticBeanStalk approach here to scale horizontally the application layer using PHP 8.2 (__requirement__).
- We can use AWS Elastic Beanstalk's **auto-scaling feature** to automatically adjust the number of running instances based on traffic patterns. This allows us to handle traffic spikes and reduce costs when demand is low.
- For the frontend layer, implementing a Content Delivery Network (CDN) to serve static assets would be beneficial. This would reduce the load on our servers and improve response times for users around the world.


#### Cache Layer
- I'd use AWS ElastiCache to manage and scale our cache layer, easy to set up and manage through aws console.
- Having Redis as our cache to store frequently accessed data, reduces the load on our database and improves the response times.
- The usage of the `allkeys-lru` eviction policy helps us manage memory usage in a effective way.
- While a single cache node can efficiently store GBs of data, we could set up ElastiCache to automatically scale the number of cache-nodes based on traffic patterns. This potential option could help us handle extreme traffic spikes, **although it may not be necessary under normal circumstances**.

#### Database layer
- Since we're already using Redis for caching, and we store the same data as we have in the database, a read replica of our database isn't really necessary.
- Similar to the application and cache, we'll need to monitor our DB performance closely and adjust our scaling strategies as necessary. This involves setting up monitoring/alerting tools to notify the team of any performance issues.
- We should consider using Amazon RDS with MySQL 5.7 (__requirement__), to handle database scaling and management. This would free up our team to focus on application development rather than database administration.

- If we continue to encounter performance and scalability issues at the database layer, I'd consider the following options:
    - **Vertical Scaling:** I'd increase the hardware resources of our database server (CPU, memory, disk space). This would provide the database with more capacity to handle larger workloads.
    - **Sharding:** As a last resort, we could consider sharding the database by email hash. While this could improve performance by distributing the load across multiple databases, it introduces **a lot** of additional complexity. We would need to implement logic for routing queries (or use RDS to it) to the correct shard and aggregating data across multiple shards.

---------

#### Considerations

##### Queue Usage:
The challenge description doesn't specify:
- The 'client' that adds subscribers
- If there's a specific time limit or service level agreement (SLA) for successful subscriber insertion. 
    
This information is crucial when considering asynchronous processing and the potential use of queues.
    - In an asynchronous processing setup, the client would submit a subscriber to be added. This action would be processed by the backend, which then generates a message event for a queue. **(Producer)**
    - This queue could be monitored by one or more consumers. An AWS Standard Queue, which guarantees at-least-once message delivery, would be suitable for this purpose. Basically multiple consumers can process the same message without issue.
    - The consumer, a backend process, would listen for subscriber messages on the queue, consume them, and insert the subscriber data into the database. **(Consumer)**

The primary advantage of this approach is that it allows for improved scalability and fault tolerance. By decoupling the process of receiving subscriber data from the process of inserting it into the database, we can handle larger volumes of data and ensure that temporary failures in one process don't cause the entire system to fail. 

This setup also allows us to scale each process (consumers and producers) independently based on its own resource needs.

