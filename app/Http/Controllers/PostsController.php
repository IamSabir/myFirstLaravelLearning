<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function show() {
        $postid = 12;
        return view('posts', compact('postid', $postid));
       
    }
}


