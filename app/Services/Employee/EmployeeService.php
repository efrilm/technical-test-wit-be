<?php

namespace App\Services\Employee;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Employee;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EmployeeService
{

    /**
     * Get All Employee with paginate
     *
     * @param PaginateRequest $request
     * @return Collection|Exception
     */
    public function get(PaginateRequest $request): Collection|Exception|LengthAwarePaginator;

    /**
     * Find id of employee
     *
     * @param integer|string $id
     * @return Employee|null
     */
    public function findId(int|string $id): Employee|null;

    /**
     * Store Employee to db
     *
     * @param EmployeeRequest $request
     * @return Employee
     */
    public function store(EmployeeRequest $request): Employee;

    /**
     * Update Employee
     *
     * @param EmployeeRequest $request
     * @param integer|string $id
     * @return boolean|null
     */
    public function update(EmployeeRequest $request, int|string $id): bool|null;

    /**
     * Delete Employee
     *
     * @param integer|string $delete
     * @return boolean
     */
    public function delete(int|string $delete): bool;

    /**
     * Get Count Employee by status
     *
     * @param string $status
     * @return void
     */
    public function getCountByStatus(string $status): int;

    /**
     * Get Counut Group By Column
     *
     * @param string $colum
     * @return Collection
     */
    public function getCountGroupBy(string $column): Collection;
}
