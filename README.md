# Shopkeeper

An example web service project with CRUD and RPC style endpoints.

## Warning

This is a demonstration project only. It is not ready to be used in production.

## Alternative versions

This code is available in the following languages:

- [PHP (Laravel)](https://github.com/WillSkates/shopkeeper/blob/php)

## Reading

To read the code top-down from the highest entry point, please start in `routes/api.php`.

## Background

This project will randomly generate shop stock from a list of items in a database.

### Items

The service provides CRUD (POST, GET, PUT, DELETE) endpoints for items within the `/api/items` resource.

An item is made up of some description and multiple possible prices so that they can be allocated to multiple shops.

*Note* Item prices have types. This is not currently used but is here to show how I would expand the program next.

An item can be represented using this JSON string:
```json
{
    "name": "A Shiny Item",
    "description": "I am really shiny.",
    "prices": [
        {
            "type": "basic",
            "value": 12345
        }
    ]
}
```

### Shops

Shops are randomly generated lists of items based on some criteria.

You will need to know:
1. Which RNG method to use:
    1. `rand` uses the inbuilt random functions.
    2. `lcg` uses a quick [LCG](https://en.wikipedia.org/wiki/Linear_congruential_generator) that I wrote.
2. A `seed` for our random number generation.
3. What our minimum (min) price is.
4. What our maximum (max) price is.
5. The maximum number of items we want in our shop (num_items).

To generate a shop first, make sure you have added some items to the database.

Then, you should make the following request:
```http
POST /api/shop
Content-Type: application/json
Accept: application/json

{
    "rng": {
        "method": "rand",
        "seed": 123456
    },
    "price": {
        "min": 1,
        "max": 20
    },
    "num_items": 10
}
```

You should receive a JSON object containing your shop details, items and prices.

## Why?

I wanted an unusual project to demonstrate that I know how to:

1. Demonstrate a solution to unusual problems.
2. Use framework conventions.
3. Employ the use of different HTTP methods.
4. Write Feature and Unit tests.
5. Write PSR-12 compatible code.
6. (Hopefully) write a decent README :).

It doesn't demonstrate that I know how to:

1. Publish a package for others to use.
2. Write a CLI app.

That's because of the current size and I have [other](https://github.com/WillSkates/pop) (older) [examples](https://github.com/WillSkates/Translator) for those.

## Installation

### Prerequisites

You will need these installed:

- Linux or MacOS (with [Colima](https://github.com/abiosoft/colima), [Docker Desktop](https://www.docker.com/products/docker-desktop/) or something similar).
- [bash](https://www.gnu.org/software/bash/)
- [podman](https://podman.io/) (and set up to use 'Rootless' containers) or [docker](https://docker.com).
- [curl](https://curl.se/)
- [gpg](https://gnupg.org/)

### How

To install, first clone the repository:

```bash
git clone https://github.com/WillSkates/shopkeeper.git
cd shopkeeper
git checkout php
```

## Usage

From there, I've provided a docker image to use with the project.

It is self installing and ready to use, you just need to pass commands through the `./run` script.

For example:

```bash
./run php artisan test --coverage
./run vendor/bin/pint --test
```

## License

This project is published under the MIT license.

Full details can be found in the "LICENSE" file.
