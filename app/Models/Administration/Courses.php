<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model {

    protected $table = "courses";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description", "value", "order"];

}
