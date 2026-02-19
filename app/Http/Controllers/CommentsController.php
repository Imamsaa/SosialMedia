<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    public function __construct()
    {
        // kode yang dijalankan setiap controller dipanggil
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
            'user_id' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => $request->user_id,
            'content' => $request->content
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment created successfully',
            'data' => $comment
        ], 201);
    }
}
