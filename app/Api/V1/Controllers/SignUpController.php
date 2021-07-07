<?php

namespace App\Api\V1\Controllers;

use Config;
use App\User;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\SignUpRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Auth;

class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request, JWTAuth $JWTAuth)
    {

        $request_body = $request->only([
            'role_id',
            'name',
            'email',
            'password'
        ]);

        $emailCheck = User::findByEmail($request_body['email'])->first();
        if($emailCheck){
            throw new BadRequestHttpException('Email sudah digunakan');
        }
        
        $user = new User($request_body);
        if(!$user->save()) {
            throw new HttpException(500);
        }

        if(!Config::get('boilerplate.sign_up.release_token')) {
            return response()->json([
                'statusCode' => 201,
                'message' => trans('sign-up.success')
            ], 201);
        }

        $token = $JWTAuth->fromUser($user);
        return response()->json([
            'statusCode' => 201,
            'message' => trans('sign-up.success'),
            'data' => [
                'name' => $user->name,
                'role_id' => $user->role_id,
                'token' => $token,
                'expires_in' => Auth::guard()->factory()->getTTL() * 60
            ]
        ], 201);
    }
}
