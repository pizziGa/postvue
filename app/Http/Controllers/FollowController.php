<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
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
