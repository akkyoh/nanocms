<? 

    page_auth();
    head('Анкета');
    
    if(isset($_GET['user']))
        $user_g = intval($_GET['user']);
    else
        $user_g = intval($user_id);
    
    $profile_d = new profile($user_g);
    $user_d = new users($user_g, 'sex, mail, level');
    
?>

<div data-role="content" data-user="<?=$user_g?>">
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <div data-role="collapsible-set">
    
        <div data-role="collapsible" data-collapsed="false">

            <h2>Основное</h2>
            
            <form id="main" action="#" method="post">

                <ul data-role="listview">
                    
                    <li data-role="fieldcontain">
                        <label for="firstname">Имя</label>
                        <input type="text" name="firstname" id="firstname" value="<?=protect_echo($profile_d->get_firsname())?>"/>
                        <p id="firstname_error" class="error_message"></p>
                    </li>
                    
                    <li data-role="fieldcontain">
                        <label for="lastname">Фамилия</label>
                        <input type="text" name="lastname" id="lastname" value="<?=protect_echo($profile_d->get_lastname())?>"/>
                        <p id="lastname_error" class="error_message"></p>
                    </li>
            
                    <li data-role="fieldcontain">
                        <label for="sex" class="select">Пол</label>
                        <select name="sex" id="sex" data-native-menu="false">
                            <option value="1"<? if($user_d -> get_sex() == 1){ echo 'selected="true"'; } ?>>мужской</option>
                            <option value="2"<? if($user_d -> get_sex() == 2){ echo 'selected="true"'; } ?>>женский</option>
                        </select>
                    </li>
                    
                    <li data-role="fieldcontain">
                        <label for="city">Дата рождения</label>
                        <input type="text" name="birthday" id="birthday" value="<?=protect_echo($profile_d->get_birthday())?>"/>
                        <p id="birthday_error" class="error_message"></p>
                    </li>
                    
                    <li data-role="fieldcontain">
                        <label for="city">Город</label>
                        <input type="text" name="city" id="city" value="<?=protect_echo($profile_d->get_city())?>"/>
                        <p id="city_error" class="error_message"></p>
                    </li>
                    
                </ul>

            </form>

        </div>

        <?
        
        if(users::is_admin($user_id))
        {
           
        ?>
        
        <div data-role="collapsible">

            <h2>Настройки</h2>
            
            <form id="settings" action="#" method="post">
            
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
                
                    <?
                        $selected_level[$user_d -> get_level()] = ' checked="checked"';
                    ?>
                    
                    <li data-role="fieldcontain">
                        <fieldset data-role="controlgroup">
                    
                            <legend>Права:</legend>
         	
                            <input type="radio" name="level" id="user_blocked" value="0"<?=$selected_level[0]?>/>
                            <label for="user_blocked">Заблокирован</label>
                            
                            <input type="radio" name="level" id="user" value="1"<?=$selected_level[1]?>/>
                            <label for="user">Пользователь</label>

                            <input type="radio" name="level" id="user_admin" value="7"<?=$selected_level[7]?>/>
                            <label for="user_admin">Администратор</label>
                            
                        </fieldset>
                    </li>

                </ul>
                
            </form>
            
        </div>
        
        <?
           
        }
        else
        {
            
            echo '<form id="settings" action="#" method="post"></form>';
            
        }
        
        ?>
        
        <div data-role="collapsible">

            <h2>Контакты</h2>
            
            <form id="contacts" action="#" method="post">
            
                <ul data-role="listview">
                
                    <li data-role="fieldcontain">
                        <label for="phone">Телефон</label>
                        <input type="text" name="phone" id="phone" value="<?=protect_echo($profile_d->get_phone())?>"/>
                        <p id="phone_error" class="error_message"></p>
                    </li>

                    <li data-role="fieldcontain">
                        <label for="skype">Skype</label>
                        <input type="text" name="skype" id="skype" value="<?=protect_echo($profile_d->get_skype())?>"/>
                        <p id="skype_error" class="error_message"></p>
                    </li>

                    <li data-role="fieldcontain">
                        <label for="icq">ICQ</label>
                        <input type="text" name="icq" id="icq" value="<?=protect_echo($profile_d->get_icq())?>"/>
                        <p id="icq_error" class="error_message"></p>
                    </li>

                    <li data-role="fieldcontain">
                        <label for="twitter">Twitter</label>
                        <input type="text" name="twitter" id="twitter" value="<?=protect_echo($profile_d->get_twitter())?>"/>
                        <p id="twitter_error" class="error_message"></p>
                    </li>

                    <li data-role="fieldcontain">
                        <label for="facebook">Facebook</label>
                        <input type="text" name="facebook" id="facebook" value="<?=protect_echo($profile_d->get_facebook())?>"/>
                        <p id="facebook_error" class="error_message"></p>
                    </li>

                    <li data-role="fieldcontain">
                        <label for="vk">Вконтакте</label>
                        <input type="text" name="vk" id="vk" value="<?=protect_echo($profile_d->get_vk())?>"/>
                        <p id="vk_error" class="error_message"></p>
                    </li>

                    <li data-role="fieldcontain">
                        <label for="site">Сайт</label>
                        <input type="text" name="site" id="site" value="<?=protect_echo($profile_d->get_site())?>"/>
                        <p id="site_error" class="error_message"></p>
                    </li>

                </ul>
                
            </form>
                
        </div>

        <div data-role="collapsible">

            <h2>О себе</h2>
            
            <form id="about" action="#" method="post">
            
                <ul data-role="listview">
                    
                    <li>
                        <textarea name="about" id="markitup"><?=protect_echo($profile_d->get_about())?></textarea>
                        <p id="about_error" class="error_message"></p>
                    </li>
                    
                </ul>
                
            </form>

        </div>
        
    </div>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">

        <li data-role="list-divider">Навигация</li>

        <li data-icon="arrow-l"><a href="#" data-rel="back">Назад</a></li>

    </ul>
        
</div>

<link rel="stylesheet" type="text/css" href="/static/js/markitup/skins/simple/style.css" />
<link rel="stylesheet" type="text/css" href="/static/js/markitup/sets/bbcode/style.css" />

<script type="text/javascript" src="/static/js/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="/static/js/markitup/sets/bbcode/set.js"></script>

<script src="/static/js/validation/profile.js"></script>
<script src="/static/js/custom/profile.js"></script>

<? 
    footer();
?>