<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CronController;
use App\Models\Days;
use App\Models\DaysDetail;
use DateTime;

class ProgramationController extends Controller {

    public function index($mont = null) {
        $obj = new CronController();

        if ((int) $mont != (int) date("m")) {
            $day = 0;
        } else {
            $day = (int) date("d");
        }

        $months = \App\Models\Administration\Parameters::where("group", "months")->orderBy("code")->get();
        $mont = ($mont == null) ? (int) date("m") : $mont;

        $daysf = $this->getCalendar($mont);
        $courses = \App\Models\Administration\Courses::all();
        $locations = \App\Models\Administration\Locations::all();

//        dd($day);
        return view("Administration.programation.init", compact("months", "daysf", "courses", "locations", "mont", "day"));
    }

    public function setMessage($id, Request $req) {
        $in = $req->all();

        $row = DaysDetail::find($id);
        $row->message = $in["message"];
        $row->save();
        return response()->json(["status" => true]);
    }

    public function getMessage($id) {
        $row = DaysDetail::find($id);

        return response()->json(["status" => true, "data" => $row]);
    }

    public function getCalendar($mount) {
        $days = Days::where("month", $mount)->get();
        $daysf = array();
        $cont = 1;
        $cont2 = 0;

        foreach ($days as $value) {
            $daysf[$cont]["week"][$cont2] = $value;

            $det = DaysDetail::select("days_detail.id", "locations.description as location", "courses.description as course", "days_detail.node_id")
                            ->join("locations", "locations.id", "days_detail.location_id")
                            ->join("courses", "courses.id", "days_detail.course_id")
                            ->where("day_id", $value->id)->get();

            if (count($det) > 0) {
                $daysf[$cont]["week"][$cont2]["detail"] = $det;
            }

            if ($value["number_week"] == 7) {
                $cont++;
            }
            $cont2++;
        }

        return $daysf;
    }

    public function store(Request $req) {
        $in = $req->all();

        $mount_id = $in["mount_id"];
        $id = $in["id"];
        unset($in["_token"]);
        unset($in["mount_id"]);
        unset($in["id"]);
       
        $d = explode("-", $in["date"]);
        
        $in["date"] = date("Y-m-d", strtotime($d[2] . "-" . $d[0] . "-" . $d[1]));
        $in["node_id"] = ($in["node_id"] != '') ? $in["node_id"] : null;

 
        if (strpos(".", $in["duration"]) === false) {
            $date = $in["duration"] * 60;
            $in["hour_end"] = date('H:i', strtotime('+' . $date . ' minute', strtotime($in["hour"])));
        } else {
            $in["hour_end"] = date('H:i', strtotime('+' . $in["duration"] . ' hour', strtotime($in["hour"])));
        }

        if ($id == '') {
            DaysDetail::create($in);
        } else {

            $row = DaysDetail::find($id);
            $row->fill($in)->save();
        }

        return redirect("/programation/" . $mount_id);
    }

    public function getMonth($month) {
        $day = 0;
        if ((int) $month == (int) date("m")) {
            $day = (int) date("d");
        }
        $daysf = $this->getCalendar($month);

        return response()->json(["days" => $daysf, "day" => $day]);
    }

    public function getProgramation($id) {
        $row = DaysDetail::find($id);
        
        $row->date = date("m-d-Y", strtotime($row->date));
        
        return response()->json(["data" => $row]);
    }

    public function destroy($id) {
        $row = DaysDetail::find($id);
        $row->delete();
        return response()->json(["status" => true]);
    }

}
