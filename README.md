# we-movies
technical test

## Requirements
* docker
* docker-compose

## Installation

1. run docker environment
```
docker-compose up -d
```

2. install php dependencies
```
docker-compose run composer install
```

3. run doctrine migration
```
docker-compose exec php bin/console d:m:m
```
4. add some fixtures
```
docker-compose exec php bin/console doctrine:fixtures:load
```

Finaly go to this URL to see the app http://127.0.0.1:8181/home
