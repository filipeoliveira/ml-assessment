# Developer decisions





## Data model

- I added `created_at` and `updated_at` fields to each table, this provides valuable information for debugging and auditing. They are not being populated or being returned to the user atm.
- Although email is already unique, I've decided to have an `id` field at the subscribers table for the following reasons:
  - **We will not need to expose the email in the URLs**.
  - If a subscriber changes their email (for some reason in the future), having `id` as the PK allows us to update the email without affecting the relationship with other tables.
  - Integer keys are usually more performant for lookup.
