
    $("#main").validate({

        rules: {
            name: {
                required: true,
                rangelength: [3, 64]
            },
            description: {
                maxlength: 512
            }
        },

        messages: {
            name: {
                required: "Имя категории обязательно для заполнения",
                rangelength: "Длина имени категории не может быть менее 3 и не более 64 символов"
            },
            description: {
                maxlength: "Описание категории не может быть более 512 символов"
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
                url: "/modules/forum_category_add/",
                cache: false,
                dataType: 'json',
                data: $("#main").serialize(),
                success: success_category,
                complete: $('#main').removeClass("ui-disabled").trigger('updatelayout')
            });

        }

    });