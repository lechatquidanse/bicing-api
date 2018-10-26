# Bicing API
> The goal of this API is to ease customer's usage of large-scale public bicycle sharing system.  
> By collecting data from different providers ([Bicing][bicing], [Velib][velib], ...) it can advice customers or provide them useful information (location to pick or return a bike, best time of picking up a bike, ...).


## Table of Contents
- [Getting Started](#installation)
- [Features](#features)
- [Built With](#support)
- [Development](#development)
- [Contributing](#contributing)
- [Deployment](#deployment)
- [Releases](#releases)
- [Acknowledgment](#acknowledgment)

## Getting Started
### Prerequisites

To install and run the API you need [Docker Compose](docker-compose) and... that's all.  
Please follow the [official documentation](docker-compose-install) to install it on your environment.

### Installing
Clone the project:

```bash
git clone https://github.com/lechatquidanse/bicing-api.git && cd bicing-api
```

Then run the default build installation:
```bash
make install
```
Your docker containers should have been successfully built and run.


## Features

To follow the goals of the API, this project offers many features across two user interfaces:

### REST API:
<p align="center">
  <img src="./documentation/features-rest.png" alt="Bicing API REST features" />
</p>

###CLI:
<p align="center">
  <img src="./documentation/features-cli.svg" alt="Bicing API CLI features" />
</p>

The commandes:
```bash
docker-compose exec php bin/console bicing-api:import:stations
docker-compose exec php bin/console bicing-api:import:stations-states
```

To run the project once installed:

## Built with

- [PHP 7.1][php]
- [Symfony 4.0][symfony]: 
- [API-Platform][api-platform]:
- [Timescale database][timescale]:
- [Docker][docker]:


### The folder structure

Code and folder structure follow Domain Driven Design (DDD).
Here is a good article to understand naming and folder [Domain Driver Design, little explanation and example](https://jorgearco.com/ddd-with-symfony/).

    src
        \
            |\ Application     `Contains the Use Cases and the Processes of the domain system, commands, handlers and subscribers`
            |
            |\ Domain          `The system business logic layer (Models, Events, Exceptions...)`
            |
            |\ Infrastructure  `Its the implementation of the system outside the model. I.E: Persistence, Query, etc`
            |
            |\ UserInterface   `It contains all the interfaces allowed for a user of the API (Cli, HTTP, Rest, etc)`



[api-platform]: https://api-platform.com/
[docker-compose]: https://docs.docker.com/compose/
[docker-compose-install]: https://docs.docker.com/compose/install
[bicing]: https://www.bicing.cat/
[php]: http://php.net/
[symfony]: http://symfony.com/
[timescale]: http://www.timescale.com/
[velib]: https://www.velib-metropole.fr/
[wiki-DDD]: https://en.wikipedia.org/wiki/Domain-driven_design

Authors
-------

* Stéphane EL MANOUNI
