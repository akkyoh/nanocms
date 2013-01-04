$("#registration").validate({

    rules: {
        name: {
            required: true,
            rangelength: [3, 32],
            language: true,
            symbols: true,
            remote: "/modules/validate_username/"
        },
        password: {
            required: true,
            rangelength: [6, 32]
        },
        mail: {
            email: true,
            remote: "/modules/validate_mail/"
        }
    },

    messages: {
        name: {
            required: "Пожалуйста, введите имя пользователя",
            rangelength: "Длина имени пользователя не может быть менее 3 и не более 32 символов",
            remote: "Имя пользователя занято"
        },
        password: {
            required: "Пожалуйста, введите пароль",
            rangelength: "Длина пароля не может быть менее 6 и не более 32 символов"
        },
        mail: {
            required: "Пожалуйста, введите почтовый ящик",
            email: "Почтовый ящик введен неверно",
            remote: "Почтовый ящик уже используется"
        }
    },

    errorPlacement: function(error, element) {
        $("#" +element.attr("name")+"_error").show();
        error.insertAfter("#" +element.attr("name")+"_error");
    },
    onkeyup: false,
    submitHandler: function(){
        
        $('#registration').addClass("ui-disabled").trigger( 'updatelayout' );
        
        $.ajax({
            type: "POST",
            url: "/modules/registration_confirm/",
            cache: false,
            dataType: 'json',
            data: $("#registration").serialize(),
            success: show_result,
            complete: $('#registration').removeClass("ui-disabled").trigger('updatelayout')
        });
        
    }

});