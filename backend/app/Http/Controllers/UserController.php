<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('id', $id)
                       ->first();

        return ($user) ? 
               response()->json(['status' => 200, 'user' => $user], 200) : 
               response()->json(['status' => 404, 'message' => 'User Not Fond'], 404) ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('id', $id)
                       ->first();

        if(!$user)
            return response()->json(['status' => 404, 'message' => 'User Not Fond'], 404);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);
        
        if($validator->fails())
            return response()->json(['status' => 422, 'message' => $validator->messages()], 422);
        
        $result = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mail_mailer' => $request->mail_mailer,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_username' => $request->email,
            'mail_from_address' => $request->email,
            'mail_from_name' => explode('@', $request->email)[0],
        ]);

        // $user = User::where('id', $id)
        //                ->first();

        return $result ?
               response()->json(['status' => 200, 'message' => 'User Update Successfully', 'user' => $user], 200) : 
               response()->json(['status' => 500, 'message' => 'Something Went Error'], 500) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
