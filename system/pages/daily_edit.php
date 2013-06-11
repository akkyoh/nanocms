<? 

    page_auth();
    head('Добавление записи');
    
    if(isset($_GET['id'])){
        
        $id = intval($_GET['id']);
        $notes = daily::note_data($id);
        
        $topic = $notes[0]['topic'];
        $text = $notes[0]['text'];
        $hide = $notes[0]['hide'];
        $comments = $notes[0]['comments'];
        $category = $notes[0]['category'];
        
    }else{
        
        $id = NULL;
        $category = intval($_GET['category']);
        
    }
    
    $list_category = daily::get_category($user_id);
    
?>

<div data-role="content">
    
    <?
    
    if($list_category != false){
    
    ?>
    
    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <form id="main" action="#" method="post" data-category="<?=intval($category)?>" data-id="<?=$id?>">

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
            
            <li><a href="/daily_category_add/">Для создания новости необходимо создать категорию.</a></li>
    
    </ul>
            
    <?
        
    }
    
    ?>
    
    <ul data-role="listview" data-inset="true" data-divider-theme="c">

        <li data-role="list-divider">Навигация</li>

        <? if(isset($_GET['id'])){ echo '<li data-icon="arrow-l"><a href="/daily_read/'.generate_url($id.'_'.$topic).'/">К записи</a></li>'; } ?>
        <li data-icon="arrow-u"><a href="/daily_category/?category=<?=intval($category)?>">В категорию</a></li>
        <li data-icon="arrow-l"><a href="/daily/?user=<?=intval($user_id)?>">Список категорий</a></li>
        <li data-icon="arrow-d"><a href="/daily/">Все записи</a></li>

    </ul>
    
</div>

<link rel="stylesheet" type="text/css" href="/static/js/markitup/skins/simple/style.css" />
<link rel="stylesheet" type="text/css" href="/static/js/markitup/sets/bbcode/style.css" />

<script type="text/javascript" src="/static/js/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="/static/js/markitup/sets/bbcode/set.js"></script>

<script src="/static/js/validation/daily_edit.js"></script>
<script src="/static/js/custom/daily_edit.js"></script>

<? 
    footer();
?>