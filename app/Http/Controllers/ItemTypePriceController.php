<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemTypePrice;
use App\Http\Requests\ItemTypePriceRequest;
use Illuminate\Support\Facades\DB;

class ItemTypePriceController extends Controller
{
    public function index(Request $request) {
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];

        $count = ItemTypePrice::count();
        $data = DB::table('itemPrice as ip')
                    ->leftJoin('itemType as it','it.itemTypeId','=','ip.itemTypeId')
                    ->where('it.'.$field,'LIKE','%'.$filter.'%')
                    ->take($limit)
                    ->skip($offset)
                    ->orderBy('it.'.$field, $order)
                    ->get();
        
        return response()->json([ 'status' => 200, 'count'=> $count ,'data' => $data], 200);
    }

    public function all(){

        $data = DB::table('itemPrice as ip')
        ->leftJoin('itemType as it','it.itemTypeId','=','ip.itemTypeId')
        ->orderBy('it.itemName', 'ASC')
        ->get();

        return response()->json(['data' => $data]);
    }


    public function store(ItemTypePriceRequest $request) {

        ItemTypePrice::create($request->all());
        
        return response()->json([ 'status' => 200,'message' => 'Data Creation Success'], 200);
    }

    public function show($id) {

        $data = ItemTypePrice::findOrFail($id);

        return response()->json($data, 200);
    }   

    public function update(ItemTypePriceRequest $request, $id){

        $data = [
            'itemTypeId'      =>  $request['itemTypeId'],
            'itemPrice'       =>  $request['itemPrice']
        ];

        ItemTypePrice::where('itemPriceId','=',$id)->update($data);
        
        return response()->json(['status' => 200, 'message' => 'Data Update Success'], 200);

    }
}
