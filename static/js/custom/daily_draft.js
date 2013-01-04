var n = 0;
var max_n = 0;
var e = 10;

$('#page_daily_draft').bind('pageshow', function () {
    
    e = parseInt($('#notes').attr('data-e'));
    
    load_notes(0, true);
    
});

$('#page_daily_draft').bind('pagehide', function () {
    $('#page_daily_draft').remove();
});

$("#page_daily_draft #next").on('click', next_page);
$("#page_daily_draft #back").on('click', back_page);

$('#page_daily_draft').on('swipeleft','#daily', back_page);
$('#page_daily_draft').on('swiperight','#daily', next_page);

function load_notes(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/daily_get/?n='+n+"&hide=1&user="+$('#page_daily_draft').attr('data-user'), function(data) {

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

        $('#notes').html(ul).trigger("create").trigger("refresh");

        update_navigation();

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}

function next_page(){
    
    var e = parseInt($('#daily').attr('data-e'));
    
    if((n-e) < 0)
        return;

    n = n-e; 
    load_notes(n,true);

}
function back_page(){
    
    var e = parseInt($('#daily').attr('data-e'));
    
    if((n+e) > max_n)
        return;
    
    n = n+e; 
    load_notes(n,true);
    
}