<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Locations;
use App\Models\Administration\Courses;
use App\Models\Administration\Parameters;
use App\Models\Administration\Schedules;
use App\Models\Administration\SchedulesDetail;
use App\Models\Administration\Addon;
use DB;

class ClientsController extends Controller {

    public $months;
    public $days;

    public function __construct() {
        date_default_timezone_set("America/Bogota");
    }

    public function index() {
        $locations = Locations::all();
        $courses = Courses::all();
        $quantity = Parameters::where("group", "show")->first();
        $end = (int) date("m") + $quantity->value;

        $start = Parameters::where("group", "Months")
                ->where("code", ">=", (int) date("m"))
                ->where("code", "<=", $end)
                ->get();
        
        return view("Purchase.client.init", compact("locations", "courses", "start"));
    }

    public function getDay($day) {
        $i = strtotime(date("Y-m-" . $day));
        $resp = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m", $i), date("d", $i), date("Y", $i)), 0);

        return ($resp == 0) ? 7 : $resp;
    }

    public function getList(Request $req) {
        $in = $req->all();

        $month = Parameters::where("group", "show")->first();
        $init = (int) date("m");
        $resp = array();
        $cont = 0;

        $end = ($month->value + $init);


        for ($i = $init; $i <= $end; $i++) {

            $initSecond = ($cont == 0) ? (int) date("d") : 1;

            if (in_array($i, $in["start_date"])) {

                for ($j = $initSecond; $j <= cal_days_in_month(CAL_GREGORIAN, $i, date("y")); $j++) {
//            for ($j = 26; $j <= 29; $j++) {
                    $day = $this->getDay($j);

                    $sche = SchedulesDetail::where("day", $day)
                            ->select("schedule_id")
                            ->join("schedules", "schedules.id", "schedules_detail.schedule_id")
                            ->orderBy("schedule_id", "asc")
                            ->distinct("schedule_id");

                    if (isset($in["location"]) && $in["location"] != 0) {
                        $sche->whereIn("schedules.location_id", $in["location"]);
                    }
                    if (isset($in["courses"]) && $in["courses"] != 0) {
                        $sche->whereIn("schedules_detail.course_id", $in["courses"]);
                    }

                    $sche = $sche->get()->toArray();

                    if (count($sche) > 0) {
                        foreach ($sche as $value) {

                            $initial = SchedulesDetail::where("schedule_id", $value["schedule_id"])
                                    ->select("day")
                                    ->orderBy("day", "asc")
                                    ->first();

                            if ($initial["day"] == $day) {
                                $data = $this->getSchedule($value["schedule_id"]);

                                foreach ($data as $key => $value) {
                                    if ($key == 0) {
                                        $data[$key]["dayweek"] = $j;
                                    } else {
                                        $data[$key]["dayweek"] = $j + ($data[$key]["day_id"] - $data[$key - 1]["day_id"]);
                                    }
                                    $data[$key]["month"] = $i;
                                }
                                $resp[] = $data;
                            }
                        }
                    }
                }
            }
            $cont++;
        }
        return response()->json(["success" => true, "data" => $resp]);
    }

    public function getSchedule($schedule_id) {
        return SchedulesDetail::where("schedule_id", $schedule_id)
                        ->select("schedules_detail.id", "parameters.code as day_id", "schedules.location_id", "courses.id as course_id", "courses.value", "schedules_detail.schedule_id", "locations.description as location", "courses.description as course", "parameters.description as day", "schedules_detail.hour", "schedules_detail.hour_end", "locations.address")
                        ->join("schedules", "schedules.id", "schedules_detail.schedule_id")
                        ->join("locations", "locations.id", "schedules.location_id")
                        ->join("courses", "courses.id", "schedules_detail.course_id")
                        ->join("parameters", "parameters.code", DB::raw("schedules_detail.day and parameters.group='days'"))
                        ->get()->toArray();
    }

    public function formInput($schedule_id, $month, $day_week) {
        \Session::put("schedule_id", $schedule_id);
        \Session::put("month", $month);
        \Session::put("day_week", $day_week);

        $sche = $this->getSchedule($schedule_id);

        foreach ($sche as $key => $value) {
            $sche[$key]["value"] = "$ " . number_format($sche[$key]["value"], 2, ",", ".");

            if ($key == 0) {
                $sche[$key]["dayweek"] = $day_week;
            } else {
                $temp = $sche[$key]["day_id"] - $sche[$key - 1]["day_id"];
                if ($temp == 0) {
                    $sche[$key]["dayweek"] = $day_week + 1;
                } else {
                    $sche[$key]["dayweek"] = $day_week + ($temp);
                }
            }
        }

        $addon = Addon::where("schedule_id", $schedule_id)->get();
        $course = Courses::find($sche[0]["course_id"]);
        session(['sche' => $sche, "months" => $month, "addon" => $addon]);

        if ($course->dui == true) {
            return view("Purchase.client.formdui", compact("sche", "month", "addon"));
        } else {
            return view("Purchase.client.form", compact("sche", "month", "addon"));
        }
    }

    public function formDui(Request $req) {
        $in = $req->all();
        session(["formclient" => $in]);

        $sche = session("sche");
        $month = session("months");
        $addon = Session("addon");
        return view("Purchase.client.formduinext", compact("sche", "month", "addon"));
    }

    public function payment(Request $req) {
        $in = $req->all();
        dd($in);
    }

    public function paymentDui(Request $req) {
        $in = $req->all();
        dd($in);
    }

}
