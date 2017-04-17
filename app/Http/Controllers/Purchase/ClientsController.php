<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Locations;
use App\Models\Administration\Courses;
use App\Models\Administration\Parameters;
use App\Models\Administration\Schedules;
use DB;

class ClientsController extends Controller {

    public $months;
    public $days;

    public function __construct() {
        date_default_timezone_set("America/Bogota");
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


        for ($i = $init; $i < $month->value + $init; $i++) {
            for ($j = (int) date("d"); $j <= cal_days_in_month(CAL_GREGORIAN, $i, date("y")); $j++) {

                $resp[$cont][] = array(
                    "day" => $j,
                    "month" => $i,
                    "monthtext" => $this->getMonth($i),
                    "weekday" => $this->getDay($j),
                );

                if ($this->getDay($j) == 7) {
                    $cont++;
                }
            }
        }

        $cont = 0;
        $number = array();
        $cal = array();

        foreach ($resp as $i => $value) {
            $cal = array();
            $number = array();
            $dayreal = array();
            foreach ($value as $val) {
//                $sche = DB::table("schedules")
//                                ->select("schedules.id", "schedules.day", "schedules.duration", "courses.description as course", "locations.description as location", "schedules.hour", "locations.address", "schedules.location_id")
//                                ->join("courses", "courses.id", "schedules.course_id")
//                                ->join("locations", "locations.id", "schedules.location_id")
//                                ->where("schedules.day", $val["weekday"])
//                                ->orderBy("schedules.day", "asc")
//                                ->orderBy("schedules.location_id", "asc")
//                                ->get()->toArray();
//
//
//                if (count($sche) > 0) {
//                    foreach ($sche as $i => $schem) {
//                        $nuevafecha = strtotime('+' . $schem->duration . ' hour', strtotime($schem->hour));
//                        $nuevafecha = date('H:i:s', $nuevafecha);
//                        $sche[$i]->finished = $nuevafecha;
//                        $sche[$i]->daymonth = $val["day"];
//                        $sche[$i]->month = $val["month"];
//                        $sche[$i]->daytext = $this->getDayText($schem->day);
//                        $cal[] = $schem;
//                    }
//                }

                $number[] = $val["weekday"];
                $dayreal[] = array("day" => $val["day"], "month" => $val["month"]);
            }


            $sche = DB::table("schedules")
                            ->select("schedules.id", "schedules.day", "schedules.duration", "courses.description as course", "locations.description as location", "schedules.hour", "locations.address", "schedules.location_id", "schedules.course_id")
                            ->join("courses", "courses.id", "schedules.course_id")
                            ->join("locations", "locations.id", "schedules.location_id")
                            ->whereIn("schedules.day", $number)
                            ->orderBy("schedules.location_id", "asc")
                            ->orderBy("schedules.day", "asc")
                            ->get()->toArray();

            foreach ($dayreal as $val) {
//                dd($val);
//                exit;
                foreach ($sche as $i => $value) {
                    if ($value->day == $this->getDay($val["day"])) {
                        $sche[$i]->weekday = $val;
                        $sche[$i]->daytext = $this->getDayText($this->getDay($val["day"]));
                        $sche[$i]->month = $val["month"];
                        $nuevafecha = strtotime('+' . $value->duration . ' hour', strtotime($value->hour));
                        $nuevafecha = date('H:i:s', $nuevafecha);
                        $sche[$i]->finished = $nuevafecha;
                    }
                }
            }
            $content[] = $sche;
        }

        return response()->json(["success" => true, "data" => $content]);
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

    public function formInput($course_id, $location_id) {
        $course = Courses::findOrFail($course_id);
        $location = Locations::findOrFail($location_id);
//        dd($course);
        return view("Purchase.client.form",compact("course","location"));
    }

}
