<?

$result[] = news::count_news($_GET['category'], intval($_GET['hide']));

$n = intval($_GET['n']);
$category = intval($_GET['category']);

$list = news::get_news($category, intval($_GET['hide']), $n);

if($list != false){

    foreach ($list as $news) {

        $result[] = array('id' => intval($news['id']), 'url' => '/news_read/'.generate_url($news['id'].'_'.$news['topic']).'/', 'user' => intval($news['user']), 'topic' => protect_echo($news['topic']), 'text' => protect_echo(clean_echo(news::substr($news['text']))), 'date' => date('d.m в H:i', $news['date']));
        
    }

}


echo json_encode($result);

?>
