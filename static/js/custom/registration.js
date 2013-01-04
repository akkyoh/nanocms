function show_result(responseText){
        
    if(responseText == 'true')
        $.mobile.changePage("/", {
            transition: "flip", 
            reloadPage: true
        });
    else
        alert_message(responseText, 'information', 5);
        
}

$('#page_registration').bind('pageshow', function () {
    
   $('#page_registration p').hide(); 
   $('#name').focus();
   
});