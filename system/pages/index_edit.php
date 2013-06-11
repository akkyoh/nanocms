<? 
    if(!users::is_admin($user_id))
         exit;
    
    head('Редактирование');
?>

<div data-role="content" style="width: 90%; margin: auto;">
    
    <ul data-role="listview" data-inset="true" id="sortable">
        
        <?
        
        $menu = menu::get_menu();

        foreach ($menu as $data) {
            
            if(empty($data['module']))
                echo '<li data-role="list-divider" id="'.intval($data['id']).'" sort="'.intval($data['sort']).'">'.protect_echo($data['name']).'</li>';
            else
            {
                
                echo '<li data-icon="false" id="'.intval($data['id']).'" sort="'.intval($data['sort']).'">';
                
                if(!empty($data['image']))
                    echo '<img src="/static/images/'.protect_echo($data['image']).'" class="ui-li-icon" alt=""> ';
                
                echo protect_echo($data['name']).'';

                if(function_exists($data['about_function']))
                {
                    $about = call_user_func($data['about_function']);
                    if(!empty($about))
                        echo '<span class="ui-li-count">'.protect_echo($about).'</span>';
                }
                
                echo '</li>';
                
            }
            
        }
        
        ?>

    </ul>

    <div data-role="popup" id="popup" data-overlay-theme="a" data-theme="c" style="min-width: 400px;" class="ui-corner-all">
        <div data-role="header" data-theme="a" class="ui-corner-top">
            <h1>Информация</h1>
        </div>
        <div data-role="content" data-theme="d" style="text-align: center" class="ui-corner-bottom ui-content">
            <p>Выберите действие</p>
            <fieldset class="ui-grid-a">
                <div class="ui-block-a"><a href="#" data-role="button" id="edit" data-theme="c">Изменить</a></div>  
                <div class="ui-block-b"><a href="#" id="delete" data-role="button" data-theme="c">Удалить</a></div>
            </fieldset>
        </div>
    </div>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Навигация</li>
         
         <li data-icon="arrow-l"><a href="/">Меню</a></li>
         <li data-icon="arrow-r"><a href="/pages_list/">Страницы</a></li>
         
    </ul>
    
    <?
    
    if(users::is_auth($auth_user)){
        
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
         
         <li data-icon="plus"><a href="/index_add/">Добавить меню</a></li>
         
    </ul>
    
    <?
    
    }
    
    ?>
    
</div>

<script src="/static/js/jquery_ui.js"></script>
<script src="/static/js/jquery_ui_touch.js"></script>
<script src="/static/js/custom/main_edit.js"></script>

<? 
    footer();
?>