<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Auth;
use App\User;

class LoginController extends Controller
{
    /**
     * Log the user in
     *
     * @param LoginRequest $request
     * @param JWTAuth $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);
        $user = User::findByEmail($credentials['email'])->first();
        
        if(!$user){
            throw new BadRequestHttpException('Email tidak ada di database');
        }

        try {
            $token = Auth::guard()->attempt($credentials);

            if(!$token) {
                throw new BadRequestHttpException('Password yang dimasukan salah');
            }

        } catch (JWTException $e) {
            throw new HttpException(500);
        }


        return response()
            ->json([
                'statusCode' => 200,
                'message' => trans('login.success'),
                'data'=> [
                    'name' => $user->name,
                    'role_id' => $user->role_id,
                    'token' => $token,
                    'expires_in' => Auth::guard()->factory()->getTTL() * 60
                ]
            ], 200);
    }
}
