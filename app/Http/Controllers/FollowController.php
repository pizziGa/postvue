<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
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
    public function store(Request $request)
    {
        $follow = new Follow();

        $follower = $request->user();
        $follower->increment('following');
        $followed = User::where('name', $request->followed)->first();
        $followed->increment('followers');
        $follow->followed_id = $followed->user_id;
        $follow->follower_id = $follower->user_id;

        $follow->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Follow $follow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Follow $follow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $followed = User::where('name', $request->followed)->first();
        $followed->decrement('followers');
        $request->user()->decrement('following');
        $follow = Follow::where('followed_id', $followed->user_id)
            ->where('follower_id', $request->user()->user_id)->first();
        $follow->delete();
    }
}
