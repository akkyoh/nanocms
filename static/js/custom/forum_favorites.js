$('#page_forum_favorites').bind('pageshow', function () {
    
    e = parseInt($('#themes').attr('data-e'));
    
    load_favorites(true);
    
});

$('#page_forum_favorites').bind('pagehide', function () {
    $('#page_forum_favorites').remove();
});

function load_favorites(status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/forum_favorites_get/', function(data) {

        if(data == 'false')
        {
            $('#themes').html('<ul data-role="listview" id="themes_list" data-inset="true"><li data-role="list-divider">Закладки</li><li>Закладок нет.</li></ul>').trigger("create").trigger("refresh");
            
            if(status)
                $.mobile.hidePageLoadingMsg();
            
            return;
        }

        var ul = '<ul data-role="listview" id="themes_list" data-inset="true"><li data-role="list-divider">Закладки</li>';
        
        $.each(data, function(i,item){

            ul += '<li data-id="'+item.id+'" data-icon="false"><a href="'+item.url+'"><img id="user_avatar" data-user="'+item.user+'" class="image-radius" style="opacity: 1.0" src="/modules/get_avatar/?id='+item.user+'&amp;size=2" alt=""><h3 style="font-size: 14px">'+item.name+'</h3><p>'+item.count+'</p><p class="ui-li-aside">'+item.date+'</p></a></li>';

        });

        ul += '</ul>';

        $('#themes').html(ul).trigger("create").trigger("refresh");

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}