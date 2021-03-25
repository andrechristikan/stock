<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Auth;

class LogoutController extends Controller
{
    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard()->logout();

        return response()
            ->json([
                'statusCode' => 200,
                'message' => trans('logout.success')
            ], 200);
    }
}
