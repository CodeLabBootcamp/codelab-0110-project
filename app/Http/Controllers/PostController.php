<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class PostController extends Controller
{
    public function createNewPost(Request $request)
    {
        $rules = [
            "text" => "required",
            "media" => "array",
            "media.*" => "image"
        ];
        $data = $this->validate($request, $rules);
        $files = [];
        if ($request->has('media') && is_array($request->media)) {
            foreach ($request->media as $file) {
                $files[] = $file->store("uploads");
            }

            $data["media"] = $files;
        }


        // TODO: Remove this and use logged in user
        $data["user_id"] = auth()->id();
        $data["type"] = $request->has('media') ? "image" : "text";

        $post = Post::create($data);

        $response = [
            "success" => true,
            "post" => $post
        ];
        return Response::json($response);
    }

    public function getAllPosts()
    {
        $posts = Post::orderBy("created_at", "desc")->with("user:id,name,image", "comments", "comments.user")->get();
        $response = [
            "success" => true,
            "posts" => $posts
        ];
        return Response::json($response);

    }

    public function comment(Request $request, $postId)
    {
        $rules = [
            "text" => "required"
        ];
        $data = $this->validate($request, $rules);
        // Valid data
        $data["user_id"] = auth()->id();
        $data["post_id"] = $postId;
        $comment = Comment::create($data);

        $response = [
            "success" => true,
            "comment" => $comment
        ];

        return Response::json($response);

    }
}
