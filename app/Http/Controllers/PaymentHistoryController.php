<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentHistory;
use App\Payment;
use Carbon\Carbon;

class PaymentHistoryController extends Controller
{
    
  

    public function index (Request $request, PaymentHistory $history) 

    {
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = $request['order'] == 'order'? 'ASC' : 'DESC';
        $field      = $request['field'];
        $filter     = Carbon::parse($request['filter'])->toDateString();
        $rr_no      = $request['rr_no'];

        $count = $history->countHistory($filter);
        $data =  $history->getHistory($limit,$limitPage,$offset,$field,$filter,$order,$rr_no);
        
        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $data], 200);
       

    }


     public function show($id)
    {
        $data    = PaymentHistory::with('category')->where('payment_id','=',$id)->get();
        return response()->json([ 'data' => $data], 200);
    }


}
