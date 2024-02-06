# Data model

This section describes the Data model for each database (MySQL), which includes only the Subscriber entity.

# MySQL data model

### Entities Description

#### Subscribers
- **Attributes**:
  - `id`: Primary Key
  - `email`: Email of the subscriber `VARCHAR(255)`
  - `name`: Name of the subscriber `VARCHAR(255)`
  - `last_name`: Last name of the subscriber `VARCHAR(255)`
  - `status`: Status of the subscriber `VARCHAR(20)`
  - `created_at`: Creation timestamp of the subscriber
  - `updated_at`: Update timestamp of the subscriber

> The possible statuses were not specified in the task requirements, so it's assumed that its a string of max-size: 255. We could normalize this field into another table, but I prefered to keep it simple.

#### Developer Decisions
Check [Data model decisions](./decisions.md#data-model)

----------

# MySQL Database Storage Calculation


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

----------

#### Table: `subscribers`
Let's calculate the storage requirements for each row in `subscriber` tables (using MySQL 5.7):


| Column      | Data Type    | Size (bytes) | Description |
|-------------|--------------|--------------|-------------|
| email       | VARCHAR(255) | 256       | VARCHAR(255) requires up to 256 bytes|
| name        | VARCHAR(255) | 256       | VARCHAR(255) requires up to 256 bytes. |
| last_name   | VARCHAR(255) | 256       | VARCHAR(255) requires up to 256 bytes. |
| status      | VARCHAR(20)  | 21        | VARCHAR(255) requires up to 256 bytes |
| created_at  | TIMESTAMP    | 4         | TIMESTAMP fields require 4 bytes each. |
| updated_at  | TIMESTAMP    | 4         | TIMESTAMP fields require 4 bytes each. |

**Total bytes per row for `subscriber`:** 797 bytes/row

#### Storage Calculation for 1MB, 100MB, and 1GB

- **1MB (1,048,576 bytes) Capacity:**
  - `subscriber`: 1,048,576 / 797 ≈ 1,316 rows

- **100MB (104,857,600 bytes) Capacity:**
  - `subscriber`: 104,857,600 / 797 ≈ 131,600 rows

- **1GB (1,073,741,824 bytes) Capacity:**
  - `subscriber`: 1,073,741,824 / 797 ≈ 1,346,800 rows

----------