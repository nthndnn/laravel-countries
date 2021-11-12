<?php

namespace NathanDunn\Countries\Currencies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use NathanDunn\Countries\Countries\Country;
use NathanDunn\Countries\Database\Factories\CurrencyFactory;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class)->withTimestamps();
    }

    public static function newFactory()
    {
        return CurrencyFactory::new();
    }
}
