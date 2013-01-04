function success_category(data){
    
    if(data == 'true'){
     
            $('#page_photos').remove();
     
            $.mobile.changePage("/photos/", {
                transition: "flip", 
                reloadPage: true
            });
        
    }else{
        
        alert_message(data, 'information', 3);
        
    }
    
}

$('#page_photos_category_add').bind('pageshow', function () {
   $('#page_photos_category_add p').hide();
});