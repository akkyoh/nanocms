<?

$result[] = photos::count_category($_GET['category']);

$n = intval($_GET['n']);
$category = intval($_GET['category']);

$list = photos::get($_GET['user'], $category, $n);

if($list != false){

    foreach ($list as $photo) {

        $result[] = array('id' => intval($photo['id']), 'user' => intval($photo['user']), 'name' => protect_echo($photo['name']), 'description' => protect_echo($photo['description']), 'date' => date('d.m в H:i', $photo['date']));
        
    }

}

echo json_encode($result);

?>