$("#main").validate({

    rules: {
        title: {
            required: true,
            rangelength: [3, 248]
        },
        description: {
            maxlength: 248
        },
        keywords: {
            maxlength: 2048
        }
    },

    messages: {
        title: {
            required: "Заголовок обязателен для заполнения",
            rangelength: "Длина заголовка не может быть менее 3 и не более 248 символов"
        },
        description: {
            maxlength: "Длина описания не может быть более 248 символов"
        },
        keywords: {
            maxlength: "Длина ключевых слов не может быть более 2048 символов"
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
            url: "/modules/pages_add/?id="+$('#main').attr('data-id'),
            cache: false,
            dataType: 'json',
            data: $("#main").serialize(),
            success: success_add,
            complete: $('#main').removeClass("ui-disabled").trigger('updatelayout')
        });

    }

});