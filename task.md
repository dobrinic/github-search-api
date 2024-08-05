## Task

To accomplish the task at hand, we'll leverage a tech stack comprising PHP as the primary language and Symfony 5+ as the framework, providing a robust foundation for web application development. Git will serve as our Version Control System (VCS), facilitating efficient management of code changes. We'll also utilize the [GitHub API](https://docs.github.com/en/rest/reference/search#search-issues-and-pull-requests), following its documentation for "Search Issues and Pull Requests," which enables programmatically searching for issues and pull requests within GitHub repositories.

It is necessary to create a system that calculates the popularity of a certain word. The system should search the GitHub issue for a given word using the number of results for {word} + rocks as a positive result and {word} + sucks as a negative. The result should be a popularity rating of the given word from 0-10 as a ratio of the positive result to the total number of results. The results should be saved in a local database so that future queries for the same words will be faster. In the future, the addition/change of providers is expected (e.g. Twitter will be used instead of GitHub), so the system should be designed accordingly.

## Expected result

### Endpoint

Endpoint that returns the result in JSON form.

For example:

```php
GET https://example.com/score?term=php {
    term: "php",
    score: 3.33
}
```

The URL is only given as an example and can be derived in any form (path parameter, query parameter, ...). Response is also an example and can be in any form, but must contain at least these 2 fields (term and score).

### README

Along with the source code, it is necessary to create a README.md in which the way in which the JSON API is consumed will be explained with several practical examples. In addition, it is expected that the project setup for further development is documented (what to do after cloning the repository so they can start working on the project).

### General instructions

The project needs to be set up as if it were a commercial project that will continue to develop regardless of the fact that it only has 1 endpoint. It is desirable that the system can be tested by running tests (PHPUnit, Codeception, Behat,...).

### Bonus

**This part is not necessary to solve!**

If you want to express yourself and get extra points, you can show us what you know and solve one of the additional and more demanding tasks.

- OAuth - set up a basic OAuth2 system without users (only client credentials)
- Align the API with the JSONAPI specification (http://jsonapi.org/)
- API v2 - introduce API versioning and create a new version of the endpoint for retrieving results that corresponds to the JSONAPI specification (http://jsonapi.org/)
- CI / CD - set up a basic CI/CD system using some of the free CI systems (eg GitLab CI, https://travis-ci.org/)
- Docker - set up a project using the Docker platform
- Create an OpenAPI 3 project specification
- Before starting the solution, give your estimates of the time required for the solution
- Turn on time tracking during solving