<?php

namespace NathanDunn\Countries\Countries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use NathanDunn\Countries\Continents\Continent;
use NathanDunn\Countries\Currencies\Currency;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    public function continent(): BelongsTo
    {
        return $this->belongsTo(Continent::class);
    }

    public function currencies(): BelongsToMany
    {
        return $this->belongsToMany(Currency::class);
    }
}
