<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Postcontroller extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:posts',
            'content' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user_id = auth('api')->user()['id'];

        $post = Post::create(array_merge(
            $validator->validated(),
            ['user_id' => $user_id]
        ));

        return response()->json([
            'status' => 'success',
            'message' => 'Posted added successfully',
            'post' => $post,
        ]);
    }
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'content' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $post->where('id', '=', $id)->update($validator->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Posted Updated successfully',
            'post' => $post,
        ]);
    }
}
