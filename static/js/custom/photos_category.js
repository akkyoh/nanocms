var n = 0;
var max_n = 0;
var e = 10;

$('#page_photos_category').bind('pageshow', function () {
    
    e = parseInt($('#photos').attr('data-e'));
    
    load_photos(0, true);
    
});

$('#page_photos_category').bind('pagehide', function () {
    $('#page_photos_category').remove();    
});

$("#page_photos_category #next").on('click', next_page);
$("#page_photos_category #back").on('click', back_page);

$('#page_photos_category').on('swipeleft','#photos', back_page);
$('#page_photos_category').on('swiperight','#photos', next_page);

function load_photos(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/photos_get/?category='+$('#photos').attr('data-category')+'&n='+n, function(data) {

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

        $('#photos').html(ul).trigger("create").trigger("refresh");

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
    
    n = n+e; 
    load_photos(n,true);
    
}