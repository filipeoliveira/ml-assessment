-- Insert statuses
INSERT INTO statuses (name) VALUES ('active'), ('inactive'), ('suspended'), ('pending_verification'), ('deleted');

-- Insert subscribers
INSERT INTO subscribers (email, name, last_name, status_id)
VALUES
('john.doe@gmail.com', 'John', 'Doe', 1),
('jane.smith@yahoo.com', 'Jane', 'Smith', 2),
('robert.johnson@hotmail.com', 'Robert', 'Johnson', 3),
('michael.williams@outlook.com', 'Michael', 'Williams', 4),
('sarah.brown@aol.com', 'Sarah', 'Brown', 5),
('james.taylor@gmail.com', 'James', 'Taylor', 1),
('linda.thomas@yahoo.com', 'Linda', 'Thomas', 2),
('patricia.jackson@hotmail.com', 'Patricia', 'Jackson', 3),
('david.white@outlook.com', 'David', 'White', 4),
('jennifer.harris@aol.com', 'Jennifer', 'Harris', 5),
('richard.martin@gmail.com', 'Richard', 'Martin', 1),
('susan.thompson@yahoo.com', 'Susan', 'Thompson', 2),
('joseph.garcia@hotmail.com', 'Joseph', 'Garcia', 3),
('margaret.martinez@outlook.com', 'Margaret', 'Martinez', 4),
('charles.robinson@aol.com', 'Charles', 'Robinson', 5);
('emma.wilson@icloud.com', 'Emma', 'Wilson', 5);
('elizabeth.clark@gmail.com', 'Elizabeth', 'Clark', 1),
('thomas.rodriguez@yahoo.com', 'Thomas', 'Rodriguez', 2),
('christopher.lewis@hotmail.com', 'Christopher', 'Lewis', 3),
('daniel.lee@outlook.com', 'Daniel', 'Lee', 4),
('paul.walker@aol.com', 'Paul', 'Walker', 5),
('mark.hall@gmail.com', 'Mark', 'Hall', 1),
('donald.allen@yahoo.com', 'Donald', 'Allen', 2),
('kenneth.young@hotmail.com', 'Kenneth', 'Young', 3),
('steven.hernandez@outlook.com', 'Steven', 'Hernandez', 4),
('edward.king@aol.com', 'Edward', 'King', 5);
('brian.wright@gmail.com', 'Brian', 'Wright', 1),
('ronald.lopez@yahoo.com', 'Ronald', 'Lopez', 2),
('anthony.hill@hotmail.com', 'Anthony', 'Hill', 3),
('kevin.scott@outlook.com', 'Kevin', 'Scott', 4),
('jason.green@aol.com', 'Jason', 'Green', 5),
('matthew.adams@gmail.com', 'Matthew', 'Adams', 1),
('gary.baker@yahoo.com', 'Gary', 'Baker', 2),
('timothy.gonzalez@hotmail.com', 'Timothy', 'Gonzalez', 3),
('jose.nelson@outlook.com', 'Jose', 'Nelson', 4),
('larry.carter@aol.com', 'Larry', 'Carter', 5),
('jeffrey.mitchell@gmail.com', 'Jeffrey', 'Mitchell', 1),
('frank.perez@yahoo.com', 'Frank', 'Perez', 2),
('scott.roberts@hotmail.com', 'Scott', 'Roberts', 3),
('eric.turner@outlook.com', 'Eric', 'Turner', 4),
('stephen.phillips@aol.com', 'Stephen', 'Phillips', 5);