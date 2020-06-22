@extends('front_blog.app')

@section('title', 'LaraBlog')

@section('main')
    <div class="col-md-8 col-md-offset-1 mt-3">
        @forelse($list as $article)
            <div class="card rounded-0">
                <div class="card-body bg-primary text-light">
                    <h3 class="card-title">{{ $article->post_date->format('Y/m/d(D)') }}　{{ $article->title }}</h3>
                </div>
                <div class="card-body">
                    {!! nl2br(e($article->body)) !!}
                </div>
                <div class="card-body text-right bg-primary text-light">
                    {{ $article->updated_at->format('Y/m/d H:i:s') }}
                </div>
            </div>
        @empty
            <p>記事がありません</p>
        @endforelse

        {{ $list->links() }}
    </div>
@endsection