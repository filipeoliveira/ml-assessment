# Developer decisions


## Dockerfile and env
- The application, frontend, database and cache are defined in the docker-compose file using a `backend` bridge network.
- I'm submitting the .env file to the repository to facilitate the testing, but on a real world scenario we shouldn't commit the .env file and use `.env.example` as best practice.


## Data model

- I added `created_at` and `updated_at` fields to each table, this provides valuable information for debugging and auditing. They are not being populated or being returned to the user atm.
- Due to requirements i'm using email as the primary key, being unique, to keep thins simple for now. Keep in mind that we could have had an id auto increment field here too.
// TODO  - explain more and better.

### Cache
- We are storing one key on redis:
  - `sub_email:<email>` which is pointing to the subscriber data

- TODO
this approach was thought to optmize even more the retrieval of a single subscriber.


## Application

### Validation
- We are always parsing `email` and status to be lowercase. On creation and on retrieval.

#### Created subscribers are not being populated directly to cache.
// todo

- The code is not populating the cache with the recently created subscriber. I prefered to load the data into the cache once its requested.
- The reason is that I didn't know the usage context of this application, so I assumed that it's possible to a newly created subscriber to never be called for the next hours.
- So let's trade cache memory for +1 database query. 
- This behavior could be modified in the `src/Repositories/SubscriberRepository`.php#createSubscriber method by adding a subscriber_email key similar to the get methods on the same repository.

