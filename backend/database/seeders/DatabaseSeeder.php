<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus semua data dari tabel sebelum memasukkan data baru
        Student::truncate();

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Student::insert([
        //     [
        //         'nama' => 'Muhammad Jidan',
        //         'email' => 'muhammadjidan+contoh@gmail.com',
        //         'tanggal_lahir' => '2005-02-05',
        //         'jenis_kelamin' => 'Laki-Laki',
        //         'kelas' => 'Enam',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'nama' => 'Rafeyfa Zulfiyani',
        //         'email' => 'rafeyfazulfiyani+contoh@gmail.com',
        //         'tanggal_lahir' => '2005-07-19',
        //         'jenis_kelamin' => 'Perempuan',
        //         'kelas' => 'Enam',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'nama' => 'Nadia Larasati Aziz',
        //         'email' => 'nadia+contoh@gmail.com',
        //         'tanggal_lahir' => '2005-07-15',
        //         'jenis_kelamin' => 'Perempuan',
        //         'kelas' => 'Enam',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'nama' => 'Salwa Mufidah',
        //         'email' => 'salwa+contoh@gmail.com',
        //         'tanggal_lahir' => '2006-10-08',
        //         'jenis_kelamin' => 'Perempuan',
        //         'kelas' => 'Enam',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);

        Student::factory(15)->create();
    }
}
