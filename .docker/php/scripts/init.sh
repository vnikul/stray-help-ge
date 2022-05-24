#!/bin/bash

# Install dependencies
composer install --ignore-platform-reqs

exec "$@"
