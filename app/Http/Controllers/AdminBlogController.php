<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminBlogRequest;
use App\Article;

class AdminBlogController extends Controller
{
    protected $article;
    
    function __construct(Article $article)
    {
        $this->article = $article;
    }
    
    public function form()
    {
        return view('admin_blog.form');
    }
    
    public function post(AdminBlogRequest $request)
    {
        $input = $request->input();

        $article = $this->article->create($input);

        return redirect()->route('admin_form')->with('message', '記事を保存しました');
    }
}
