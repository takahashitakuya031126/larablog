<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminBlogController extends Controller
{
    public function form()
    {
        return view('admin_blog.form');
    }
}
