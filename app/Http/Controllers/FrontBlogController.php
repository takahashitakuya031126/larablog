<?php

namespace App\Http\Controllers;

use App\Http\Requests\FrontBlogRequest;
use App\Article;
use App\Category;

class FrontBlogController extends Controller
{
    protected $article;
    
    protected $category;
    
    const NUM_PER_PAGE = 10;
    
    function __construct(Article $article, Category $category)
    {
        $this->article = $article;
        $this->category = $category;
    }
    
    function index(FrontBlogRequest $request)
    {
        $input = $request->input();
        
        $list = $this->article->getArticleList(self::NUM_PER_PAGE, $input);
        
        $list->appends($input);
        
        $category_list = $this->category->getCategoryList();
        
        $month_list = $this->article->getMonthList();
        
        return view('front_blog.index', compact('list', 'month_list', 'category_list'));
    }
}
