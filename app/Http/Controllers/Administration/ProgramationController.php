<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CronController;
use App\Models\Days;
use App\Models\DaysDetail;

class ProgramationController extends Controller {

    public function index($mont = null) {
        $obj = new CronController();
        $months = $obj->createMonts();
        $mont = ($mont == null) ? (int) date("m") : $mont;
        $daysf = $this->getCalendar($mont);
        $courses = \App\Models\Administration\Courses::all();
        $locations = \App\Models\Administration\Locations::all();

        return view("Administration.programation.init", compact("months", "daysf", "courses", "locations", "mont"));
    }

    public function getCalendar($mount) {
        $days = Days::where("month", $mount)->get();
        $daysf = array();
        $cont = 1;
        $cont2 = 0;

        foreach ($days as $value) {
            $daysf[$cont]["week"][$cont2] = $value;

            $det = DaysDetail::select("days_detail.id", "locations.description as location", "courses.description as course")
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
        unset($in["_token"]);
        unset($in["mount_id"]);
        $in["date"] = date("Y-m-d", strtotime($in["date"]));
        DaysDetail::create($in);
        return redirect("/programation/" . $mount_id);
    }

    public function getMonth($month) {
        $daysf = $this->getCalendar($month);
        return response()->json($daysf);
    }

    public function destroy($id) {
        $row = DaysDetail::find($id);
        $row->delete();
    }

}
