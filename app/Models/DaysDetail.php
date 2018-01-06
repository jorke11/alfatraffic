<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaysDetail extends Model {

    protected $table = "days_detail";
    protected $primaryKey = "id";
    protected $fillable = [
        'day_id', 'course_id', 'location_id', "date", "hour","node_id","duration","message","hour_end"
    ];

}
