<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Locations;
use App\Models\Administration\Courses;
use App\Models\Administration\Parameters;
use App\Models\Administration\Schedules;

class ClientsController extends Controller {

    public $months;
    public $days;

    public function __construct() {
        $this->days = array("1" => "monday", "2" => "tuesday", "3" => "wednesday", "4" => "thurday",
            "5" => "friday", "6" => "saturday", "7" => "sunday");
        $this->months = array(
            "1" => "january",
            "2" => "february",
            "3" => "march",
            "4" => "april",
            "5" => "may",
            "6" => "june",
            "7" => "july",
            "8" => "august",
            "9" => "september",
            "10" => "october",
            "11" => "november",
            "12" => "december",
        );
    }

    public function index() {
        $locations = Locations::all();
        $courses = Courses::all();
        $star = $this->getStarDate();
        return view("Purchase.client.init", compact("locations", "courses", "star"));
    }

    public function getStarDate() {
        $month = Parameters::where("group", "show")->first();
        $init = (int) date("m");
        $resp = array();
        for ($i = $init; $i < $month->value + $init; $i++) {
            $resp[] = $this->getMonth($i);
        }
        return $resp;
    }

    public function getMonth($id) {
        foreach ($this->months as $i => $value) {
            if ($i == $id) {
                return array("id" => $i, "month" => $value, "year" => date("Y"));
            }
        }
    }

    public function getDayText($id) {
        foreach ($this->days as $i => $value) {
            if ($i == $id) {
                return $value;
            }
        }
    }

    public function getDay($day) {
        $i = strtotime(date("Y-m-" . $day));
        $resp = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m", $i), date("d", $i), date("Y", $i)), 0);

        return ($resp == 0) ? 7 : $resp;
    }

    public function getList() {
        $courses = Courses::all()->toArray();
        $month = Parameters::where("group", "show")->first();
        $locations = Locations::all();
        $init = (int) date("m");
        $resp = array();
        $cont = 0;

        foreach ($locations as $loc) {
            for ($i = $init; $i < $month->value + $init; $i++) {
                for ($j = (int) date("d"); $j <= cal_days_in_month(CAL_GREGORIAN, $i, date("y")); $j++) {
                    $sche = Schedules::
                                    where("day", $this->getDay($j))
                                    ->where("location_id", $loc["id"])
                                    ->get()->toArray();
                    if (count($sche) > 0) {
                        $cour = array();
                        foreach ($sche as $val) {
                            if (!in_array($val["course_id"], $cour)) {
                                $cour[] = $val["course_id"];
                            }
                        }

                        $resp[$cont][] = array(
                            "day" => $j,
                            "day_text" => $this->getDayText($this->getDay($j)),
                            "weekday" => $this->getDay($j),
                            "courses" => implode(",", $cour),
                            "location" => $loc["id"],
                            "location_text" => $loc["description"]
                        );
                    }

                    if ($this->getDay($j) == 7) {
                        $cont++;
                    }
                }
            }
        }


        $cont = 0;
        $number = array();
        foreach ($resp as $i => $value) {
            $resp[$i] = $this->setWeeek($value);
        }

        return response()->json(["success" => true, "data" => $resp]);
    }

    public function setWeeek($arrWeek) {

        $arrWeek = array_values($arrWeek);
        for ($i = 1; $i < count($arrWeek); $i++) {
            for ($j = 0; $j < count($arrWeek) - 1; $j++) {
                if ($arrWeek[$j]["courses"] == $arrWeek[$j + 1]["courses"]) {
                    $arrWeek[$j]["repeat"][] = $arrWeek[$j + 1]["day"];
                    $arrWeek[$j]["repeat"] = array_unique($arrWeek[$j]["repeat"]);
                }
            }
        }
        return $arrWeek;
    }

    public function getDayWeek($day) {
        $month = Parameters::where("group", "show")->first();
        $init = (int) date("m");
        $resp = array();
        for ($i = $init; $i < $month->value + $init; $i++) {

            for ($j = (int) date("d"); $j <= cal_days_in_month(CAL_GREGORIAN, $i, date("y")); $j++) {
                if ($this->getDay($j) == $day) {
                    $resp[] = $j;
                }
            }
        }
        return $resp;
    }

}
