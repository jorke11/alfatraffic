<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Locations;
use App\Models\Administration\Courses;
use App\Models\Administration\Parameters;

class LocationsController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $day = Parameters::where("group", "days")->get();
        $courses = Courses::all();
        return view("Administration.locations.init", compact("day", "courses"));
    }

    public function create() {
        return "create";
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            $input["phone"] = $this->formatPhoneNumber($input["phone"]);

            unset($input["id"]);
//            $user = Auth::User();
            $input["status_id"] = 1;

            $input["init"] = array_filter($input["init"]);
            $input["end"] = array_filter($input["end"]);
            $day = null;
            if (count($input["init"]) > 0) {

                foreach ($input["init"] as $i => $value) {
                    $day[] = array("day" => $i + 1, "init" => $value, "end" => $input["end"][$i]);
                }
            }

            if ($day != null) {
                $input["days"] = (string) json_encode($day);
            }
            if (isset($input["courses"])) {
                $input["courses"] = (string) json_encode($input["courses"]);
            }


            $result = Locations::create($input);
            if ($result) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function formatPhoneNumber($phoneNumber) {
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        if (strlen($phoneNumber) > 10) {
            $countryCode = substr($phoneNumber, 0, strlen($phoneNumber) - 10);
            $areaCode = substr($phoneNumber, -10, 3);
            $nextThree = substr($phoneNumber, -7, 3);
            $lastFour = substr($phoneNumber, -4, 4);

            $phoneNumber = '+' . $countryCode . ' ' . $areaCode . '-' . $nextThree . '-' . $lastFour;
        } else if (strlen($phoneNumber) == 10) {
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3, 3);
            $lastFour = substr($phoneNumber, 6, 4);

            $phoneNumber =  $areaCode . '-' . $nextThree . '-' . $lastFour;
        } else if (strlen($phoneNumber) == 7) {
            $nextThree = substr($phoneNumber, 0, 3);
            $lastFour = substr($phoneNumber, 3, 4);

            $phoneNumber = $nextThree . '-' . $lastFour;
        }

        return $phoneNumber;
    }

    public function edit($id) {
        $row = Locations::Find($id);
        $row->days = json_decode($row->days);
        $row->courses = json_decode($row->courses);
        return response()->json($row);
    }

    public function update(Request $request, $id) {
        $row = Locations::FindOrFail($id);
        $input = $request->all();

        $input["init"] = array_filter($input["init"]);
        $input["end"] = array_filter($input["end"]);
        $day = null;
        if (count($input["init"]) > 0) {

            foreach ($input["init"] as $i => $value) {
                $day[] = array("day" => $i + 1, "init" => $value, "end" => $input["end"][$i]);
            }
        }


        $input["phone"] = $this->formatPhoneNumber($input["phone"]);

        if ($day != null) {
            $input["days"] = json_encode($day);
        }
        if (isset($input["courses"])) {
            $input["courses"] = json_encode($input["courses"]);
        }
        $input["status_id"] = 1;

        $result = $row->fill($input)->save();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $category = Locations::FindOrFail($id);
        $result = $category->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
