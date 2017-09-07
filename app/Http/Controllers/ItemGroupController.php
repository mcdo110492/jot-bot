<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemGroup;
use App\Http\Requests\ItemGroupRequest;
use Illuminate\Support\Facades\DB;

class ItemGroupController extends Controller
{
    public function index(Request $request) {
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];
        $group      = $request['group'];

        $count = ItemGroup::where('groupId','=',$group)->count();
        $data = DB::table('itemGroup as ig')
                    ->leftJoin('itemPrice as ip','ip.itemPriceId','=','ig.itemPriceId')
                    ->leftJoin('itemType as it','it.itemTypeId','=','ip.itemTypeId')
                    ->where('ig.groupId','=',$group)
                    ->where('it.'.$field,'LIKE','%'.$filter.'%')
                    ->take($limit)
                    ->skip($offset)
                    ->orderBy('it.'.$field, $order)
                    ->get();
        
        return response()->json([ 'status' => 200, 'count'=> $count ,'data' => $data], 200);
    }


    public function store(ItemGroupRequest $request) {

        ItemGroup::create($request->all());
        
        return response()->json([ 'status' => 200,'message' => 'Data Creation Success'], 200);
    }



    public function delete($id){

        ItemGroup::where('itemGroupId','=',$id)->delete();
        
        return response()->json(['status' => 200, 'message' => 'Data Remove Success'], 200);

    }

    public function checkValue(Request $request){

        $count = ItemGroup::where([ ['itemPriceId','=',$request['keyValue']], ['groupId','=',$request['keyId']] ])->count();

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

    public function getItemsPos(Request $request) {

        $filter     = $request['filter'];

        $data = DB::table('itemPrice as ip')
                ->select('*','ip.itemPriceId as item_price')
                ->leftJoin('itemType as it','it.itemTypeId','=','ip.itemTypeId')
                ->leftJoin('itemGroup as ig','ig.itemPriceId','=','ip.itemPriceId')
                ->leftJoin('groups as g','g.groupId','=','ig.groupId')
                ->where('it.itemName','LIKE','%'.$filter.'%')
                ->orWhere('g.groupName','LIKE','%'.$filter.'%')
                ->orderBy('g.groupName', 'ASC')
                ->orderBy('it.itemName', 'ASC')
                ->get();

        return response()->json($data, 200);
    }


}
