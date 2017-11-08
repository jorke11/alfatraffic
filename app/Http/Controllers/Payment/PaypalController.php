<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
use Illuminate\Support\Facades\Input;

class PaypalController extends Controller {

    private $_api_context;

    public function __construct() {

        $paypal_conf = \Config::get("paypal");
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf["client_id"], $paypal_conf["secret"]));
//        $this->_apiContext = Payment::ApiContext($paypal_conf["client_id"], $paypal_conf["secret"]);
        $this->_api_context->setConfig($paypal_conf["settings"]);
    }

    public function index() {
        return view("paypalform");
    }

    public function payment(Request $req) {
        $input = array_except($req->all(), array("_token"));

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");


        $item = new Item();

        $item->setName('Price Course')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($input["amount"]);

        $item_list = new ItemList();
        $item_list->setItems([$item]);


        $amount = new Amount();
        $amount->setCurrency('USD')
                ->setTotal(12);


        $transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Purchase Course');


        $redirect_urls = new RedirectUrls();

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(\URL::route("paypal.status"))
                ->setCancelUrl(\URL::route("paypal.status"));

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

        Session::put('paypal_payment_id', $payment->getId());
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

            /** it's all right * */
            /** Here Write your database logic like that insert record or value in database if you want * */
            \Session::put('success', 'Payment success');
            return Redirect::route('addmoney.paywithpaypal');
        }
        \Session::put('error', 'Payment failed');
//        return Redirect::route('addmoney.paywithpaypal');
    }

}
