<?

$result[] = array('count' => files::count_category($_GET['category']), 'parent' => files::get_parent($_GET['category']));

$n = intval($_GET['n']);
$category = intval($_GET['category']);

if($category > 0)
    $n_url = '?nc='.$n;
else
    $n_url = '?na='.$n;

$list = files::get($category, $n);

if($list != false){

    foreach ($list as $file) {

        $result[] = array('id' => intval($file['id']), 'url' => '/files_show/'.generate_url($file['id'].'_'.$file['name']).'/'.$n_url, 'image' => files::get_image($file['filetype'], $file['id']), 'name' => protect_echo($file['name']), 'date' => date('d.m в H:i', $file['date']));
        
    }

}


echo json_encode($result);

?>