<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PostController extends Controller
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
        $storeData = $request->validate([
            'media'=>'file|mimes:jpeg,jpg,png,svg,webp,mp4',
            'content'=>'string|required'
        ]);

        $post = new Post();

        $ext = $request->file('media')->getMimeType();

        if ($ext == 'video/mp4') {
            $media = $request->file('media')->store('posts_vids');
            $post->type = 'video';
        } else {
            $media = $request->file('media')->store('posts_img');
            $post->type = 'image';
        }

        $post->media = $media;
        $post->content = $storeData['content'];
        $post->user_id = $request->user()->user_id;

        $post->save();

        return response(200);
    }

    /**
     * Check if a user has liked a post
     *
     * @param User $user
     * @param Post $post
     * @return boolean
     */
    public function checkLike(User $user, Post $post): bool
    {
        $like = Like::where('user_id', $user->user_id)
                    ->where('post_id', $post->post_id)
                    ->first();

        return ($like) ? true : false;
    }

    /**
     * Display the specified resource.
     */
    public function fetchProfilePosts(Request $request)
    {
        $user = User::where('name', $request->username)->first();
        $posts = $user->posts()->get();

        foreach ($posts as $post) {
            $post->isLiked = $this->checkLike($request->user(), $post);
            $post->author = User::where('user_id', $post->user_id)->first()->only(['name']);
            $post->comments = $post->comments()->orderByDesc('created_at')->get();
            foreach ($post->comments as $comment) { 
                $comment->author = User::where('user_id', $comment->user_id)->first()->only(['name']);
            }
        }
        
        return response()->json([
            'posts' => $posts
        ]); 
    }

    public function fetchPostMedia(Request $request)
    {
        $mediaType = $request->mediaType == 'posts_img' ? 'posts_img/' : 'posts_vids/';
        return response()->file($mediaType.$request->url);
    }

    public function fetchExplorePosts(Request $request) {
        $posts = Post::orderByDesc('created_at')->get();

        foreach ($posts as $post) {
            $post->isLiked = $this->checkLike($request->user(), $post);
            $post->author = User::where('user_id', $post->user_id)->first()->only(['name']);
            $comments = $post->comments()->orderByDesc('created_at')->get();
            foreach ($comments as $comment) { 
                $comment->author = User::where('user_id', $comment->user_id)->first()->only(['name']);
            }
            $post->comments = $comments;
        }
        
        return response()->json([
            'posts' => $posts
        ]); 
    }

    public function fetchFollowingPosts(Request $request) { 
        $following = $request->user()->following()->get();

        $posts = new Collection();

        foreach ($following as $followed) {
            $user = User::where('user_id', $followed->followed_id)->first();
            $posts = $posts->merge($user->posts()->get());
        }

        foreach ($posts as $post) {
            $post->isLiked = $this->checkLike($request->user(), $post);
            $post->author = User::where('user_id', $post->user_id)->first()->only(['name']);
            $comments = $post->comments()->orderByDesc('created_at')->get();
            foreach ($comments as $comment) { 
                $comment->author = User::where('user_id', $comment->user_id)->first()->only(['name']);
            }
            $post->comments = $comments;
        }

        return response()->json([
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post = Post::find($request->id);
        
        if ($request->isLiked == 'true') {
            $post->increment('likes');
            $like = new Like();
            $like->post_id = $post->post_id;
            $like->user_id = $request->user()->user_id;
            $like->save();
        } else {
            $post->decrement('likes');
            $like = Like::where('user_id', $request->user()->user_id)->where('post_id', $post->post_id)->delete();
        }
        
        return response()->json([
            'isLiked'=>$request->isLiked
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        $post->find($request->id)->delete();
    }
}
