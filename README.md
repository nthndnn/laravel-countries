# Laravel Countries 🌎
Laravel Countries provides database migrations and syncing capabilities in order to maintain an up-to-date list of countries.


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

```bash
php artisan countries:sync
```

### Seeder
You may find you'd like to add syncing countries as part of your development/staging environment. If this is the case, 

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