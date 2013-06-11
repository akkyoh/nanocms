<?  
    page_auth(); 
    head('Профиль');  
?>

<div data-role="content">	

    <p style="text-align: center; padding-bottom: 10px;">
        
        <?
        
        echo '<a href="/id'.$user_id.'/">'.users::print_avatar($user_id, 2).'</a>';
        
        
        ?>
        
    </p>
    
    <ul data-role="listview">
        
        <li data-icon="false"><a href="/messages/"><img src="/static/images/18-envelope.png" class="ui-li-icon" alt=""> Сообщения <span class="ui-li-count"><?=messages::unread($user_id)?></span></a></li>
        <li data-icon="false"><a href="/friends/"><img src="/static/images/112-group.png" class="ui-li-icon" alt=""> Друзья <span class="ui-li-count"><?=users::count_friends($user_id)?></span></a></li>
        <li data-icon="false"><a href="/profile/"><img src="/static/images/111-user.png" class="ui-li-icon" alt=""> Анкета</a></li>
        <li data-icon="false"><a href="/settings/"><img src="/static/images/20-gear2.png" class="ui-li-icon" alt=""> Настройки</a></li>
        <li data-icon="false"><a href="#" id="exit"><img src="/static/images/38-airplane.png" class="ui-li-icon" alt=""> Выход</a></li>
        
    </ul>
    
</div>

<script src="/static/js/custom/profile_exit.js"></script>

<? 
    footer();
?>