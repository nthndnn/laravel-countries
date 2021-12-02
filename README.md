# Laravel Countries 🌎

[![Packagist](https://img.shields.io/packagist/dt/nathandunn/laravel-countries.svg?style=flat-square)](https://packagist.org/packages/nathandunn/laravel-countries)
[![GitHub Workflow Status (master branch)](https://img.shields.io/github/workflow/status/nthndnn/laravel-countries/run-tests/master)](https://github.com/nthndnn/laravel-countries/actions/workflows/run-tests.yml?query=branch%3Amaster)
[![Code Climate](https://img.shields.io/codeclimate/maintainability/nthndnn/laravel-countries.svg?style=flat-square)](https://codeclimate.com/github/nthndnn/laravel-countries)
[![Codecov](https://img.shields.io/codecov/c/gh/nthndnn/laravel-countries?token=YF9BTSH4GN&style=flat-square)](https://app.codecov.io/gh/nthndnn/laravel-countries)
[![StyleCI](https://github.styleci.io/repos/424978710/shield)](https://github.styleci.io/repos/424978710)

Laravel Countries provides database migrations and syncing capabilities in order to sync continents, currencies and currencies. The package uses the [REST Countries](https://restcountries.com/) API
to maintain an up-to-date list of countries. This is in contrast to a lot of existing libraries, which rely on data stored in the repository and often becomes out-of-date.

## Installation

You can install the package via [Composer](https://getcomposer.org/):

```bash
composer require nathandunn/laravel-countries
```

Once the package has been installed, run Laravel's migration command to create the base tables.

```bash
php artisan migrate
```

## Syncing countries

### Console command
The primary method of syncing companies is by running the following command:

```bash
php artisan countries:sync
```

This will fetch and sync data from the API.

### Seeder
You may find you'd like to add syncing countries as part of your development/staging environment. You may add `NathanDunn\Countries\Database\Seeders\CountrySeeder` to your `DatabaseSeeder`.

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use NathanDunn\Countries\Database\Seeders\CountrySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
    }
}
```
