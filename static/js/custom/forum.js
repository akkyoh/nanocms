var n = 0;
var max_n = 0;
var e = 10;

$("#page_forum").on('click', '#delete', function(){
    $.get('/modules/forum_category_delete/?id='+category, function (){
        load_categories(true)
    });
});

$("#page_forum").on('taphold', '#categories_list li', function(){

    if($('#page_forum').attr('data-admin') == 0)
        return;

    category = $(this).attr('data-id');
    $('#page_forum #popup').popup("open", {
        positionTo: "window", 
        transition: "flip"
    });

});

$('#page_forum').bind('pageshow', function () {
    
    e = parseInt($('#themes').attr('data-e'));
    
    load_categories(true);
    load_themes(0, true);
    
});

$('#page_forum').bind('pagehide', function () {
    $('#page_forum').remove();
});

function load_categories(status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/forum_category_get/', function(data) {

        if(data == 'false')
        {
            $('#notes').html('<ul data-role="listview" id="themes_list" data-inset="true"><li data-role="list-divider">Категории</li><li>Категорий нет.</li></ul>').trigger("create").trigger("refresh");
            
            if(status)
                $.mobile.hidePageLoadingMsg();
            
            return;
        }

        var ul = '<ul data-role="listview" data-inset="true" id="categories_list"><li data-role="list-divider">Категории</li>';
        
        $.each(data, function(i,item){

            ul += '<li data-id="'+item.id+'" data-icon="false"><a href="/forum_category/?id='+item.id+'"><h3 style="font-size: 14px">'+item.name+'</h3><p>'+item.description+'</p><span class="ui-li-count">'+item.count+'</span></a></li>';

        });

        ul += '</ul>';

        $('#categories').html(ul).trigger("create").trigger("refresh");

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}

function load_themes(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/forum_themes_get/?category=0&n='+n, function(data) {

        if(data == 'false')
        {
            $('#themes').html('<ul data-role="listview" id="themes_list" data-inset="true"><li data-role="list-divider">Закладки</li><li>Закладок нет.</li></ul>').trigger("create").trigger("refresh");
            
            if(status)
                $.mobile.hidePageLoadingMsg();
            
            return;
        }

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