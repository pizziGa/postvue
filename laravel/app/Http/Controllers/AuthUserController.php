<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\AuthenticateUserRequest;
use App\Http\Requests\LogoutUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Exception;
use Laravel\Sanctum\PersonalAccessToken;

class AuthUserController extends Controller
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
        $storeData = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8',
            'birthdate'=>'required'
        ]);
        
        $user = User::create([
            'name'=>$storeData['name'],
            'email'=>$storeData['email'],
            'password'=>$storeData['password'],
            'birthdate'=>$storeData['birthdate']
        ]);

        return response()->json([
            'message' => 'User created',
        ]);
    }

    public function authenticate(Request $request) {
        $loginData = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8'
        ]);

        $user = User::where('email', $loginData['email'])->first();

        if (!$user || !Hash::check($loginData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'message' => 'User logged in',
            'token' => $token
        ]);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json([
            'message'=>'User logged out'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'user'=>$user->only(['name', 'pfp', 'bio', 'followers', 'following'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $updateData = $request->validate([
            'name'=>'string',
            'bio'=>'string'
        ]);

        if($request->hasFile('pfp')) {
            $updateData['pfp'] = $request->file('pfp')->store('pfp', 'public');
        }

        $user = $request->user();

        $user->update(['name'=>$updateData['name'], 'pfp'=>$updateData['pfp'], 'bio'=>$updateData['bio']]);
        return response()->json(['User updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
