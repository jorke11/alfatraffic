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

//        dd(config("mail"));exit;

        $locations = Locations::all();
        $courses = Courses::all();
        $quantity = Parameters::where("group", "show")->first();
        $end = (int) date("m") + $quantity->value;

        $start = Parameters::where("group", "months")
                ->where("code", ">=", (int) date("m"))
                ->where("code", "<=", $end)
                ->get();

        return view("Purchase.client.init", compact("locations", "courses", "start", "course_id"));
    }

    public function getDay($day) {
        $i = strtotime(date("Y-m-" . $day));
        $resp = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m", $i), date("d", $i), date("Y", $i)), 0);

        return ($resp == 0) ? 7 : $resp;
    }

    public function getList(Request $req) {
        $in = $req->all();

        $month = Parameters::where("group", "show")->first();
        $init = (int) date("m");
        $resp = array();
        $cont = 0;

        $end = ($month->value + $init);

        $events = Events::where("dateevent", ">=", date("Y-m-d"))->get();

//        echo cal_days_in_month(CAL_GREGORIAN, 1, date("y"));exit;


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

    public function getSchedule($schedule_id) {
        return SchedulesDetail::where("schedule_id", $schedule_id)
                        ->select("schedules_detail.id", "parameters.code as day_id", "schedules.location_id", "courses.id as course_id", "courses.value", "schedules_detail.schedule_id", "locations.description as location", "courses.description as course", "parameters.description as day", "schedules_detail.hour", "schedules_detail.hour_end", "locations.address"
                                , "locations.phone")
                        ->join("schedules", "schedules.id", "schedules_detail.schedule_id")
                        ->join("locations", "locations.id", "schedules.location_id")
                        ->join("courses", "courses.id", "schedules_detail.course_id")
                        ->join("parameters", "parameters.code", DB::raw("schedules_detail.day and parameters.group='days'"))
                        ->get()->toArray();
    }

    public function formInput($schedule_id, $year, $month, $day_week) {
//        echo config('mail.host');exit;
        \Session::put("schedule_id", $schedule_id);
        \Session::put("year", $year);
        \Session::put("month", $month);
        \Session::put("day_week", $day_week);

        $sche = $this->getSchedule($schedule_id);
        $sche[0]["date"] = date("Y/m/d", strtotime(date($year . "-" . $month . "-" . $day_week)));
        $sche[0]["dateFormated"] = date("l, d / F", strtotime($sche[0]["date"]));
        foreach ($sche as $key => $value) {
            $sche[$key]["value"] = "$ " . number_format($sche[$key]["value"], 2, ".", ",");

            if ($key > 0) {
                $sche[$key]["date"] = date("Y/m/d", strtotime('+' . $key . " days", strtotime($sche[0]["date"])));
                $sche[$key]["dateFormated"] = date("l, d / F", strtotime($sche[$key]["date"]));
            }
        }

        $addon = Addon::where("schedule_id", $schedule_id)->get();
        $course = Courses::find($sche[0]["course_id"]);
        session(['sche' => $sche, "months" => $month, "addon" => $addon]);
        $states = States::all();
        if ($course->dui == true) {
            return view("Purchase.client.formdui", compact("sche", "month", "addon", "schedule_id", "day_week", "year", "states"));
        } else {
            return view("Purchase.client.form", compact("sche", "month", "addon", "schedule_id", "day_week", "year", "states"));
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

        $in["status_id"] = 2;
        $in["date_course"] = $in["year"] . "/" . $in["month"] . "/" . $in["day_week"];
        unset($in["year"]);
        unset($in["month"]);
        unset($in["day_week"]);


        $sche = $this->getSchedule($in["schedule_id"]);

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
            $input["sche"] = $sche;



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
