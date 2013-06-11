<?

$result[] = users::count();

$n = intval($_GET['n']);

$list = users::get($n);

if($list != false){

    foreach ($list as $users) {

        $result[] = array('user' => intval($users['id']), 'name' => protect_echo($users['login']), 'date' => date('d.m.Y в H:i', $users['last_update']));
        
    }

}

echo json_encode($result);

?>