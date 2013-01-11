var n = 0;
var max_n = 0;
var e = 10;

$("#page_pages_list").on('click', '#delete', function(){
    $.get('/modules/pages_delete/?id='+page, function (){
        load_pages(n, true);
    });
});

$('#page_pages_list').bind('pageshow', function () {
    
    e = parseInt($('#pages').attr('data-e'));
    
    load_pages(0, true);
    
});

$("#page_pages_list #next").on('click', next_page);
$("#page_pages_list #back").on('click', back_page);

$('#page_pages_list').on('swipeleft','#pages', back_page);
$('#page_pages_list').on('swiperight','#pages', next_page);

$('#page_pages_list').bind('pagehide', function () {
    $('#page_pages_list').remove();
});

$("#page_pages_list").on('taphold', '#pages_list li', function(){

    if($('#page_pages_list').attr('data-admin') == 0)
        return;

    page = $(this).attr('data-id');
    $('#page_pages_list #popup').popup("open", {
        positionTo: "window", 
        transition: "flip"
    });

});

function load_pages(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/pages_list/?n='+n, function(data) {

        var ul = '';

        $.each(data, function(i,item){

            if(i == 0)
            {
                ul += '<ul data-role="listview" id="pages_list" data-inset="true" data-max="'+item+'"><li data-role="list-divider">Страницы</li>';
                max_n = item;
            }
            else
                ul += '<li data-id="'+item.id+'" data-icon="false"><a href="'+item.url+'"><h3 style="font-size: 14px">'+item.title+'</h3><p>'+item.description+'</p></a></li>';

        });
        
        if(max_n == 0)
            ul += '<li>Страниц нет.</li>';

        ul += '</ul>';

        $('#pages').html(ul).trigger("create").trigger("refresh");

        update_navigation();

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}

function next_page(){
    
    if((n-e) < 0)
        return;

    n = n-e; 
    load_pages(n,true);

}
function back_page(){
    
    if((n+e) >= max_n)
        return;
    
    n = n+e; 
    load_pages(n,true);
    
}