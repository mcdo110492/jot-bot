<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;


class SalesReportController extends Controller
{
    public function __construct(){
        $token = JWTAuth::parseToken()->authenticate();

        $this->user = $token->user_id;
    }

    public function index(Request $request){
        $from       = Carbon::parse($request['from'])->toDateString();
        $to         = Carbon::parse($request['to'])->toDateString();
        $type       = $request['type'];
        $totalSales =   0;
        $data       =   [];

        if($type === 'byIndividual'){
            $items  = DB::table('services')->get();

            foreach($items as $item){
                $totalCost = 0;
                $sales = DB::table('serviceSales as ss')
                         ->leftJoin('serviceSaleItems as si','si.serviceSalesId','=','ss.serviceSalesId')
                         ->whereBetween('ss.dateIssued',[$from,$to])
                         ->where('si.serviceId','=',$item->serviceId)
                         ->get();
                foreach($sales as $sale){
                    $totalCost += ($sale->serviceCost * $sale->serviceQty);
                }
                $data[] = [ 'items' => $item, 'totalCost' => $totalCost ];
                $totalSales += $totalCost;
                $totalCost = 0;
            }
        }
        else{
            $items  = DB::table('serviceCategories')->orderBy('serviceCategoryName','ASC')->get();
            foreach($items as $item){
                $totalCost = 0;
                $sales = DB::table('services as s')
                            ->leftJoin('serviceSaleItems as si','si.serviceId','=','s.serviceId')
                            ->whereBetween('si.created_at',[$from,$to])
                            ->where('s.serviceCategoryId','=',$item->serviceCategoryId)
                            ->get();
                foreach($sales as $sale){
                    $totalCost += ($sale->serviceCost * $sale->serviceQty);
                }   
                $data[] = [ 'items' => $item, 'totalCost' => $totalCost ];
                $totalSales += $totalCost;
                $totalCost = 0;
            }
        }

        return response()->json(['data' => $data,'totalSales' => $totalSales]);
        
    }
}
