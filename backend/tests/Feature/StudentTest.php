<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentTest extends TestCase
{
    /**
     * test ini digunakan untuk mendapatkan semua data students
     */
    public function testIndex()
    {
        $this->get('/api/students')
             ->assertStatus(200)
             ->assertSeeText('students')
             ->assertSeeText('id')
             ->assertSeeText('nama')
             ->assertSeeText('email')
             ->assertSeeText('tanggal_lahir')
             ->assertSeeText('jenis_kelamin')
             ->assertSeeText('kelas')
             ->assertSeeText('created_at')
             ->assertSeeText('updated_at');
    }

    /**
     * test ini digunakan untuk menambahkan data student
     */
    public function testStore()
    {
        $student = [
            'nama' => 'Bima Ramadhan',
            'email' => 'bima+contoh@gmail.com',
            'tanggal_lahir' => '2005-06-20',
            'jenis_kelamin' => 'Laki-Laki',
            'kelas' => 'Empat'
        ];

        $this->post('/api/students', $student)
             ->assertStatus(200)
             ->assertJson([
                'status' => 200, 
                'message' => 'Student Add Successfully'
             ]);
    }

    /**
     * test ini digunakan untuk mendapatkan student bedasarkan id
     */
    public function testShow()
    {
        $this->get('/api/students/1')
             ->assertStatus(200)
             ->assertSeeText('student')
             ->assertSeeText('id')
             ->assertSeeText('nama')
             ->assertSeeText('email')
             ->assertSeeText('tanggal_lahir')
             ->assertSeeText('jenis_kelamin')
             ->assertSeeText('kelas')
             ->assertSeeText('created_at')
             ->assertSeeText('updated_at');
    }

    /**
     * test ini digunakan untuk mendapatkan student bedasarkan id yang tidak ada di database
     */
    public function testShowIdNotFound()
    {
        $this->get('/api/students/1111')
             ->assertStatus(404)
             ->assertJson([
                "status" => 404,
                "message" => "Student Not Fond"
             ]);
    }

    /**
     * test ini digunakan untuk update student
     */
    public function testUpdate()
    {
        $student = [
            'nama' => 'Grandis Tenar',
            'email' => 'grandis@gmail.com',
            'tanggal_lahir' => '2005-11-15',
            'jenis_kelamin' => 'Perempuan',
            'kelas' => 'Enam'
        ];

        $this->put('/api/students/1', $student)
             ->assertStatus(200)
             ->assertJson([
                "status" => 200,
                "message" => "Student Update Successfully"
             ]);
    }

    /**
     * test ini digunakan untuk update student, tetapi id nya tidak terdaftar di database
     */
    public function testUpdateIdNotFound()
    {
        $student = [
            'nama' => 'Grandis Tenar',
            'email' => 'grandis@gmail.com',
            'tanggal_lahir' => '2005-11-15',
            'jenis_kelamin' => 'Perempuan',
            'kelas' => 'Enam'
        ];

        $this->put('/api/students/1111', $student)
             ->assertStatus(404)
             ->assertJson([
                "status" => 404,
                "message" => "Student Not Fond"
             ]);
    }

    /**
     * test ini digunakan untuk update murid, tetapi saat melakukan perubahan nama, namanya kosong
     */
    public function testUpdateNameNotRequired()
    {
        $student = [
            'email' => 'grandis@gmail.com',
            'tanggal_lahir' => '2005-11-15',
            'jenis_kelamin' => 'Perempuan',
            'kelas' => 'Enam'
        ];

        $this->put('/api/students/1', $student)
             ->assertStatus(422);
    }

    /**
     * test ini digunakan untuk menghapus student, bedasarkan id nya
     */
    public function testDelete()
    {
        $this->delete('/api/students/1')
             ->assertStatus(200)
             ->assertJson([
                "status" => 200,
                "message" => "Student Delete Successfully"
             ]);
    }

    /**
     * test ini digunakan untuk menghapus student, tetapi id nya tidak terdaftar di database
     */
    public function testDeleteIdNotFound()
    {
        $this->delete('/api/students/1111')
        ->assertStatus(404)
        ->assertJson([
           "status" => 404,
           "message" => "Student Not Fond",
        ]);
    }
}
