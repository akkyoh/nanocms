var n = 0;
var max_n = 0;
var e = 10;

$('#page_forum_theme_read').bind('pageshow', function () {
    
    e = parseInt($('#messages').attr('data-e'));
    
    $('#message_send').sisyphus({
        timeout: sisyphus_time
    });  
    
    n = 0;
    load_messages(n, true);
    
    $('#markitup').markItUp(mySettings);
    
    if($('#add_favorite').attr('hide') == 1)
        $('#add_favorite').hide();
    if($('#delete_favorite').attr('hide') == 1)
        $('#delete_favorite').hide();
    
});

$('#page_forum_theme_read').bind('pagehide', function () {
    $('#page_forum_theme_read').remove();
});

$("#page_forum_theme_read #next").on('click', next_page);
$("#page_forum_theme_read #back").on('click', back_page);

$('#page_forum_theme_read').on('swipeleft','#messages', function(){ 

    if(is_PC())
        return;
    back_page(); 

});
$('#page_forum_theme_read').on('swiperight','#messages', function(){ 

    if(is_PC())
        return;
    next_page(); 

});

$("#page_forum_theme_read").on('taphold', '#messages_list li', function(){

    if($('#page_forum_theme_read').attr('data-admin') == 0 || altKey)
        return;

    message = $(this).attr('data-id');
    $('#page_forum_theme_read #popup').popup("open", {
        positionTo: "window", 
        transition: "flip"
    });

});

$('#messages_list li').live('click', function (){

    if($('#page_forum_theme_read').attr('data-auth') == 0)
        return;

    $('#markitup').focus().attr('value', $(this).attr('data-user')+', ');
    
});

$("#page_forum_theme_read").on('click', '#delete', function(){
    $.get('/modules/forum_message_delete/?id='+message, function (){
        load_messages(n, true);
    });
});

$("#page_forum_theme_read").on('click', '#submit', function(){

    $('#message_send').addClass("ui-disabled").trigger('updatelayout');

    $.ajax({
        type: "POST",
        url: "/modules/forum_message_add/?theme="+$('#messages').attr('data-id'),
        cache: false,
        dataType: 'json',
        data: $("#message_send").serialize(),
        success: success_send,
        complete: $('#message_send').removeClass("ui-disabled").trigger('updatelayout')
    });

    return false;
});

$('#page_forum_theme_read').on('click', '#add_favorite a', function (){
   
   $.get('/modules/forum_favorites_add/?id='+$(this).attr('data-theme'), function (){});
   
   $('#add_favorite').hide();
   $('#delete_favorite').show();
   
});

$('#page_forum_theme_read').on('click', '#delete_favorite a', function (){
   
   $.get('/modules/forum_favorites_delete/?id='+$(this).attr('data-theme'), function (){});
   
   $('#add_favorite').show();
   $('#delete_favorite').hide();
   
});

$('#markitup').keydown(function (e) {
    
    if (e.ctrlKey && e.keyCode == 13) {
        $('#submit').click();
    }
        
});

function load_messages(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/forum_messages_get/?theme='+$('#messages').attr('data-id')+'&n='+n, function(data) {

        var ul = '';

        $.each(data, function(i,item){

            if(i == 0)
            {
                ul += '<ul data-role="listview" id="messages_list" data-inset="true" data-max="'+item+'"><li data-role="list-divider">Сообщения</li>';
                max_n = item;
            }
            else
                ul += '<li data-id="'+item.id+'" data-user="'+item.username+'" data-icon="false"><img id="user_avatar" data-user="'+item.user_id+'" class="image-radius" style="opacity: 1.0" src="/modules/get_avatar/?id='+item.user_id+'&amp;size=2" alt=""><h3 style="font-size: 14px">'+item.username+'</h3><p>'+item.message+'</p><p class="ui-li-aside">'+item.date+'</p></li>';

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
    load_messages(n,true);

}
function back_page(){
    
    if((n+e) >= max_n)
        return;
    
    n = n+e; 
    load_messages(n,true);
    
}

function success_send(text){
        
    if(text != 'true')
        return alert_message(text, 'information', 3);
        
    n = 0;
    load_messages(n, true);
    $('#message_send').find('textarea').val('');
        
    return true;
        
}