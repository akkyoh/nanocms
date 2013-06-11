<ul data-role="listview" id="files_list" data-inset="true" data-max="<?=files::count_category($_GET['category']);?>"> 
    
<?

$n = intval($_GET['n']);
$category = intval($_GET['category']);

if($category > 0)
    $n_url = '&amp;nc='.$n;
else
    $n_url = '&amp;na='.$n;

$list = files::get($category, $n);

if($list != false){

    foreach ($list as $file) {

        echo '';
        
        echo '<li data-role="list-divider">'.protect_echo($file['name']).'</li>';
        
        echo '<li id="'.intval($file['id']).'" data-icon="false"><img class="image-radius" src="'.files::get_image($file['filetype'], $file['id']).'" alt=""><h3 style="font-size: 14px">'.protect_echo($file['name']).'</h3>';
        echo '<p id="about"></p><p class="ui-li-aside">'.date('d.m в H:i', $file['date']).'</p></li>';
        
        echo '<li><input data-id="'.intval($file['id']).'" type="text" name="name" id="name" value="'.protect_echo($file['name']).'" placeholder="Имя файла"/></li>';
        
        echo '<li><textarea data-id="'.intval($file['id']).'" name="description" id="description" placeholder="Описание файла">'.protect_echo($file['description']).'</textarea></li>';
        
        echo '';

    }

}else{
    
    echo '<li>Файлов нет</li>';
    
}

?>

</ul>