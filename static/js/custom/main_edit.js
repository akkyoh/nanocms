var start_id = 0;

$('#page_index_edit').bind('pageshow', function () {
    
    $("#sortable").sortable({
        start: function(event, ui)
        {
            start_i = ui.item.attr('sort');
            start_index = ui.item.index();
            start_id = ui.item.attr('id');
        },
        stop: function(event, ui)
        {
            
            $('#sortable').listview('refresh');
            $('#sortable').sortable('disable');
            
            $.mobile.showPageLoadingMsg();
            
            end_i = parseInt(start_i)+parseInt(ui.item.index())-parseInt(start_index);
            
            $.ajax({
                url: "/modules/menu_update/",
                type: "POST",
                cache: false,
                data: {
                    'position_old': start_i, 
                    'position_new': end_i,
                    'id': start_id
                },
                success: function(data){ 
                    
                    $('li[sort]').each(function(index) {
                        
                       if(parseInt($(this).attr('sort')) > start_i)
                           $(this).attr('sort', parseInt($(this).attr('sort'))-1);
                       
                       if(parseInt($(this).attr('sort')) >= end_i)
                           $(this).attr('sort', parseInt($(this).attr('sort'))+1);
                       
                       if(parseInt($(this).attr('id')) == start_id)
                           $(this).attr('sort', end_i);
                        
                    });
                    
                    $.mobile.hidePageLoadingMsg();
                
                },
                complete: function(){ $('#sortable').sortable('enable'); }
            });
            
        }
    });
    
    $( "#sortable" ).disableSelection();
    
});

$('#page_index_edit').on('click', 'li[sort]', function(){
   
    menu = $(this).attr('id');
    
    $('#page_index_edit #popup').popup("open", {
        positionTo: "window", 
        transition: "flip"
    });
   
    $('#edit').attr('href', '/index_add/?id='+menu);
   
});

$('#page_index_edit').bind('pagehide', function () {
    $('#page_index_edit').remove();
});

$("#page_index_edit").on('click', '#delete', function(){

    $.get('/modules/menu_delete/?id='+menu, function (){});
    
    $.mobile.changePage("/", {
        transition: "flip", 
        reloadPage: true
    });
    
});