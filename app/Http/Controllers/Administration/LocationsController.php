<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Locations;

class LocationsController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        return view("Administration.locations.init");
    }

    public function create() {
        return "create";
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $result = Locations::create($input);
            if ($result) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function edit($id) {
        $suppliers = Locations::FindOrFail($id);
        return response()->json($suppliers);
    }

    public function update(Request $request, $id) {
        $category = Locations::FindOrFail($id);
        $input = $request->all();
        $result = $category->fill($input)->save();
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
