<?php

namespace App\Http\Controllers;

use App\Http\Requests\FrontBlogRequest;
use App\Article;

class FrontBlogController extends Controller
{
    protected $article;
    
    const NUM_PER_PAGE = 10;
    
    function __construct(Article $article)
    {
        $this->article = $article;
    }
    
    function index(FrontBlogRequest $request)
    {
        $input = $request->input();
        
        $list = $this->article->getArticleList(self::NUM_PER_PAGE, $input);
        
        $list->appends($input);
        
        $month_list = $this->article->getMonthList();
        return view('front_blog.index', compact('list', 'month_list'));
    }
}
