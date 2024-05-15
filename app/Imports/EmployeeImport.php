<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Employee::create([
                'nama' => $row['nama'],
                'nomor' => $row['nomor'],
                'jabatan' => $row['jabatan'],
                'departmen' => $row['departmen'],
                'tanggal_masuk' => $row['tanggal_masuk'],
                'foto' => $row['foto'],
                'status' => $row['status'],
            ]);
        }
    }
}
