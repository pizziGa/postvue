<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\AuthenticateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->birthdate = $request->birthdate;
            $user->save();
            return response();
        } catch (Exception $ex) {
            return response()->json($ex);
        }   
    }

    public function authenticate(AuthenticateUserRequest $request) {
            if (auth()->attempt($request->only(['email', 'password']))) {
                $user = auth()->user();
                $token = $user->createToken('SECRET_KEY')->plainTextToken;
                return response()->json([
                    "token"=>$token
                ]);
            } else {
                return response(status: 401);
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
