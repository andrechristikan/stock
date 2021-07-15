<?php
namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Rack;
use App\Item;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RackController extends Controller
{

    public function index(Request $request)
    {
        $rack = Rack::getAll();
        
        $warehouse_id = $request->warehouse_id;
        if($warehouse_id){
            $rack->getByWarehouseId($warehouse_id);
        }
        
        $rack = $rack->get();

        return response()->json([
            'statusCode' => 200,
            'message' => trans('rack.success'),
            'data' => $rack
        ], 200);
    }

    public function create(Request $request)
    {

        $rack = new Rack([
            'name' => $request->name,
            'warehouse_id' => $request->warehouse_id,
        ]);

        if(!$rack->save()){
            throw new HttpException(trans('http.internal-server-error'));
        }

        return response()->json([
            'statusCode' => 201,
            'message' => trans('rack.store'),
            'data' => [
                "id" => $rack->id
            ]
        ], 201);
    }

    public function delete($id)
    {
        $rack = Rack::find($id);
        if(!$rack){
            throw new NotFoundHttpException(trans('http.not-found'));
        }

        $item = Item::getByRackId($id)->first();
        if($item){
            throw new BadRequestHttpException(trans('rack.used'));
        }

        Rack::find($id)->delete();

        return response()->json([
            'statusCode' => 200,
            'message' => trans('rack.destroy'),
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $rack = Rack::find($id);
        if(!$rack){
            throw new NotFoundHttpException(trans('http.not-found'));
        }

        $rack->name = $request->name;
        if(!$rack->save()){
            throw new HttpException(trans('http.internal-server-error'));
        }

        return response()->json([
            'statusCode' => 200,
            'message' => trans('rack.update'),
            'data' => [
                "id" => $rack->id
            ]
        ], 200);
    }
    

}