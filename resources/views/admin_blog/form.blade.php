@extends('admin_blog.app')

@section('title', 'ブログ記事投稿フォーム')

@section('body')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2 class="border-bottom py-2 mb-4">ブログ記事投稿・編集</h2>
            
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                <br>
            @endif
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin_post') }}">
                <div class="form-group">
                    <label>日付</label>
                    <input class="form-control w-auto" name="post_date" size="20" value="{{ $input['post_date'] or null }}" placeholder="日付を入力して下さい。">
                </div>

                <div class="form-group">
                    <label>タイトル</label>
                    <input class="form-control" name="title" value="{{ $input['title'] or null }}" placeholder="タイトルを入力して下さい。">
                </div>

                <div class="form-group">
                    <label>本文</label>
                    <textarea class="form-control" rows="15" name="body" placeholder="本文を入力してください。">{{ $input['body'] or null }}</textarea>
                </div>

                <input type="submit" class="btn btn-primary btn-sm" value="送信">
                <input type="hidden" name="article_id" value="{{ $article_id }}">
                {{ csrf_field() }}
            </form>
            
            @if ($article_id)
                <br>
                <form action="{{ route('admin_delete') }}" method="POST">
                    <input type="submit" class="btn btn-danger btn-sm" value="削除">
                    <input type="hidden" name="article_id" value="{{ $article_id }}">
                    {{ csrf_field() }}
                </form>
            @endif
        </div>
    </div>
</div>
@endsection