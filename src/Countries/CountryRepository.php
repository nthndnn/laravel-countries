<?php

namespace NathanDunn\Countries\Countries;

use NathanDunn\Repositories\Repository;

class CountryRepository extends Repository
{
    public function __construct(Country $country)
    {
        parent::__construct($country);
    }

    public function byAlpha2Code(string $code)
    {
        return $this->model->where('alpha_2_code', $code);
    }

    public function byAlpha3Code(string $code)
    {
        return $this->model->where('alpha_3_code', $code);
    }
}
