<?php

$list = news::get_category();

if ($list != false) {

    foreach ($list as $c) {

        $result[] = array('id' => intval($c['id']), 'name' => protect_echo($c['name']), 'about' => protect_echo($c['about']), 'count' => news::count_news($c['id'], 0));
        
    }
    
    echo json_encode($result);
    
}
else
{
    
    echo json_encode('false');
    
}

?>