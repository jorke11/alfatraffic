<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Events extends Model {

    protected $table = "events";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description", "location_id", "course_id", "dateevent", "action_id", "status_id"];

}
