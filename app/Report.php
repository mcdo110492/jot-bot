<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Report extends Model
{
    public function getReport($from,$to)

    {
        $from   = Carbon::parse($from)->toDateString();
        $to     = Carbon::parse($to)->toDateString();
        $total  = 0;
        $net    = 0;
        $data   = [];
        $main   = DB::table('tblprice_categories')->where('parent_id','=',0)->get();

        foreach($main as $m)

        {
            $data [] = ['description' => $m->description,'totalAmount' => 0 ,'main' => true];
            $sub   = DB::table('tblprice_categories')->where('parent_id','=',$m->price_cat_id)->get();

            foreach($sub as $s)

            {
                $total = DB::table('tblpayments as p')
                            ->leftJoin('tblpayment_history as ph','ph.payment_id','=','p.payment_id')
                            ->select(DB::raw('sum(ph.current_price*ph.qty) AS total_sales'))
                            ->whereBetween('p.payment_date', [$from, $to])
                            ->where('ph.price_cat_id','=',$s->price_cat_id)
                            ->where('p.status','=',1)
                            ->first();

                $data [] = ['description' => $s->description,'totalAmount' => $total->total_sales ,'main' => false];
                
                $net += $total->total_sales;
            }

        }


        return ['data'=>$data,'netAmount'=>$net];

    }
}
