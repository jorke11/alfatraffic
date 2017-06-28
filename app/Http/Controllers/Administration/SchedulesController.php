<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Courses;
use App\Models\Administration\Schedules;
use App\Models\Administration\SchedulesDetail;
use App\Models\Administration\Locations;
use DB;

class SchedulesController extends Controller {

    public $day;

    public function __construct() {
        date_default_timezone_set("America/Bogota");
        $this->middleware("auth");
        $this->day = array("1" => "monday", "2" => "tuesday", "3" => "wednesday", "4" => "thurday",
            "5" => "friday", "6" => "saturday", "7" => "sunday");
    }

    public function index() {
        $day = $this->day;
        $courses = Courses::all();
        $locations = Locations::all();
        $today = $this->getDay();
        return view("Administration.schedules.init", compact("day", "courses", "today", "locations"));
    }

    public function getDay() {
        $fecha = date("Y-m-d");
        $i = strtotime($fecha);
        return jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m", $i), date("d", $i), date("Y", $i)), 0);
    }

    public function create() {
        return "create";
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
            $result = Schedules::create($input)->id;
            if ($result) {
                $header = Schedules::findOrfail($result);
                return response()->json(['success' => true, "header" => $header]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function storeDetail(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
            $input["hour_end"] = date('H:i', strtotime('+' . $input["duration"] . ' hour', strtotime(date('H:i'))));
            $result = SchedulesDetail::create($input);
            if ($result) {
                $detail = $this->getDetailAll($input["schedule_id"]);
                return response()->json(['success' => true, "detail" => $detail]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function getDetailAll($id) {
        return DB::table("schedules_detail")
                        ->select("schedules_detail.id", "schedules_detail.schedule_id", "schedules_detail.day", "courses.description as course", "schedules_detail.hour", "schedules_detail.duration", "schedules_detail.course_id", "parameters.description as daytext")
                        ->join("courses", "courses.id", "schedules_detail.course_id")
                        ->join("parameters", "parameters.code", DB::raw("schedules_detail.day and parameters.group='days'"))
                        ->where("schedules_detail.schedule_id", $id)
                        ->get()->toArray();
    }

    public function getDetail($id) {
        return (array) DB::table("schedules_detail")
                        ->select("schedules_detail.id", "schedules_detail.schedule_id", "schedules_detail.day", "locations.description as location", "courses.description as course", "schedules_detail.hour", "schedules_detail.duration", "schedules_detail.course_id")
                        ->join("courses", "courses.id", "schedules_detail.course_id")
                        ->where("schedules_detail.id", $id)
                        ->first();
    }

    public function edit($id) {
        $header = Schedules::FindOrFail($id);
        $detail = $this->getDetailAll($id);
        return response()->json(["success" => true, "header" => $header, "detail" => $detail]);
    }

    public function update(Request $request, $id) {
        $category = Schedules::FindOrFail($id);
        $input = $request->all();
        $result = $category->fill($input)->save();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $record = Schedules::FindOrFail($id);
        $day = $record->day;

        $result = $record->delete();
        if ($result) {
            $data = $this->getTable($day, 0)->getData();
            return response()->json(['success' => true, "data" => $data->data]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroyItem(Request $req, $id) {
        $input = $req->all();
        $record = SchedulesDetail::FindOrFail($id);
        $result = $record->delete();

        if ($result) {
            $detail = $this->getDetailAll($input["schedule_id"]);
            return response()->json(['success' => true, "detail" => $detail]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
