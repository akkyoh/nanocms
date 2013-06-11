<? 
    page_auth();
    head('Друзья');    
?>

<div data-role="content">
    
    <ul data-role="listview" id="users_all" data-inset="true"> 

        <li data-role="list-divider">Список</li>

    <?

    $list = users::get_friends($user_id);

    if($list != false){

        foreach ($list as $users) {

            $user_data = new users($users['friend'], 'login, sex, last_update');
            
            echo '<li data-icon="false"><a href="/id'.intval($users['friend']).'/">'.users::print_avatar($users['friend'], 2, 1).'<h3 style="font-size: 14px">'.$user_data -> get_name().'</h3><p>Последнее посещение: '.date('d.m.y H:i', $user_data -> get_online_time()).'</p>';
            echo '</a></li>';

        }

    }else{

        echo '<li>Друзей нет.</li>';

    }

    ?>

    </ul>
    
</div>

<? 
    footer();
?>