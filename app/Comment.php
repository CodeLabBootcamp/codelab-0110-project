<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ["text", "user_id", "post_id"];
//    protected $with = ["user"];

    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    public function post()
    {
        return $this->belongsTo(Post::Class);
    }
}
