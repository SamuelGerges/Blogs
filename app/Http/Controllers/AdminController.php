<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class AdminController extends Controller
{
    public function getPostIsPending(Request $request)
    {
        $status = '';
        if ($request->query('status')) {
            $status = $request->query('status');
        }
        $post = Post::where('status', '=', $status)->get();
        return response()->json($post);
    }

    public function rejected(Request $request, $id)
    {
        if (!$post = Post::find($id))
            return response()->json([
                'status' => '404',
                'message' => 'Post is not Found'
            ]);
        if ($request->status !== $post->status) {
            $post->where('id', '=', $id)->update(['status' => $request->status]);
            $msg = "change Status is successfully";
        } else {
            $msg = "Post status is already {$request->status}";
        }
        return response()->json([
            'status' => '200',
            'message' => $msg
        ]);
    }

    public function deletePost($id)
    {
        if (!$post = Post::find($id))
            return response()->json([
                'status' => '404',
                'message' => 'Post is not Found'
            ]);
        $post->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Post is deleted'
        ]);

    }

    public function destroy($id)
    {
        if (!$post = Post::withTrashed()->find($id))       // withTrashed => return data with data trashed
            return response()->json([
                'status' => '404',
                'message' => 'Post is not Found'
            ]);
        if ($post->forceDelete()) {
            return response()->json([
                'status' => '200',
                'message' => 'Deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => '400',
                'message' => 'Deleted Failed'
            ]);
        }
    }

}
