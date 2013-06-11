<?

$result[] = pages::count();

$n = intval($_GET['n']);

$list = pages::get_list($n);

if($list != false){

    foreach ($list as $page) {

        $result[] = array('id' => intval($page['id']), 'url' => '/pages/'.generate_url($page['id'].'_'.$page['title']).'/', 'title' => protect_echo($page['title']), 'description' => protect_echo($page['description']));
        
    }

}


echo json_encode($result);

?>