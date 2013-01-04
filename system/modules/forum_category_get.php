<?php

$list = forum::get_categories();

if ($list != false) {

    foreach ($list as $categories) {

        $result[] = array('id' => intval($categories['id']), 'name' => protect_echo($categories['name']), 'description' => protect_echo($categories['description']), 'count' => forum::count_themes($categories['id']));
        
    }
    
    echo json_encode($result);
    
}
else
{
    
    echo json_encode('false');
    
}

?>