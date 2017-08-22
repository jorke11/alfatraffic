<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class Purchases extends Model {

    protected $table = "purchases";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "schedule_id",
        "date_course",
        "name",
        "last_name",
        "city_id",
        "state_id",
        "zip_code",
        "telephone",
        "license",
        "email",
        "license_issuing",
        "name_building",
        "last_name_building",
        "address_building",
        "city_id_building",
        "state_id_building",
        "zip_code_building",
        "card_building",
        "date_expired_building",
        "security_code_building",
        "date_selected",
        "status_id",
        ];

}
