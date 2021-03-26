<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ItemFlow;

class ReportController extends Controller
{
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $from, $to)
    {
        $type = $request->query('type') ? explode(',',$request->query('type')) : [ 'in' ];
        $start_date = date($from) ?? date();
        $end_date = date($to) ?? date();
        $items = ItemFlow::joinItem();

        if(in_array("in", $type)){
            $items->getByType('in');
        }

        if(in_array("out", $type)){
            $items->getByType('out');
        }

        $items = $items->inDateRange($start_date, $end_date)->get();
        return response()->json([
            'statusCode' => 200,
            'message' => trans('report.success'),
            'data' => [
                'start_date'=> $start_date,
                'end_date'=> $end_date,
                'type'=> $type,
                'items' => $items
            ]
        ]);
    }
}
