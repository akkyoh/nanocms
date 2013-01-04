var n = 0;
var max_n = 0;
var e = 10;

$('#page_photos_category_edit').bind('pageshow', function () {
    
    e = parseInt($('#photos').attr('data-e'));
    
    load_photos(0, true);
    
});

$('#page_photos_category_edit').on('change', 'input,textarea', function(){
        
        var id = $(this).attr('data-id');
        var field = $(this).attr('name');
        var value = $(this).val();

        if((field == 'name' && value != '') || field == 'description'){

            if(field == 'name'){
                $('li#'+id+' h3').html(value).trigger("create").trigger("refresh");
                $('li#'+id).prev().html(value).trigger("create").trigger("refresh");
            }
            if(field == 'description')
                $('li#'+id).find('p#about').html(value).trigger("create").trigger("refresh");
            
            $.ajax({
                url: "/modules/photo_update/",
                type: "POST",
                cache: false,
                dataType: 'json',
                data: {
                    field: field, 
                    value: value,
                    id: id
                },
                success: show_result
            });
            
        }
         
});

$('#page_photos_category_edit').bind('pagehide', function () {
    $('#page_photos_category_edit').remove();    
});

$("#page_photos_category_edit #next").on('click', next_page);
$("#page_photos_category_edit #back").on('click', back_page);

$('#page_photos_category_edit').on('swipeleft','#photos', back_page);
$('#page_photos_category_edit').on('swiperight','#photos', next_page);

$('#page_photos_category_edit').on('focusin','input,textarea', function(){
    $('#page_photos_category_edit').off('swipeleft');
    $('#page_photos_category_edit').off('swiperight');
});

$('#page_photos_category_edit').on('focusout','input,textarea', function(){
    $('#page_photos_category_edit').on('swipeleft','#photos', back_page);
    $('#page_photos_category_edit').on('swiperight','#photos', next_page);
});

function load_photos(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/photos_get_edit/?category='+$('#photos').attr('data-category')+'&n='+n, function(data) {

        var ul = '';

        $.each(data, function(i,item){

            if(i == 0)
            {
                ul += '<ul data-role="listview" id="photos_list" data-inset="true" data-max="'+item+'">';
                max_n = item;
            }
            else
                ul += '<li data-role="list-divider">'+item.name+'</li><li id="'+item.id+'" data-icon="false"><img class="image-radius" src="/modules/photo_download/?id='+item.id+'&size=preview" alt=""><h3 style="font-size: 14px">'+item.name+'</h3><p id="about"></p><p class="ui-li-aside">'+item.date+'</p></li><li><input data-id="'+item.id+'" type="text" name="name" id="name" value="'+item.name+'" placeholder="Имя фотографии"/></li><li><textarea data-id="'+item.id+'" name="description" id="description" placeholder="Описание фотографии">'+item.description+'</textarea></li>';

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

function show_result(responseText){
        
    if(responseText != 'true')
        alert_message(responseText, 'information', 3);
        
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