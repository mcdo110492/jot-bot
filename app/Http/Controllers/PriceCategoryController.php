<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PriceCategoryRequest;
use App\PriceCategory;

class PriceCategoryController extends Controller
{

    public function __construct(PriceCategory $category)

    {
        $this->category = $category;
    }


    public function index(Request $request)

    {
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = $request['order'] == 'order'? 'ASC' : 'DESC';
        $field      = $request['field'];
        $filter     = $request['filter'];
        $count      = $this->category->where('parent_id','=',0)->count();
        $data       = $this->category->where('parent_id','=',0)->where($field, 'LIKE' , '%'.$filter.'%')->take($limit)->skip($offset)->orderBy($field, $order)->get();
        return response()->json(compact('count','data'), 200);

    }


    public function store(PriceCategoryRequest $request)
    {
        $category = PriceCategory::create($request->all());
        
        return response()->json([ 'status' => 200,'message' => 'Success'], 200);
    }

    public function update(PriceCategoryRequest $request, PriceCategory $category)
    {
        $category->update($request->all());

        return response()->json(['status' => 200]);
    }

    public function show($id, Request $request)
    {
       $limit      = $request['limit'];
       $limitPage  = $request['page'] - 1;
       $offset     = $limit * $limitPage;
       $order      = $request['order'] == 'order'? 'ASC' : 'DESC';
       $field      = $request['field'];
       $filter     = $request['filter'];
       $count      = $this->category->where('parent_id','=',$id)->count();
       $data       = $this->category->where('parent_id','=',$id)->take($limit)->skip($offset)->orderBy($field, $order)->get();

       return response()->json(compact('count','data'), 200);
    }

    public function create()

    {
        $data = $this->category->with('subCategory')->where('parent_id','=',0)->get();

         return response()->json(compact('data'), 200);
    }
}
