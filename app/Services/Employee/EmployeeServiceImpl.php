<?php

namespace App\Services\Employee;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Employee;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EmployeeServiceImpl implements EmployeeService
{

    /**
     * Get All Emmployee with paginate
     *
     * @param PaginateRequest $request
     * @return Collection|Exception|LengthAwarePaginator
     */
    public function get(PaginateRequest $request): Collection|Exception|LengthAwarePaginator
    {
        try {
            $requests = $request->all();

            $method = $request->get('paginate', 0) == 1 ? 'paginate' : 'get';
            $methodValue = $request->get('paginate', 0) == 1 ? $request->get('per_page', 10) : '*';
            $orderColumn = $request->get('order_column') ?? 'id';
            $orderType = $request->get('order_type') ?? 'asc';

            $employee = Employee::where(function ($query) use ($requests) {
                foreach ($requests  as $key => $request) {
                    if (in_array($key, ['nama'])) {
                        $query->where($key, 'like', '%' . $request . '%');
                    }

                    if (in_array($key, ['excepts'])) {
                        $explodes = explode('|', $request);
                        if (is_array($explodes)) {
                            foreach ($explodes as $explode) {
                                $query->where('id', '!=', $explode);
                            }
                        }
                    }
                }
            })
                ->orderBy($orderColumn, $orderType)
                ->$method($methodValue);

            return $employee;
        } catch (\Exception $e) {
            Log::error("GET_EMPLOYEE_ERROR", [
                'message' => $e->getMessage()
            ]);
            throw new Exception($e->getMessage(), 422);
        }
    }

    /**
     * Find id of the employee
     *
     * @param integer|string $id
     * @return Employee|null
     */
    public function findId(int|string $id): ?Employee
    {
        try {
            $employee = Employee::findOrFail($id);

            return $employee;
        } catch (\Exception $e) {
            Log::error("FIND_ID_EMPLOYEE_ERROR", [
                'message' => $e->getMessage()
            ]);
            throw new Exception($e->getMessage(), 422);
        }
    }

    /**
     * Store Employee on Database
     *
     * @param EmployeeRequest $request
     * @return Employee
     */
    public function store(EmployeeRequest $request): Employee
    {
        try {

            $nama = $request->nama;
            $nomor = $request->nomor;
            $jabatan = $request->jabatan;
            $departmen = $request->departmen;
            $tanggalMasuk = $request->tanggal_masuk;
            $foto = $request->foto;
            $status = $request->status;

            $path = Employee::PATH;
            $foto = $request->file('foto');

            $data = [
                'nama' => $nama,
                'nomor' => $nomor,
                'jabatan' => $jabatan,
                'departmen' => $departmen,
                'tanggal_masuk' => $tanggalMasuk,
                'foto' => $foto->hashName(),
                'status' => $status,
            ];

            $employee = Employee::create($data);
            $foto->store($path, 'public');

            return $employee;
        } catch (\Exception $e) {
            Log::error("CREATE_EMPLOYEE_ERROR", [
                'message' => $e->getMessage()
            ]);
            throw new Exception($e->getMessage(), 422);
        }
    }

    /**
     * Update Employee
     *
     * @param EmployeeRequest $request
     * @param integer|string $id
     * @return boolean|null
     */
    public function update(EmployeeRequest $request, int|string $id): ?bool
    {
        try {
            // get employee data
            $find = $this->findId($id);

            $nama = $request->nama;
            $nomor = $request->nomor;
            $jabatan = $request->jabatan;
            $departmen = $request->departmen;
            $tanggalMasuk = $request->tanggal_masuk;
            $foto = $request->foto;
            $status = $request->status;

            $data = [
                'nama' => $nama,
                'nomor' => $nomor,
                'jabatan' => $jabatan,
                'departmen' => $departmen,
                'tanggal_masuk' => $tanggalMasuk,

                'status' => $status,
            ];

            if ($request->has('foto')) {

                // Check Image in Storage
                if (Storage::exists('public/' . Employee::PATH . '/' . $find->foto)) {
                    Storage::delete('public/' . Employee::PATH . '/' . $find->foto);
                }

                $path = Employee::PATH;

                $foto = $request->file('foto');
                $foto->store($path, 'public');

                $data['foto'] = $foto->hashName();
            }



            $employee = Employee::find($id)->update($data);

            return true;
        } catch (\Exception $e) {
            Log::error("DELETE_EMPLOYEE_ERROR", [
                'message' => $e->getMessage()
            ]);
            throw new Exception($e->getMessage(), 422);
            return false;
        }
    }

    /**
     * Delete Employee
     *
     * @param integer|string $id
     * @return boolean
     */
    public function delete(int|string $id): bool
    {
        try {
            // get employee data
            $find = $this->findId($id);

            // Check Image in Storage
            if (Storage::exists('public/' . Employee::PATH . '/' . $find->foto)) {
                Storage::delete('public/' . Employee::PATH . '/' . $find->foto);
            }

            $find->delete();

            return true;
        } catch (\Exception $e) {
            Log::error("DELETE_EMPLOYEE_ERROR", [
                'message' => $e->getMessage()
            ]);
            throw new Exception($e->getMessage(), 422);
            return false;
        }
    }

    /**
     * Get Count By Status
     *
     * @param string $status
     * @return integer
     */
    public function getCountByStatus(string $status): int
    {
        $count = Employee::where('status', $status)
            ->get()
            ->count();

        return $count;
    }

    public function getCountGroupBy(string $column): Collection
    {
        $result = DB::table('employees')
            ->select(DB::raw($column . ', count(*) as jumlah'))
            ->groupBy($column)
            ->get();

        return $result;
    }
}
