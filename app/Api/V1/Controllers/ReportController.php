<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ItemFlow;
use Storage;
use PDF;

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

        $items = $items
            ->inDateRange($start_date, $end_date)
            ->sortDescByCreatedAt()
            ->get();

        if(!$items && count($items) <= 0){
            throw new BadRequestHttpException(trans('item-flow.empty'));
        }

        $data = [
            'start_date'=> $start_date,
            'end_date'=> $end_date,
            'type'=> $request->query('type'),
            'items' => $items
        ];

        $headers = [
            'Content-Type','application/pdf'
        ];

        return $this->createPdf($data);
    }

    private function createPdf($data){

        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        $type = $data['type'];
        $items = $data['items'];

        $pdf = PDF::loadView(
            'report.index', 
            compact(
                'start_date', 
                'end_date', 
                'type',
                'items'
            )
        );
        $milliseconds = round(microtime(true) * 1000);
        return $pdf->download($milliseconds.'.pdf');
    }
}
