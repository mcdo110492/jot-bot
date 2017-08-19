<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\PriceCategory;

class PaymentHistory extends Model
{
    protected $table = 'tblpayment_history';
    protected $primaryKey = 'payment_history_id';

    protected $fillable = [
   		'payment_id',
        'price_cat_id',
        'current_price',
        'qty'
    ];


    public function category ()

    {

        return $this->belongsTo('App\PriceCategory','price_cat_id');

    }


    public function countHistory ($date)

    {
        $num    = DB::table('tblpayments')
                  ->where('payment_date','=',$date)
                  ->count();
        return $num;
    }




    public function getHistory ($limit,$limitPage,$offset,$field,$filter,$order,$rr_no)

    {
        $query 		= DB::table('tblpayments')
  					  ->where($field, '=' , $filter)
                      ->where('rr_no','LIKE','%'.$rr_no.'%')
  					  ->orderBy('rr_no', $order)
  					  ->take($limit)
  					  ->skip($offset)
  					  ->get();
        $total = 0;
        $data = [];
        foreach($query as $q)

        {
            $total = DB::table('tblpayment_history') 
                     ->select(DB::raw('sum(current_price*qty) AS total_sales'))
                     ->where('payment_id','=',$q->payment_id)
                     ->first();
            $data [] = ['payment_id'    => $q->payment_id,
                        'amount_paid'   => $q->amount_paid,
                        'status'        => $q->status,
                        'total'         => $total,
                        'rr_no'         => $q->rr_no];

        }

        return $data;


    }
}
