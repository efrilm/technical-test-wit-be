<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\EmployeeResource;
use App\Services\Employee\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    /**
     * Employee Service
     *
     * @var EmployeeService
     */
    protected EmployeeService $employeeService;

    /**
     * Employee Constructor
     *
     * @param EmployeeService $employeeService
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Employee Index
     *
     * @param PaginateRequest $request
     * @return JsonResponse
     */
    public function index(PaginateRequest $request): JsonResponse
    {
        $results = $this->employeeService->get($request);

        return response()->json([
            'success' => true,
            'message' => 'Get Employee Data',
            'data' => EmployeeResource::collection($results),
        ]);
    }

    /**
     * Count Of Employee
     *
     * @param PaginateRequest $request
     * @return JsonResponse
     */
    public function count(PaginateRequest $request): JsonResponse
    {
        $all = $this->employeeService->get($request)->count();
        $contract = $this->employeeService->getCountByStatus(StatusEnum::KONTRAK);
        $alive = $this->employeeService->getCountByStatus(StatusEnum::TETAP);
        $probation = $this->employeeService->getCountByStatus(StatusEnum::PROBATION);
        $distributions = $this->employeeService->getCountGroupBy('departmen');
        $label = [];
        $series  = [];
        for ($i = 0; $i < count($distributions); $i++) {
            $label[] = $distributions[$i]->departmen;
            $series[] = $distributions[$i]->jumlah;
        }

        return response()->json([
            'success' => true,
            'message' => 'Get Count Employee Data',
            'data' => [
                'all_employee' => $all,
                'contract'  => $contract,
                'alive'  => $alive,
                'probation'  => $probation,
                'distributions' => [
                    'label' => $label,
                    'series' => $series
                ],
            ],
        ]);
    }

    /**
     * Find Employee with id
     *
     * @param integer|string $id
     * @return JsonResponse
     */
    public function find(int|string $id): JsonResponse
    {
        $result = $this->employeeService->findId($id);

        return response()->json([
            'success' => true,
            'message' => 'Find Employee',
            'data' => new EmployeeResource($result),
        ]);
    }

    /**
     * Store Employee to db
     *
     * @param EmployeeRequest $request
     * @return JsonResponse
     */
    public function store(EmployeeRequest $request): JsonResponse
    {
        try {

            $this->employeeService->store($request);

            return response()->json([
                'success' => true,
                'message' => 'Create employee successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 'false',
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Update Employee
     *
     * @param EmployeeRequest $request
     * @param integer|string $id
     * @return JsonResponse
     */
    public function update(EmployeeRequest $request, int|string $id): JsonResponse
    {
        try {

            // check id
            $find = $this->employeeService->findId($id);

            if (empty($find)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Employee not found',
                ], 422);
            }

            $this->employeeService->update($request, $id);

            return response()->json([
                'success' => true,
                'message' => 'Update employee successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 'false',
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Delete Employee
     *
     * @param integer|string $id
     * @return JsonResponse
     */
    public function delete(int|string $id): JsonResponse
    {
        try {
            $this->employeeService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Delete Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 'false',
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
