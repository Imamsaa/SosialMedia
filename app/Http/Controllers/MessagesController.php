<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class MessagesController extends Controller
{
    public function __construct()
    {
        // kode yang dijalankan setiap controller dipanggil
    }

    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $validador = Validator::make($request->all(), [
            'receiver_id' => 'required',
            'message_content' => 'required'
        ]);

        if ($validador->fails()){
            return response()->json([
                'success' => false,
                'message' => $validador->errors()
            ], 400);
        }

        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'message_content' => $request->message_content
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message created successfully',
            'data' => $message
        ], 201);
    }

    public function show($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Message retrieved successfully',
            'data' => $message
        ]);
    }

    public function getMessages($id)
    {
        $messages = Message::where('receiver_id', $id)->get();

        if ($messages->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No messages found for this user'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Messages retrieved successfully',
            'data' => $messages
        ]);
    }

    public function destroy($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message not found'
            ], 404);
        }

        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully'
        ]);
    }
}
