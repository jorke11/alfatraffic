<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Courses;
use App\Models\Administration\Schedules;
use App\Models\Administration\SchedulesDetail;
use App\Models\Administration\Locations;
use DB;
use App\Models\Administration\Parameters;

class SchedulesController extends Controller {

    public function __construct() {
        date_default_timezone_set("America/Bogota");
        $this->middleware("auth");
    }

    public function index() {
        $day = Parameters::where("group", "days")->get();
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

    public function getModalData($id) {
        $location = Locations::Find($id);
        $days = null;
        $courses = null;

        if ($location != null) {
            if ($location->days != '') {
                $days = Parameters::where("group", "days");
                $arr = json_decode($location->days);
                
                foreach ($arr as $value) {
                    $wh[]=$value->day;
                }
                
                                
                $days->whereIn("code", $wh);
                $days = $days->get();
            }
            if ($location->courses != '') {
                $arr = json_decode($location->courses);
                $courses = Courses::whereIn("id", $arr)->get();
            }
        }

        return response()->json(["success" => true, "days" => $days, "courses" => $courses]);
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

        $detail = SchedulesDetail::where("schedule_id", $record->id)->get();

        foreach ($detail as $value) {
            $row = SchedulesDetail::find($value->id);
            $row->delete();
        }
        $result = $record->delete();

        if ($result) {
            return response()->json(['success' => true]);
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
