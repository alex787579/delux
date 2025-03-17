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
            'signin_email' => 'required|max:50',
            // 'signin_password' => 'required|min:6',
        ]);
        
           // Find user by email
           $user = User::where(function ($query) use ($request) {
            $query->where('c_id', trim($request->signin_email))
                  ->orWhere('email', trim($request->signin_email))
                  ->orWhere('mobile', trim($request->signin_email));
        })
        ->where('status', 'Active')
        ->first();
    
        if (!$user) {
            return back()->with('error', 'Invalid credentials or account is inactive.');
        }
        
        $request->session()->put('role', $user->role);
        $request->session()->put('EMPID', $user->id);
        $request->session()->put('Email', $user->email);
        $request->session()->put('c_id', $user->c_id);
        $request->session()->put('EMP_NAME', ucfirst($user->name));
        
        return redirect('/order-trail')->with('success', 'Login successful!');
    
 
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

    public function getUsers(Request $request)
    {
        $search = $request->search;

        $users = User::where('c_id', 'LIKE', "%{$search}%")
        ->orWhere('c_name', 'LIKE', "%{$search}%")
        ->limit(10) // Limit results to 10 for performance
        ->get(['id', 'c_id', 'c_name']);

      

        return response()->json($users);
    }
}
