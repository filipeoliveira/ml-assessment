# MailerLite Challenge

This is my understanding and rephrasing in bullet-points of the assignment. 
The original text is at the bottom.

## Overview
At MailerLite we store millions and millions of subscribers for our users. This challenge involves designing and implementing a scalable endpoint to handle these subscribers efficiently.

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


----------

## Original text:

> On MailerLite we store millions and millions of subscribers for our users.
> Design an endpoint that can be used to write a subscriber to a database, along with a couple of fields (email, name, last name, status). Unfortunately, due to other dependencies, you cannot upsert records, so you’ll have to check if the subscriber already exists in the database.
> That endpoint will be called about a million times a minute and some requests will be for the same subscriber, how would you scale it? Please be as specific as possible (e.g. I would use X configured like Y, etc.).
> Provide a sample implementation in raw PHP (no frameworks please) for the above endpoint, along with any infrastructure requirements. Assume that batching multiple subscribers into a single call isn’t an option.
> Implement a simple GET endpoint that retrieves a subscriber assuming it will also be called a million times a minute for different subscribers.
> Finally, write a simple page in either Angular, AngularJS or Vue that shows a form to insert and read subscribers. Implement pagination as well.
> How would you scale the above endpoints to handle 10 times the traffic? What challenges do you foresee?
> General information
> PSR-2 compliant source code
> Instructions how to run a project on local environment running PHP 8.x, MySQL 5.x and the latest Chrome browser
> Feel free to provide a dockerize your test assignment
> No need to implement authentication, CSRF or database migration (just provide the sql file)
> Test coverage a plus
> Deliverables: Please create a public repository on GitHub for your source code, push it and send us the link.