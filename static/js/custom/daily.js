var n = 0;
var max_n = 0;
var e = 10;

$("#page_daily").on('click', '#delete', function(){
    $.get('/modules/daily_category_delete/?id='+category, function (){
        load_categories(true);
    });
});

$("#page_daily").on('taphold', '#categories li', function(){

    if((!$('#page_daily').attr('data-auth') && $('#categories').attr('data-user') != $('#page_daily').attr('data-user')) || !$('#page_daily').attr('data-admin'))
        return;

    category = $(this).attr('data-id');
    $('#page_daily #popup').popup("open", {
        positionTo: "window", 
        transition: "flip"
    });

});

$('#page_daily').bind('pageshow', function () {
    
    e = parseInt($('#daily_last').attr('data-e'));
    
    load_notes(n, true);
    load_categories(true);
    
});

$('#page_daily').bind('pagehide', function () {
    $('#page_daily').remove()
});

$("#page_daily").on('click', '#next', next_page);
$("#page_daily").on('click', '#back', back_page);

$('#page_daily').on('swipeleft','#daily_last', back_page);
$('#page_daily').on('swiperight','#daily_last', next_page);

function load_categories(status){
       
    if($('#page_daily').attr('data-auth') == 0 && $('#categories').attr('data-user') != $('#page_daily').attr('data-auth'))
        return;
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/daily_category_get/?user='+$('#categories').attr('data-user'), function(data) {

        if(data == 'false')
        {
            if(status)
                $.mobile.hidePageLoadingMsg();
            return;
        }
        var ul = '';

        ul += '<ul data-role="listview" data-inset="true"><li data-role="list-divider">Категории</li>';

        $.each(data, function(i,item){

            ul += '<li data-icon="false" data-id="'+item.id+'"><a href="/daily_category/?category='+item.id+'&amp;user='+item.user+'"><h3>'+item.name+'</h3>';
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

function load_notes(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/daily_last/?user='+$('#daily_last').attr('data-user')+'&n='+n, function(data) {

        var ul = '';

        $.each(data, function(i,item){

            if(i == 0)
            {
                ul += '<ul data-role="listview" id="daily_list" data-inset="true" data-max="'+item+'"><li data-role="list-divider">Записи</li>';
                max_n = item;
            }
            else
                ul += '<li data-id="'+item.id+'" data-icon="false"><a href="'+item.url+'"><img id="user_avatar" data-user="'+item.user+'" class="image-radius" style="opacity: 1.0" src="/modules/get_avatar/?id='+item.user+'&amp;size=2" alt=""><h3 style="font-size: 14px">'+item.topic+'</h3><p>'+item.text+'</p><p class="ui-li-aside">'+item.date+'</p></a></li>';

        });
        
        if(max_n == 0)
            ul += '<li>Записей нет.</li>';

        ul += '</ul>';

        $('#daily_last').html(ul).trigger("create").trigger("refresh");

        update_navigation();

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}

function next_page(){
    
    if((n-e) < 0)
        return;

    n = n-e; 
    load_notes(n,true);

}
function back_page(){
    
    if((n+e) >= max_n)
        return;
    
    n = parseInt(n+e); 

    load_notes(n,true);
    
}