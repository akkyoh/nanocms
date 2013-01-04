var n = 0;
var max_n = 0;
var e = 10;

$("#page_files_show").on('click', '#delete_file', function(){

    $.get('/modules/file_delete/?id='+$(this).attr('data-id'), function (){});
    
    $.mobile.changePage("/files/?category="+$(this).attr('data-category'), {
        transition: "flip", 
        reloadPage: true
    });
    
});

$('#page_files_show').bind('pageshow', function () {
    
    $( ".photo_popup" ).on({
        popupbeforeposition: function() {
            var maxHeight = $( window ).height() - 60 + "px";
            $( ".photo_popup img" ).css( "max-height", maxHeight );
        }
    });
    
    e = parseInt($('#comments').attr('data-e'));
    
    $('#comments_send').sisyphus({
        timeout: sisyphus_time
    });  
    
    if(e > 0)
        load_comments(0, true);
    
    if($('#video').attr('data-url') != '')
        $('#video').html('').trigger("create").trigger("refresh");
    
});

$('#page_files_show').bind('pagehide', function () {
    $('#page_files_show').remove();    
});

$("#page_files_show #next").on('click', next_page);
$("#page_files_show #back").on('click', back_page);

$('#page_files_show').on('swipeleft','#comments', function(){ 

    if(is_PC())
        return;
    back_page(); 

});
$('#page_files_show').on('swiperight','#comments', function(){ 

    if(is_PC())
        return;
    next_page(); 

});

$("#page_files_show").on('click', '#submit', function(){

    $('#comments_send').addClass("ui-disabled").trigger('updatelayout');

    $.ajax({
        type: "POST",
        url: "/modules/comments_add/?id="+$('#comments').attr('data-files')+"&type=files",
        cache: false,
        dataType: 'json',
        data: $("#comments_send").serialize(),
        success: success_send,
        complete: $('#comments_send').removeClass("ui-disabled").trigger('updatelayout')
    });

    return false;
});

$("#page_files_show").on('taphold', '#comments li', function(){

    if($('#page_files_show').attr('data-admin') == 0 || altKey)
        return;

    comment = $(this).attr('data-id');
    $('#page_files_show #popup_comment').popup("open", {
        positionTo: "window", 
        transition: "flip"
    });

});

$('#comments_list li').live('click', function (){

    if($('#page_files_show').attr('data-auth') == 0)
        return;

    $('#text').focus().attr('value', $(this).attr('data-user')+', ');

});

$("#page_files_show").on('click', '#delete_comment', function(){

    $.get('/modules/comments_delete/?id='+comment, function (){
        load_comments(n,true);
    });
    
    alert_message('Комментарий удален.', 'information', 3);
    comment = 0;

});

$('#text').keydown(function (e) {
    
    if (e.ctrlKey && e.keyCode == 13) {
        $('#submit').click();
    }
        
});

function success_send(text){
        
    if(text != 'true')
        return alert_message(text, 'information', 3);
        
    load_comments(0, true);
    $('#comments_send').find('textarea').val('');
        
    return true;
        
}

function load_comments(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/comments_get/?id='+$('#comments').attr('data-files')+'&n='+n+'&type=files', function(data) {

        var ul = '';

        $.each(data, function(i,item){

            if(i == 0)
            {
                ul += '<ul data-role="listview" id="comments_list" data-inset="true" data-max="'+item+'"><li data-role="list-divider">Комментарии</li>';
                max_n = item;
            }
            else
                ul += '<li data-id="'+item.id+'" data-user="'+item.username+'" data-icon="false"><img id="user_avatar" data-user="'+item.user_id+'" class="image-radius" style="opacity: 1.0" src="/modules/get_avatar/?id='+item.user_id+'&amp;size=2" alt=""><h3 style="font-size: 14px">'+item.username+'</h3><p>'+item.message+'</p><p class="ui-li-aside">'+item.date+'</p></li>';

        });
        
        if(max_n == 0)
            ul += '<li>Комментариев нет.</li>';

        ul += '</ul>';

        $('#comments').html(ul).trigger("create").trigger("refresh");

        update_navigation();

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}

function next_page(){
    
    if((n-e) < 0)
        return;

    n = n-e; 
    load_comments(n,true);

}
function back_page(){
    
    if((n+e) >= max_n)
        return;
    
    n = n+e; 
    load_comments(n,true);
    
}