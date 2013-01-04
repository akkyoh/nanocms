<?php

if(!users::is_auth($auth_user))
    exit;

if(($_GET['user'] != $user_id and !users::is_admin($user_id)) or $config['demo'] == 'TRUE')
    exit;

$user_g = $_GET['user'];

$profile = new profile($user_g);
$user = new users($user_g, 'sex, mail, password');

$field = trim($_POST['field']);
$value = trim($_POST['value']);

if($field == 'password' and mb_strlen($value, 'UTF-8') >= 6 and mb_strlen($value, 'UTF-8') <= 32)
    $user -> set_password(encrypt_password($value));

if($field == 'mail' and filter_var($value, FILTER_VALIDATE_EMAIL))
    $user -> set_mail($value);

if($field == 'firstname' and mb_strlen($value, 'UTF-8') <= 32)
    $profile -> set_firstname($value);

if($field == 'lastname' and mb_strlen($value, 'UTF-8') <= 32)
    $profile -> set_lastname($value);

if($field == 'birthday' and preg_match("/^(0[1-9]|[12][0-9]|3[01])[-](0[1-9]|1[012])[-](19|20)\d\d$/", $value))
    $profile -> set_birthday($value);

if($field == 'sex' and ($value == 1 or $value == 2))
    $user -> set_sex($value);

if($field == 'forum' and ($value == 1 or $value == 2))
    $user -> set_forum($value);

if($field == 'city' and mb_strlen($value, 'UTF-8') <= 32)
    $profile -> set_city($value);

if($field == 'about' and mb_strlen($value, 'UTF-8') <= 255)
    $profile -> set_about($value);

if($field == 'phone' and preg_match('/(\+?\d{1,3}\s)\(?\d{3}\)?\s?\d{1,3}\s?(\-?\s?\d{1,4}){1,2}(\s?\(?(\w*\.?\s?)?\+?\d{1,5}\)?)/', $value))
    $profile -> set_phone($value);

if($field == 'skype' and mb_strlen($value, 'UTF-8') <= 32)
    $profile -> set_skype($value);

if($field == 'icq' and mb_strlen($value, 'UTF-8') <= 9 and is_numeric($value))
    $profile -> set_icq($value);

if($field == 'twitter' and mb_strlen($value, 'UTF-8') <= 32)
    $profile -> set_twitter($value);

if($field == 'facebook' and mb_strlen($value, 'UTF-8') <= 32)
    $profile -> set_facebook($value);

if($field == 'vk' and mb_strlen($value, 'UTF-8') <= 32)
    $profile -> set_vk($value);

if($field == 'site' and mb_strlen($value, 'UTF-8') <= 64 and filter_var($value, FILTER_SANITIZE_URL))
    $profile -> set_site($value);

if($field == 'password' and mb_strlen($value, 'UTF-8') >= 6 and mb_strlen($value, 'UTF-8') <= 32)
    echo 'success_password';

if($field == 'count_e' and ($value == 5 or $value == 10 or $value == 15 or $value == 20 or $value == 25 or $value == 30))
    $user -> set_elements($value);

if($field == 'level' and ($value == 0 or $value == 1 or $value == 7))
    $user -> set_level($value);

if($field == 'timezone' and $value > 0 and $value <= 34)
    $user -> set_timezone($value);

if($field == 'password' and mb_strlen($value, 'UTF-8') >= 6 and mb_strlen($value, 'UTF-8') <= 32)
    echo 'success_password';

$profile -> update();
$user -> update();

if($field == 'forum' and ($value == 1 or $value == 2))
    get_sort(TRUE);

if($field == 'count_e' and ($value == 5 or $value == 10 or $value == 15 or $value == 20 or $value == 25 or $value == 30))
    get_elements(TRUE);

if($field == 'timezone' and $value > 0 and $value <= 34)
    set_timezone(TRUE);

?>
