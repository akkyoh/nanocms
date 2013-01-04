function success_category(data){
    
    if(data == 'true'){
     
            $('#page_files').remove();
     
            $.mobile.changePage("/files/?category="+$('#parent').attr('value'), {
                transition: "flip", 
                reloadPage: true
            });
        
    }else{
        
        alert_message(data, 'information', 3);
        
    }
    
}

$('#page_files_category_add').bind('pageshow', function () {
   
   $('#page_files_category_add p').hide();
    
});