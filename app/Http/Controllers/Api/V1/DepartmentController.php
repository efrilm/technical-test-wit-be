<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(): JsonResponse
    {
        $data = [
            [
                'value' =>  'Finance',
            ],
            [
                'value' =>  'Tech',
            ],
            [
                'value' =>  'Marketing',
            ],
            [
                'value' =>  'HR',
            ],
            [
                'value' =>  'Customer Service',
            ],
        ];

        return response()->json([
            'success' => true,
            'message' => 'Get Departments Successfully',
            'data' => $data,
        ]);
    }
}
