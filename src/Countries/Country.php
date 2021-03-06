<?php

namespace NathanDunn\Countries\Countries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use NathanDunn\Countries\Continents\Continent;
use NathanDunn\Countries\Currencies\Currency;
use NathanDunn\Countries\Database\Factories\CountryFactory;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $casts = [
        'capital' => 'array',
    ];

    public function continent(): BelongsTo
    {
        return $this->belongsTo(Continent::class);
    }

    public function currencies(): BelongsToMany
    {
        return $this->belongsToMany(Currency::class)->withTimestamps();
    }

    public static function newFactory()
    {
        return CountryFactory::new();
    }
}
