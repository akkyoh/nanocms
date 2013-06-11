<?php

if(!users::is_admin($user_id))
    exit;

$position_old = intval($_POST['position_old']);
$position_new = intval($_POST['position_new']);
$id = intval($_POST['id']);

menu::update($position_old, $position_new, $id);

?>
