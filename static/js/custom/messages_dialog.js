var myInterval;
var n = 0;
var max_n = 0;
var message = 0;
var e = 10;

$('#page_messages_dialog').bind('pageshow', function () {
    
    e = parseInt($('#messages').attr('data-e'));
    
    $('#message_send').sisyphus({
        timeout: sisyphus_time
    });  
    
    u_messages(0, true);

    myInterval = setInterval(function(){
        u_messages(n, false);
    }, 10000);
    
});

$("#page_messages_dialog").on('taphold', '#messages li', function(){

    message = $(this).attr('data-id');
    $('#page_messages_dialog #popup').popup("open", {
        positionTo: "window", 
        transition: "flip"
    });

});

$("#page_messages_dialog").on('click', '#delete', function(){

    $.get('/modules/messages_delete/?id='+message, u_messages(n,true));
    alert_message('Сообщение удалено.', 'information', 5);
    message = 0;

});
    
$("#page_messages_dialog").on('click', '#submit', function(){

    $('#message_send').addClass("ui-disabled").trigger('updatelayout');

    $.ajax({
        type: "POST",
        url: "/modules/messages_send/?id="+$('#messages').attr('data-user'),
        cache: false,
        data: $("#message_send").serialize(),
        dataType: 'json',
        success: s_send,
        complete: $('#message_send').removeClass("ui-disabled").trigger('updatelayout')
    });

    return false;
});

$('#page_messages_dialog').bind('pagehide', function () {
    clearInterval(myInterval);
    $('#page_messages_dialog').remove();
});
    
$("#page_messages_dialog").on('click', '#next', next_page);
$("#page_messages_dialog").on('click', '#back', back_page);

$('#page_messages_dialog').on('swipeleft','#messages', function(){ 

    if(is_PC())
        return;
    back_page(); 

});
$('#page_messages_dialog').on('swiperight','#messages', function(){ 

    if(is_PC())
        return;
    next_page(); 

});

$('#text').keydown(function (e) {
    
    if (e.ctrlKey && e.keyCode == 13) {
        $('#submit').click();
    }
        
});
    
function s_send(text){
        
    if(text != 'true')
        return alert_message(text, 'information', 5);
        
    u_messages(0, true);
    $('#message_send').find('textarea').val('');
        
    return true;
        
}

    
function u_messages(n, status){

    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/messages_dialog/?id='+$('#messages').attr('data-user')+'&n='+n, function(data) {

        var ul = '';

        $.each(data, function(i,item){

            if(i == 0)
            {
                ul += '<ul data-role="listview" id="messages_list" data-inset="true" data-max="'+item+'"><li data-role="list-divider">Сообщения</li>';
                max_n = item;
            }
            else
                ul += '<li data-id="'+item.id+'" data-icon="false"><img id="user_avatar" data-user="'+item.user+'" class="image-radius" style="opacity: '+item.avatar+'" src="/modules/get_avatar/?id='+item.user+'&amp;size=2" alt=""><h3 style="font-size: 14px">'+item.name+'</h3><p>'+item.text+'</p><p class="ui-li-aside">'+item.date+'</p>';

        });
        
        if(max_n == 0)
            ul += '<li>Сообщений нет.</li>';

        ul += '</ul>';

        $('#messages').html(ul).trigger("create").trigger("refresh");

        update_navigation();

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
       
}

function next_page(){
    
    if((n-e) < 0)
        return;

    n = n-e; 
    u_messages(n,true);

}
function back_page(){
    
    if((n+e) >= max_n)
        return;
    
    n = parseInt(n+e); 

    u_messages(n,true);
    
}