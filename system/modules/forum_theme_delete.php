<?php

if(!users::is_admin($user_id))
    exit;

forum::theme_delete($_GET['id']);

?>
