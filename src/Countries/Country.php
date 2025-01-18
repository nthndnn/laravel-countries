<?php

namespace NathanDunn\Countries\Countries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use NathanDunn\Countries\Continents\Continent;
use NathanDunn\Countries\Currencies\Currency;
use NathanDunn\Countries\Database\Factories\CountryFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $casts = [
        'capital' => 'array',
    ];

    protected function name(): Attribute
    {
        return Attribute::get(fn () => $this->name_common ?? $this->name_official);
    }

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
