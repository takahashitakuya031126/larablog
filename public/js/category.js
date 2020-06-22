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