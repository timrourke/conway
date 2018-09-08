# Conway's Game of Life

An implementation of Conway's Game of Life in PHP.

Requires PHP 7.1+.

___

## Running the game

1. Clone this repository
```bash
git clone git@github.com:timrourke/conway.git
```
2. Install the [composer](https://getcomposer.org/) dependencies
```bash
composer install
```
3. Execute the `run` command
```bash
bin/conway run
```

## Running the game with docker-compose

1. Build the image
```bash
docker-compose build
```
2. Execute the `run` command
```bash
docker-compose run -T conway bin/conway run

# It is also possible to specify command line arguments:
docker-compose run -T conway bin/conway run --help

# Press ctrl-c to exit.
```

## For more info

See the main application menu by running the command `bin/conway`.

See the application's documentation by running the command `bin/conway --help`.

See the `run` command's documentation by running the command `bin/conway run --help`.
