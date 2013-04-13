<?

if(!users::is_admin($user_id))
    exit;

if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
    $contentType = $_SERVER["HTTP_CONTENT_TYPE"];

if (isset($_SERVER["CONTENT_TYPE"]))
    $contentType = $_SERVER["CONTENT_TYPE"];

$part = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$parts = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
$name = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
$size = $_FILES['file']['size'];
$type = strtolower(substr(strrchr($name, '.'), 1));
$image = getimagesize($_FILES['file']['tmp_name']);
if(substr_count(files::get_mimetype($type), 'audio') > 0)
    $music = get_bitrate($_FILES['file']['tmp_name']);
$category = $_GET['category'];
$filetypes = files::get_filetypes($category);
$list = explode(',', str_replace(' ', '', $filetypes));

if(!files::exist_category($category) or empty($category))
    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Неверный раздел для загрузки."}, "id" : "id"}');

if(!in_array($type, $list) and !empty($filetypes))
    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "К загрузке разрешены только файлы расширения '.protect_echo($filetypes).'."}, "id" : "id"}');

if (strpos($contentType, "multipart") !== false) {
    
    if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {

        $upload = fopen($_SERVER['DOCUMENT_ROOT'].'/system/files/temporary/'.md5($name).'.part', $part == 0 ? "wb" : "ab");
	
        if ($upload) {
	
            $temporary = fopen($_FILES['file']['tmp_name'], "rb");

            if ($temporary) {
                
                while ($buff = fread($temporary, 4096))
                    fwrite($upload, $buff);
                
            } else
		
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Ошибка при обработке загруженного файла."}, "id" : "id"}');
		
            fclose($temporary);
            fclose($upload);
            
            unlink($_FILES['file']['tmp_name']);
	
        } else
        
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Ошибка при обработке загруженного файла."}, "id" : "id"}');
	
        } else
            
            die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Ошибка при обработке загруженного файла."}, "id" : "id"}');

}

if (!$part or $part == $parts - 1){
    
    $file_id = files::add_file(str_replace('.'.$type, '', $name), $type, $category, $size, $image[0], $image[1], $music[1], $music[0]);
    
    rename($_SERVER['DOCUMENT_ROOT'].'/system/files/temporary/'.md5($name).'.part', $_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.$file_id.'.download'); # Перемещаем 
    
    if($type == 'jpeg' or $type == 'jpg' or $type == 'gif' or $type == 'png'){
        
        image_convert($_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.$file_id.'.download', $_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.$file_id.'.preview', 'jpg', $type);
        image_crop($_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.$file_id.'.preview', $_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.$file_id.'.preview', 'square', FALSE, 'jpg');
        image_resize($_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.$file_id.'.preview', 0, TRUE, $_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.$file_id.'.preview', 100);
        
    }
    
}

die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

?>