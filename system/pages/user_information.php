<? 

    $user = intval($_GET['id']);
    
    $profile_g = new profile($user);
    $user_g = new users($user, 'login, sex, last_update, date_registration');
    
    head($user_g -> get_name(), NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/id'.$user.'/'); 
    
?>

<div data-role="content">

    <div class="content-primary">

        <p style="text-align: center"><a href="#popup" data-rel="popup" data-position-to="window" data-transition="flip"><?=users::print_avatar($user, 1)?></a></p>
        
        <? if(users::is_auth($auth_user)){ ?>
        
        <ul data-role="listview" data-inset="true" data-divider-theme="c">

            <li data-role="list-divider">Действия</li>

            <? if($user_id == $user){ ?><li data-icon="plus"><a href="/avatar/">Установить фотографию</a></li><? } ?>
            
            <?
        
            if($user_id != $user and users::is_auth($auth_user)){

            ?>
            <li data-icon="plus"><a href="/messages_dialog/?id=<?=$user?>">Написать письмо</a></li>
            <? if(users::is_admin($user_id)){ ?><li data-icon="gear"><a href="/profile/?user=<?=$user?>">Редактировать</a></li><? } ?>
            <li data-icon="star" id="add_friend" hide="<?=users::is_friend($user_id, $user)?>"><a href="#" data-user="<?=$user?>">Добавить в друзья</a></li>
            <li data-icon="minus" id="delete_friend" hide="<?=!users::is_friend($user_id, $user)?>"><a href="#" data-user="<?=$user?>">Удалить из друзей</a></li>
            
            <? } ?>
            
        </ul>

        <?  
        
        }
        
        $daily_c = daily::count($user, 0);
        $photos_c = photos::count($user);
        
        if($daily_c > 0 or $photos_c > 0){
        
        ?>
        
        <ul data-role="listview" data-inset="true" data-divider-theme="c">

            <li data-role="list-divider">Разное</li>

            <? if($daily_c > 0){ ?><li data-icon="false"><a href="/daily/?user=<?=$user?>">Записи</a><span class="ui-li-count"><?=$daily_c?></span></li><? } ?>
            <? if($photos_c > 0){ ?><li data-icon="false"><a href="/photos/?user=<?=$user?>">Фотографии</a><span class="ui-li-count"><?=$photos_c?></span></li><? } ?>

        </ul>
        
        <? } ?>
        
         <ul data-role="listview" data-inset="true" data-divider-theme="c">

            <li data-role="list-divider">Навигация</li>

            <li data-icon="arrow-l"><a href="#" data-rel="back">Назад</a></li>

        </ul>
        
    </div>
    
    <div class="content-secondary">
    
                <ul data-role="listview" data-inset="true">
                    
                    <li data-role="list-divider">
                        Информация
                    </li>
                    
                    <?
                        if($profile_g->get_firsname() != ''){
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Имя:</div>
                        <div><?=protect_echo($profile_g->get_firsname())?></div>
                    </li>
                    
                    <?
                    
                        }
                    
                        if($profile_g->get_lastname() != ''){
                        
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Фамилия:</div>
                        <div><?=protect_echo($profile_g->get_lastname())?></div>
                    </li>
                    
                    <?
                    
                        }
                        
                    ?>
                    
                     <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Пол:</div>
                        <div>
                            <?
                        
                            if($user_g -> get_sex() == 1)
                                echo 'Мужской';
                            else
                                echo 'Женский';
                        
                            ?>
                        </div>
                    </li>
                    
                    <?
                    
                        if($profile_g->get_birthday() != ''){
                        
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Дата рождения:</div>
                        <div><?=protect_echo($profile_g->get_birthday())?></div>
                    </li>
                    
                    <?
                    
                        }
                    
                        if($profile_g->get_city() != ''){
                        
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Город:</div>
                        <div><?=protect_echo($profile_g->get_city())?></div>
                    </li>
                    
                    <?
                    
                        }
                    
                        if($user_g -> is_online() == FALSE){
                        
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Состояние:</div>
                        <div><?=date('d.m.y в H:i', protect_echo($user_g->get_online_time()))?> <?=  word_format($user_g -> get_sex(), array('был', 'была'))?> в сети</div>
                    </li>
                    
                    <?
                    
                        }else{
                        
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Состояние:</div>
                        <div>В сети</div>
                    </li>
                    
                    <?
                    
                        }
                        
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Дата регистрации:</div>
                        <div><?=date('d.m.y в H:i', protect_echo($user_g->get_registration()))?></div>
                    </li>
                    
                </ul>
        
                <ul data-role="listview" data-inset="true">
                    
                    <li data-role="list-divider">
                        Контакты
                    </li>
                    
                    <?
                    
                        $status_contacts = FALSE;
                    
                        if($profile_g->get_phone() != ''){
                        
                        $status_contacts = TRUE;
                            
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Телефон:</div>
                        <div><a href="tel:<?=protect_echo($profile_g->get_phone())?>"><?=protect_echo($profile_g->get_phone())?></a></div>
                    </li>
                    
                    <?
                    
                        }
                    
                        if($profile_g->get_skype() != ''){
                        
                        $status_contacts = TRUE;
                        
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Skype:</div>
                        <div><a href="skype:<?=protect_echo($profile_g->get_skype())?>?call"><?=protect_echo($profile_g->get_skype())?></a></div>
                    </li>
                    
                    <?
                    
                        }
                    
                        if($profile_g->get_icq() != ''){
                        
                        $status_contacts = TRUE;
                        
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">ICQ:</div>
                        <div><?=protect_echo($profile_g->get_icq())?></div>
                    </li>
                    
                    <?
                    
                        }
                    
                        if($profile_g->get_twitter() != ''){
                        
                        $status_contacts = TRUE;
                        
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Twitter:</div>
                        <div><a href="https://twitter.com/<?=protect_echo($profile_g->get_twitter())?>" rel="external" target="_blank"><?=protect_echo($profile_g->get_twitter())?></a></div>
                    </li>
                    
                    <?
                    
                        }
                        
                        if($profile_g->get_facebook() != ''){
                        
                        $status_contacts = TRUE;
                        
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Facebook:</div>
                        <div>
                        <?
                            if(is_numeric($profile_g->get_facebook()))
                                echo '<a href="http://www.facebook.com/profile.php?id='.protect_echo($profile_g->get_facebook()).'" rel="external" target="_blank">перейти</a>';
                            else
                                echo '<a href="http://www.facebook.com/'.protect_echo($profile_g->get_facebook()).'" rel="external" target="_blank">'.protect_echo($profile_g->get_facebook()).'</a>';
                        ?>
                        </div>
                    </li>
                    
                    <?
                    
                        }
                        
                        if($profile_g->get_vk() != ''){
                        
                        $status_contacts = TRUE;
                        
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Вконтакте:</div>
                        <div>
                        <?
                            if(is_numeric($profile_g->get_vk()))
                                echo '<a href="http://vk.com/id'.protect_echo($profile_g->get_vk()).'" rel="external" target="_blank">перейти</a>';
                            else
                                echo '<a href="http://vk.com/'.protect_echo($profile_g->get_vk()).'" rel="external" target="_blank">'.protect_echo($profile_g->get_vk()).'</a>';
                        ?>
                        </div>
                    </li>
                    
                    <?
                    
                        }
                        
                        if($profile_g->get_site() != ''){
                        
                        $status_contacts = TRUE;
                        
                    ?>
                    
                    <li style="font-weight: normal">
                        <div style="float:left; width: 146px; color: #808080;">Сайт:</div>
                        <div><a href="<?=protect_echo($profile_g->get_site())?>" rel="external" target="_blank"><?=protect_echo($profile_g->get_site())?></a></div>
                    </li>
                    
                    <?
                    
                        }
                        
                        if(!$status_contacts)
                        {
                            
                            echo '<li style="font-weight: normal">
                                      <div style="color: #808080;">Нет информации</div>
                                  </li>';
                            
                        }
                            
                        
                    ?>
                    
                </ul>
        
                <ul data-role="listview" data-inset="true">
                    
                    <li data-role="list-divider">
                        О себе
                    </li>
                    
                    <?
                    
                        if($profile_g->get_about() != ''){
                            
                    ?>
                    
                    <li style="font-weight: normal">
                        <div><?=format_echo(protect_echo($profile_g->get_about()), TRUE)?></div>
                    </li>
                    
                    <?
                    
                        }  else {
                            
                            echo '<li style="font-weight: normal">
                                      <div style="color: #808080;">Нет информации</div>
                                  </li>';
                            
                        }
                            
                    ?>
                  
    </div>
        
    <div data-role="popup" id="popup" class="photo_popup" data-corners="false" data-tolerance="30,15" >
        <a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Закрыть</a>
        <img src="/modules/get_avatar/?id=<?=intval($user)?>&amp;size=0" alt="">
    </div>
    
</div>

<script src="/static/js/custom/user_information.js"></script>

<? 
    footer();
?>