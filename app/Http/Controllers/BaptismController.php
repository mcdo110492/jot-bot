<?php

namespace App\Http\Controllers;

use App\Baptism;
use Illuminate\Http\Request;
use App\Http\Requests\CreateBaptismRequest;



class BaptismController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        

        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];

        $count = Baptism::count();
        $data = Baptism::with('minister')->where($field, 'LIKE' , '%'.$filter.'%')->take($limit)->skip($offset)->orderBy($field, $order)->get();
        
        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $data], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return response()->json([ 'status' => 404,'message' => 'Page Not Found.'], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBaptismRequest $request)
    {
        Baptism::create($request->all());
        
        return response()->json([ 'status' => 200,'message' => 'Data Creation Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Baptism  $baptism
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data    = Baptism::with('minister')->findOrFail($id);
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Baptism  $baptism
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //

       return response()->json([ 'status' => 404,'message' => 'Page Not Found.'], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Baptism  $baptism
     * @return \Illuminate\Http\Response
     */
    public function update(CreateBaptismRequest $request, Baptism $baptism)
    {
        $baptism->update($request->all());

        return response()->json(['status' => 200, 'message' => 'Data Update Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Baptism  $baptism
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
        return response()->json([ 'status' => 404,'message' => 'Page Not Found.'], 404);
    }


   


}
