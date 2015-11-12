#!/bin/bash

# Migrate the database
php artisan migrate

# Seed the database with initial values
php artisan db:seed

# Compile less and js
gulp