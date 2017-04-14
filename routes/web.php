<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::resource('/locations', 'Administration\LocationsController');
Route::resource('/courses', 'Administration\CoursesController');
Route::resource('/parameters', 'Administration\ParametersController');

Route::resource('/schedules', 'Administration\SchedulesController');
Route::get('/schedules/getTable/{day}/{course_id}/{location_id}', 'Administration\SchedulesController@getTable');

Route::get('/clients', 'Purchase\ClientsController@index');
Route::get('/clients/getList', 'Purchase\ClientsController@getList');


Route::get('/api/listLocations', function() {
    return Datatables::queryBuilder(DB::table("locations"))->make(true);
});

Route::get('/api/listCourses', function() {
    return Datatables::queryBuilder(DB::table("courses"))->make(true);
});

Route::get('/api/listSchedules', function(Request $request) {
    $query = DB::table("schedules");
    if ($_GET["course_id"] != 0) {
        $query->where("course_id", $_GET["course_id"]);
    }
    if ($_GET["day"] != 0) {
        $query->where("course_id", $_GET["day"]);
    }

    return Datatables::queryBuilder($query)->make(true);
});
Route::get('/api/listParameter', function() {
    return Datatables::queryBuilder(
                    DB::table('parameters')->orderBy("id", "asc")
            )->make(true);
});
