<?php

namespace NathanDunn\Countries\Continents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use NathanDunn\Countries\Countries\Country;
use NathanDunn\Countries\Database\Factories\ContinentFactory;

class Continent extends Model
{
    use HasFactory;

    protected $table = 'continents';

    public function countries(): HasMany
    {
        return $this->hasMany(Country::class);
    }

    public static function newFactory()
    {
        return ContinentFactory::new();
    }
}
