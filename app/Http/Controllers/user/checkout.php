<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\PaymentExecution;
use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use App\order;
use App\Item as Item2;


class checkout extends Controller
{
    private $apiContext;
    private $client_id = 'AYtfDDZU1feDkB83cnJ3WJiV-32uKTHJQqD6YGUH4JsFK7EZrYBkEjVlb-2VV2ZkybfyZkBsRUgxWeow';
    private $secret='EJesieE4q4Cv4fEJW_1fh_5c99VVoy3UmeQXceMahcGHVqYIHbxPoOk17qn2ZwN5Cq7OJK5dG8dyibB_';
    public function __construct()
    {
        $this->apiContext= new ApiContext(new OAuthTokenCredential($this->client_id,$this->secret));
        $this->apiContext->setConfig(config('paypal.settings'));
    }
    public function checkout(Request $req)
    {
        $dollar=1000;
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        $itemList = new ItemList();
        $total=0;
        foreach ($req['cart'] as $item) {
            $item1=new Item();
            $item1->setName($item['item']['name'])
            ->setCurrency('USD')
            ->setQuantity($item['quantity'])
            ->setPrice($item['item']['price'] / $dollar);
            $itemList->addItem($item1);
            $total+=$item['item']['price'] * $item['quantity'] / $dollar;
        }
        //return $itemList;
        $details = new Details();
        $details->setTax(5)
        ->setSubtotal($total);
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal(($total+5))->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("http://127.0.0.1:8000/status")
            ->setCancelUrl("http://127.0.0.1:8000/canceled");
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->apiContext);
        } catch (Exception $ex) {
            return $ex;
        }
        $approvalUrl = $payment->getApprovalLink();
        return $payment;
    }
    public function status(Request $request)
    {
        $paymentId = $request['paymentID'];
        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request['payerID']);
        $result = $payment->execute($execution, $this->apiContext);
        $shipping=5000;
        $order=order::create([
            'location' => $request['user']['location'],
            'name' => $request['user']['name'],
            'phone' => $request['user']['phone'],
            'total_price' => 0,
            'user_id' => auth()->user() ? auth()->user()->id : 0,
            'shipping' => $shipping
        ]);
        $total_price=0;
        foreach ($request['cart'] as $record) {
            $item=Item2::find($record['item']['id']);
            $item->quantity-=$record['quantity'];
            $item->save();
            $order->items()->attach([
                $item->id =>
                    ['quantity' => $record['quantity']]
                ]);
            $total_price+=($item->price*$record['quantity']);
        }
        $order->total_price=$total_price;
        $order->save();
    }

    public function storeOrder(REQuest $req)
    {
    }


}
