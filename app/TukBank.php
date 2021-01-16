<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TukBank extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tuk_id',
        'bank_name',
        'account_number',
        'account_name',
    ];

    /**
     * Relation to Table TUK
     *
     * @return HasOne
     */
    public function Tuk()
    {
        return $this->hasOne('App\Tuk', 'id', 'tuk_id');
    }
}
