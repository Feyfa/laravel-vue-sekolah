<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToCollection, WithHeadingRow
{
    // /**
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */
    // public function model(array $row)
    // {
    //     return new Student([
    //         'nama' => $row[0],
    //         'email' => $row[1],
    //         'tanggal_lahir' => $row[2],
    //         'jenis_kelamin' => $row[3],
    //         'kelas' => $row[4],
    //     ]);
    // }

    public function collection(Collection $rows)
    {
        foreach($rows as $row)
        {
            $countEmailDuplicate = Student::where('email', $row['email'])
                                          ->count();

            if(!$countEmailDuplicate)                
                Student::create([
                    'nama' => $row['nama'],
                    'email' => $row['email'],
                    'tanggal_lahir' => $row['tanggal_lahir'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'kelas' => $row['kelas'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
        }
    }
}
