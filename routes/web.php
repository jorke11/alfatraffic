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
Route::resource('/addon', 'Administration\AddonController');

Route::resource('events', 'Administration\EventsController');
Route::get('/programation', 'Administration\ProgramationController@index');
Route::post('/programation', 'Administration\ProgramationController@store');
Route::get('/programation/{mounth}', 'Administration\ProgramationController@index');
Route::get('/programation/{month}/getMonth', 'Administration\ProgramationController@getMonth');

Route::get('/purchases', 'Report\PurchasesController@index');


Route::resource('/email', 'Administration\EmailController');
Route::post('/email/detail', 'Administration\EmailController@storeDetail');
Route::put('/email/detail/{id}', 'Administration\EmailController@updateDetail');
Route::get('/email/detail/{id}/edit', 'Administration\EmailController@editDetail');
Route::delete('/email/detail/{id}', 'Administration\EmailController@destroyDetail');

Route::get('/api/listEmail', function() {
    return Datatables::eloquent(App\Models\Administration\Email::query())->make(true);
});


Route::resource('/schedules', 'Administration\SchedulesController');
Route::get('/schedules/getTable/{day}/{course_id}/{location_id}', 'Administration\SchedulesController@getTable');

Route::post('/schedules/detail', 'Administration\SchedulesController@storeDetail');
Route::get('/schedules/{id}/editDetail', 'Administration\SchedulesController@getDetail');
Route::delete('/schedules/detail/{id}', 'Administration\SchedulesController@destroyItem');
Route::get('/schedules/{id}/getModal', 'Administration\SchedulesController@getModalData');


//Route::get('/clients', 'Purchase\ClientsController@index');
Route::get('clients/page/{id}', 'Purchase\ClientsController@index');
Route::get('clients', ["as" => "paypal.clients", "uses" => 'Purchase\ClientsController@index']);
Route::get('/clients/getList', 'Purchase\ClientsController@getList');
Route::get('/clients/{schedule_id}/{year}/{month}/{day_week}', 'Purchase\ClientsController@formInput');
Route::post('/ClientDui', 'Purchase\ClientsController@formDui');
Route::get('clients/testNotification/{id}', 'Purchase\ClientsController@testNotification');
Route::get('clients/testSendNotification/{id}', 'Purchase\ClientsController@testSendNotification');


Route::post('payment', 'Purchase\ClientsController@payment');
Route::get('payment', ["as" => "payment.status", "uses" => 'Purchase\ClientsController@getPaymentStatus']);
Route::post('/paymentDui', 'Purchase\ClientsController@paymentDui');
Route::get('paypal', 'Payment\PaypalController@index');
Route::post('paypal/payment', ["as" => "paypal.payment", "uses" => 'Payment\PaypalController@payment']);
Route::get('paypal/payment', ["as" => "paypal.status", "uses" => 'Payment\PaypalController@getPaymentStatus']);


Route::get('/drivered', 'PageController@driverEd');
Route::get('/scholarship', 'PageController@scholarship');
Route::get('/duirisk', 'PageController@duirisk');
Route::get('/victimimpact', 'PageController@victimImpact');
Route::get('/duiclinical', 'PageController@duiClinical');
Route::get('/victimimpact', 'PageController@victimimpact');
Route::get('/defensive', 'PageController@defensive');
Route::get('/adultdrivers', 'PageController@adultdrivers');
Route::get('/teendriving', 'PageController@teendriving');
Route::get('/roadtest', 'PageController@roadtest');
Route::get('/pageschedule', 'PageController@pageschedule');
Route::get('/sandysprings', 'PageController@sandysprings');
Route::get('/buckheadatlanta', 'PageController@buckheadatlanta');
Route::get('/midtownatlanta', 'PageController@midtownatlanta');
Route::get('/smyrnaaustell', 'PageController@smyrnaaustell');
Route::get('/mariettaeastcobb', 'PageController@mariettaeastcobb');
Route::get('/doravillechamblee', 'PageController@doravillechamblee');
Route::get('/duluthlawrenceville', 'PageController@duluthlawrenceville');
Route::get('/clock', 'Administration\ClockController@index');

Route::resource('/role', 'Security\RoleController');
Route::put('/role/savePermission/{id}', 'Security\RoleController@savePermissionRole');


Route::get('/api/listLocations', function() {
    return Datatables::queryBuilder(DB::table("locations"))->make(true);
});
Route::get('/api/listEvents', function() {
    return Datatables::queryBuilder(DB::table("events"))->make(true);
});

Route::get('/api/listCourses', function() {
    return Datatables::queryBuilder(DB::table("courses"))->make(true);
});

Route::get('/api/listSchedules', function(Request $request) {
    $query = DB::table("schedules");
    return Datatables::queryBuilder($query)->make(true);
});

Route::get('/api/listParameter', function() {
    return Datatables::queryBuilder(
                    DB::table('parameters')->orderBy("id", "asc")
            )->make(true);
});

Route::get('/api/listPurchases', function() {
    return Datatables::queryBuilder(
                    DB::table('vpurchases')->orderBy("id", "desc")
            )->make(true);
});

Route::get('/api/listRole', function() {
    return Datatables::eloquent(App\Models\Security\Roles::query())->make(true);
});

Route::get('/api/listAddon', function() {
    $sql = DB::table('addon')
            ->select("addon.id", "addon.description", "schedules.description as schedule")
            ->join("schedules", "schedules.id", "addon.schedule_id")
            ->orderBy("id", "asc");

    return Datatables::queryBuilder($sql)->make(true);
});

require __DIR__ . "/cron.php";
