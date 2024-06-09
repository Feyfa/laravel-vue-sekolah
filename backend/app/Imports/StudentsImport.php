<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithLimit;

class StudentsImport implements ToCollection, WithHeadingRow, WithLimit
{
    public function limit(): int
    {
        return 1000;
    }

    public function collection(Collection $rows)
    {
        $students = [];

        foreach($rows as $row)
        {
            $countEmailDuplicate = Student::where('email', $row['email'])
                                          ->count();

            if(!$countEmailDuplicate) 
                $students[] = [
                    'nama' => $row['nama'],
                    'email' => $row['email'],
                    'tanggal_lahir' => $row['tanggal_lahir'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'kelas' => $row['kelas'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
        }

        Student::insert($students);
    }
}
