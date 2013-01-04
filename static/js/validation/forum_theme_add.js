$("#main").validate({

    rules: {
        name: {
            required: true,
            rangelength: [3, 128]
        },
        text: {
            required: true,
            rangelength: [3, 10240]
        }
    },

    messages: {
        name: {
            required: "Название обязательно для заполнения",
            rangelength: "Длина названия не может быть менее 3 и не более 128 символов"
        },
        text: {
            required: "Сообщение обязательно для заполнения",
            rangelength: "Длина сообщения не может быть менее 3 и не более 10240 символов"
        }
    },

    errorPlacement: function(error, element) {
        $("#" +element.attr("name")+"_error").show();
        error.insertAfter("#" +element.attr("name")+"_error");
    },
    onkeyup: false,
    submitHandler: function(){
        
        $('#submit').parent().addClass("ui-disabled");
        
        $.ajax({
            type: "POST",
            url: "/modules/forum_theme_add/?id="+$('#main').attr('data-category'),
            cache: false,
            dataType: 'json',
            data: $("#main").serialize(),
            success: success_add,
            complete: $('#submit').parent().removeClass("ui-disabled")
        });

    }

});