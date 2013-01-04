$("#page_lost_password").on('click', '#submit', function(){

    $('#main').addClass("ui-disabled").trigger('updatelayout');

    $.ajax({
        type: "POST",
        url: "/modules/lost_password/",
        cache: false,
        dataType: 'json',
        data: $("#main").serialize(),
        success: success_send,
        complete: $('#main').removeClass("ui-disabled").trigger('updatelayout')
    });

    return false;
});

function success_send(text){
        
    alert_message(text, 'information', 3);
        
    return true;
        
}