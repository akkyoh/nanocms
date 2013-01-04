<?php

$mail = $_GET['mail'];

$q = $db -> query("SELECT 1 from `users` WHERE `mail` = ?;", $mail);

if(empty($q))
    echo 'true';
else
    echo 'false';

?>