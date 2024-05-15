<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkStatusController extends Controller
{
    public function index(): JsonResponse
    {
        $data = [
            [
                'value' =>  StatusEnum::TETAP,
            ],
            [
                'value' =>  StatusEnum::KONTRAK,
            ],
            [
                'value' =>  StatusEnum::PROBATION,
            ],
        ];

        return response()->json([
            'success' => true,
            'message' => 'Get Work Status Successfully',
            'data' => $data,
        ]);
    }
}
