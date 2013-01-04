$('#page_news_draft').bind('pageshow', function () {
    
    e = parseInt($('#news').attr('data-e'));
    
    load_news(true);
    
});

$('#page_news_draft').bind('pagehide', function () {
    $('#page_news_draft').remove();
});

function load_news(status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/get_news/?category='+$('#news').attr('data-category')+'&hide=1', function(data) {

        ul = '<ul data-role="listview" id="news_list" data-inset="true"><li data-role="list-divider">Новости</li>';
        load = false;

        $.each(data, function(i,item){

            if(i > 0)
            {
                load = true;
                ul += '<li data-id="'+item.id+'" data-icon="false"><a href="'+item.url+'"><img id="user_avatar" data-user="'+item.user+'" class="image-radius" style="opacity: 1.0" src="/modules/get_avatar/?id='+item.user+'&amp;size=2" alt=""><h3 style="font-size: 14px">'+item.topic+'</h3><p>'+item.text+'</p><p class="ui-li-aside">'+item.date+'</p></a></li>';
            }

        });
        
        if(load == false)
            ul += '<li>Черновиков нет.</li>';

        ul += '</ul>';

        $('#news').html(ul).trigger("create").trigger("refresh");

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}