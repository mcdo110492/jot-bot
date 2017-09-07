<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Invoices;
use App\InvoiceItems;
use Validator;
use Carbon\Carbon;

class InvoicesController extends Controller
{

    public function __construct(){
        $token = JWTAuth::parseToken()->authenticate();

        $this->user = $token->user_id;
    }


    public function index(Request $request){
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];
        $date       = new \DateTime($request['dateIssued']);
        $dateFilter = Carbon::parse($request['dateIssued'])->toDateString();

        $count = Invoices::where('dateIssued','=',$dateFilter)->count();
        $data = Invoices::with('users')
        ->where(function($q) use ($dateFilter) {
                 $q->where('dateIssued','=',$dateFilter);
        })
        ->where(function ($q) use ($filter,$field) {
             $q->where($field, 'LIKE' , '%'.$filter.'%');
        })
        ->take($limit)->skip($offset)->orderBy($field, $order)->get();
        
        return response()->json([ 'status' => 200, 'count'=> $count ,'data' => $data, 'date' => $date ], 200);
    }


    public function totalCollection(){

        $now = Carbon::today();
        $where = ['dateIssued' => $now, 'status' => 1];
        $invoices =  Invoices::where($where)->get();
        $total  = 0;

        foreach($invoices as $invoice){
            $items = InvoiceItems::where('invoiceId','=',$invoice->invoiceId)->get();
            foreach($items as $item){
                $total += ($item->qty * $item->currentPrice);
            }
        }

        return response()->json(['collection' => $total, 'date' => $now]);

    }

    public function checkValue(Request $request){
        
        $count = Invoices::where('rrNo','=',$request['keyValue'])->count();

        if($count>0){
            $status = 403;
            $message = 'Duplicate data entry';
        }
        else{
            $status = 200;
            $message = 'Data is available';
        }

        return response()->json(compact('status','message'));
    }


    public function store(Request $request){

        $details            = $request->details;
        $items              = $request->items;
        $invoiceId          = 0;
        DB::beginTransaction();

        $validateDetails    = Validator::make($details, [
            'rrNo'          =>  'required|unique:invoices,rrNo',
            'amountPaid'    =>  'required|numeric'
        ]);

        if($validateDetails->fails()){
            DB::rollback();
            $response   =   ['message'=>'Form Details is not Complete.'];
            return response()->json($response,422);
        }
        else{
            $data1  = [
                'rrNo'          =>      $details['rrNo'],
                'amountPaid'    =>      $details['amountPaid'],
                'customer'      =>      $details['customer'],
                'dateIssued'    =>      Carbon::now(),
                'user_id'       =>      $this->user

            ];

            $invoice    = Invoices::create($data1);
            $invoiceId  = $invoice->invoiceId;
        }


        foreach($items as $item){

            $validateItems      =   Validator::make($item, [
                'itemTypeId'    =>  'required|integer',
                'itemPrice'     =>  'required|numeric',
                'qty'           =>  'required|numeric'
            ]);

            if($validateItems->fails()){
                DB::rollback();
                $response   =   ['message'=>'Form Items is not Complete.'];
                return response()->json($response,422);
                break;
            }
            else{
                $data2 = [
                    'invoiceId'     =>      $invoiceId,
                    'itemTypeId'    =>      $item['itemTypeId'],
                    'groupId'       =>      $item['groupId'],
                    'currentPrice'  =>      $item['itemPrice'],
                    'qty'           =>      $item['qty']
                ];

                InvoiceItems::create($data2);
            }
        }

        DB::commit();
        $status         = 200;
        $message        = 'Data Creation Success';

        return response()->json(compact('status','message'));
    }


    public function changeStatus(Request $request){
        $invoiceId  = $request['invoiceId'];
        $status     = $request['status'];

        Invoices::where('invoiceId','=',$invoiceId)->update(['status' => $status]);

        return response()->json(['status' => 200, 'message' => 'Status has been changed.']);
    }

    public function getItems($id){

        $invoiceId         = $id;
        $total             = 0; 
        $data              = InvoiceItems::with('itemType','group')->where('invoiceId','=',$invoiceId)->get();
        foreach($data as $item){
            $total += ($item->currentPrice * $item->qty);
        }
        
        return response()->json(compact('data','total'));
    }
}
