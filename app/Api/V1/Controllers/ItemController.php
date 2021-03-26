<?php
namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Item;
use App\ItemFlow;
use Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Image;
use Storage;

class ItemController extends Controller
{


    public function index()
    {

        $user = Auth::guard()->user();
        if($user->role_id != 1){
            throw new UnauthorizedHttpException(trans('http.unauthorized'));
        }

        $items = Item::getAllItem()->get();

        return response()->json([
            'statusCode' => 200,
            'message' => trans('item.success'),
            'data' => $items
        ], 200);
    }

    public function indexOut(Request $request)
    {

        $user = Auth::guard()->user();
        if($user->role_id != 1){
            throw new UnauthorizedHttpException(trans('http.unauthorized'));
        }
        
        $search = $request->query('search');
        $items = ItemFlow::joinItem()->getByType('out');
        
        if($search){
            $items->search($search);
        }
        $items = $items->get();
        return response()->json([
            'statusCode' => 200,
            'message' => trans('itemFlow.success'),
            'data' => $items
        ], 200);
    }

    public function show($id){

        $user = Auth::guard()->user();
        if($user->role_id != 1){
            throw new UnauthorizedHttpException(trans('http.unauthorized'));
        }

        $item = Item::getOneItemById($id)->first();
        if(!$item){
            throw new NotFoundHttpException(trans('http.not-found'));
        }

        return response()->json([
            'statusCode' => 200,
            'message' => trans('item.success'),
            'data' => $item,
        ], 200);

    }

    public function in(Request $request){

        $user = Auth::guard()->user();
        if($user->role_id != 1){
            throw new UnauthorizedHttpException(trans('http.unauthorized'));
        }

        $request_body = $request->only([
            'name', 
            'amount', 
            'quantity'
        ]);

        DB::beginTransaction();

        $item = new Item([
            'name' => $request_body['name'],
            'amount' => $request_body['amount'],
        ]);

        if ($request->hasFile('photo')) {
            $image      = $request->file('photo');
            $fileName   = time() . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            $img->resize(120, 120, function ($constraint) {
                $constraint->aspectRatio();                 
            });

            $img->stream(); // <-- Key point

            $link = 'images/'.$item->id.'/'.$fileName;
            Storage::disk('public')->put($link, $img);

            $item->photo = 'storage/'.$link;
        }


        if(!$item->save()){
            DB::rollBack();
            throw new HttpException(trans('http.internal-server-error'));
        }

        $user = Auth::guard()->user();
        $ItemFlow = new ItemFlow([
            'item_id'=> $item->id,
            'user_id'=> $user->id,
            'type'=> 'in',
            'quantity'=> $request_body['quantity'],
        ]);

        if(!$ItemFlow->save()){
            DB::rollBack();
            throw new HttpException(trans('http.internal-server-error'));
        }
        
        DB::commit();

        return response()->json([
            'statusCode' => 201,
            'message' => trans('item.store'),
            'data' => [
                "id" => $item->id
            ]
        ], 201);

    }


    public function destroy($id){

        $user = Auth::guard()->user();
        if($user->role_id != 1){
            throw new UnauthorizedHttpException(trans('http.unauthorized'));
        }

        $item = Item::getOneItemById($id)->first();
        if(!$item){
            throw new NotFoundHttpException(trans('http.not-found'));
        }

        $user = Auth::guard()->user();
        $quantityOfItem = ItemFlow::getByItemId($id)->sum('quantity');
        $ItemFlow = new ItemFlow([
            'item_id'=> $item->id,
            'user_id'=> $user->id,
            'type'=> 'out',
            'quantity'=> -$quantityOfItem,
        ]);

        if(!$ItemFlow->save()){
            throw new HttpException(trans('http.internal-server-error'));
        }

        return response()->json([
            'statusCode' => 200,
            'message' => trans('item.destroy'),
        ], 200);

    }


    public function out(Request $request, $id){

        $user = Auth::guard()->user();
        if($user->role_id != 1){
            throw new UnauthorizedHttpException(trans('http.unauthorized'));
        }

        $request_body = $request->only([
            'quantity'
        ]);

        $quantity = $request_body['quantity'];
        if($quantity <= 0){
            throw new BadRequestHttpException(trans('item.quantity-must-more-than-one'));
        }

        $item = Item::getOneItemById($id)->first();
        if(!$item){
            throw new NotFoundHttpException(trans('http.not-found'));
        }

        $user = Auth::guard()->user();
        $quantityOfItem = ItemFlow::getByItemId($id)->sum('quantity');
        if($quantityOfItem < $quantity){
            throw new BadRequestHttpException(trans('item.quantity-out-more-than-stock'));
        }

        $ItemFlow = new ItemFlow([
            'item_id'=> $item->id,
            'user_id'=> $user->id,
            'type'=> 'out',
            'quantity'=> -$quantity,
        ]);

        if(!$ItemFlow->save()){
            throw new HttpException(trans('http.internal-server-error'));
        }

        return response()->json([
            'statusCode' => 200,
            'message' => trans('item.out'),
        ], 200);
    }

    public function updateItemPhoto(Request $request, $id){

        $user = Auth::guard()->user();
        if($user->role_id != 1){
            throw new UnauthorizedHttpException(trans('http.unauthorized'));
        }

        if (!$request->hasFile('photo')) {
            throw new BadRequestHttpException(trans('item.photo-null'));
        }

        $item = Item::getOneItemById($id)->first();
        if(!$item){
            throw new NotFoundHttpException(trans('http.not-found'));
        }

        $image      = $request->file('photo');
        $fileName   = time() . '.' . $image->getClientOriginalExtension();

        $img = Image::make($image->getRealPath());
        $img->resize(120, 120, function ($constraint) {
            $constraint->aspectRatio();                 
        });

        $img->stream(); // <-- Key point

        $link = 'images/'.$item->id.'/'.$fileName;
        Storage::disk('public')->put($link, $img);

        $item->photo = 'storage/'.$link;
        
        return response()->json([
            'statusCode' => 200,
            'message' => trans('item.update'),
        ], 200);
    }


    public function update(Request $request, $id){

        $user = Auth::guard()->user();
        if($user->role_id != 1){
            throw new UnauthorizedHttpException(trans('http.unauthorized'));
        }
        
        $request_body = $request->only([
            'name',
            'amount',
        ]);

        $item = Item::getOneItemById($id)->first();
        if(!$item){
            throw new NotFoundHttpException(trans('http.not-found'));
        }

        $item->name = $request_body['name'];
        $item->amount = $request_body['amount'];

        if(!$item->save()){
            throw new HttpException(trans('http.internal-server-error'));
        }

        return response()->json([
            'statusCode' => 200,
            'message' => trans('item.update'),
        ], 200);
    }

}