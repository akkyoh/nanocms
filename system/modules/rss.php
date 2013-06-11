<?php

define('DATE_FORMAT_RFC822','r');
header("Content-type: application/rss+xml");

echo '<?xml version="1.0" encoding="utf-8"?>';

?>

<rss version="2.0">
<channel>
    <title>Новостная лента</title>
    <link>http://<?=$_SERVER['HTTP_HOST']?></link>
    <description>Новостная лента сайта <?=$_SERVER['HTTP_HOST']?>. Будьте в курсе всех событий нашего портала!</description>
<?    

$list = news::get_last(0);

if($list != false){

    foreach ($list as $news) {
                
        ?>
        <item>
            <title><?=protect_echo($news['topic'])?></title>
            <description><![CDATA[<?=protect_echo(clean_echo($news['text']))?>]]></description>
            <link>http://<?=$_SERVER['HTTP_HOST']?>/news_read/<?=generate_url($news['id'].'_'.$news['topic'])?>/</link>
            <pubDate><?=date(DATE_FORMAT_RFC822, $news['date'])?></pubDate>
        </item>
        <?
        
    }

}

?>
</channel>
</rss>