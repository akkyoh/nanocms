$('#page_daily_edit').bind('pageshow', function () {
   
   $('#page_daily_edit p').hide();
   $('#markitup').markItUp(news);
    
});

function success_add(data){
    
    if(data[0] == 'true'){
        
        $('#page_daily_read').remove();
        
        $.mobile.changePage("/daily_read/"+data[1]+'/', {
            transition: "flip", 
            reloadPage: true
        });
        
    }else{
        
        alert_message(data, 'information', 3);
        
    }
    
}

$('#page_daily_edit').bind('pagehide', function () {
    $('#page_daily_edit').remove();
});