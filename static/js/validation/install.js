$("#install").validate({

    rules: {
        server: "required",
        database: "required",
        username: "required",
        password: "required",
        title: "required",
        name: {
            required: true,
            rangelength: [3, 32],
            language: true,
            symbols: true
        },
        user_password: {
            required: true,
            rangelength: [6, 32]
        },
        mail: {
            email: true,
        }
    },

    messages: {
        server: {
            required: "Пожалуйста, введите сервер для соединения с базой данных"
        },
        title: {
            required: "Пожалуйста, введите название сайта"
        },
        database: {
            required: "Пожалуйста, введите имя базы данных"
        },
        username: {
            required: "Пожалуйста, введите имя пользователя для соединения с базой данных"
        },
        user_password: {
            required: "Пожалуйста, введите пароль",
            rangelength: "Длина пароля не может быть менее 6 и не более 32 символов"
        },
        name: {
            required: "Пожалуйста, введите имя пользователя",
            rangelength: "Длина имени пользователя не может быть менее 3 и не более 32 символов"
        },
        password: {
            required: "Пожалуйста, введите пароль для соединения с базой данных"
        },
        mail: {
            email: "Почтовый ящик введен неверно"
        }
    },

    errorPlacement: function(error, element) {
        $("#" +element.attr("name")+"_error").show();
        error.insertAfter("#" +element.attr("name")+"_error");
    },
    onkeyup: false,
    submitHandler: function(){
        
        $('#install').addClass("ui-disabled").trigger( 'updatelayout' );
        
        $.ajax({
            type: "POST",
            url: "/modules/install/",
            cache: false,
            dataType: 'json',
            data: $("#install").serialize(),
            success: show_result,
            complete: $('#install').removeClass("ui-disabled")
        });
        
    }

});