<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminBlogRequest;
use App\Article;
use App\Category;

class AdminBlogController extends Controller
{
    protected $article;
    protected $category;
    
    const NUM_PER_PAGE = 10;
    
    function __construct(Article $article, Category $category)
    {
        $this->article = $article;
        $this->category = $category;
    }
    
    public function list()
    {
        $list = $this->article->getArticleList(self::NUM_PER_PAGE);
        return view('admin_blog.list', compact('list'));
    }
    
    public function form(int $article_id = null)
    {
        $article = $this->article->find($article_id);
        
        $input = [];
        if ($article) {
            $input = $article->toArray();
            $input['post_date'] = $article->post_date_text;
        } else {
            $article_id = null;
        }
        
        $input = array_merge($input, old());
        
        $category_list = $this->category->getCategoryList()->pluck('name', 'category_id');
        
        return view('admin_blog.form', compact('input', 'article_id', 'category_list'));
    }
    
    public function post(AdminBlogRequest $request)
    {
        $input = $request->input();
        
        $article_id = array_get($input, 'article_id');

        $article = $this->article->updateOrCreate(compact('article_id'), $input);

        return redirect()
            ->route('admin_form', ['article_id' => $article->article_id])
            ->with('message', '記事を保存しました');
    }
    
    public function delete(AdminBlogRequest $request)
    {
        $article_id = $request->input('article_id');

        $result = $this->article->destroy($article_id);
        $message = ($result) ? '記事を削除しました' : '記事の削除に失敗しました。';

        return redirect()->route('admin_list')->with('message', $message);
    }
    
    public function category()
    {
        $list = $this->category->getCategoryList(self::NUM_PER_PAGE);
        return view('admin_blog.category', compact('list'));
    }
    
    public function editCategory(AdminBlogRequest $request)
    {
        $input = $request->input();
        $category_id = $request->input('category_id');

        $category = $this->category->updateOrCreate(compact('category_id'), $input);

        return response()->json($category);
    }
    
    public function deleteCategory(AdminBlogRequest $request)
    {
        $category_id = $request->input('category_id');
        $this->category->destroy($category_id);

        return response()->json();
    }
}
