$("#licence_add").validate({

    rules: {
        name: {
            required: true,
            rangelength: [3, 32],
            language: true,
            symbols: true,
            remote: "/modules/validate_username/?licence"
        },
        domain: {
            required: true,
            url: true
        }
    },

    messages: {
        name: {
            required: "Пожалуйста, введите имя пользователя",
            rangelength: "Длина имени пользователя не может быть менее 3 и не более 32 символов",
            remote: "Имя пользователя не найдено"
        },
        domain: {
            required: "Пожалуйста, введите доменное имя",
            url: "Доменное имя введено неверно"
        }
    },

    errorPlacement: function(error, element) {
        $("#" +element.attr("name")+"_error").show();
        error.insertAfter("#" +element.attr("name")+"_error");
    },
    onkeyup: false

});