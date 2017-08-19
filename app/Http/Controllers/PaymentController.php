<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;
use App\Payment;

class PaymentController extends Controller
{
    
    
    public function index(Payment $payment)

    {
        $results = $payment->getTotalCollection();

        return response()->json($results);

    }

    public function checkrrNo (Request $request)

    {
        $rrno  = $request['uniqueValue'];

        $count = Payment::where('rr_no','=',$rrno)->count();

        if($count == 0) 

        {
            $response = ['status'=>200];
        }
        else

        {
            $response = ['status'=>403];
        }

        return response()->json($response);

    }


    public function store (PaymentRequest $request,Payment $payment)

    {

        $store = $payment->addPayment($request);

        return response()->json($store);

    }


    public function update (Payment $payment, Request $request) 

    {
        $payment->update($request->all());

        return response()->json(['status' => 200]);

    }

    public function show() 

    {


    }
}
