<?php

if(!users::is_auth($auth_user))
    exit;

forum::delete_favorite($user_id, $_GET['id']);

?>
