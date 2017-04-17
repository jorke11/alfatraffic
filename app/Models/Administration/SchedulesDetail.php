<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class SchedulesDetail extends Model {

    protected $table = "schedules_detail";
    protected $primaryKey = "id";
    protected $fillable = ["id", "day", "course_id",  "hour", "duration",
        "schedule_id", "hour_end"];

}
