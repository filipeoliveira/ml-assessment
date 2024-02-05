# Developer decisions

## Infrastructure and environment
- The application, frontend, database and cache are defined in the docker-compose file using a `backend` bridge network.
- I'm submitting the .env file to the repository to facilitate testing, but in a real world scenario we shouldn't commit the .env file and use `.env.example` as best practice.
- In a production environment, all communications would be secured using HTTPS. However, for this challenge, I didn't allocate time to implement HTTPS as it wasn't the primary focus. Implementing HTTPS would involve several steps, including configuring the application and web server, obtaining and managing SSL/TLS certificates (through lets encrypt, i.e), and ensuring secure communication with the MySQL and Redis servers.

## Data model

#### created_at and updated_at
- I added `created_at` and `updated_at` fields to each table, this provides valuable information for debugging and auditing. They are not being populated or being returned to the user at the moment.

#### Email as primary key
- I'm using email as the primary key, being unique, to keep things simple for now. This guarantees that emails are unique and indexed.
> A few improvements could be made here:
> - We could use an ID field as primary key but using an *autoincrement ID* or a *email hash as the ID*. This could give us two benefits: Flexibility for the user to change their email if necessary and even more speed on the lookup (although this point might not be noticeable). 

#### Required fields an length
- Considering the requirements, it wans't clear if the subscriber attributes could be optional, neither their max-length. So on this project it's assumed that `email`, `name`, `last_name` and `status` are required and have max-length of 255.

#### Status field
- It's also not clear what could be the possible statuses. To keep things simple, I've assumed that they are just strings. The code is also lowercasing the statuses to keep them standardized.
> Future improvement:
> - Keep in mind that a possible `status table` could be beneficial. This would ensure what are the possible statuses that a subscriber could have. This would lead to more complexity on the application, and the necessity of JOINS.

#### 

----------

## Application
- Talk about usage of dependency injection through a bootstrapcontainer (to simplify things) in a laravel way.
- Tried to not use external libraries -- to practice.
- The API handles both JSON and application/x-www-form-urlencoded
- It follows [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards which satisfies [PSR-2](https://www.php-fig.org/psr/psr-2/)
- There isn't authentication, CSRF protection or database migration scripts (Possible future improvements).

#### Validation
- We are always parsing `email` and status to be lowercase. On creation and on retrieval.
- Status is also being saved as lowercase to maintain the same standard.

#### Tests
- Application currently has around 85% of unit test coverage considering lines, functions and methods.
- Frontend application has no tests. I though it wasn't the focus of this assignment.
- I prefered to dedicate more time on stress tests using [Locust](locust.io) than on integration or frontend tests. 
- See more on [Tests](docs/tests.md)

#### Frontend
- I decided to use Vue3 with vue-router, typescript and eslint.
- Frontend design was inspired on Mailerlite brand and colors.
- It's possible to:
  - List all subscribers, *with pagination* :smile: . 
  - View single subscriber information. 
  - Submit a form to create a subscriber.
- **App is using a custom debounce function to avoid multiple requests to the backend if the user spam clicks.**

#### Create subscriber strategy
- 


----------

## Cache

#### Why use a cache in this challenge?
- We stores only one key on Redis `sub_email:<email>` which points to the subscriber data as a string.
- **We're using a cache to speed up the retrieval of a single subscriber by email**. When an existing subscriber is retrieved __(a cache miss)__, we fetch the subscriber from the database, return the data, and also store it in the cache. This way, the next time we need to retrieve this subscriber, we can get it from the cache, which is faster than querying the database.

This caching strategy helps us serve requests faster, which is crucial for handling the high volume of requests expected in this challenge.

- The Redis eviction policy is set to be `allkeys-lru`. This policy evicts the least recently used keys out of all keys, which helps ensure that the cache is filled with data that's accessed frequently. Keep in mind that it's important to monitor the cache ensure that important danta isn't being evicted too frequently and if necessary, we can adjust the cache eviction strategy.


#### Created subscribers are not being populated directly to cache.
- The code is not populating the cache with the recently created subscriber. Instead, we load the data into the cache once it's requested. 
- This is a **trade-off** we're making due to not understanding the usage pattern. We're trading cache memory for an additional database query.
- The reasoning behind this decision is that it's possible for a new created subscriber to not be called for the next few hours. In such a case, populating the cache immediately after creation could lead to unnecessary use of cache memory and speeding down each create subscriber request.
- **However, this behavior is easily changeable**. If we find out that new subscribers are often retrieved shortly after creation, we can modify the `src/Repositories/SubscriberRepository.php#createSubscriber` method to populate the cache immediately after a subscriber is created.