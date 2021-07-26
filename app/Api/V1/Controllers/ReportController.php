<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ItemFlow;
use Storage;
use PDF;
use Auth;

class ReportController extends Controller
{
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $from, $to)
    {
        $user = Auth::guard()->user();
        $type = $request->query('type') ? explode(',',$request->query('type')) : [ 'in' ];
        $start_date = date($from) ?? date();
        $end_date = date($to) ?? date();
        $items = ItemFlow::joinItem();

        if(in_array("in", $type)){
            $items->getByType('in');
        }

        if(in_array("out", $type)){
            $items->orGetByType('out');
        }

        $items = $items
            ->inDateRange($start_date, date('Y-m-d', strtotime($end_date . ' +1 day')))
            ->sortDescByCreatedAt()
            ->get();

        $items_defect = ItemFlow::joinItem()
            ->inDateRange($start_date, date('Y-m-d', strtotime($end_date . ' +1 day')))
            ->getByType('defect')
            ->sortDescByCreatedAt()
            ->get();

        if(!$items && count($items) <= 0){
            throw new BadRequestHttpException(trans('item-flow.empty'));
        }

        $data = [
            'start_date'=> $start_date,
            'end_date'=> $end_date,
            'type'=> $request->query('type'),
            'items' => $items,
            'items_in' => $items->filter(function($value, $key){
                return $value['type'] === 'in';
            }),
            'items_out' => $items->filter(function($value, $key){
                return $value['type'] === 'out';
            }),
            'items_defect' => $items_defect
        ];

        $headers = [
            'Content-Type','application/pdf'
        ];

        $pdf = $this->createPdf($data);
        $fileName   = time() . '.pdf';
        $link = 'pdf/'.$user->id.'/'.$fileName;
        Storage::disk('public')->put($link, $pdf);

        return response()->json([
            'statusCode' => 200,
            'message' => trans('report.create'),
            'data' => [
                "link" =>  'storage/'.$link
            ]
        ], 200);
    }

    private function createPdf($data){

        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        $type = $data['type'];
        $items = $data['items'];
        $items_defect = $data['items_defect'];
        $items_in = $data['items_in'];
        $items_out = $data['items_out'];

        $pdf = PDF::loadView(
            'report.index', 
            compact(
                'start_date', 
                'end_date', 
                'type',
                'items',
                'items_defect',
                'items_in',
                'items_out'
            )
        );
        $milliseconds = round(microtime(true) * 1000);
        return $pdf->download($milliseconds.'.pdf');
    }


}
