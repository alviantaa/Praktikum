<?php
namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
class PostController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
    //
    }
    //
    public function createPost(Request $request)
    {
        $post = Post::create([
            'content' => $request->content,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'New post created',
            'data' => [
            'post' => $post
            ]
        ]);
    }
    public function getPostById(Request $request)
    {
        $post = Post::find($request->id);
        return response()->json([
            'success' => true,
            'message' => 'All post grabbed',
            'data' => [
            'post' => [
            'id' => $post->id,
            'content' => $post->content,
            'comments' => $post->comments,
            'tags' => $post->tags, //response tags
            ]
            ]
        ]);
    }
    public function addTag(Request $request)
    {
        $post = Post::find($request->id);
        $post->tags()->attach($request->tagId);
        return response()->json([
            'success' => true,
            'message' => 'Tag added to post',
        ]);
    }
}