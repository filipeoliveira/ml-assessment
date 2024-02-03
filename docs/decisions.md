# Developer decisions


## Dockerfile and env
- The application, frontend, database and cache are defined in the docker-compose file using a `backend` bridge network.
- I'm submitting the .env file to the repository to facilitate the testing, but on a real world scenario we shouldn't commit the .env file and use `.env.example` as best practice.


## Data model

- I added `created_at` and `updated_at` fields to each table, this provides valuable information for debugging and auditing. They are not being populated or being returned to the user atm.
- Although email is already unique, I've decided to have an `id` field at the subscribers table for the following reasons:
  - **We will not need to expose the email in the URLs**.
  - If a subscriber changes their email (for some reason in the future), having `id` as the PK allows us to update the email without affecting the relationship with other tables.
  - Integer keys are usually more performant for lookup.

### Cache
- We are storing two keys on redis:
  - `subscriber_email:<email>` which is pointing to another key `subscriber_id:<id>`
  - `subscriber_email:<id>` which is pointing to the subscriber data`

- This optmization has the goal to not store duplicate data in redis. Therefore trading memory to +1 query in redis.
- Since the endpoint to retrieve a subscriber will be executed a million times per minute, it is in the lower level of these keys.


## Application

### Validation
- We are always parsing `email` to be lowercase. On creation and on retrieval.

#### Created subscribers are not being populated directly to cache.
- The code is not populating the cache with the recently created subscriber. I prefered to load the data into the cache once its requested.
- The reason is that I didn't know the usage context of this application, so I assumed that it's possible to a newly created subscriber to never be called for the next hours.
- So let's trade cache memory for +1 database query. 
- This behavior could be modified in the `src/Repositories/SubscriberRepository`.php#createSubscriber method by adding a subscriber_email key similar to the get methods on the same repository.

