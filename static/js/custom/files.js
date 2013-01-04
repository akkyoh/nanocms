var n = 0;
var max_n = 0;
var e = 10;

$("#page_files").on('click', '#delete', function(){
    $.get('/modules/files_category_delete/?id='+category_tap, function (){
        load_files(n, true);
        load_categories(true);
    });
});

$("#page_files").on('click', '#categories_list a', function(){
    
    category = parseInt($(this).attr('data-id'));
    
    n = 0;
    
    load_files(n, true);
    load_categories(true);
    update_buttons();

});

$("#page_files").on('click', '#add_category a', function(){
    
    $.mobile.changePage("/files_category_add/?category="+category, {
        transition: "flip", 
        reloadPage: true
    });

});

$("#page_files").on('click', '#add_files a', function(){
    
    $.mobile.changePage("/files_add/?category="+category, {
        transition: "flip", 
        reloadPage: true
    });

});

$("#page_files").on('click', '#files_edit a', function(){
    
    $.mobile.changePage("/files_edit/?category="+category, {
        transition: "flip", 
        reloadPage: true
    });

});

$("#page_files").on('click', '#category_edit a', function(){
    
    $.mobile.changePage("/files_category_add/?id="+category, {
        transition: "flip", 
        reloadPage: true
    });

});

$("#page_files").on('click', '#category_back', function(){
    
    category = parseInt($('#files_list').attr('data-parent'));
    
    n = 0;
    
    load_files(n, true);
    load_categories(true);
    update_buttons();
        
});

$("#page_files").on('taphold', '#categories li', function(){

    if($('#page_files').attr('data-admin') == 0)
        return;

    category_tap = $(this).attr('data-id');
    $('#page_files #popup').popup("open", {
        transition: "flip"
    });

});

$('#page_files').bind('pageshow', function () {
    
    e = parseInt($('#files').attr('data-e'));
    category = parseInt($('#files').attr('data-category'));
    n = parseInt($('#files').attr('data-n'));
    
    update_buttons();
    
    load_files(n, true);
    load_categories(true);
    
});

$('#page_files').bind('pagehide', function () {
    $('#page_files').remove()
});

$("#page_files").on('click', '#next', next_page);
$("#page_files").on('click', '#back', back_page);

$('#page_files').on('swipeleft','#files', back_page);
$('#page_files').on('swiperight','#files', next_page);

function load_categories(status){

    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/files_category_get/?category='+category, function(data) {

        if(data == 'false')
        {
            $('#categories').html('').trigger("create").trigger("refresh");
            
            if(status)
                $.mobile.hidePageLoadingMsg();
            
            return;
        }
        
        var ul = '';

        ul += '<ul data-role="listview" data-inset="true" id="categories_list"><li data-role="list-divider">Категории</li>';

        $.each(data, function(i,item){

            ul += '<li data-icon="false" data-id="'+item.id+'"><a href="#" data-id="'+item.id+'"><h3>'+item.name+'</h3>';
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

function load_files(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.getJSON('/modules/files_get/?category='+category+'&n='+n, function(data) {

        var ul = '';

        $.each(data, function(i,item){

            if(i == 0)
            {
                ul += '<ul data-role="listview" id="files_list" data-inset="true" data-max="'+item.count+'" data-parent="'+item.parent+'"><li data-role="list-divider">Файлы</li>';
                max_n = item.count;
            }
            else
            {
                ul += '<li data-id="'+item.id+'" data-icon="false"><a href="'+item.url+'"><img class="image-radius" src="'+item.image+'" alt=""><h3 style="font-size: 14px">'+item.name+'</h3><p class="ui-li-aside">'+item.date+'</p></a></li>';
            }
            
        });
        
        if(max_n == 0)
            ul += '<li>Файлов нет.</li>';

        ul += '</ul>';

        $('#files').html(ul).trigger("create").trigger("refresh");

        update_navigation();

        if(status)
            $.mobile.hidePageLoadingMsg();

    });
    
}

function next_page(){
    
    if((n-e) < 0)
        return;

    n = n-e; 
    load_files(n,true);

}
function back_page(){
    
    if((n+e) >= max_n)
        return;
    
    n = parseInt(n+e); 

    load_files(n,true);
    
}

function update_buttons(){
    
    if(category == 0)
    {
        $('#category_navigation').hide();
        $('#category_edit').hide();
        $('#files_edit').hide();
        $('#add_files').hide();
    }
    else
    {
        $('#category_navigation').show();
        $('#category_edit').show();
        $('#files_edit').show();
        $('#add_files').show();
    }
    
}