# Data model

This section describes the Data model for each database (MySQL and Redis), which includes only the Subscriber entity.

# MySQL data model

![ER Diagram]TODO add diagram

### Entities Description

#### Subscribers
- **Attributes**:
  - `id`: Primary Key
  - `email`: Email of the subscriber `VARCHAR(255)`
  - `name`: Name of the subscriber `VARCHAR(255)`
  - `last_name`: Last name of the subscriber `VARCHAR(255)`
  - `status_id`: Status of the subscriber `FOREIGN KEY pointing to Statuses(id)`
  - `created_at`: Creation timestamp of the subscriber
  - `updated_at`: Update timestamp of the subscriber

#### Statuses
- **Attributes**
  - `id`: Primary Key
  - `name`: Name of the status `VARCHAR(40)`
  - `created_at`: Creation timestamp of the status
  - `updated_at`: Update timestamp of the status

> The possible statuses were not specified in the task requirements, so it's assumed that its a string of max-size: 40, that is populated in the statuses table. This was a developer's decision to make the status table flexible enough for adding or modifying existing statuses.

#### Developer Decisions
Check [Data model decisions](./decisions.md#data-model)

----------

# MySQL Database Storage Calculation

Assuming that the statuses table will not grow a lot, and that would have around 100+- statuses for example. The grow factor of our database is basically the subscribers table.

**TLDR**; `Subscriber row ≈ 784 bytes`

| Database capacity     | Subscribers      | 
|-----------------------|------------------|
| 1MB                   | ≈ 1,336 rows     |
| 100MB                 | ≈ 133.600 rows   |
| 1GB                   | ≈ 1.360.000 rows |
| 10GB                  | ≈ 13.600.000 rows|

[Reference](https://dev.mysql.com/doc/refman/8.0/en/storage-requirements.html)
----------

### Considerations:

1. **Row Overhead**: There is a small overhead per row and additional storage requirements for table metadata - We are not considering that on the calculation.
2. **Data Distribution**: These calculations are assuming that we use every space available of each VARCHAR fields. So, actual data may consume less space.
3. **Index Size**: These calculations do not account for the additional storage used by indexes (like the one on `email` in the `subscriber` table). This is just to have a general idea of capacity planing.
4. **Grow factor**: We are not considering the statuses table here, as its growth should not be great.

----------

#### Table: `subscribers`
Let's calculate the storage requirements for each row in `subscriber` tables (using MySQL 5.7):


| Column      | Data Type  | Size (bytes) | Description |
|-------------|------------|--------------|-------------|
| id          | INT        | 4            | INT requires 4 bytes. Being an AUTO_INCREMENT PRIMARY KEY, it also acts as the clustered index. |
| email       | VARCHAR(255) | 256       | VARCHAR(255) requires up to 256 bytes (255 characters max and 1 byte for length prefix). An index on the email adds to the storage but is not calculated per row. |
| name        | VARCHAR(255) | 256       | VARCHAR(255) requires up to 256 bytes. |
| last_name   | VARCHAR(255) | 256       | VARCHAR(255) requires up to 256 bytes. |
| status_id   | INT        | 4            | INT requires 4 bytes. Links to the `statuses` table. |
| created_at  | TIMESTAMP  | 4            | TIMESTAMP fields require 4 bytes each. |
| updated_at  | TIMESTAMP  | 4            | TIMESTAMP fields require 4 bytes each. |

**Total bytes per row for `subscriber`:** 784 bytes/row

#### Storage Calculation for 1MB, 100MB, and 1GB

- **1MB (1,048,576 bytes) Capacity:**
  - `subscriber`: 1,048,576 / 784 ≈ 1,337 rows

- **100MB (104,857,600 bytes) Capacity:**
  - `subscriber`: 104,857,600 / 784 ≈ 133,754 rows

- **1GB (1,073,741,824 bytes) Capacity:**
  - `subscriber`: 1,073,741,824 / 784 ≈ 1,369,156 rows

----------

# Redis Data Model
- Stored as key-value pairs, where the key is the subscriber email and the value is the `subscriber` object.



# Redis Database Storage Calculation
- TODO




