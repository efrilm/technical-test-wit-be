<?php

namespace App\Http\Controllers\Api\v1;

use App\Exports\EmployeeExport;
use App\Http\Controllers\Controller;
use App\Imports\EmployeeImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportImportController extends Controller
{

    public function exportPdf()
    {
        return Excel::download(new EmployeeExport, 'data-karyawan.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function exportExcel()
    {
        return Excel::download(new EmployeeExport, 'data-karyawan.xlsx');
    }

    public function importExcel(Request $request): JsonResponse
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');
        $nama_file = rand() . $file->getClientOriginalName();
        $file->move('imports', $nama_file);

        Excel::import(new EmployeeImport, public_path('/imports/' . $nama_file));
        return response()->json([
            'success' => true,
            'message' => 'Success'
        ]);
    }
}
