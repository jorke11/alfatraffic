<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class Purchases extends Model {

    protected $table = "purchases";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "programation_id",
        "date_course",
        "name",
        "last_name",
        "address",
        "city_id",
        "state_id",
        "zip_code",
        "date_birth",
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
        "value",
        "type_sign",
        "text_sign",
        "img_sign",
        "form_select",
        ];

}
