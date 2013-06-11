<?php

if(!users::is_admin($user_id))
    exit;

chat::delete($_GET['id']);

?>
