$("#main").validate({

    rules: {
        name: {
            required: true,
            rangelength: [3, 64]
        },
        module: {
            maxlength: 64
        },
        page: "digits",
        image: {
            maxlength: 192
        },
        about: {
            maxlength: 192
        }
    },

    messages: {
        name: {
            required: "Название меню обязательно для заполнения",
            rangelength: "Длина названия меню не может быть менее 3 и не более 64 символов"
        },
        page: {
            digits: "Страница может содержать только цифры"
        },
        module: {
            maxlength: "Модуль не может быть более 64 символов"
        },
        image: {
            maxlength: "Картинка не может быть более 192 символов"
        },
        about: {
            maxlength: "Информация не может быть более 64 символов"
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
            url: "/modules/menu_add/",
            cache: false,
            dataType: 'json',
            data: $("#main").serialize(),
            success: success_edit,
            complete: $('#main').removeClass("ui-disabled").trigger('updatelayout')
        });

    }

});