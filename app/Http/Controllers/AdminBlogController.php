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
        
        return view('admin_blog.form', compact('input', 'article_id'));
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

        return redirect()->route('admin_form')->with('message', $message);
    }
}
