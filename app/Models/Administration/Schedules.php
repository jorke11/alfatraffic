<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Schedules extends Model {

    protected $table = "schedules";
    protected $primaryKey = "id";
    protected $fillable = ["id", "day", "course_id", "hour","location_id"];

}
