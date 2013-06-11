<?

$result[] = daily::count_category($_GET['category'], intval($_GET['hide']));

$n = intval($_GET['n']);
$category = intval($_GET['category']);

$list = daily::get($_GET['user'], $category, intval($_GET['hide']), $n);

if($list != false){

    foreach ($list as $note) {

        $result[] = array('id' => intval($note['id']), 'url' => '/daily_read/'.generate_url($note['id'].'_'.$note['topic']).'/', 'user' => $note['user'], 'topic' => protect_echo($note['topic']), 'text' => protect_echo(daily::substr(clean_echo($note['text']))), 'date' => date('d.m в H:i', $note['date']));

    }

}

echo json_encode($result);

?>