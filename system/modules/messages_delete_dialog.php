<?php

if(!users::is_auth($auth_user))
    exit;

messages::delete_dialog($user_id, $_GET['id']);

?>
