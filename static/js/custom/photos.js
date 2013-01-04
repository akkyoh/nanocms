var n = 0;
var max_n = 0;
var e = 10;

$("#page_photos").on('click', '#delete', function(){
    $.get('/modules/photos_category_delete/?id='+category, function (){
        load_photos(n, true);
        load_categories(true);
    });
});

$("#page_photos").on('taphold', '#categories li', function(){

    if((!$('#page_photos').attr('data-auth') && $('#categories').attr('data-user') != $('#page_photos').attr('data-user')) || !$('#page_photos').attr('data-admin'))
        return;

    category = $(this).attr('data-id');
    $('#page_photos #popup').popup("open", {
        positionTo: "window", 
        transition: "flip"
    });

});

$('#page_photos').bind('pageshow', function () {
    
    e = parseInt($('#photos_last').attr('data-e'));
    
    load_photos(n, true);
    load_categories(true);
    
});

$('#page_photos').bind('pagehide', function () {
    $('#page_photos').remove()
});

$("#page_photos").on('click', '#next', next_page);
$("#page_photos").on('click', '#back', back_page);

$('#page_photos').on('swipeleft','#photos_last', back_page);
$('#page_photos').on('swiperight','#photos_last', next_page);

function load_categories(status){
       
    if($('#page_photos').attr('data-auth') == 0 && $('#categories').attr('data-user') != $('#page_photos').attr('data-auth'))
        return;
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/photos_category_get/?user='+$('#categories').attr('data-user'), function(data) {

        if(data == 'false')
        {
            if(status)
                $.mobile.hidePageLoadingMsg();
            return;
        }
        var ul = '';

        ul += '<ul data-role="listview" data-inset="true"><li data-role="list-divider">Категории</li>';

        $.each(data, function(i,item){

            ul += '<li data-icon="false" data-id="'+item.id+'"><a href="/photos_category/?category='+item.id+'&amp;user='+item.user+'"><h3>'+item.name+'</h3>';
            if(item.about != '')
                ul += '<p>'+item.about+'</p>';
            ul += '<span class="ui-li-count">'+item.count+'</span></a></li>';
            
        });

        ul += '</ul>';

        $('#categories').html(ul).trigger("create").trigger("refresh");
        
        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}

function load_photos(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/photos_last/?user='+$('#photos_last').attr('data-user')+'&n='+n, function(data) {

        var ul = '';

        $.each(data, function(i,item){

            if(i == 0)
            {
                ul += '<ul data-role="listview" id="photos_list" data-inset="true" data-max="'+item+'"><li data-role="list-divider">Записи</li>';
                max_n = item;
            }
            else
                ul += '<li data-id="'+item.id+'" data-icon="false"><a href="'+item.url+'"><img class="image-radius" src="/modules/photo_download/?id='+item.id+'&size=preview" alt=""><h3 style="font-size: 14px">'+item.name+'</h3><p>'+item.description+'</p><p class="ui-li-aside">'+item.date+'</p></a></li>';

        });
        
        if(max_n == 0)
            ul += '<li>Фотографий нет.</li>';

        ul += '</ul>';

        $('#photos_last').html(ul).trigger("create").trigger("refresh");

        update_navigation();

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}

function next_page(){
    
    if((n-e) < 0)
        return;

    n = n-e; 
    load_photos(n,true);

}
function back_page(){
    
    if((n+e) >= max_n)
        return;
    
    n = parseInt(n+e); 

    load_photos(n,true);
    
}