$('#exit').live('click', function (){
    
    $.get('/modules/exit/', function (){});
    
    $.mobile.changePage("/", {
        transition: "flip", 
        reloadPage: true
    });
    
});