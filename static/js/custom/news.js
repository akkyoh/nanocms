$("#page_news").on('click', '#delete', function(){
    $.get('/modules/news_category_delete/?id='+category, function (){
        load_categories(true);
    });
});

$("#page_news").on('taphold', '#categories li', function(){

    if($('#page_news').attr('data-admin') == 0)
        return;

    category = $(this).attr('data-id');
    $('#page_news #popup').popup("open", {
        positionTo: "window", 
        transition: "flip"
    });

});

$('#page_news').bind('pageshow', function () {
    load_categories(true);
});

$('#page_news').bind('pagehide', function () {
    $('#page_news').remove();
});

function load_categories(status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/news_category_get/', function(data) {

        if(data == 'false')
        {
            if(status)
                $.mobile.hidePageLoadingMsg();
            return;
        }
        var ul = '';

        ul += '<ul data-role="listview" data-inset="true"><li data-role="list-divider">Категории</li>';

        $.each(data, function(i,item){

            ul += '<li data-icon="false" data-id="'+item.id+'"><a href="/news_category/?category='+item.id+'"><h3>'+item.name+'</h3>';
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