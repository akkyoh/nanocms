$('#page_forum_theme_add').bind('pageshow', function () {
   
   $('#page_forum_theme_add p').hide();
   $('#markitup').markItUp(mySettings);
    
});

function success_add(data){
    
    if(data == 'true'){
        
        $.mobile.changePage("/forum_category/?id="+$('#main').attr('data-category'), {
            transition: "flip", 
            reloadPage: true
        });
        
    }else{
        
        alert_message(data, 'information', 3);
        
    }
    
}

$('#page_news_edit').bind('pagehide', function () {
    $('#page_forum_theme_add').remove();
});