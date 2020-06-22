@extends('admin_blog.app')

@section('title', 'カテゴリー一覧')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="border-bottom py-2 mb-4">カテゴリー一覧</h2>
                
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#categoryModal">
                    登録
                </button>
                <br>

                @if (count($list) > 0)
                    <br>
                    
                    {{ $list->links() }}
                    <table class="table table-striped">
                        <tr>
                            <th width="120px">カテゴリ番号</th>
                            <th>カテゴリ名</th>
                            <th width="60px">表示順</th>
                            <th width="60px">編集</th>
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
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#categoryModal" data-category_id="{{ $category->category_id }}">編集</button>
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
    
    <div class="modal fade" id="categoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>×</span>
                    </button>
                    <h4 class="modal-title">カテゴリー編集</h4>
                </div>

                <div class="modal-body">
                    <div id="api_result" class="hidden"></div>

                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">カテゴリー名</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" placeholder="カテゴリー名">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">表示順</label>
                            <div class="col-sm-10">
                                <input type="text" name="display_order" size="20" class="form-control" placeholder="表示順">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    <button type="button" id="category_delete" class="btn btn-danger">削除</button>
                    <button type="button" id="category_submit" class="btn btn-primary">保存</button>
                    <input type="hidden" name="category_id">
                </div>

            </div>
        </div>
    </div>
@endsection