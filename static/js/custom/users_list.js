var n = 0;
var max_n = 0;
var e = 10;

$('#page_users_list').bind('pageshow', function () {
    
    e = parseInt($('#users').attr('data-e'));
    
    load_users(0, true);
    
});

$("#page_users_list #next").on('click', next_page);
$("#page_users_list #back").on('click', back_page);

$('#page_users_list').on('swipeleft','#users', back_page);
$('#page_users_list').on('swiperight','#users', next_page);

$('#page_users_list').bind('pagehide', function () {
    $('#page_users_list').remove();
});

function load_users(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/users_list/?n='+n, function(data) {

        var ul = '';

        $.each(data, function(i,item){

            if(i == 0)
            {
                ul += '<ul data-role="listview" id="users_all" data-inset="true" data-max="'+item+'"><li data-role="list-divider">Список</li>';
                max_n = item;
            }
            else
                ul += '<li data-id="'+item.user+'" data-icon="false"><a href="/id'+item.user+'/"><img id="user_avatar" data-user="'+item.user+'" class="image-radius" style="opacity: 1.0" src="/modules/get_avatar/?id='+item.user+'&amp;size=2" alt=""><h3 style="font-size: 14px">'+item.name+'</h3><p>Последнее посещение: '+item.date+'</p></a></li>';

        });
        
        if(max_n == 0)
            ul += '<li>Пользователей нет.</li>';

        ul += '</ul>';

        $('#users').html(ul).trigger("create").trigger("refresh");

        update_navigation();

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}

function next_page(){
    
    if((n-e) < 0)
        return;

    n = n-e; 
    load_users(n,true);

}
function back_page(){
    
    if((n+e) >= max_n)
        return;
    
    n = n+e; 
    load_users(n,true);
    
}