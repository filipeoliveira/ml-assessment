# MailerLite Challenge

## Overview
On MailerLite we store millions and millions of subscribers for our users. This challenge involves designing and implementing a scalable endpoint to handle these subscribers efficiently.

## Task Description

1. **Write Endpoint**:
   - Design an endpoint to add a subscriber to the database.
   - The endpoint should handle fields such as email, name, last name, and status.
   - Upserting records is not an option; the existence of the subscriber must be checked before insertion.

2. **Performance and Scalability**:
   - The endpoint is expected to be called about a million times a minute, sometimes for the same subscriber.
   - Detail how you would scale this endpoint. Be as specific as possible (e.g., using X configured as Y).

3. **GET Endpoint**:
   - Implement a simple GET endpoint to retrieve subscriber information.
   - This endpoint is also expected to handle a high volume of requests.

4. **Front-End Implementation**:
   - Create a simple page using Angular, AngularJS, or Vue.
   - The page should include a form to insert and read subscriber data.
   - Implement pagination.

5. **Handling Increased Traffic**:
   - Propose solutions for scaling the endpoints to handle ten times the traffic.
   - Discuss potential challenges and how you would address them.

## General Requirements

- The solution should follow [PSR-2](https://www.php-fig.org/psr/psr-2/) coding standards.
- Provide instructions for setting up and running the project in a local environment with PHP 8.x, MySQL 5.x, and the latest Chrome browser.
- Dockerizing the assignment is encouraged.
- No need for authentication, CSRF protection, or database migration scripts (just provide the SQL file).
- Including test coverage is a plus.

## Submission

Please ensure your submission includes:

- A sample implementation in raw PHP (No frameworks allowed).
- Any necessary infrastructure requirements.
- The implementation of both POST and GET endpoints as described.
- A front-end page built with Angular, AngularJS, or Vue.
- Send it as a public repository in Github.
