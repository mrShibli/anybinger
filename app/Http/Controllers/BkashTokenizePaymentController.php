<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Karim007\LaravelBkashTokenize\Facade\BkashPaymentTokenize;
use Karim007\LaravelBkashTokenize\Facade\BkashRefundTokenize;

class BkashTokenizePaymentController extends Controller
{

    public function createPayment(Request $request, $order_id, $payment_id)
    {
        $order = Order::find($order_id);
        $payment = Payment::find($payment_id);

        if(!$order){
            return redirect()->back();
        }
        if(!$payment){
            return redirect()->back();
        }

        $inv = $order->invoice_id;
        $request['intent'] = 'sale';
        $request['mode'] = '0011';
        $request['payerReference'] = $inv;
        $request['currency'] = 'BDT';
        $request['amount'] = $payment->pay_amount;
        $request['merchantInvoiceNumber'] = $inv;
        $request['callbackURL'] = config("bkash.callbackURL");;

        $request_data_json = json_encode($request->all());

        $response =  BkashPaymentTokenize::cPayment($request_data_json);

        if (isset($response['bkashURL'])) return redirect()->away($response['bkashURL']);
        else return redirect()->back()->with('error-alert2', $response['statusMessage']);
    }

    public function callBack(Request $request)
    {
        //callback request params
        // paymentID=your_payment_id&status=success&apiVersion=1.2.0-beta
        //using paymentID find the account number for sending params
        
        if ($request->status == 'success'){
            $response = BkashPaymentTokenize::executePayment($request->paymentID);



            if (!$response){ //if executePayment payment not found call queryPayment

                $response = BkashPaymentTokenize::queryPayment($request->paymentID);
            }

            if (isset($response['statusCode']) && $response['statusCode'] == "0000" && $response['transactionStatus'] == "Completed") {
                /*
                 * for refund need to store
                 * paymentID and trxID
                 * */
                $order = Order::where('invoice_id', $response['payerReference'])->first();
                $payment = Payment::where(['user_id' => Auth::user()->id, 'order_id' => $order->id ])->latest()->first();

                if($order->status == 'pending_payment'){
                    $order->status = 'approved';
                }
                $order->paid = $order->paid + $payment->pay_amount;
                $order->save();

                $payment->payment_number = $response['customerMsisdn'];
                $payment->trxID = $response['trxID'];
                $payment->paymentID = $response['paymentID'];
                $payment->status = 'paid';
                $payment->save();

                return redirect()->route('account.orders', $order->id);
            }
            return BkashPaymentTokenize::failure($response['statusMessage']);
        }else if ($request->status == 'cancel'){
            return BkashPaymentTokenize::cancel('Your payment is canceled');
        }else{
            return BkashPaymentTokenize::failure('Your transaction is failed');
        }
    }

    public function searchTnx($trxID)
    {
        //response
        return BkashPaymentTokenize::searchTransaction($trxID);
        //return BkashPaymentTokenize::searchTransaction($trxID,1); //last parameter is your account number for multi account its like, 1,2,3,4,cont..
    }

    public function refund(Request $request)
    {
        $paymentID='Your payment id';
        $trxID='your transaction no';
        $amount=5;
        $reason='this is test reason';
        $sku='abc';
        //response
        return BkashRefundTokenize::refund($paymentID,$trxID,$amount,$reason,$sku);
        //return BkashRefundTokenize::refund($paymentID,$trxID,$amount,$reason,$sku, 1); //last parameter is your account number for multi account its like, 1,2,3,4,cont..
    }
    public function refundStatus(Request $request)
    {
        $paymentID='Your payment id';
        $trxID='your transaction no';
        return BkashRefundTokenize::refundStatus($paymentID,$trxID);
        //return BkashRefundTokenize::refundStatus($paymentID,$trxID, 1); //last parameter is your account number for multi account its like, 1,2,3,4,cont..
    }
}
