<? 
    head('Карта сайта', NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'); 
?>

<div data-role="content">
    
    <ul data-role="listview" data-inset="true">
           
        <li data-role="list-divider">
            Новости
        </li>
    
        <li>
            <a href="/news/">Свежие новости</a>
        </li>
        
        <?
        
            $list = news::get_category();
        
            if($list != false){
                
                foreach($list as $c){
            
                    echo '<li><a href="/news_category/?category='.intval($c['id']).'">'.protect_echo($c['name']).'</a></li>';
                
                }
                
            }
        
        ?>
        
    </ul>
   
    <ul data-role="listview" data-inset="true">
           
        <li data-role="list-divider">
            Пользователи
        </li>
    
        <li>
            <a href="/users_online/">Пользователи в сети</a>
        </li>
    
        <li>
            <a href="/users_list/">Все пользователи</a>
        </li>
    
    </ul>
   
    <?
        
    $list = pages::get_list($n);

    if($list != false){

        ?>
    
        <ul data-role="listview" data-inset="true">

            <li data-role="list-divider">
               Страницы
            </li>
    
        <?
        
        foreach ($list as $page) {

            echo '<li><a href="/pages/'.generate_url($page['id'].'_'.$page['title']).'/">'.protect_echo($page['title']).'</a>';
                
        }   
        
        ?>
        
        </ul>
            
        <?
        
    }
    
    $list = forum::get_categories();

    if ($list != false) {

    ?>
    
    <ul data-role="listview" data-inset="true">
           
        <li data-role="list-divider">
            Форум
        </li>
    
        <?
        
        foreach ($list as $categories) {
            
            echo '<li><a href="/forum_category/?id=' . intval($categories['id']) . '">' . protect_echo($categories['name']) . '</a>';
            
        }
        
        echo '</ul>';
        
   }
        
   ?>
     
    <ul data-role="listview" data-inset="true">
           
        <li data-role="list-divider">
            Общение
        </li>
        
        <li>
            <a href="/guestbook/">Гостевая книга</a>
        </li>
        
        <li>
            <a href="/chat/">Чат</a>
        </li>
    
    </ul>
    
    <?
    
    $list = files::get_category();

    if ($list != false) {
    
        ?>
        
        <ul data-role="listview" data-inset="true">
           
            <li data-role="list-divider">
                Файлы
            </li>
            
            <?

            foreach ($list as $c) {

                echo '<li><a href="/files/?category='.intval($c['id']).'">' . protect_echo($c['name']) . '</a>';
                
            }
    
        echo '</ul>';
            
    }
        
    ?>
    
    <ul data-role="listview" data-inset="true">
           
        <li data-role="list-divider">
            Разное
        </li>
        
        <li>
            <a href="/daily/">Дневники</a>
        </li>
    
        <li>
            <a href="/photos/">Фотоальбом</a>
        </li>
        
    </ul>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c" id="management">
    
        <li data-role="list-divider">Навигация</li>
    
        <li data-icon="arrow-l"><a data-rel="back" href="#">Назад</a></li>
             
    </ul>
    
</div>

<?
    footer();
?>