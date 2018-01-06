<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class States extends Model {

    protected $table = "states";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description","short"];

}
