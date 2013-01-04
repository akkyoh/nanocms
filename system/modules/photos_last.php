<?

$result[] = photos::count($_GET['user']);

$n = intval($_GET['n']);

$list = photos::get_last($_GET['user'], $n);

if($list != false){

    foreach ($list as $photo) {

        $result[] = array('id' => intval($photo['id']), 'url' => '/photos_show/'.generate_url($photo['id'].'_'.$photo['name']).'/', 'user' => intval($photo['user']), 'name' => protect_echo($photo['name']), 'description' => protect_echo($photo['description']), 'date' => date('d.m в H:i', $photo['date']));
        
    }

}

echo json_encode($result);

?>
