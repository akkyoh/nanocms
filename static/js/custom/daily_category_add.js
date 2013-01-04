function success_category(data){

    if(data == 'true'){
     
            $('#page_daily').remove();
     
            $.mobile.changePage("/daily/", {
                transition: "flip", 
                reloadPage: true
            });
        
    }else{
        
        alert_message(data, 'information', 3);
        
    }
    
}

$('#page_daily_category_add').bind('pageshow', function () {
   $('#page_daily_category_add p').hide();
});