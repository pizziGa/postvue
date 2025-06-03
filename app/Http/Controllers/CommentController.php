<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $post = Post::find($request->id);
        $comments = $post->comments()->get();

        foreach ($comments as $comment) {
            $comment->author = User::where('user_id', $comment->user_id)->select('name')->first();
        }
        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $storeData = $request->validate([
            'content' => 'string|required',
            'post_id' => 'integer|required',
        ]);

        $comment = new Comment();

        $comment->comment = $storeData['content'];
        $comment->user_id = $request->user()->user_id;
        $comment->post_id = $request->post_id;

        $comment->save();

        return response(200);
    }
}
