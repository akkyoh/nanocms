<?php

if(!users::is_admin($user_id))
    exit;

forum::theme_close($_GET['id']);

?>
