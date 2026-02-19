<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Validator;

class LikesController extends Controller
{
    public function __construct()
    {
        // kode yang dijalankan setiap controller dipanggil
    }

    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'post_id' => 'required',
            'user_id' => 'required'
        ]);

        if ($validador->fails()){
            return response()->json([
                'success' => false,
                'message' => $validador->errors()
            ], 400);
        }

        $like = Like::create([
            'post_id' => $request->post_id,
            'user_id' => $request->user_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Like created successfully',
            'data' => $like
        ], 201);
    }

    public function destroy($id)
    {
        
    }
}
