<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemType;
use App\Http\Requests\ItemTypeRequest;

class ItemTypeController extends Controller
{
    
    public function index(Request $request) {
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];

        $count = ItemType::count();
        $data = ItemType::where($field, 'LIKE' , '%'.$filter.'%')->take($limit)->skip($offset)->orderBy($field, $order)->get();
        
        return response()->json([ 'status' => 200, 'count'=> $count ,'data' => $data], 200);
    }

    public function all() {
        $data = ItemType::orderBy('itemName', 'ASC')->get();

        return response()->json(['data' => $data]);
    }


    public function store(ItemTypeRequest $request) {

        ItemType::create($request->all());
        
        return response()->json([ 'status' => 200,'message' => 'Data Creation Success'], 200);
    }

    public function show($id) {

        $data = ItemType::findOrFail($id);

        return response()->json($data, 200);
    }   

    public function update(ItemTypeRequest $request, $id){

        $data = [
            'itemName'      =>  $request['itemName']
        ];

        ItemType::where('itemtypeId','=',$id)->update($data);
        
        return response()->json(['status' => 200, 'message' => 'Data Update Success'], 200);

    }

    public function checkValue(Request $request){
        $id    = $request['keyId'];
        $value = $request['keyValue'];

        //Check if the id is 0 determine that this item is newly created
        if($id == 0){
            $count = ItemType::where('itemName','=',$value)->count();
            
                    if($count>0){
                        $status = 403;
                        $message = 'Duplicate data entry';
                    }
                    else{
                        $status = 200;
                        $message = 'Data is available';
                    }
        }
        //Else if the item is to be updated
        else {
            //check if the item has a value with the same id set the status to 200 because this is a valid
            $count = ItemType::where('itemName','=',$value)->where('itemTypeId','=',$id)->count();
            if($count>0){
                $status = 200;
                $message = 'Data is available';
            }
            else{
                //except the value is not the same with the id check the value again if is valid or not
                $count2 = ItemType::where('itemName','=',$value)->count();
                
                        if($count2>0){
                            $status = 403;
                            $message = 'Duplicate data entry';
                        }
                        else{
                            $status = 200;
                            $message = 'Data is available';
                        }
            }
        }
        

        return response()->json(compact('status','message'));

    }
}
