<?php

if(!users::is_admin($user_id))
    exit;

forum::delete_category($_GET['id']);

?>
