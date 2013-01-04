function show_result(responseText){
        
    if(responseText == 'true')
        $.mobile.changePage("/", {
            transition: "flip", 
            reloadPage: true
        });
    else
        alert_message(responseText, 'information', 5);
        
}

$('#page_install').bind('pageshow', function () {
    
   $('#page_install p').hide(); 
   $('#database').focus();
   
});