<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>@yield('title')</title>
</head>

<body>
    @yield('body')
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>

<script>
    $(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('[data-toggle=modal]').on('click', function() {
        var target_category_id = $(this).attr('data-category_id');

        if (target_category_id) {
            var target_object = $('tr[data-category_id=' + target_category_id + ']');
            var target_value = {
                category_id   : target_category_id,
                name          : target_object.find('span.name').text(),
                display_order : target_object.find('span.display_order').text()
            };
            $('input[name=category_id]').val(target_value.category_id);
            $('input[name=name]').val(target_value.name);
            $('input[name=display_order]').val(target_value.display_order);
        }
    });

    $('#categoryModal').on('hidden.bs.modal', function() {
        $('#api_result').html('').removeClass().addClass('hidden');
        $('input[name=category_id]').val(null);
        $('input[name=name]').val(null);
        $('input[name=display_order]').val(null);
    });

    $('#category_submit').on('click', function() {
        var category_id = $('input[name=category_id]').val();
        category_id = (category_id) ? category_id : null;
        var data = {
            category_id   : category_id,
            name          : $('input[name=name]').val(),
            display_order : $('input[name=display_order]').val()
        };

        $.ajax({
            type : 'POST',
            url : 'category/edit',
            data : data

        }).done(function(data) {
            $('#api_result').html('<span>正常に処理が完了しました</span>')
                .removeClass()
                .addClass('alert alert-success show');
            location.reload();

        }).fail(function(data) {
            var error_message = '';
            $.each(data.responseJSON.errors, function(element, message_array) {
                $.each(message_array, function(index, message) {
                    error_message += message + '<br>';
                })
            });

            $('#api_result').html('<span>' + error_message + '</span>')
                .removeClass()
                .addClass('alert alert-danger show');
        });
    });

    $('#category_delete').on('click', function() {
        var data = {
            category_id : $('input[name=category_id]').val()
        };

        $.ajax({
            type : 'POST',
            url : 'category/delete',
            data : data

        }).done(function(data) {
            $('#api_result').html('<span>削除しました</span>')
                .removeClass()
                .addClass('alert alert-success show');
            location.reload();

        }).fail(function(data) {
            $('#api_result').html('<span>削除に失敗しました</span>')
                .removeClass()
                .addClass('alert alert-danger show');
        });
    });
});
</script>
</body>
</html>