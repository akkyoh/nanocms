<?php

if(!users::is_admin($user_id))
    exit;

guestbook::delete($_GET['id']);

?>
