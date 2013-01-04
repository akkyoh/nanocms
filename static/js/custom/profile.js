$('#page_profile').bind('pageshow', function () {
    
    $('#page_profile p').hide();
    
    $('input,textarea,select,checkbox').change(function(){
    
        if($('#main').valid() && $('#contacts').valid() && $('#about').valid() && ($('#settings').valid() || $('#page_profile').attr('data-admin') == 0)){
    
            var $this = $(this);

            $.ajax({
                url: "/modules/profile_update/?user="+$('div[data-role="content"]').attr('data-user'),
                type: "POST",
                cache: false,
                data: {
                    field: $this.attr('name'), 
                    value: $this.val()
                },
                success: function (data){
                    if(data == 'success_password')
                        alert_message('Пароль изменен.', 'information', 5)
                }
            });
        
        }
        
    });
   
   $('#markitup').markItUp(mySettings);
   
});

$('#page_profile').bind('pagehide', function () {
    $('#page_profile').remove();
});