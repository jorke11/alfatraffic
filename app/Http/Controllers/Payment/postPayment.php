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

class postPayment extends Controller {

    private $_api_context;

    public function __construct() {
        $paypal_conf = \Config::get("paypal");
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf["client_id"], $paypal_conf["secret"]));
        $this->_api_context->setConfig($paypal_conf["settings"]);
    }

    public function postPayment() {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $items = array();
        $subtotal = 0;
        $cart = \Session::get("cart");

        $currency = "COL";

        foreach ($cart as $product) {
            $item = new Item();
            $item->setName($product->name)
                    ->setCurrency($currency)
                    ->setDescription($product->extract)
                    ->setQuantity($product->quantity)
                    ->setPrice($product->price);

            $items[] = $item;
            $subtotal += $product->quantity * $product->price;
        }

        $item_list = new ItemList();
        $item_list->setItems($items);

        $details = new Details();
        $details->setSubtotal($subtotal)->setShipping(100);

        $total = $subtotal + 100;

        $amount = new Amount();
        $amount->setCurrency($currency)
                ->setTotal($total)
                ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription("Pedido de prueba");

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(\URL::route("payment.status"))
                ->setCancelUrl(\URL::route("payment.status"));

        $payment = new Payment();
        $payment->setIntent("Sale")
                ->setPayee($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions($transaction);


        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PayPalConnectionException $ext) {
            if (\Config::get("app.debug")) {
                echo "exception " . $ex->getMessage() . PHP_EOL;
                $error_data = json_decode($ex->getData(), true);
                exit;
            } else {
                die("Ups,algo salio mal");
            }
        }


        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        \Session::put("paypal_payment_id", $payment->getId());

        if (isset($redirect_url)) {
            return \Redirect::away($redirect_url);
        }

        return \Redirect::route("cart-show")->with("error", "error,desconocido");
    }

    public function getPaymentStatus() {
        // Get the payment ID before session clear
        $payment_id = \Session::get('paypal_payment_id');
        // clear the session payment ID
        \Session::forget('paypal_payment_id');
        $payerId = \Input::get('PayerID');
        $token = \Input::get('token');
        //if (empty(\Input::get('PayerID')) || empty(\Input::get('token'))) {
        if (empty($payerId) || empty($token)) {
            return \Redirect::route('home')
                            ->with('message', 'Hubo un problema al intentar pagar con Paypal');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        // PaymentExecution object includes information necessary 
        // to execute a PayPal account payment. 
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId(\Input::get('PayerID'));
        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);
        //echo '<pre>';print_r($result);echo '</pre>';exit; // DEBUG RESULT, remove it later
        if ($result->getState() == 'approved') { // payment made
            // Registrar el pedido --- ok
            // Registrar el Detalle del pedido  --- ok
            // Eliminar carrito 
            // Enviar correo a user
            // Enviar correo a admin
            // Redireccionar
//            $this->saveOrder(\Session::get('cart'));
            \Session::forget('cart');
            return \Redirect::route('home')
                            ->with('message', 'Compra realizada de forma correcta');
        }
        return \Redirect::route('home')
                        ->with('message', 'La compra fue cancelada');
    }

//    private function saveOrder($cart) {
//        $subtotal = 0;
//        foreach ($cart as $item) {
//            $subtotal += $item->price * $item->quantity;
//        }
//
//        $order = Order::create([
//                    'subtotal' => $subtotal,
//                    'shipping' => 100,
//                    'user_id' => \Auth::user()->id
//        ]);
//
//        foreach ($cart as $item) {
//            $this->saveOrderItem($item, $order->id);
//        }
//    }
//
//    private function saveOrderItem($item, $order_id) {
//        OrderItem::create([
//            'quantity' => $item->quantity,
//            'price' => $item->price,
//            'product_id' => $item->id,
//            'order_id' => $order_id
//        ]);
//    }
}
    