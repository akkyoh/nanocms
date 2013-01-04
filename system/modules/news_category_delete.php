<?php

if(!users::is_admin($user_id))
    exit;

news::delete_category($_GET['id']);

?>
