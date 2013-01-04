$('#page_profile').bind('pageshow', function () {

    $("#about").validate({
        
        rules: {
            about: {
                maxlength: 255
            }
        },

        messages: {
            about: {
                maxlength: "Информация о себе не может быть более 255 символов"
            }
        },

        errorPlacement: function(error, element) {
            error.insertAfter("#" +element.attr("name")+"_error");
        },
        onkeyup: false
        
    });
    
    $("#settings").validate({
        
        rules: {
            password: {
                rangelength: [6, 32]
            },
            mail: {
                email: true
            }
        },

        messages: {
            password: {
                rangelength: "Длина пароля не может быть менее 6 и не более 32 символов"
            },
            mail: {
                email: "Почтовый ящик введен неверно"
            }
        },

        errorPlacement: function(error, element) {
            error.insertAfter("#" +element.attr("name")+"_error");
        },
        onkeyup: false
        
    });

    $("#main").validate({

        rules: {
            lastname: {
                maxlength: 32
            },
            firstname: {
                maxlength: 32
            },
            birthday: "date_format",
            sex: {
                min: 1,
                max: 2
            },
            city: {
                maxlength: 64
            }
        },

        messages: {
            lastname: {
                maxlength: "Фамилия не может быть более 32-х символов"
            },
            firstname: {
                maxlength: "Имя не может быть более 32-х символов"
            },
            sex: {
                min: "Неверено выбран пол.",
                max: "Неверено выбран пол."
            },
            city: {
                maxlength: "Город не может быть более 64-х символов"
            }
        },

        errorPlacement: function(error, element) {
            $("#" +element.attr("name")+"_error").show();
            error.insertAfter("#" +element.attr("name")+"_error");
        },
        onkeyup: false

    });
    
        $("#contacts").validate({

        rules: {
            phone: {
                phone: true
            },
            skype: {
                maxlength: 32
            },
            icq: {
                maxlength: 9,
                digits: true
            },
            twitter: {
                maxlength: 32
            },
            vk: {
                maxlength: 32
            },
            facebook: {
                maxlength: 32
            },
            site: "url"
        },

        messages: {
            skype: {
                maxlength: "Skype не может быть более 32-х сиволов"
            },
            icq: {
                maxlength: "ICQ не может быть более 9-и символов",
                digits: "ICQ может содержать только цифры"
            },
            twitter: {
                maxlength: "Twitter не может быть более 32-х сиволов"
            },
            vk: {
                maxlength: "Вконтакте не может быть более 32-х сиволов"
            },
            facebook: {
                maxlength: "Facebook не может быть более 32-х сиволов"
            },
            site: {
                url: "Адрес сайта введен неверно (пример: http://domain.com)"
            }
        },

        errorPlacement: function(error, element) {
            error.insertAfter("#" +element.attr("name")+"_error");
        },
        onkeyup: false

    });

});