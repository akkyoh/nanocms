function success_edit(data){
    
    if(data == 'true'){
     
            $('#page_index').remove();
     
            $.mobile.changePage("/index_edit/", {
                transition: "flip", 
                reloadPage: true
            });
        
    }else{
        
        alert_message(data, 'information', 3);
        
    }
    
}

$('#page_index_add').bind('pageshow', function () {
    
   $('#page_index_add p').hide();
   
   if($('#module').attr('value') == '')
   {
       $('#image').parent().hide();
       $('#about').parent().hide();
       $('#module_custom').parent().hide();
       $('#module_custom').val('');
       $('#page').parent().parent().hide();
   }
   
   if($('#module').attr('value') != 'pages')
       $('#page').parent().parent().hide();
   
   if($('#module').attr('value') != 'other')
   {
       $('#module_custom').parent().hide();
       $('#module_custom').val('');
   }
   
});

$('#module').change(function(){
    
    if($('#module').attr('value') == 'pages')
        $('#page').parent().parent().show();
    else
        $('#page').parent().parent().hide();
    
    if($('#module').attr('value') == 'other')
        $('#module_custom').parent().show();
    else
    {
        $('#module_custom').parent().hide();
       $('#module_custom').val('');
    }
    
    if($('#module').attr('value') == '')
    {
        $('#image').parent().hide();
        $('#about').parent().hide();
    }
    else
    {
        $('#image').parent().show();
        $('#about').parent().show();
    }
    
});

$('#page_index_add').bind('pagehide', function () {
    $('#page_index_add').remove();
});