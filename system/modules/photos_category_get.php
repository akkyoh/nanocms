<?php

$list = photos::get_category($_GET['user']);

if ($list != false) {

    foreach ($list as $c) {

        $result[] = array('id' => intval($c['id']), 'user' => intval($c['user']), 'name' => protect_echo($c['name']), 'about' => protect_echo($c['about']), 'count' => photos::count_category($c['id'], 0));
        
    }
    
    echo json_encode($result);
    
}
else
{
    
    echo json_encode('false');
    
}

?>