<?php
namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Warehouse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Rack;

class WarehouseController extends Controller
{

    public function index()
    {
        $warehouse = Warehouse::all();

        return response()->json([
            'statusCode' => 200,
            'message' => trans('warehouse.success'),
            'data' => $warehouse
        ], 200);
    }


    public function create(Request $request)
    {

        $warehouse = new Warehouse([
            'name' => $request->name,
        ]);

        if(!$warehouse->save()){
            throw new HttpException(trans('http.internal-server-error'));
        }

        return response()->json([
            'statusCode' => 201,
            'message' => trans('warehouse.store'),
            'data' => [
                "id" => $warehouse->id
            ]
        ], 201);
    }

    public function delete($id)
    {
        $warehouse = Warehouse::find($id);
        if(!$warehouse){
            throw new NotFoundHttpException(trans('http.not-found'));
        }

        $rack = Rack::getByWarehouseId($id)->first();
        if($rack){
            throw new BadRequestHttpException(trans('warehouse.used'));
        }

        Warehouse::find($id)->delete();

        return response()->json([
            'statusCode' => 200,
            'message' => trans('warehouse.destroy'),
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::find($id);
        if(!$warehouse){
            throw new NotFoundHttpException(trans('http.not-found'));
        }

        $warehouse->name = $request->name;
        if(!$warehouse->save()){
            throw new HttpException(trans('http.internal-server-error'));
        }

        return response()->json([
            'statusCode' => 200,
            'message' => trans('warehouse.update'),
            'data' => [
                "id" => $warehouse->id
            ]
        ], 200);
    }
}