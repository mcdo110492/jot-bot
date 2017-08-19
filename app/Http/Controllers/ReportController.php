<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
   
    public function index(Request $request,Report $report)

    {
        $from   = $request['from'];
        $to     = $request['to'];
        $get    = $report->getReport($from,$to);

        return response()->json($get);
    }

   
   
}
