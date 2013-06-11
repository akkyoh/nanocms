<? 
    head('Новости', NULL, NULL, 'http://'.$_SERVER['HTTP_HOST'].'/'.$_GET['page'].'/'); 
?>

<div data-role="content">
    
    <ul data-role="listview" data-inset="true">
        
        <li data-role="list-divider">Новости</li>
        
        <?

        $list = news::get_last(0);

        if($list != false){

            foreach ($list as $news) {

                echo '<li data-id="'.intval($news['id']).'" data-icon="false"><a href="/news_read/'.generate_url($news['id'].'_'.$news['topic']).'/">'.users::print_avatar($news['user'], 2, '1.0').'<h3 style="font-size: 14px">'.protect_echo($news['topic']).'</h3><p>'.protect_echo(clean_echo(news::substr($news['text'])));
                echo '</p><p class="ui-li-aside">' . date('d.m в H:i', $news['date']) . '</p></a></li>';

            }

        }else{

            echo '<li>Новостей нет.</li>';

        }

        ?>
        
    </ul>
    
    <p id="categories"></p>
    
    <?
    
    if(users::is_admin($user_id)){
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">
    
         <li data-role="list-divider">Управление</li>
        
    <?
    
        echo '<li data-icon="star"><a href="/news_draft/">Черновики</a></li>';
        echo '<li data-icon="gear"><a href="/news_category_add/">Добавить категорию</a></li></ul>';
            
    }
        
    ?>
    
    <? if(users::is_admin($user_id)){ ?>
    
    <div data-role="popup" id="popup" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
        <div data-role="header" data-theme="a" class="ui-corner-top">
            <h1>Информация</h1>
        </div>
        <div data-role="content" data-theme="d" style="text-align: center" class="ui-corner-bottom ui-content">
            <p>Вы действительно желаете удалить категорию?</p>
            <fieldset class="ui-grid-a">
                <div class="ui-block-a"><a href="#" data-role="button"  data-rel="back" data-theme="c">Отмена</a></div>  
                <div class="ui-block-b"><a href="#" id="delete" data-rel="back" data-role="button" data-transition="flow" data-theme="b">Удалить</a></div>
            </fieldset>
        </div>
    </div>
    
    <? } ?>
    
</div>

<script src="/static/js/custom/news.js"></script>

<?
    footer();
?>