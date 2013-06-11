<?php

if(!users::is_admin($user_id))
    exit;

if($config['demo'] == 'TRUE')
    exit;

menu::delete($_GET['id']);

?>
