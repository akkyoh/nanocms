function show_result(responseText){
        
    if(responseText == 'true')
        $(".ui-dialog").dialog("close");
    else
        alert_message('Ошибка при авторизации. Проверьте правильность введеных данных (имя пользователя или почтовый ящик, пароль).<br>Для входа на сайт требуется разрешение использования Cookie.', 'information', 5);
        
}

$('#dialog_login').on('click', '#submit', function(){

    $('#submit').parent().addClass("ui-disabled");

    $.ajax({
        type: "POST",
        url: "/modules/enter/",
        cache: false,
        dataType: 'json',
        data: $("#login").serialize(),
        success: show_result,
        complete: $('#submit').parent().removeClass("ui-disabled")
    });

    return false;
    
});