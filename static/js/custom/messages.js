var dialog = 0;

$("#page_messages").on('taphold', 'li', function(){

    dialog = $(this).attr('data-id');
    $('#page_messages #popup').popup("open", {
        positionTo: "window", 
        transition: "flip"
    });

});
    
$("#page_messages").on('click', '#delete', function(){
        
    $.get('/modules/messages_delete_dialog/?id='+dialog, function (){} );
    dialog = 0;

});