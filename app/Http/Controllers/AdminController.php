<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function users()
    {
        $users = User::with('role')->selection()->where('role_id', '=', '2')->get();
        return response()->json($users);
    }


    public function addAdmin(Request $request)
    {
        $existing = [];
        $notExisting = [];
        $user = new User();
        if (empty($request->all())) return 'error';
        foreach ($request->all() as $single) {
            $checkedUser = $user->where('email', '=', $single['email'])->get();
            if (count($checkedUser) > 0) {
                $existing[] = $single;
                DB::table('users')
                    ->where('email', $single['email'])
                    ->update([
                        'role_id' => 1,
                    ]);
            } else {
                $notExisting[] = $single;
                $validator = Validator::make($single, [
                    'name' => 'required|string|between:2,100',
                    'age' => 'nullable|integer',
                    'email' => 'required|string|email|max:100|unique:users',
                    'password' => 'required|string|min:6',
                ]);
                if ($validator->fails()) {
                    return response()->json($validator->errors()->toJson(), 400);
                }

                $new_user = DB::table('users')->insert(array_merge($validator->validated(), [
                    'password' => bcrypt($single['password']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'process successfully',
            'dataExisting' => $existing ,
            'datNotExisting' =>$notExisting
        ]);
    }

}
