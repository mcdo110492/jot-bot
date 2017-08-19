<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\PaymentHistory;

class Payment extends Model
{
    protected $table = 'tblpayments';
    protected $primaryKey = 'payment_id';

    protected $fillable = [
   		'payment_date',
        'rr_no',
        'amount_paid',
        'status',
        'client'
    ];




    public function getTotalCollection ()

    {
        $date = date('Y-m-d');

        $q    = DB::table('tblpayments as p')
                ->leftJoin('tblpayment_history as ph','p.payment_id','=','ph.payment_id')
                ->where('p.payment_date','=',$date)
                ->where('p.status','=',1)
                ->get();

        $total = 0;

        foreach($q as $r)
        {
            $total += $r->current_price * $r->qty;
        }

        return compact('total');

    }

    public function addPayment($request)

    {
        DB::transaction(function () use ($request) {
            $payment      = [
                'payment_date'              =>  date('Y-m-d'),
                'rr_no'                     =>  $request->rr_no,
                'amount_paid'               =>  $request->amount,
                'status'                    =>  1,
            ];

            $paymentAdd = $this::create($payment);
            
            foreach($request->items as $item)

            {
                $history = [
                    'payment_id'    =>  $paymentAdd->payment_id,
                    'price_cat_id'  =>  $item['price_cat_id'],
                    'current_price' =>  $item['price'],
                    'qty'           =>  $item['qty']

                ];

                PaymentHistory::create($history);

            }

        });

        return ['status' => 200];
    }
}
