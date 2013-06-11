<?php

if(!users::is_admin($user_id))
    exit;

forum::message_delete($_GET['id']);

?>
