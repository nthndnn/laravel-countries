# Laravel Countries 🌎
Laravel Countries provides database migrations and syncing capabilities in order to sync continents, currencies and currencies.

Laravel Countries package uses the [REST Countries](https://restcountries.com/) API
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
You may find you'd like to add syncing countries as part of your development/staging environment. You may add `NathanDunn\Countries\Database\Seeders\CountriesSeeder` to your `DatabaseSeeder`.

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use NathanDunn\Countries\Database\Seeders\CountriesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesSeeder::class);
    }
}
```