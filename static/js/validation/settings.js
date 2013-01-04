$('#page_settings').bind('pageshow', function () {

    $("#main").validate({

        rules: {
            password: {
                rangelength: [6, 32]
            },
            mail: {
                email: true
            },
            timezone: {
                required: true,
                min: 1,
                max: 33
            },
            c_elements: {
                required: true,
                accept: "5|10|15|20|25|30"
            }
        },

        messages: {
            password: {
                rangelength: "Длина пароля не может быть менее 6 и не более 32 символов"
            },
            mail: {
                email: "Почтовый ящик введен неверно"
            },
            timezone: {
                required: "Выбор часового пояса обязателен",
                min: "Неверно выбран часовой пояс",
                max: "Неверно выбран часовой пояс"
            },
            c_elements: {
                required: "Выбор количества отображаемых элементов обязателен",
                accept: "Неверено выбрано количество отображаемых элементов"
            }
        },

        errorPlacement: function(error, element) {
            $("#" +element.attr("name")+"_error").show();
            error.insertAfter("#" +element.attr("name")+"_error");
        },
        onkeyup: false

    });

});