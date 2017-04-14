<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Courses;
use App\Models\Administration\Schedules;
use App\Models\Administration\Locations;
use DB;

class SchedulesController extends Controller {

    public $day;

    public function __construct() {
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
            $result = Schedules::create($input);
            if ($result) {
                $data = $this->getTable($input["day"], 0)->getData();
                return response()->json(['success' => true, "data" => $data->data]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function edit($id) {
        $suppliers = Schedules::FindOrFail($id);
        return response()->json($suppliers);
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

    public function getTable($day, $course_id) {

        $query = DB::table("schedules")
                ->select("schedules.id", "schedules.day", "schedules.hour", "courses.description as course", "locations.description as location")
                ->join("courses", "courses.id", "schedules.course_id")
                ->join("locations", "locations.id", "schedules.location_id")
                ->where("day", $day);

        if ($course_id != 0) {
            $query->where("course_id", $course_id);
        }


        return response()->json(["success" => true, "data" => $query->get()]);
    }

}
