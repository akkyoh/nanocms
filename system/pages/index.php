<? 
    head('Главная', NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'); 
?>

<div data-role="content">
    
    <ul data-role="listview" data-inset="true">
        
        <?
        
        $menu = menu::get_menu();

        foreach ($menu as $data) {
            
            if(empty($data['module']))
                echo '<li data-role="list-divider">'.protect_echo($data['name']).'</li>';
            else
            {
                
                if($data['module'] == 'pages')
                {
                    
                    $data_page = pages::get($data['page_id']);
                    
                    $href = 'pages/'.generate_url($data_page['id'].'_'.$data_page['title']);
                    
                }
                else
                    $href = protect_echo($data['module']);
                
                echo '<li data-icon="false"><a href="'.$href.'/">';
                
                if(!empty($data['image']))
                    echo '<img src="/static/images/'.protect_echo($data['image']).'" class="ui-li-icon" alt=""> ';
                
                echo protect_echo($data['name']).'';
                
                if(function_exists($data['about_function']))
                {
                    $about = call_user_func($data['about_function']);
                    if(!empty($about))
                        echo '<span class="ui-li-count">'.protect_echo($about).'</span>';
                }
                    
                echo '</a></li>';
                
            }
            
        }
        
        ?>

    </ul>

    <?
    
    if(users::is_admin($user_id)){
        
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
         
         <li data-icon="plus"><a href="/index_add/">Добавить меню</a></li>
         <li data-icon="gear"><a href="/index_edit/">Редактирование</a></li>
         
    </ul>
    
    <?
    
    }
    
    ?>
    
</div>

<script src="/static/js/custom/main.js"></script>

<? 
    footer();
?>