<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'nama',
            'email',
            'tanggal_lahir',
            'jenis_kelamin',
            'kelas',
            'created_at',
            'updated_at',
        ];
    }
}
