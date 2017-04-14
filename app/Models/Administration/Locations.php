<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model {

    protected $table = "locations";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description", "address", "order"];

}
