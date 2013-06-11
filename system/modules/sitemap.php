<?php

$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/</loc><changefreq>weekly</changefreq><priority>0.5</priority></url>'.PHP_EOL; # Главная
$sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/news/</loc><changefreq>daily</changefreq><priority>1.0</priority></url>'.PHP_EOL; # Новости

$list = news::get_category();

if($list != false)
    foreach($list as $c)
    {
        $sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/news_category/?category='.intval($c['id']).'</loc><changefreq>daily</changefreq><priority>0.5</priority></url>'.PHP_EOL; # Категории новостей
    }
        
$list = news::get_last(0);
if($list != false)
    foreach ($list as $news) 
    {
        $sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/news_read/'.generate_url($news['id'].'_'.$news['topic']).'/</loc><lastmod>'.date('Y-m-d', $news['date']).'</lastmod><changefreq>daily</changefreq><priority>0.3</priority></url>'.PHP_EOL; # Список новостей
    }
        
$sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/users_online/</loc><changefreq>weekly</changefreq><priority>0.1</priority></url>'.PHP_EOL; # Пользователи в сети
$sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/users_list/</loc><changefreq>weekly</changefreq><priority>0.1</priority></url>'.PHP_EOL; # Все пользователи
$sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/registration/</loc><changefreq>monthly</changefreq><priority>0.1</priority></url>'.PHP_EOL; # Регистрация

$list = pages::get_list($n);
if($list != false)
    foreach ($list as $page)
    {
        $sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/pages/'.generate_url($page['id'].'_'.$page['title']).'/</loc><changefreq>daily</changefreq><priority>0.3</priority></url>'.PHP_EOL; # Список страниц
    }
        
$sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/forum/</loc><changefreq>daily</changefreq><priority>0.5</priority></url>'.PHP_EOL; # Форум

$list = forum::get_categories();
if ($list != false)
    foreach ($list as $categories)
    {
        $sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/forum_category/?id='.intval($categories['id']).'/</loc><changefreq>daily</changefreq><priority>0.3</priority></url>'.PHP_EOL; # Список категорий
    }
        
$list = forum::get_themes(0, 0);
if($list != false)
    foreach ($list as $theme)
    {
        $sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/forum_theme_read/'.generate_url($theme['id'].'_'.$theme['name']).'/</loc><lastmod>'.date('Y-m-d', $theme['date']).'</lastmod><changefreq>weekly</changefreq><priority>0.3</priority></url>'.PHP_EOL; # Список категорий
    }
        
$sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/guestbook/</loc><changefreq>daily</changefreq><lastmod>'.date('Y-m-d').'</lastmod><priority>0.5</priority></url>'.PHP_EOL; # Гостевая книга
$sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/chat/</loc><changefreq>daily</changefreq><lastmod>'.date('Y-m-d').'</lastmod><priority>1.0</priority></url>'.PHP_EOL; # Чат
$sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/daily/</loc><changefreq>daily</changefreq><lastmod>'.date('Y-m-d').'</lastmod><priority>1.0</priority></url>'.PHP_EOL; # Дневники
$sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/photos/</loc><changefreq>daily</changefreq><lastmod>'.date('Y-m-d').'</lastmod><priority>1.0</priority></url>'.PHP_EOL; # Фотографии
$sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/files/</loc><changefreq>daily</changefreq><lastmod>'.date('Y-m-d').'</lastmod><priority>1.0</priority></url>'.PHP_EOL; # Файлы

$list = files::get_category();
if ($list != false)
    foreach ($list as $c)
    {
        $sitemap .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/files/?category='.intval($c['id']).'</loc><changefreq>daily</changefreq><priority>0.3</priority></url>'.PHP_EOL; # Список категорий
    }

$sitemap .= '</urlset>';

echo $sitemap;

?>