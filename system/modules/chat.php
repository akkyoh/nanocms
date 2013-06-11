<?

$result[] = chat::count();

$n = intval($_GET['n']);

$list = chat::get($n);

if($list != false){

    foreach ($list as $message) {

        $user = new users($message['user'], 'login');

        $result[] = array('id' => intval($message['id']), 'username' => $user -> get_name(), 'user_id' => $message['user'], 'message' => protect_echo($message['text']), 'date' => date('d.m в H:i', $message['date']));
        
    }

}


echo json_encode($result);

?>