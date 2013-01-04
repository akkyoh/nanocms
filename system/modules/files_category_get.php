<?php

$list = files::get_category($_GET['category']);

if ($list != false) {

    foreach ($list as $c) {

        $result[] = array('id' => intval($c['id']), 'name' => protect_echo($c['name']), 'about' => protect_echo($c['about']), 'count' => files::count_category($c['id']));
        
    }
    
    echo json_encode($result);
    
}
else
{
    
    echo json_encode('false');
    
}

?>