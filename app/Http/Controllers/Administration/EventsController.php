<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Parameters;
use App\Models\Administration\Courses;
use App\Models\Administration\Locations;
use App\Models\Administration\Events;

class EventsController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $locations = Locations::all();
        $actions = Parameters::where("group", "actions")->get();
        return view("Administration.events.init", compact("locations", "actions"));
    }

    public function create() {
        return "create";
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
            $input["status_id"] = 1;

            if (isset($input["days"])) {
                $input["days"] = json_encode($input["days"]);
            }
            if (isset($input["courses"])) {
                $input["courses"] = json_encode($input["courses"]);
            }

            $result = Events::create($input);
            if ($result) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function edit($id) {
        $row = Events::Find($id);
        return response()->json($row);
    }

    public function update(Request $request, $id) {
        $row = Events::FindOrFail($id);
        $input = $request->all();

        $input["status_id"] = 1;

        $result = $row->fill($input)->save();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $row = Events::FindOrFail($id);
        $result = $row->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
