<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Schedules extends Model {

    protected $table = "schedules";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description","location_id"];

}
