CREATE DATABASE IF NOT EXISTS mailerlite;
USE mailerlite;

DROP TABLE IF EXISTS subscribers;

CREATE TABLE IF NOT EXISTS subscribers (
    email VARCHAR(255) UNIQUE PRIMARY KEY,
    name VARCHAR(255),
    last_name VARCHAR(255),
    status VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO subscribers (email, name, last_name, status)
VALUES
('john.doe@gmail.com', 'John', 'Doe', 'active'),
('jane.smith@yahoo.com', 'Jane', 'Smith', 'pending'),
('robert.johnson@hotmail.com', 'Robert', 'Johnson', 'inactive'),
('michael.williams@outlook.com', 'Michael', 'Williams', 'active'),
('sarah.brown@aol.com', 'Sarah', 'Brown', 'pending'),
('james.taylor@gmail.com', 'James', 'Taylor', 'inactive'),
('linda.thomas@yahoo.com', 'Linda', 'Thomas', 'active'),
('patricia.jackson@hotmail.com', 'Patricia', 'Jackson', 'pending'),
('david.white@outlook.com', 'David', 'White', 'inactive'),
('jennifer.harris@aol.com', 'Jennifer', 'Harris', 'active'),
('richard.martin@gmail.com', 'Richard', 'Martin', 'pending'),
('susan.thompson@yahoo.com', 'Susan', 'Thompson', 'inactive'),
('joseph.garcia@hotmail.com', 'Joseph', 'Garcia', 'active'),
('margaret.martinez@outlook.com', 'Margaret', 'Martinez', 'pending'),
('charles.robinson@aol.com', 'Charles', 'Robinson', 'inactive'),
('emma.wilson@icloud.com', 'Emma', 'Wilson', 'active'),
('elizabeth.clark@gmail.com', 'Elizabeth', 'Clark', 'pending'),
('thomas.rodriguez@yahoo.com', 'Thomas', 'Rodriguez', 'inactive'),
('christopher.lewis@hotmail.com', 'Christopher', 'Lewis', 'active'),
('daniel.lee@outlook.com', 'Daniel', 'Lee', 'pending'),
('paul.walker@aol.com', 'Paul', 'Walker', 'inactive'),
('mark.hall@gmail.com', 'Mark', 'Hall', 'active'),
('donald.allen@yahoo.com', 'Donald', 'Allen', 'pending'),
('kenneth.young@hotmail.com', 'Kenneth', 'Young', 'inactive'),
('steven.hernandez@outlook.com', 'Steven', 'Hernandez', 'active'),
('edward.king@aol.com', 'Edward', 'King', 'pending'),
('brian.wright@gmail.com', 'Brian', 'Wright', 'inactive'),
('ronald.lopez@yahoo.com', 'Ronald', 'Lopez', 'active'),
('anthony.hill@hotmail.com', 'Anthony', 'Hill', 'pending'),
('kevin.scott@outlook.com', 'Kevin', 'Scott', 'inactive'),
('jason.green@aol.com', 'Jason', 'Green', 'active'),
('matthew.adams@gmail.com', 'Matthew', 'Adams', 'pending'),
('gary.baker@yahoo.com', 'Gary', 'Baker', 'inactive'),
('timothy.gonzalez@hotmail.com', 'Timothy', 'Gonzalez', 'active'),
('jose.nelson@outlook.com', 'Jose', 'Nelson', 'pending'),
('larry.carter@aol.com', 'Larry', 'Carter', 'inactive'),
('jeffrey.mitchell@gmail.com', 'Jeffrey', 'Mitchell', 'active'),
('frank.perez@yahoo.com', 'Frank', 'Perez', 'pending'),
('scott.roberts@hotmail.com', 'Scott', 'Roberts', 'inactive'),
('eric.turner@outlook.com', 'Eric', 'Turner', 'active'),
('stephen.phillips@aol.com', 'Stephen', 'Phillips', 'pending');