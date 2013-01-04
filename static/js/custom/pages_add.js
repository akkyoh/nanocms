$('#page_pages_add').bind('pageshow', function () {
   
   $('#page_pages_add p').hide();
   $('#markitup').markItUp(htmlSettings);
   
});

function success_add(data){
    
    if(data[0] == 'true'){
        
        
        
        $('#page_pages').remove();
        
        $.mobile.changePage("/pages/"+data[1]+"/", {
            transition: "flip", 
            reloadPage: true
        });
        
    }else{
        
        alert_message(data, 'information', 3);
        
    }
    
}

$('#page_pages_add').bind('pagehide', function () {
    $('#page_pages_add').remove();
});