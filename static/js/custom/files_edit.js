var n = 0;
var max_n = 0;
var e = 10;

$('#page_files_edit').bind('pageshow', function () {
    
    e = parseInt($('#files').attr('data-e'));
    
    load_files(0, true);
    
});

$('#page_files_edit').on('change', 'input,textarea', function(){
        
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
                url: "/modules/file_update/",
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

$('#page_files_edit').bind('pagehide', function () {
    $('#page_files_edit').remove();    
});

$("#page_files_edit #next").on('click', next_page);
$("#page_files_edit #back").on('click', back_page);

$('#page_files_edit').on('swipeleft','#files', back_page);
$('#page_files_edit').on('swiperight','#files', next_page);

$('#page_files_edit').on('focusin','input,textarea', function(){
    $('#page_files_edit').off('swipeleft');
    $('#page_files_edit').off('swiperight');
});

$('#page_files_edit').on('focusout','input,textarea', function(){
    $('#page_files_edit').on('swipeleft','#files', back_page);
    $('#page_files_edit').on('swiperight','#files', next_page);
});

function load_files(n, status){
       
    if(status)
        $.mobile.showPageLoadingMsg();

    $.get('/modules/files_edit/?category='+$('#files').attr('data-category')+'&n='+n, function(data) {
            
        $('#files').html(data).trigger("create").trigger("refresh");
        max_n = $('#files_list').attr('data-max');
       
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
    load_files(n,true);

}
function back_page(){
    
    if((n+e) >= max_n)
        return;
    
    n = n+e; 
    load_files(n,true);
    
}