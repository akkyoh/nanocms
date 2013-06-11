<?php

if(!users::is_auth($auth_user))
    exit;

messages::delete($user_id, $_GET['id']);

?>
