<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();

        return ($students->count() > 0) ?
               response()->json(['status' => 200, 'students' => $students], 200) : 
               response()->json(['status' => 404, 'message' => 'Student Not Found'], 404) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'string'],
            'email' => ['required', 'email'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'string', 'in:Laki-Laki,Perempuan'],
            'kelas' => ['required', 'string', 'in:Satu,Dua,Tiga,Empat,Lima,Enam'],
        ]);

        if($validator->fails())
            return response()->json(['status' => 422, 'message' => $validator->messages()], 422);

        $students = Student::create($validator->validate());

        return $students ?
               response()->json(['status' => 200, 'message'=> 'Student Add Successfully'], 200) : 
               response()->json(['status' => 500, 'message' => 'Something Went Error'], 500) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::where('id', $id)
                       ->first();

        return ($student) ? 
               response()->json(['status' => 200, 'student' => $student], 200) : 
               response()->json(['status' => 404, 'message' => 'Student Not Fond'], 404) ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::where('id', $id)
                       ->first();

        if(!$student)
            return response()->json(['status' => 404, 'message' => 'Student Not Fond'], 404);

        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'string'],
            'email' => ['required', 'email'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'string', 'in:Laki-Laki,Perempuan'],
            'kelas' => ['required', 'string', 'in:Satu,Dua,Tiga,Empat,Lima,Enam'],
        ]);

        
        if($validator->fails())
            return response()->json(['status' => 422, 'message' => $validator->messages()], 422);
        
        $result = $student->update($validator->validate());

        return $result ?
               response()->json(['status' => 200, 'message' => 'Student Update Successfully']) : 
               response()->json(['status' => 500, 'message' => 'Something Went Error'], 500) ;
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy(string $id)
    {
        $student = Student::where('id', $id)
                       ->first();
    
        if(!$student)
            return response()->json(['status' => 404, 'message' => 'Student Not Fond'], 404);

        $result = $student->delete();

        return $result ?
               response()->json(['status' => 200, 'message' => 'Student Delete Successfully']) : 
               response()->json(['status' => 500, 'message' => 'Something Went Error'], 500) ;
    }
}
