<? 
    head('Пользователи в сети', NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/');
?>

<div data-role="content">
    
    <div data-role="navbar" data-iconpos="top">
	<ul>
                <li><a href="/users_online/" class="ui-btn-active">Пользователи в сети</a></li>
                <li><a href="/users_list/">Все пользователи</a></li>
	</ul>
    </div>
    
    <p id="users" data-e="<?=get_elements()?>"></p>

    <?
        pages();
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c" id="management">
    
        <li data-role="list-divider">Навигация</li>
    
        <li data-icon="arrow-l"><a data-rel="back" href="#">Назад</a></li>
             
    </ul>
    
</div>

<script src="/static/js/custom/users_online.js"></script>

<? 
    footer();
?>