<?php

namespace NathanDunn\Countries\Currencies;

use Illuminate\Database\Eloquent\Builder;
use PackagedBy\Repositories\Repository;

class CurrencyRepository extends Repository
{
    public function __construct(Currency $country)
    {
        parent::__construct($country);
    }

    public function byCode(string $code): Builder
    {
        return $this->model->where('code', $code);
    }
}
