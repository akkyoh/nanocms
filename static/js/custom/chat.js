var myInterval;
var n = 0;
var max_n = 0;
var e = 10;

$('#page_chat').on('pageshow', function () {
    
    e = parseInt($('#chat').attr('data-e'));
    
    load_chat(0, true);
    
    $('#chat_send').sisyphus({
        timeout: sisyphus_time
    });    
    
    myInterval = setInterval(function(){
        load_chat(n, false);
    }, 10000);
    
});

$('#page_chat').bind('pagehide', function () {
    $('#page_chat').remove();
});

$('#page_chat').on('pagehide', function () {
    clearInterval(myInterval);
});

$("#page_chat #next").on('click', next_page);
$("#page_chat #back").on('click', back_page);

$('#page_chat').on('swipeleft','#chat', function(){ 

    if(is_PC())
        return;
    back_page(); 

});
$('#page_chat').on('swiperight','#chat', function(){ 

    if(is_PC())
        return;
    next_page(); 

});

$("#page_chat").on('click', '#submit', function(){

    $('#chat_send').addClass("ui-disabled").trigger('updatelayout');

    $.ajax({
        type: "POST",
        url: "/modules/chat_add/",
        cache: false,
        dataType: 'json',
        data: $("#chat_send").serialize(),
        success: success_send,
        complete: $('#chat_send').removeClass("ui-disabled").trigger('updatelayout')
    });

    return false;
});

$("#page_chat").on('taphold', '#chat_list li', function(){

    if($('#page_chat').attr('data-admin') == 0 || altKey)
        return;

    message = $(this).attr('data-id');
    $('#page_chat #popup').popup("open", {
        positionTo: "window", 
        transition: "flip"
    });

});

$('#chat_list li').live('click', function (){

    if($('#page_chat').attr('data-auth') == 0)
        return;

    $('#text').focus().attr('value', $(this).attr('data-user')+', ');

});

$("#page_chat").on('click', '#delete', function(){

    $.get('/modules/chat_delete/?id='+message, function (){
        load_chat(n,true);
    });
    
    alert_message('Запись удалена.', 'information', 3);
    message = 0;

});

$('#text').keydown(function (e) {
    
    if (e.ctrlKey && e.keyCode == 13) {
        $('#submit').click();
    }
        
});

function success_send(text){
        
    if(text != 'true')
        return alert_message(text, 'information', 3);
       
    load_chat(0, true);
    $('#chat_send').find('textarea').val('');
        
    return true;
        
}

function load_chat(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/chat/?n='+n, function(data) {

        var ul = '';

        $.each(data, function(i,item){

            if(i == 0)
            {
                ul += '<ul data-role="listview" id="chat_list" data-inset="true" data-max="'+item+'"><li data-role="list-divider">Записи</li>';
                max_n = item;
            }
            else
                ul += '<li data-id="'+item.id+'" data-user="'+item.username+'" data-icon="false"><img id="user_avatar" data-user="'+item.user_id+'" class="image-radius" style="opacity: 1.0" src="/modules/get_avatar/?id='+item.user_id+'&amp;size=2" alt=""><h3 style="font-size: 14px">'+item.username+'</h3><p>'+item.message+'</p><p class="ui-li-aside">'+item.date+'</p></li>';

        });
        
        if(max_n == 0)
            ul += '<li>Сообщений нет.</li>';

        ul += '</ul>';

        $('#chat').html(ul).trigger("create").trigger("refresh");

        update_navigation();

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}

function next_page(){
    
    if((n-e) < 0)
        return;

    n = n-e; 
    load_chat(n,true);

}
function back_page(){
    
    if((n+e) >= max_n)
        return;
    
    n = n+e; 
    load_chat(n,true);
    
}