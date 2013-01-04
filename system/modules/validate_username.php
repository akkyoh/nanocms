<?php

$name = $_GET['name'];

$q = $db -> query("SELECT 1 from `users` WHERE `login`=?", $name);

if(empty($q))
    echo 'true';
else
    echo 'false';
    
?>