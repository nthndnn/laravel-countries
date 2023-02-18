<?php

namespace NathanDunn\Countries\Continents;

use Illuminate\Database\Eloquent\Builder;
use NathanDunn\Repositories\Repository;

class ContinentRepository extends Repository
{
    public function __construct(Continent $continent)
    {
        parent::__construct($continent);
    }

    public function byName(string $name): Builder
    {
        return $this->model->where('name', $name);
    }
}
