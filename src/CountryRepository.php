<?php

namespace NathanDunn\Countries;

use PackagedBy\Repositories\Repository;

class CountryRepository extends Repository
{
    public function __construct(Country $country)
    {
        parent::__construct($country);
    }
}
