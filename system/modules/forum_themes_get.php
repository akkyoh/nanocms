<?

$result[] = forum::count_themes($_GET['category']);

$n = intval($_GET['n']);
$category = intval($_GET['category']);

$list = forum::get_themes($category, $n);

if($list != false){

    foreach ($list as $theme) {

        $user = new users($theme['user'], 'login');

        if($theme['close'] == 1 and $theme['warning'] == 1)
            $status = 'Тема закреплена и закрыта';
        elseif($theme['close'] == 1)
            $status = 'Тема закрыта';
        elseif($theme['warning'] == 1)
            $status = 'Тема закреплена';
        else
            $status = '';
        
        $result[] = array('id' => intval($theme['id']), 'url' => '/forum_theme_read/'.generate_url($theme['id'].'_'.$theme['name']).'/', 'user' => $theme['user'], 'status' => $status, 'name' => protect_echo($theme['name']), 'count' => forum::count_messages($theme['id']).' '.word_format(forum::count_messages($theme['id']), array('сообщение','сообщения','сообщений')), 'date' => date('d.m в H:i', $theme['date']));
        
    }

}


echo json_encode($result);

?>