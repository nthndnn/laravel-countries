<?php

namespace NathanDunn\Countries;

use App\Currencies\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    public function currencies(): BelongsToMany
    {
        return $this->belongsToMany(Currency::class);
    }
}
