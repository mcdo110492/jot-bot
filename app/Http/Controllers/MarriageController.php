<?php

namespace App\Http\Controllers;

use App\Marriage;
use Illuminate\Http\Request;
use App\Http\Requests\MarriageRequest;

class MarriageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, Marriage $marriage)
    {
        

        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $field      = $request['field'];
        $filter     = $request['filter'];
        $order      = strtoupper($request['order']);

        $count = Marriage::count();

        $data = $marriage->queryMarriage($limit,$limitPage,$offset,$field,$filter,$order);

        return response()->json(compact('count','data'),200);
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
    public function store(MarriageRequest $request, Marriage $marriage)
    {

        $marriage->addMarriage($request);
        
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
        $data    = [Marriage::with(['minister','wife','husband'])->find($id)];

        return response()->json([ 'data' => $data], 200);
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
    public function update(MarriageRequest $request, Marriage $marriage)
    {
        $marriage->updateMarriage($request);

        return response()->json(['status' => 200]);
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
