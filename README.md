<p align="center">
    <img alt="Bicing Log" title="Bicing API" src="./documentation/images/bicing-logo.png" width="20%">
</p>

<h3 align="center">
  Bicing Statistics API
</h3>

<p align="center">
  <a href="https://symfony.com/">Symfony 4</a> 
  <a href="https://en.wikipedia.org/wiki/Representational_state_transfer">REST API</a> 
  applying <a href="https://martinfowler.com/bliki/CQRS.html">CQRS</a>,
  <a href="https://en.wikipedia.org/wiki/Domain-driven_design">DDD</a> patterns,
  built with <a href="https://en.wikipedia.org/wiki/Continuous_integration">CI</a>,
  and driven by <a href="https://en.wikipedia.org/wiki/Behavior-driven_development">BDD</a>.
</p>

<p align="center">
    <img src="https://img.shields.io/badge/php-%5E7.2-blue.svg" alt="PHP 7.2">
    <img src="https://gitlab.com/lechatquidanse/public-badges/raw/master/bicing-statistics-api/reference.svg" alt="reference">
    <img src="https://gitlab.com/lechatquidanse/public-badges/raw/master/bicing-statistics-api/build.svg" alt="build">
    <img src="https://gitlab.com/lechatquidanse/public-badges/raw/master/bicing-statistics-api/coverage.svg" alt="coverage">
    <img src="https://img.shields.io/badge/contributions-welcome-orange.svg" alt="Contributions welcome">
    <img src="https://img.shields.io/badge/license-MIT-lightgrey.svg" alt="License">
</p>

<h5 align="center">Get statistics and locations of bicycle stations.</h5>

> The goal of this REST API is to ease customer's usage of large-scale public bicycle sharing system.  
> By collecting data from different providers ([Bicing][bicing], [Velib][velib], ...) it gives customers powerful information (location to pick or return a bike, best time for picking up a bike, ...).
> Here is an example of a user interface project calling the API [/lechatquidanse/bicing-user-interface-app]((https://github.com/lechatquidanse/bicing-user-interface-app/))

<p align="center">
  <a href="#getting-started">Getting Started</a> •
  <a href="#features">Features</a> •
  <a href="#built-with">Built With</a> •
  <a href="#development">Development</a> •
  <a href="#coding-standard">Coding Standard</a> •
  <a href="#ci-and-deployment">CI and Deployment</a>
</p>

![Bicing API RESTs examples](./documentation/images/bicing-api-curl-examples.png)

## <a name="getting-started"></a> Getting Started
### Prerequisites

To install and run the API you need [Docker Compose](docker-compose) and... that's all.
Please follow the [official documentation](docker-compose-install) to install it on your environment.

### Installing
Clone the project and run the default installation:

```bash
git clone https://github.com/lechatquidanse/bicing-statistics-api.git && cd bicing-statistics-api && make install
```
Your docker containers should have been successfully built and run.

## Features

Multiple features are proposed across 2 user interfaces, a REST API and command-line commands:

### REST API:
![Bicing API RESTs features](./documentation/images/features-rest.png)

You can find the concrete user stories written in [Gherkin][gherkin] in [features folder](./features).
These behaviour requirements are tested with [Behat][behat].

### CLI:

![Bicing API CLI features](./documentation/images/features-cli-min.png)

To run the project once installed:

## <a name="built-with"></a> Built with

- [PHP 7.2][php]
- [Symfony 4.1][symfony]
- [API-Platform][api-platform]
- [Timescale Database][timescale]
- [Docker][docker]

## Development
The Makefile contains useful command for development purpose

![Makefile helpul commands](./documentation/images/makefile-help-min.png)

## <a name="coding-standard"></a> Coding standard

### Domain Driven Design

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

### Command Query Responsibility Segregation

In this project, a use case is a command or a query with a single responsibility.
This use case is then handled by a handler for a command or a data provider for a query.

Commands are handled by a message bus ([SimpleBus][simplebus]) where a command is link to one handler.   
For example, to create a station in database:

![CQRS command handler](./documentation/images/command-handler-min.png)

## <a name="ci-and-deployment"></a> CI and Deployment

CI and deployment can be handled through [Gitlab][gitlab] and [Docker][docker] thanks to [.gitlab-ci.yml](./.gitlab-ci.yml)
It contains 3 different stages.

### Test

Environment 'test' is triggered when a 'feature/*' branch is pushed to the repository. 
It will then install project and launch qa tools. 

### Build

Environment 'build' is triggered when a 'release/*' branch is pushed to the repository. 
It will then install project, launch qa tools and then build and push a docker image on a registry if no error occured.

### Production

This manual action, will pull the image build by the previous step and update the specific container.

![Continuous Integration](./documentation/images/continuous-integration.png)

## License

[MIT](https://opensource.org/licenses/MIT)

> Stéphane EL MANOUNI &nbsp;&middot;&nbsp;
> [Linkedin](https://www.linkedin.com/in/stephane-el-manouni/)

[api-platform]: https://api-platform.com/
[behat]: http://behat.org/en/latest/
[bicing]: https://www.bicing.cat/
[docker]: https://www.docker.com/
[docker-compose]: https://docs.docker.com/compose/
[docker-compose-install]: https://docs.docker.com/compose/install
[gherkin]: https://docs.cucumber.io/gherkin/
[gitlab]: https://gitlab.com/
[php]: http://php.net/
[simplebus]: https://github.com/SimpleBus/SimpleBus
[symfony]: http://symfony.com/
[timescale]: http://www.timescale.com/
[velib]: https://www.velib-metropole.fr/
[wiki-DDD]: https://en.wikipedia.org/wiki/Domain-driven_design
