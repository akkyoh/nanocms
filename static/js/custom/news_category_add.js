function success_category(data){
    
    if(data == 'true'){
     
            $('#page_news').remove();
     
            $.mobile.changePage("/news/", {
                transition: "flip", 
                reloadPage: true
            });
        
    }else{
        
        alert_message(data, 'information', 3);
        
    }
    
}

$('#page_news_category_add').bind('pageshow', function () {
   $('#page_news_category_add p').hide();
});