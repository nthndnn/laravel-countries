<?php

namespace NathanDunn\Countries\Currencies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use NathanDunn\Countries\Countries\Country;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class);
    }
}
