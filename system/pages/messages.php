<? 

    page_auth();
    head('Сообщения'); 
    
?>

<div data-role="content">	

    <div id="information" class="ui-content" data-role="popup" data-theme="b"></div>
    
    <div style="padding-top: 10px">
    
        <ul data-role="listview" data-inset="true" data-filter="true">

            <li data-role="list-divider">Диалоги</li>

            <?

            $list = messages::get_list($user_id);

            if($list != false){

                foreach ($list as $messages) {

                    if($messages['from'] == $user_id)
                        $autor = $messages['whom'];
                    else
                        $autor = $messages['from'];

                    $user = new users($autor, 'login');

                    if(messages::unread_group($user_id, $messages['from'], $messages['whom']) > 0){
                        $o = '0.7';
                    }else{
                        $o = '1';
                    }

                    echo '<li data-icon="false" data-id="'.intval($autor).'"><a href="/messages_dialog/?id='.intval($autor).'">'.users::print_avatar($autor, 2, $o).'<h3 style="font-size: 14px">'.$user -> get_name().'</h3><p>'.protect_echo(mb_substr($messages['text'], 0, 50, 'UTF-8'));
                    if(mb_strlen($messages['text']) > 50)
                        echo '...';
                    echo '</p><p class="ui-li-aside" style="padding-top: 18px">'.date('d.m в H:i', $messages['time']).'</p></a>';

                    echo '</li>';

                }

            }else{

                echo '<li>Сообщений нет</li>';

            }

            ?>

        </ul>
        
    </div>
    
    <div data-role="popup" id="popup" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
        <div data-role="header" data-theme="a" class="ui-corner-top">
            <h1>Информация</h1>
        </div>
        <div data-role="content" data-theme="d" style="text-align: center" class="ui-corner-bottom ui-content">
            <p>Вы действительно желаете удалить диалог?</p>
            <fieldset class="ui-grid-a">
                <div class="ui-block-a"><a href="#" data-role="button"  data-rel="back" data-theme="c">Отмена</a></div>  
                <div class="ui-block-b"><a href="/messages/" id="delete" data-ajax="false" data-transition="flow" data-role="button" data-theme="b">Удалить</a></div>
            </fieldset>
        </div>
    </div>
    
</div>

<script src="/static/js/custom/messages.js"></script>

<? 
    footer();
?>