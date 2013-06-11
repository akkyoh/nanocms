<?

if(!users::is_auth($auth_user))
    exit;

$result[] = messages::count_messages($user_id, $_GET['id']);

$user_d = $_GET['id'];
$n = intval($_GET['n']);

$list = messages::get_messages($user_id, $user_d, $n);

if($list != false){

    foreach ($list as $messages) {

        $user = new users($messages['from'], 'login');

        if($messages['read'] == 0){
            $o = '0.7';
        }else{
            $o = '1';
        }

        $result[] = array('id' => intval($messages['id']), 'avatar' => $o, 'user' => $messages['from'], 'name' => $user->get_name(), 'text' => protect_echo($messages['text']), 'date' => date('d.m в H:i', $messages['time']));
        
        if($messages['read'] == 0){

            if($messages['from'] != $user_id)
                $unread[] = $messages['id'];

        }

    }

    if(count($unread) > 0){

        messages::set_read($unread);

    }

    echo json_encode($result);
    
}

?>