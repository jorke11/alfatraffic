<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model {

    protected $table = "addon";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description", "schedule_id"];

}
