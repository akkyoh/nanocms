<?

$result[] = forum::count_messages($_GET['theme']);

$n = intval($_GET['n']);
$theme = intval($_GET['theme']);

$list = forum::get_messages($theme, $n);

if($list != false){

    foreach ($list as $message) {

        $user = new users($message['user'], 'login');

        $result[] = array('id' => intval($message['id']), 'username' => $user -> get_name(), 'user_id' => $message['user'], 'message' => format_echo(protect_echo($message['text']), TRUE), 'date' => date('d.m в H:i', $message['date']));
        
    }

}


echo json_encode($result);

?>
