<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\AuthenticateUserRequest;
use App\Http\Requests\LogoutUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\File;
use Exception;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class AuthUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $storeData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'birthdate' => 'required'
        ]);

        User::create([
            'name' => $storeData['name'],
            'email' => $storeData['email'],
            'password' => $storeData['password'],
            'birthdate' => $storeData['birthdate']
        ]);

        return response(200);
    }

    public function authenticate(Request $request): JsonResponse
    {
        $loginData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:8'
        ]);

        $user = User::where('email', $loginData['email'])->first();

        if (!$user || !Hash::check($loginData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        return response()->json([
            'username' => $user->name,
            'token' => $token
        ]);
    }

    public function logout(Request $request): Response
    {
        $request->user()->tokens()->delete();

        return response(200);
    }

    /**
     * Display the specified resource.
     */
    public function fetchUser(Request $request): JsonResponse
    {
        $user = User::where('name', $request->username)->first();

        $followers = $user->followers()->get();
        $isFollowed = false;

        foreach ($followers as $follower) {
            ($follower->follower_id == $request->user()->user_id) ? $isFollowed = true : $isFollowed = false;
        }

        ($user->user_id == $request->user()->user_id) ? $isAuth = true : $isAuth = false;

        return response()->json([
            'user' => $user,
            'isAuth' => $isAuth,
            'isFollowed' => $isFollowed
        ]);
    }

    public function fetchProfilePicture(Request $request): BinaryFileResponse
    {
        return response()->file('pfp/' . $request->url);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function searchUser(Request $request): JsonResponse
    {
        $users = User::select('name')->where('name', 'LIKE', '%' . $request->username . '%')->get();

        return response()->json([
            'results' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): JsonResponse
    {
        $updateData = $request->validate([
            'name' => 'string',
            'bio' => 'string',
            'pfp' => 'image|mimes:jpeg,jpg,png,svg,webp|max:2048'
        ]);

        if ($request->hasFile('pfp')) {
            $pfp_image = $request->file('pfp')->store('pfp');
        }

        $user = $request->user();

        $user->update([
            'name' => $updateData['name'],
            'pfp' => $pfp_image ?? null,
            'bio' => $updateData['bio'] ?? null
        ]);

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
