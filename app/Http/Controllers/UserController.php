<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function profile($id)
    {
        $data = [
            "id" => $id

        ];
        return view('users.profile', $data);
    }

    public function posts($id)
    {


//        User::with("posts")->where('id','=',3)->get();
//        $user->load("posts");

        $response = [
            "success" => true,
            "user" => User::with("posts")->find($id)
        ];

        return Response::json($response);
    }


}
