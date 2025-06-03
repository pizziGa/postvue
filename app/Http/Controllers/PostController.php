<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
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
    public function store(StorePostRequest $request): Response
    {
        $storeData = $request->validated();

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
    public function fetchProfilePosts(Request $request, string $username): JsonResponse
    {
        $user = User::where('name', $username)->first();
        $posts = $user->posts()->orderBy('created_at', 'desc')->get();

        $this->sortPosts($request, $posts);

        return response()->json($posts);
    }

    public function fetchExplorePosts(Request $request): JsonResponse
    {
        $posts = Post::orderByDesc('created_at')->get();

        $this->sortPosts($request, $posts);

        return response()->json($posts);
    }

    public function fetchFollowingPosts(Request $request): JsonResponse
    {
        $following = $request->user()->following()->get();

        $posts = new Collection();

        foreach ($following as $followed) {
            $user = User::where('user_id', $followed->followed_id)->first();
            $posts = $posts->merge($user->posts()->orderBy('created_at', 'desc')->get());
        }

        $this->sortPosts($request, $posts);

        return response()->json($posts);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $post_id): Response
    {
        $post = Post::find($post_id);
        $isLiked = $request->query('isLiked');

        if ($isLiked == 'true') {
            $post->increment('likes');
            $like = new Like();
            $like->post_id = $post->post_id;
            $like->user_id = $request->user()->user_id;
            $like->save();
        } else {
            $post->decrement('likes');
            Like::where('user_id', $request->user()->user_id)->where('post_id', $post->post_id)->delete();
        }

        return response(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post): Response
    {
        $post = $post->find($request->id);
        Storage::disk('s3')->delete(''.$post->media);
        $post->likes()->delete();
        $post->comments()->delete();
        $post->delete();

        return response(200);
    }

    private function sortPosts(Request $request, Collection $posts): void
    {
        foreach ($posts as $post) {
            $post->isLiked = $this->checkLike($request->user(), $post);
            $post->author = User::where('user_id', $post->user_id)->first()->only(['name']);
            $post->media = Storage::disk('s3')->url($post->media);
        }
    }
}
