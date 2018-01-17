<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Locations;
use App\Models\Administration\Courses;
use App\Models\Administration\Parameters;
use App\Models\Administration\Schedules;
use App\Models\Administration\SchedulesDetail;
use App\Models\Administration\Addon;
use App\Models\Administration\Events;
use App\Models\Administration\States;
use App\Models\Administration\Email;
use App\Models\Administration\EmailDetail;
use App\Models\Client\Purchases;
use DB;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Session;
use Mail;
use Illuminate\Support\Facades\Input;

class ClientsController extends Controller {

    public $months;
    public $days;
    private $_api_context;

    public function __construct() {
        date_default_timezone_set("America/Bogota");
        $paypal_conf = \Config::get("paypal");

        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf["client_id"], $paypal_conf["secret"]));
//        $this->_apiContext = Payment::ApiContext($paypal_conf["client_id"], $paypal_conf["secret"]);
        $this->_api_context->setConfig($paypal_conf["settings"]);
    }

    public function index($course_id = -1) {

        $locations = Locations::all();
        $courses = Courses::all();
        $quantity = Parameters::where("group", "show")->first();
        $end = (int) date("m") + $quantity->value;

        $sql = "
            select month,year,p.description as month_text
            from days 
            LEFT JOIN parameters p ON p.code=days.month and p.group='months'
            group by 1,2,3
            ORDER BY 1 , 2 ASC ";

        $start = DB::select($sql);

        return view("Purchase.client.init", compact("locations", "courses", "start", "course_id"));
    }

    public function getDay($day) {
        $i = strtotime(date("Y-m-" . $day));
        $resp = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m", $i), date("d", $i), date("Y", $i)), 0);

        return ($resp == 0) ? 7 : $resp;
    }

    public function getList(Request $req) {
        $in = $req->all();
        $day = 0;

        $query = \App\Models\Days::select("id", "day", "month", "year");
        $limit = false;

        if (isset($in["start_date"])) {
            $data = $in["start_date"];
        } else {
            $sql = "
            select month as value,year 
            from days 
            group by 1,2
            ORDER BY 1 , 2 ASC ";

            $data = (array) DB::select($sql);

            $json = json_encode($data);
            $data = json_decode($json, true);

        }


        $query->where(function($sql) use($data) {
            foreach ($data as $value) {

                $sql->orWhere("month", $value["value"])->where("year", $value["year"]);
                if ($value["value"] == (int) date("m")) {
                    $limit = true;
                    $sql->where("day", ">=", (int) date("d"));
                }
            }
        });

//        $data = $query->get()->toArray();
        $data = $query->get();

        $dat = [];


        foreach ($data as $i => $value) {
//            dd($value);
            $res = \App\Models\DaysDetail::select("days_detail.id", "courses.description as course", "locations.description as location", "days_detail.date", "days_detail.date as dateFormated", "days_detail.hour", "days_detail.hour_end", "days_detail.day_id", "locations.address", "days_detail.message")
                            ->join("courses", "courses.id", "days_detail.course_id")
                            ->join("locations", "locations.id", "days_detail.location_id")
                            ->where("day_id", $value->id)->whereNull("node_id");


            if (isset($in["location"])) {
                $res->whereIn("locations.id", $in["location"]);
            }
            if (isset($in["courses"])) {
                $res->whereIn("courses.id", $in["courses"]);
            }

            $res = $res->orderBy("day_id")
                            ->orderBy("days_detail.date")->get()->toArray();

//                            ->where("day_id", $value->id)->whereNull("node_id")->orderBy("day_id")->toSql();
//            $res = \App\Models\DaysDetail::where("day_id", $value->id)->whereNull("node_id")->orderBy("day_id")->get()->toArray();
//            dd($res);
            if (count($res) > 0) {

                foreach ($res as $j => $val) {

                    $result = \App\Models\DaysDetail::select("days_detail.id", "courses.description as course", "locations.description as location", "days_detail.date", "days_detail.hour", "days_detail.hour_end", "days_detail.day_id", "days_detail.date as dateFormated", "locations.address", "locations.phone", "days_detail.message")
                                    ->join("courses", "courses.id", "days_detail.course_id")
                                    ->join("locations", "locations.id", "days_detail.location_id")
                                    ->where("node_id", $val["id"])->whereNotNull("node_id")->Orwhere("days_detail.id", $val["id"])->orderBy("days_detail.date")->get()->toArray();
//                                    ->where("node_id", $val["id"])->whereNotNull("node_id")->orderBy("days_detail.date")->toSql();
//                                    ->where("node_id", $val["day_id"])->whereNotNull("node_id")->toSql();
//                    echo ($result);exit;
                    if (count($result) > 0) {

                        foreach ($result as $k => $val2) {
                            $result[$k]["date"] = date("Y/m/d", strtotime($result[$k]["date"]));
                            $result[$k]["dateFormated"] = date("l, F d", strtotime($result[$k]["date"]));
//                                    $data[$k]["hour"] = date("h:i A", strtotime($data[$k]["hour"]));
                            $result[$k]["hour"] = date("h:i A", strtotime($result[$k]["hour"]));
                            $result[$k]["hour_end"] = date("h:i A", strtotime($result[$k]["hour_end"]));
                        }



//                        $result[] = $val;
                        $res[$j]["node"] = $result;
                    } else {
                        $res[$j]["node"][] = $val;
                    }
//                    dd($res[$j]);
                }
                $dat[] = $res;
            }
//            dd($res);
        }

//        echo "<pre>";print_r($dat);exit;

        return response()->json(["success" => true, "data" => $dat]);
    }

    public function getListOld(Request $req) {
        $in = $req->all();

        $month = Parameters::where("group", "show")->first();
        $init = (int) date("m");
        $resp = array();
        $cont = 0;

        $end = ($month->value + $init);

        $events = Events::where("dateevent", ">=", date("Y-m-d"))->get();


        for ($i = $init; $i <= $end; $i++) {

            $initSecond = ($cont == 0) ? (int) date("d") : 1;

            if (in_array($i, $in["start_date"])) {

                for ($j = $initSecond; $j <= cal_days_in_month(CAL_GREGORIAN, $i, date("y")); $j++) {
//                for ($j = $initSecond; $j <= date('t', mktime(0, 0, 0, $i + 1, 0, date("y"))); $j++) {
//            for ($j = 26; $j <= 29; $j++) {
                    $day = $this->getDay($j);

                    $sche = SchedulesDetail::where("day", $day)
                            ->select("schedule_id")
                            ->join("schedules", "schedules.id", "schedules_detail.schedule_id")
                            ->orderBy("schedule_id", "asc")
                            ->distinct("schedule_id");



                    if (isset($in["location"]) && $in["location"] != 0) {
                        $sche->whereIn("schedules.location_id", $in["location"]);
                    }
                    if (isset($in["courses"]) && $in["courses"] != 0) {
                        $sche->whereIn("schedules_detail.course_id", $in["courses"]);
                    }


                    $sche = $sche->get()->toArray();
//                    dd($sche);
//                    echo $day;
//                    $sche = $sche->toSql();

                    if (count($sche) > 0) {

                        foreach ($sche as $value) {

                            $initial = SchedulesDetail::where("schedule_id", $value["schedule_id"])
                                    ->select("day")
                                    ->orderBy("day", "asc")
                                    ->first();


                            if ($initial["day"] == $day) {

                                $data = $this->getSchedule($value["schedule_id"]);

                                $dayCont = $j;
                                foreach ($data as $k => $val) {
                                    $data[$k]["date"] = date("Y/m/d", strtotime(date("Y-" . $i . "-" . $j)));
                                    $data[$k]["dateFormated"] = date("l, F d", strtotime($data[$k]["date"]));
//                                    $data[$k]["hour"] = date("h:i A", strtotime($data[$k]["hour"]));
                                    $data[$k]["hour"] = date("h:i A", strtotime($data[$k]["hour"]));
                                    $data[$k]["hour_end"] = date("h:i A", strtotime($data[$k]["hour_end"]));
                                }

                                foreach ($events as $a => $value) {
                                    if ((strtotime($value["date"]) == strtotime($value->dateevent)) && $value->course_id == $value["course_id"] && $value->location_id == $data[0]["location_id"]) {

                                        if ($value->action_id == 1) {
                                            $data[$a]["message"] = $value->description;
                                        } else {
                                            unset($data[$a]);
                                        }
                                    }
                                }



                                foreach ($data as $key => $value) {
                                    if ($key > 0) {
                                        $cont = 0;
                                        foreach ($events as $val) {

                                            if ((strtotime($value["date"]) == strtotime($val->dateevent)) && $val->course_id == $value["course_id"] && $val->location_id == $value["location_id"]) {
                                                if ($val->action_id == 1) {
                                                    $data[$key]["message"] = $val->description;
                                                    $cont++;
                                                } else {
                                                    unset($data[$key]);
                                                }
                                            }
                                        }
                                        if ($cont > 0) {
                                            $data[$key]["hour"] = date("h:i A", strtotime($value["hour"]));
                                            $data[$key]["hour_end"] = date("h:i A", strtotime($value["hour_end"]));
                                            $data[$key]["date"] = date("Y/m/d", strtotime('+' . $key . " days", strtotime($value["date"])));
                                            $data[$key]["dateFormated"] = date("l, F d", strtotime($data[$key]["date"]));
                                        }
                                    }
                                }

                                $resp[] = $data;
                            }
                        }
                    }
                }
            }
            $cont++;
        }
//        dd($resp);
        return response()->json(["success" => true, "data" => $resp]);
    }

    public function getSchedule($programation_id) {

        $res = \App\Models\DaysDetail::select("days_detail.id", "courses.description as course", "courses.value", "locations.description as location", "days_detail.date", "days_detail.date as dateFormated", "days_detail.hour", "days_detail.hour_end", "days_detail.day_id", "locations.address", "courses.value", "days_detail.course_id", "days_detail.message", "locations.phone")
                        ->join("courses", "courses.id", "days_detail.course_id")
                        ->join("locations", "locations.id", "days_detail.location_id")
                        ->where("days_detail.id", $programation_id)->whereNull("node_id")->orderBy("days_detail.date")->get()->toArray();
//                            ->where("day_id", $value->id)->whereNull("node_id")->orderBy("day_id")->toSql();
//            $res = \App\Models\DaysDetail::where("day_id", $value->id)->whereNull("node_id")->orderBy("day_id")->get()->toArray();



        if (count($res) > 0) {

            foreach ($res as $j => $val) {
                $result = \App\Models\DaysDetail::select("days_detail.id", "courses.description as course", "locations.description as location", "days_detail.date", "days_detail.hour", "days_detail.hour_end", "days_detail.day_id", "days_detail.date as dateFormated", "locations.address", "locations.phone", "days_detail.message", "days_detail.course_id", "locations.phone")
                                ->join("courses", "courses.id", "days_detail.course_id")
                                ->join("locations", "locations.id", "days_detail.location_id")
                                ->where("node_id", $val["id"])->whereNotNull("node_id")->Orwhere("days_detail.id", $val["id"])->orderBy("days_detail.date")->get()->toArray();
//                                    ->where("node_id", $val["day_id"])->whereNotNull("node_id")->toSql();
//                    dd($val);
                if (count($result) > 0) {
                    $res[$j]["node"] = $result;
                } else {
                    $res[$j]["node"] = $val;
                }
                $dat[] = $res;
            }
        }
        return $res;
    }

    public function formInput($programation_id) {

//        dd($programation_id);
//        \Session::put("programation_id", $programation_id);

        $sche = $this->getSchedule($programation_id);

//        $sche[0]["dateFormated"] = date("l, d / F", strtotime($sche[0]["date"]));

        foreach ($sche as $key => $value) {
            $sche[$key]["value"] = "$ " . number_format($sche[$key]["value"], 2, ".", ",");

            if ($key >= 0) {
                $sche[$key]["date"] = date("Y/m/d", strtotime('+' . $key . " days", strtotime($sche[0]["date"])));
                $sche[$key]["dateFormated"] = date("l, F d", strtotime($sche[$key]["date"]));
                $sche[$key]["hour"] = date("h:i A", strtotime($sche[0]["hour"]));
                $sche[$key]["hour_end"] = date("h:i A", strtotime($sche[0]["hour_end"]));
            }
        }
        $schedule = $sche[0]["node"];
        foreach ($schedule as $i => $value) {
            $schedule[$i]["date"] = date("Y/m/d", strtotime('+' . $key . " days", strtotime($schedule[$i]["date"])));
            $schedule[$i]["dateFormated"] = date("l, F d", strtotime($schedule[$i]["date"]));
            $schedule[$i]["hour"] = date("h:i A", strtotime($schedule[$i]["hour"]));
            $schedule[$i]["hour_end"] = date("h:i A", strtotime($schedule[$i]["hour_end"]));
        }
//        dd($schedule);
//        $addon = Addon::where("schedule_id", $schedule_id)->get();
        $addon = array();
//        dd($sche);
        $course = Courses::find($sche[0]["course_id"]);
//        session(['sche' => $sche, "months" => $month, "addon" => $addon]);
        $states = States::all();
        
        if ($course->id == 5) {
            return view("Purchase.client.formdui", compact("programation_id", "sche", "schedule", "addon", "states"));
        } else {
//            dd($sche);
            return view("Purchase.client.form", compact("programation_id", "sche", "schedule", "addon", "states"));
        }
    }

    public function formDui(Request $req) {
        $in = $req->all();
        session(["formclient" => $in]);

        $sche = session("sche");
        $month = session("months");
        $addon = Session("addon");
        return view("Purchase.client.formduinext", compact("sche", "month", "addon"));
    }

    public function payment(Request $req) {
        $in = $req->all();

        $programation = \App\Models\DaysDetail::find($in["programation_id"]);

        $in["status_id"] = 2;
        $in["date_course"] = $programation["date"];

        $sche = $this->getSchedule($in["programation_id"]);

        $price = $sche[0]["value"];
        $course = $sche[0]["course"];

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item = new Item();

        $item->setName('Price Course')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($price);

        $item_list = new ItemList();
        $item_list->setItems([$item]);


        $amount = new Amount();
        $amount->setCurrency('USD')
                ->setTotal($price);


        $transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription($course);


        $redirect_urls = new RedirectUrls();

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(\URL::route("payment.status"))
                ->setCancelUrl(\URL::route("payment.status"));

        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            Session::flash('alert', 'Something Went wrong, funds could not be loaded');
            Session::flash('alertClass', 'danger no-auto-close');
            $err_data = json_decode($ex->getData(), true);
            dd($err_data);
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }



        $id = Purchases::create($in)->id;

        Session::put('paypal_payment_id', $payment->getId());
        Session::put('row_id', $id);
        Session::put('programation_id', $in["programation_id"]);
        if (isset($redirect_url)) {
            /** redirect to paypal * */
            return \Redirect::away($redirect_url);
        } else {
            dd("problemas");
        }
    }

    public function getPaymentStatus() {
        /** Get the payment ID before session clear * */
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID * */
        Session::forget('paypal_payment_id');

        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error', 'Payment failed');
            echo "error";
            Exit;
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary * */
        /** to execute a PayPal account payment. * */
        /** The payer_id is added to the request query parameters * */
        /** when the user is redirected from paypal back to your site * */
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /*         * Execute the payment * */
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {

            $this->sendEmailPurchase();
            /** it's all right * */
            /** Here Write your database logic like that insert record or value in database if you want * */
//            \Session::put('success', 'Payment success');

            return \Redirect::route('paypal.clients')->with("success", 'Payment success');
        }
        \Session::put('error', 'Payment failed');
//        return Redirect::route('addmoney.paywithpaypal');
    }

    public function sendEmailPurchase() {

        $row_id = Session::get('row_id');
        Session::forget('row_id');


        $row = Purchases::find($row_id);

        $sche = $this->getSchedule(Session::get('programation_id'));
//        dd($sche);
        $email = Email::where("description", "invoices")->first();

        if ($email != null) {
            $emDetail = EmailDetail::where("email_id", $email->id)->get();
        }

        if (count($emDetail) > 0) {
            $this->mails = array();

            $this->mails[] = $row->email;
            foreach ($emDetail as $value) {
                $this->mails[] = $value->description;
            }

            $state = States::find($row->state_id);

            $this->subject = "DUI School confirmation with AlfaDrivingSchool.com";
            $input["state"] = $state->description;

            $input["name"] = ucwords($row->name);
            $input["last_name"] = ucwords($row->last_name);


//            dd($sche);
            foreach ($sche as $key => $value) {
                $sche[$key]["value"] = "$ " . number_format($sche[$key]["value"], 2, ".", ",");

                if ($key > 0) {
                    $sche[$key]["date"] = date("Y/m/d", strtotime('+' . $key . " days", strtotime($sche[0]["date"])));
                    $sche[$key]["dateFormated"] = date("l, d / F", strtotime($sche[$key]["date"]));
                }
            }
            $input["sche"] = $sche;



//            dd($input);
            Mail::send("Notifications.purchase", $input, function($msj) {
                $msj->subject($this->subject);
                $msj->to($this->mails);
            });

            $row->status_id = 1;
            $row->save();
        }
    }

    public function paymentDui(Request $req) {
        $in = $req->all();
        dd($in);
    }

    public function testSendNotification($row_id) {

        $row = Purchases::find($row_id);
        $sche = $this->getSchedule($row->schedule_id);
        $email = Email::where("description", "invoices")->first();

        if ($email != null) {
            $emDetail = EmailDetail::where("email_id", $email->id)->get();
        }

        if (count($emDetail) > 0) {
            $this->mails = array();
            $this->mails[] = $row->email;
            foreach ($emDetail as $value) {
                $this->mails[] = $value->description;
            }

            $state = States::find($row->state_id);

            $this->subject = "DUI School confirmation with AlfaDrivingSchool.com";
            $input["state"] = $state->description;

            $input["name"] = ucwords($row->name);
            $input["last_name"] = ucwords($row->last_name);

            $sche[0]["date"] = date("Y/m/d", strtotime($row->date_course));
            $sche[0]["dateFormated"] = date("l, d / F", strtotime($sche[0]["date"]));
            foreach ($sche as $key => $value) {
                $sche[$key]["value"] = "$ " . number_format($sche[$key]["value"], 2, ".", ",");

                if ($key > 0) {
                    $sche[$key]["date"] = date("Y/m/d", strtotime('+' . $key . " days", strtotime($sche[0]["date"])));
                    $sche[$key]["dateFormated"] = date("l, d / F", strtotime($sche[$key]["date"]));
                }
            }

            Mail::send("Notifications.purchase", $input, function($msj) {
                $msj->subject($this->subject);
                $msj->to($this->mails);
            });
        }
    }

    public function testNotification($row_id) {
        $row = Purchases::find($row_id);
        $sche = $this->getSchedule($row->schedule_id);

        $sche[0]["date"] = date("Y/m/d", strtotime($row->date_course));
        $sche[0]["dateFormated"] = date("l, d / F", strtotime($sche[0]["date"]));
        foreach ($sche as $key => $value) {
            $sche[$key]["value"] = "$ " . number_format($sche[$key]["value"], 2, ".", ",");

            if ($key > 0) {
                $sche[$key]["date"] = date("Y/m/d", strtotime('+' . $key . " days", strtotime($sche[0]["date"])));
                $sche[$key]["dateFormated"] = date("l, d / F", strtotime($sche[$key]["date"]));
            }
        }

        $name = "jorge";
        $last_name = "jorge";
        $address = $sche[0]["address"];
        $location = $sche[0]["location"];
        $phone = $sche[0]["phone"];

        return view("Notifications.purchase", compact("name", "last_name", "address", "location", "phone", "sche"));
    }

}
