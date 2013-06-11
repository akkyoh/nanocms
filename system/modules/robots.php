<?

header("Content-type: text/plain");

if($config['demo'] == 'TRUE')
{
    
die('User-agent: *
Disallow: /');
    
}

?>
User-agent: *
Disallow: /tools
Disallow: /system
Disallow: /demo

Host: <?=$_SERVER['HTTP_HOST'].PHP_EOL?>
Sitemap: http://<?=$_SERVER['HTTP_HOST']?>/sitemap.xml