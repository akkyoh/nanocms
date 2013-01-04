var n = 0;
var max_n = 0;
var e = 10;

$('#page_guestbook').bind('pageshow', function () {
    
    e = parseInt($('#guestbook').attr('data-e'));
    
    $('#guestbook_send').sisyphus({
        timeout: sisyphus_time
    });
    
    load_guestbook(0, true);
    
});

$('#page_guestbook').bind('pagehide', function () {
    $('#page_guestbook').remove();
});

$("#page_guestbook #next").on('click', next_page);
$("#page_guestbook #back").on('click', back_page);

$('#page_guestbook').on('swipeleft','#guestbook', function(){ 

    if(is_PC())
        return;
    back_page(); 

});
$('#page_guestbook').on('swiperight','#guestbook', function(){ 

    if(is_PC())
        return;
    next_page(); 

});

$("#page_guestbook").on('click', '#submit', function(){

    $('#guestbook_send').addClass("ui-disabled").trigger('updatelayout');

    $.ajax({
        type: "POST",
        url: "/modules/guestbook_add/",
        cache: false,
        dataType: 'json',
        data: $("#guestbook_send").serialize(),
        success: success_send,
        complete: $('#guestbook_send').removeClass("ui-disabled").trigger('updatelayout')
    });

    return false;
});

$("#page_guestbook").on('taphold', '#guestbook_list li', function(){

    if($('#page_guestbook').attr('data-admin') == 0 || altKey)
        return;

    message = $(this).attr('data-id');
    $('#page_guestbook #popup').popup("open", {
        positionTo: "window", 
        transition: "flip"
    });

});

$('#guestbook_list li').live('click', function (){

    $('#text').focus().attr('value', $(this).attr('data-user')+', ');

});

$("#page_guestbook").on('click', '#delete', function(){

    $.get('/modules/guestbook_delete/?id='+message, function (){
        load_guestbook(n,true);
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
        
    load_guestbook(0, true);
    $('#guestbook_send').find('textarea').val('');
        
    return true;
        
}

function load_guestbook(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/guestbook/?n='+n, function(data) {

        var ul = '';

        $.each(data, function(i,item){

            if(i == 0)
            {
                ul += '<ul data-role="listview" id="guestbook_list" data-inset="true" data-max="'+item+'"><li data-role="list-divider">Записи</li>';
                max_n = item;
            }
            else
                ul += '<li data-id="'+item.id+'" data-user="'+item.username+'" data-icon="false"><img id="user_avatar" data-user="'+item.user_id+'" class="image-radius" style="opacity: 1.0" src="/modules/get_avatar/?id='+item.user_id+'&amp;size=2" alt=""><h3 style="font-size: 14px">'+item.username+'</h3><p>'+item.message+'</p><p class="ui-li-aside">'+item.date+'</p></li>';

        });
        
        if(max_n == 0)
            ul += '<li>Сообщений нет.</li>';

        ul += '</ul>';

        $('#guestbook').html(ul).trigger("create").trigger("refresh");

        update_navigation();

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}

function next_page(){
    
    if((n-e) < 0)
        return;

    n = n-e; 
    load_guestbook(n,true);

}
function back_page(){
    
    if((n+e) >= max_n)
        return;
    
    n = n+e; 
    load_guestbook(n,true);
    
}