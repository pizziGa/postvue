<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $storeData = $request->validate([
            'media' => 'file|mimes:jpeg,jpg,png,svg,webp,mp4',
            'content' => 'string|required'
        ]);

        $post = new Post();

        $ext = $request->file('media')->getMimeType();

        if ($ext == 'video/mp4') {
            $media = $request->file('media')->store('posts_vids', ["disk" => "s3", "visibility" => "public"]);
            $post->type = 'video';
        } else {
            $media = $request->file('media')->store('posts_img', ["disk" => "s3", "visibility" => "public"]);
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

        return (bool)$like;
    }

    /**
     * Display the specified resource.
     */
    public function fetchProfilePosts(Request $request): JsonResponse
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
            $post->media = Storage::disk('s3')->url($post->media);
        }

        return response()->json([
            'posts' => $posts
        ]);
    }

//    public function fetchPostMedia(Request $request)
//    {
//        $mediaType = $request->mediaType == 'posts_img' ? 'posts_img/' : 'posts_vids/';
//        Storage::url('file.jpg');
//        return response()->file($mediaType . $request->url);
//    }

    public function fetchExplorePosts(Request $request): JsonResponse
    {
        $posts = Post::orderByDesc('created_at')->get();

        foreach ($posts as $post) {
            $post->isLiked = $this->checkLike($request->user(), $post);
            $post->author = User::where('user_id', $post->user_id)->first()->only(['name']);
            $comments = $post->comments()->orderByDesc('created_at')->get();
            foreach ($comments as $comment) {
                $comment->author = User::where('user_id', $comment->user_id)->first()->only(['name']);
            }
            $post->comments = $comments;
            $post->media = Storage::disk('s3')->url($post->media);
        }

        return response()->json([
            'posts' => $posts
        ]);
    }

    public function fetchFollowingPosts(Request $request): JsonResponse
    {
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
            $post->media = Storage::disk('s3')->url($post->media);
        }

        return response()->json([
            'posts' => $posts
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): JsonResponse
    {
        $post = Post::find($request->id);

        if ($request->isLiked) {
            $post->increment('likes');
            $like = new Like();
            $like->post_id = $post->post_id;
            $like->user_id = $request->user()->user_id;
            $like->save();
        } else {
            $post->decrement('likes');
            Like::where('user_id', $request->user()->user_id)->where('post_id', $post->post_id)->delete();
        }

        return response()->json([
            'isLiked' => $request->isLiked
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
