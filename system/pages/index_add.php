<? 

    if(!users::is_admin($user_id))
         exit;
    
    if(!isset($_GET['id']))
    {
        head('Добавление меню');
    }
    else
    {
        head('Редактирование меню');
        
        $id = intval($_GET['id']);
        $data_menu = menu::get_data($id);
        
    }
?>

<div data-role="content">
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <form id="main" action="#" method="post">

        <ul data-role="listview" data-inset="true">

            <li data-role="list-divider">Меню</li>
            
            <li data-role="fieldcontain">
                <label for="name">Название меню</label>
                <input type="text" name="name" id="name" value="<?=protect_echo($data_menu['name'])?>"/>
                <p id="name_error" class="error_message"></p>
            </li>
            
            <li data-role="fieldcontain">
                <label for="module">Модуль</label>
                <select name="module" id="module" data-native-menu="false">
                    <?
                        
                        $selected = FALSE;
                    
                        foreach ($modules as $key => $value) {
                            echo '<option value="'.$key.'"'; if($data_menu['module'] == $key or (!$selected and $data_menu['module'] != '' and $key == 'other')){ $selected = TRUE; echo 'selected="true"'; } echo '>'.protect_echo($value).'</option>';
                        }
                        
                    ?>
                </select>
            </li>
            
            <li data-role="fieldcontain">
                <label for="module_custom">Произвольный модуль</label>
                <input type="text" name="module_custom" id="module_custom" value="<?=protect_echo($data_menu['module'])?>"/>
            </li>
            
            <li data-role="fieldcontain">
                <label for="page">Страница</label>
                <select name="page" id="page" data-native-menu="false">
                    <?
                        
                        $list = pages::get_list(NULL);
                        
                        if($list != false){
                        
                        foreach ($list as $page) {
                            echo '<option value="'.intval($page['id']).'"'; if($data_menu['page_id'] == $page['id']){ echo 'selected="true"'; } echo '>'.protect_echo($page['title']).'</option>';
                        }
                        
                        }
                        else
                        {
                            echo '<option value="0">страница не выбрана</option>';
                        }
                        
                    ?>
                </select>
            </li>
            
            <li data-role="fieldcontain">
                <label for="image">Картинка</label>
                <input type="text" name="image" id="image" value="<?=protect_echo($data_menu['image'])?>"/>
                <p id="image_error" class="error_message"></p>
            </li>
            
            <li data-role="fieldcontain">
                <label for="about">Функция или текст для информации</label>
                <input type="text" name="about" id="about" value="<?=protect_echo($data_menu['about_function'])?>"/>
                <p id="about_error" class="error_message"></p>
            </li>
            
            <li>
                <input type="hidden" id="id" name="id" value="<?=$id?>">
                <input type="submit" id="submit" value="Продолжить">
            </li>
            
        </ul>
        
    </form>
        
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
        
        <li data-role="list-divider">Навигация</li>
            
        <li data-icon="arrow-l"><a href="/">Меню</a></li>
            
    </ul>
        
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
        
        <li data-role="list-divider">Управление</li>
            
        <li data-icon="gear"><a href="/index_edit/">Редактирование</a></li>
            
    </ul>
    
</div>

<script src="/static/js/validation/main_add.js"></script>
<script src="/static/js/custom/main_add.js"></script>

<?
    footer();
?>