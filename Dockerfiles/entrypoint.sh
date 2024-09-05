#!/bin/bash

if [ "${PWD}" == "/work" ]; then
    if [ ! -f ".env" ]; then
        cp .env.example .env
    fi

    if [ ! -f "database/database.sqlite" ]; then
        touch database/database.sqlite
    fi

    if [ ! -d "vendor" ] && [ -f "composer.json" ]; then
        composer install -o
        php artisan key:generate
        php artisan migrate:fresh
        php artisan optimize:clear
    fi
fi

export PATH="${PATH}:${HOME}/.composer/vendor/bin"

$@
