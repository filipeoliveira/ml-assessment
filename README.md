# Mailerlite assessment

![Mailerlite logo](docs/images/ml-github-banner.png)

At MailerLite we store millions and millions of subscribers for our users. This challenge involves designing and implementing a scalable endpoint to handle these subscribers efficiently.

1. [Task information](docs/tasks.md)
2. [Developer decisions](docs/decisions.md)
3. [Data model](docs/tasks.md)
4. [How to scale this project](docs/scalability.md)
5. [Tests](docs/tests.md)

----------

## Project requirements

Before running this project, ensure that you have the following prerequisites installed on your system:

### Docker and Docker Compose

- **Docker**: A platform for developing, shipping, and running applications inside isolated environments called containers. [Install](https://docs.docker.com/get-docker/)
- **Docker Compose**: A tool for defining and running multi-container Docker applications. [Install](https://docs.docker.com/compose/install/)

Ensure that both Docker and Docker Compose are installed and properly set up on your machine before proceeding.

## Running
To run this project, just do: `docker-compose up` on the root folder of this project.
It will download all the necessary docker images and will spin up the required backend infrastructure (database, application, cache, network, frontend ...).

It's ready when the following message is presented:

```
web-1          |    INFO  Server running on [http://0.0.0.0:8005].  
...
```

- Backend API is available through [127.0.0.1:8080/api/subscribers](http://0.0.0.0:8000/api/subscribers)

- Frontend web app is available through [127.0.0.1:8085](127.0.0.1:8085)

----------
