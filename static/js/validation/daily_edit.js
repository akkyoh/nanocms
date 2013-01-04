$("#main").validate({

    rules: {
        topic: {
            required: true,
            rangelength: [3, 192]
        },
        text: {
            required: true,
            rangelength: [3, 10240]
        }
    },

    messages: {
        topic: {
            required: "Заголовок обязателен для заполнения",
            rangelength: "Длина заголовка не может быть менее 3 и не более 192 символов"
        },
        text: {
            required: "Текст обязателен для заполнения",
            rangelength: "Длина текста не может быть менее 3 и не более 10240 символов"
        }
    },

    errorPlacement: function(error, element) {
        $("#" +element.attr("name")+"_error").show();
        error.insertAfter("#" +element.attr("name")+"_error");
    },
    onkeyup: false,
    submitHandler: function(){
        
        $('#main').addClass("ui-disabled").trigger('updatelayout');
        
        $.ajax({
            type: "POST",
            url: "/modules/daily_edit/?id="+$('#main').attr('data-id'),
            cache: false,
            dataType: 'json',
            data: $("#main").serialize(),
            success: success_add,
            complete: $('#main').removeClass("ui-disabled").trigger('updatelayout')
        });

    }

});