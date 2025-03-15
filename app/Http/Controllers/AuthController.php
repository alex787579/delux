<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = User::all();
        return view('UserList',['userList' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'signin_email' => 'required|email|max:50',
            // 'signin_password' => 'required|min:6',
        ]);
        
           // Find user by email
        $user = User::where('email', trim($request->signin_email))
        ->where('is_active', 1)
        ->first();

        if (!$user) {
        return back()->with('error', 'Invalid email or account is inactive.');
        }
        $request->session()->put('UserRole', $user->role);
        $request->session()->put('EMPID', $user->id);
        $request->session()->put('Email', $user->email);
        $request->session()->put('CustomerCode', $user->CustomerCode);
        $request->session()->put('EMP_NAME', ucfirst($user->name));

        return redirect('/')->with('success', 'Login successful!');
 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout()
    {
        return redirect('/login'); // Redirect to the login page
    }
}
