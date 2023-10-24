<?php
namespace App\Http\Controllers;
use App\Models\Comment;
use Illuminate\Http\Request;
class CommentController extends Controller
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
    public function createComment(Request $request)
    {
        $comment = Comment::create([
            'review' => $request->review,
            'postId' => $request->postId,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'New comment created',
            'data' => [
            'comment' => $comment
            ]
        ]);
    }
}