<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Days extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day', 'month', 'year', "is_festive", "number_week"
    ];

}
