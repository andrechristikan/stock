<?php
namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Role;

class RoleController extends Controller
{

    public function index()
    {
        $role = Role::all();

        return response()->json([
            'statusCode' => 200,
            'message' => trans('role.success'),
            'data' => $role
        ], 200);
    }
}