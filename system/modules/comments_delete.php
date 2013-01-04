<?php

if(!users::is_auth($auth_user))
    exit;

$comment_data = comments::get_data($_GET['id']);

if($comment_data['type'] == 'photos')
{
    $photo_data = photos::photo_data($comment_data['category']);
    
    if($photo_data['user'] != $user_id and !users::is_admin($user_id))
        exit;
    
}
elseif($comment_data['type'] == 'daily')
{
    $daily_data = daily::note_data($comment_data['category']);
    
    if($daily_data[0]['user'] != $user_id and !users::is_admin($user_id))
        exit;
}
else
{
    if(!users::is_admin($user_id))
        exit;
}

comments::delete($_GET['id']);

?>
