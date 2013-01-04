var n = 0;
var max_n = 0;
var e = 10;

$('#page_forum_category').bind('pageshow', function () {
    
    e = parseInt($('#themes').attr('data-e'));
    
    load_themes(0, true);
    
});

$('#page_forum_category').bind('pagehide', function () {
    $('#page_forum_category').remove();
});

$("#page_forum_category #next").on('click', next_page);
$("#page_forum_category #back").on('click', back_page);

$('#page_forum_category').on('swipeleft','#news', back_page);
$('#page_forum_category').on('swiperight','#news', next_page);

$("#page_forum_category").on('taphold', '#themes_list li', function(){

    if($('#page_forum_category').attr('data-admin') == 0)
        return;

    message = $(this).attr('data-id');
    $('#page_forum_category #popup').popup("open", {
        positionTo: "window", 
        transition: "flip"
    });

});

$("#page_forum_category").on('click', '#delete', function(){
    $.get('/modules/forum_theme_delete/?id='+message, function (){
        load_themes(n, true);
    });
});

$("#page_forum_category").on('click', '#close', function(){
    $.get('/modules/forum_theme_close/?id='+message, function (){
        load_themes(n, true);
    });
});

$("#page_forum_category").on('click', '#warning', function(){
    $.get('/modules/forum_theme_warning/?id='+message, function (){
        load_themes(n, true);
    });
});

function load_themes(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/forum_themes_get/?category='+$('#themes').attr('data-id')+'&n='+n, function(data) {

        var ul = '';
        
        $.each(data, function(i,item){

            if(i == 0)
            {
                ul += '<ul data-role="listview" id="themes_list" data-inset="true"><li data-role="list-divider">Темы</li>';
                max_n = item;
            }
            else
                ul += '<li data-id="'+item.id+'" data-icon="false"><a href="'+item.url+'"><img id="user_avatar" data-user="'+item.user+'" class="image-radius" style="opacity: 1.0" src="/modules/get_avatar/?id='+item.user+'&amp;size=2" alt=""><h3 style="font-size: 14px">'+item.name+'</h3><p>'+item.count+'</p><p>'+item.status+'</p><p class="ui-li-aside">'+item.date+'</p></a></li>';

        });
        
        if(max_n == 0)
            ul += '<li>Тем нет.</li>';

        ul += '</ul>';

        $('#themes').html(ul).trigger("create").trigger("refresh");

        update_navigation();

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}

function next_page(){
    
    if((n-e) < 0)
        return;

    n = n-e; 
    load_themes(n,true);

}
function back_page(){
    
    if((n+e) >= max_n)
        return;
    
    n = n+e; 
    load_themes(n,true);
    
}