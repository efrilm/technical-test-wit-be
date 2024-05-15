<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection,  WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('employees')
            ->select(DB::raw("nama, nomor, jabatan, departmen, tanggal_masuk, foto, status"))
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama', 'Nomor', 'Jabatan', 'Departmen', 'Tanggal Masuk', 'Foto', 'Status'
        ];
    }
}
