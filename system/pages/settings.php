<? 

    page_auth();
    head('Настройки');
    
    $user_d = new users($user_id, 'mail, elements, timezone, forum');
    
?>

<div data-role="content" data-user="<?=intval($user_id)?>">
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <form id="main" action="#" method="post">

        <ul data-role="listview">
                    
            <li data-role="fieldcontain">
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" value=""/>
                <p id="password_error" class="error_message"></p>
            </li>
            
            <li data-role="fieldcontain">
                <label for="mail">Почтовый ящик</label>
                <input type="text" name="mail" id="mail" value="<?=protect_echo($user_d -> get_mail())?>"/>
                <p id="mail_error" class="error_message"></p>
            </li>
            
            <li data-role="fieldcontain">
                <label for="count_e">Элементов на странице</label>
                <select name="count_e" id="count_e" data-native-menu="false">
                    <option value="5"<? if($user_d -> get_elements() == 5){ echo 'selected="true"'; } ?>>5</option>
                    <option value="10"<? if($user_d -> get_elements() == 10){ echo 'selected="true"'; } ?>>10</option>
                    <option value="15"<? if($user_d -> get_elements() == 15){ echo 'selected="true"'; } ?>>15</option>
                    <option value="20"<? if($user_d -> get_elements() == 20){ echo 'selected="true"'; } ?>>20</option>
                    <option value="25"<? if($user_d -> get_elements() == 25){ echo 'selected="true"'; } ?>>25</option>
                    <option value="30"<? if($user_d -> get_elements() == 30){ echo 'selected="true"'; } ?>>30</option>
                </select>
            </li>
            
            <li data-role="fieldcontain">
                <label for="forum">Порядок сообщений на форуме</label>
                <select name="forum" id="forum" data-native-menu="false">
                    <option value="1"<? if($user_d -> get_forum() == 1){ echo 'selected="true"'; } ?>>Прямой</option>
                    <option value="2"<? if($user_d -> get_forum() == 2){ echo 'selected="true"'; } ?>>Обратный</option>
                </select>
            </li>
            
            <li data-role="fieldcontain">
                <label for="timezone">Часовой пояс</label>
                <select name="timezone" id="timezone" data-native-menu="false">
                    <?
                        $c_timezones = count($timezones);
                        for($i = 1; $i <= $c_timezones; $i++){
                            echo '<option value="'.$i.'"'; if($user_d -> get_timezone() == $i){ echo 'selected="true"'; } echo '>(UTC'; if($timezones[$i]['zone'] == 0){ echo '-'; }elseif($timezones[$i]['zone'] > 0){ echo '+'; } echo $timezones[$i]['zone'].') '.$timezones[$i]['name'].'</option>';
                        }
                    ?>
                </select>
            </li>
        
        </ul>

    </form>

</div>

<script src="/static/js/validation/settings.js"></script>
<script src="/static/js/custom/settings.js"></script>

<? 
    footer();
?>