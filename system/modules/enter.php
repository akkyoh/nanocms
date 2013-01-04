<?php

$user = $_POST['login'];
$password = $_POST['password'];

if(!antiflood('enter', $password, ip2long(get_ip())))
    die(json_encode('false'));

$auth = users::auth($user, $password);

if($auth)
    echo json_encode('true');
else
    echo json_encode('false');

?> 