function success_category(data){
    
    if(data == 'true'){
     
            $.mobile.changePage("/forum/", {
                transition: "flip", 
                reloadPage: true
            });
        
    }else{
        
        alert_message(data, 'information', 3);
        
    }
    
}

$('#page_forum_category_add').bind('pageshow', function () {
   $('#page_forum_category_add p').hide();
});