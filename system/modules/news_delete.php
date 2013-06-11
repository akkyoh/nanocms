<?php

if(!users::is_admin($user_id))
    exit;

news::delete($_GET['id']);

?>
