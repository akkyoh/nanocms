$('#page_news_edit').bind('pageshow', function () {
   
   $('#page_news_edit p').hide();
   $('#markitup').markItUp(news);
    
});

function success_add(data){
    
    if(data[0] == 'true'){
        
        $('#page_news_read').remove();
        
        $.mobile.changePage("/news_read/"+data[1]+'/', {
            transition: "flip", 
            reloadPage: true
        });
        
    }else{
        
        alert_message(data, 'information', 3);
        
    }
    
}

$('#page_news_edit').bind('pagehide', function () {
    $('#page_news_edit').remove();
});