$('#page_user_information').bind('pageshow', function () {
    
    if($('#add_friend').attr('hide') == 1)
        $('#add_friend').hide();
    if($('#delete_friend').attr('hide') == 1)
        $('#delete_friend').hide();
   
});

$('#page_user_information').bind('pagehide', function () {
    $('#page_user_information').remove();
});

$('#page_user_information').on('click', '#add_friend a', function (){
   
   $.get('/modules/friend_add/?id='+$(this).attr('data-user'), function (){});
   
   $('#add_friend').hide();
   $('#delete_friend').show();
   
});

$('#page_user_information').on('click', '#delete_friend a', function (){
   
   $.get('/modules/friend_delete/?id='+$(this).attr('data-user'), function (){});
   
   $('#add_friend').show();
   $('#delete_friend').hide();
   
});