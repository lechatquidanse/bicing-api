# Bicing API

The goal of this API is to ease customer's usage of large-scale public bicycle sharing system.

By collecting data from different providers (Bicing, Velib, ...) it can advice customers or provide them useful information (best time of picking up a bike, ...)

This API has been implemented in [DDD][wiki-DDD] with [PHP 7.1][PHP], [Symfony 4.0][symfony] and a [Timescale database][timescale].


## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Support](#support)

## Installation

Clone the project:
```bash
git clone https://github.com/lechatquidanse/bicing-api.git
```

Then run the default build installation:

```bash
make install
```

Your docker containers have been successfully built and run.


## Usage

To run the project once installed:

```bash
make run
```

To collect new data from [Bicing][Bicing], you can run two Symfony commands.

- The first one is used to add new Bicing stations:
```bash
docker-compose run --rm php bin/console bicing-api:import:stations
```

- the second one is used to add states for each stations already in database:
```bash
docker-compose run --rm bin/console bicing-api:import:stations-states
```


## Support

Code and folder structure follow Domain Driven Design (DDD).
Here is a good article to understand naming and folder [Domain Driver Design, little explanation and example](https://jorgearco.com/ddd-with-symfony/).

### The folder structure

    src
        \
            |\ Application     `Contains the Use Cases and the Processes of the domain system, commands, handlers and subscribers`
            |
            |\ Domain          `The system business logic layer (Models, Events, Exceptions...)`
            |
            |\ Infrastructure  `Its the implementation of the system outside the model. I.E: Persistence, Query, etc`
            |
            |\ UserInterface   `It contains all the interfaces allowed for a user of the API (Cli, HTTP, Rest, etc)`



[wiki-DDD]: https://en.wikipedia.org/wiki/Domain-driven_design
[PHP]: http://php.net/
[symfony]: http://symfony.com/
[timescale]: http://www.timescale.com/
[Bicing]: https://www.bicing.cat/

Authors
-------

* Stéphane EL MANOUNI
