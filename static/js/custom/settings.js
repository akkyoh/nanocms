$('#page_settings').bind('pageshow', function () {
    
    $('#page_settings p').hide();
    
    $('input,select').change(function(){
    
        if($('#main').valid()){
    
            var $this = $(this);

            $.ajax({
                url: "/modules/profile_update//?user="+$('div[data-role="content"]').attr('data-user'),
                type: "POST",
                cache: false,
                data: {
                    field: $this.attr('name'), 
                    value: $this.val()
                },
                success: function (data){
                    if(data == 'success_password')
                        alert_message('Пароль изменен. Сохраните его в надежном месте и используйте при следующей авторизации.', 'information', 5)
                }
            });
        
        }
        
    });
   
});