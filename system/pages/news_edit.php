<? 

    if(!users::is_admin($user_id))
        exit;
    
    head('Добавление новости');
    
    if(isset($_GET['id'])){
        
        $id = intval($_GET['id']);
        $news = news::current_news($id);
        
        $topic = $news[0]['topic'];
        $text = $news[0]['text'];
        $hide = $news[0]['hide'];
        $comments = $news[0]['comments'];
        $category = $news[0]['category'];
        
    }else{
        
        $category = intval($_GET['category']);
        
    }
    
    $list_category = news::get_category();
    
?>

<div data-role="content">
    
    <?
    
    if($list_category != false){
    
    ?>
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <form id="main" action="#" method="post" data-category="<?=$category?>" data-id="<?=$id?>">

        <ul data-role="listview" data-inset="true">
            
            <li data-role="list-divider">
                Заголовок
            </li>
            
            <li>
                <input type="text" name="topic" id="topic" value="<?=protect_echo($topic)?>"/>
                <p id="topic_error" class="error_message"></p>
            </li>
            
            <li data-role="list-divider">
                Текст
            </li>
            
            <li>
                <textarea name="text" id="markitup"><?=protect_echo($text)?></textarea>
                <p id="text_error" class="error_message"></p>
            </li>
            
            <li data-role="list-divider">
                Категория
            </li>
            
            <li>
                <select name="category" id="category" data-native-menu="false">
                    
                    <?
                    
                    foreach($list_category as $c){
                    
                        echo '<option value="'.intval($c['id']).'"';
                        
                        if($c['id'] == $category)
                            echo ' selected="true"';
                        
                        echo '>'.protect_echo($c['name']).'</option>';
                    
                    }
                    
                    ?>
                    
                </select>
            </li>
            
            <li data-role="list-divider">
                Прочее
            </li>
            
            <li>
                <fieldset data-role="controlgroup">
                    
                    <input type="checkbox" name="public" id="public" <? if($hide == 1) echo 'checked="checked"'; ?>/>
                    <label for="public">Черновик</label>
                    
                    <input type="checkbox" name="comments" id="comments" <? if($comments == 1) echo 'checked="checked"'; ?>/>
                    <label for="comments">Разрешить комментарии</label>
                    
                </fieldset>
            </li>
            
            <li>
                <input type="submit" id="submit" value="Сохранить">
            </li>
        
        </ul>

    </form>

    <?
    
    }else{
        
    ?>
    
    <ul data-role="listview" data-inset="true">
            
            <li data-role="list-divider">
                Заголовок
            </li>
            
            <li><a href="/news_category_add/">Для создания новости необходимо создать категорию.</a></li>
    
    </ul>
            
    <?
        
    }
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">

        <li data-role="list-divider">Управление</li>

        <? if(isset($_GET['id'])){ echo '<li data-icon="arrow-l"><a href="/news_read/'.generate_url($_GET['id'].'_'.$topic).'/">К новости</a></li>'; } ?>
        <li data-icon="arrow-l"><a href="/news_category/?category=<?=$category?>">В категорию</a></li>
        <li data-icon="arrow-l"><a href="/news/">Список категорий</a></li>

    </ul>
    
</div>

<link rel="stylesheet" type="text/css" href="/static/js/markitup/skins/simple/style.css" />
<link rel="stylesheet" type="text/css" href="/static/js/markitup/sets/bbcode/style.css" />

<script type="text/javascript" src="/static/js/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="/static/js/markitup/sets/bbcode/set.js"></script>

<script src="/static/js/validation/news_edit.js"></script>
<script src="/static/js/custom/news_edit.js"></script>

<? 
    footer();
?>