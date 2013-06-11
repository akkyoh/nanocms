<?php

$list = forum::get_favorites($user_id);

if ($list != false) {

    foreach ($list as $theme) {

        $result[] = array('id' => intval($theme['id']), 'url' => '/forum_theme_read/'.generate_url($theme['id'].'_'.$theme['name']).'/', 'user' => $theme['user'], 'name' => protect_echo($theme['name']), 'count' => forum::count_messages($theme['id']).' '.word_format(forum::count_messages($theme['id']), array('сообщение','сообщения','сообщений')), 'date' => date('d.m в H:i', $theme['date']));
        
    }
    
    echo json_encode($result);
    
}
else
{
    
    echo json_encode('false');
    
}

?>