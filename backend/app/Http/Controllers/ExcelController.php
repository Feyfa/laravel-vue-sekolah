<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new StudentsImport, $request->file('file')->getRealPath());
        return response()->json(['status' => 200, 'message'=> 'Import Add Successfully'], 200);
    }
}
