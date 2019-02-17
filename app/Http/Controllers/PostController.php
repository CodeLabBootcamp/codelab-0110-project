<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class PostController extends Controller
{
    public function createNewPost(Request $request)
    {
        $rules = [
            "text" => "required"
        ];

        $data = $this->validate($request, $rules);

        // TODO: Remove this and use logged in user
        $data["user_id"] = auth()->id();
        $data["type"] = "text";

        $post = Post::create($data);

        $response = [
            "success" => true,
            "post" => $post
        ];
        return Response::json($response);
    }

    public function getAllPosts()
    {
        $posts = Post::orderBy("created_at","desc")->with("user:id,name,image")->get();
        $response = [
            "success" => true,
            "posts" => $posts
        ];
        return Response::json($response);

    }
}
