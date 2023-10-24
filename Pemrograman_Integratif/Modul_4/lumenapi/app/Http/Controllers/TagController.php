<?php
namespace App\Http\Controllers;
use App\Models\Tag;
use Illuminate\Http\Request;
class TagController extends Controller
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
    public function createTag(Request $request)
    {
        $tag = Tag::create([
            'name' => $request->name
        ]);
        return response()->json([
            'success' => true,
            'message' => 'New tag created',
            'data' => [
            'tag' => $tag
            ]
        ]);
    }
}