@extends('admin_blog.app')

@section('title', 'カテゴリー一覧')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="border-bottom py-2 mb-4">カテゴリー一覧</h2>
                <br>

                @if (count($list) > 0)
                    <br>
                    {{ $list->links() }}
                    <table class="table table-striped">
                        <tr>
                            <th width="120px">カテゴリ番号</th>
                            <th>カテゴリ名</th>
                            <th width="60px">表示順</th>
                        </tr>

                        @foreach ($list as $category)
                            <tr data-category_id="{{ $category->category_id }}">
                                <td>
                                    <span class="category_id">{{ $category->category_id }}</span>
                                </td>
                                <td>
                                    <span class="name">{{ $category->name }}</span>
                                </td>
                                <td>
                                    <span class="display_order">{{ $category->display_order }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <br>
                    <p>カテゴリーがありません。</p>
                @endif

            </div>
        </div>
    </div>
@endsection