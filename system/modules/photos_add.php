<?

if(!users::is_auth($auth_user))
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
$category = $_GET['category'];
$image = getimagesize($_FILES['file']['tmp_name']);
$list = array("jpg", "jpeg", "gif", "png");

if(!photos::exist_category($user_id, $category))
    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Неверный раздел для загрузки."}, "id" : "id"}');

if(!in_array($type, $list))
    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "К загрузке разрешены только файлы расширения GIF, PNG, JPEG и JPG."}, "id" : "id"}');


if($_FILES['file']['type'] != 'image/gif' and
   $_FILES['file']['type'] != 'image/png' and
   $_FILES['file']['type'] != 'image/jpeg' and
   $_FILES['file']['type'] != 'image/jpg' and
   $image['mime'] != 'image/gif' and
   $image['mime'] != 'image/png' and
   $image['mime'] != 'image/jpeg' and
   $image['mime'] != 'image/jpg')
    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "К загрузке разрешены только файлы расширения GIF, PNG, JPEG и JPG."}, "id" : "id"}');

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
    
    $photo_id = photos::add_photo($user_id, $category, str_replace('.'.$type, '', $name), $size, $image[0], $image[1]);
    
    rename($_SERVER['DOCUMENT_ROOT'].'/system/files/temporary/'.md5($name).'.part', $_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'.'.$type); # Перемещаем 
    if($image[0] > 1024 or $image[1] > 1024)
        image_resize($_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'.'.$type, 1024, TRUE, $_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'.'.$type, 1024);
    
    if($type != 'jpg'){
        
        image_convert($_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'.'.$type, $_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'.jpg', 'jpg');
        unlink($_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'.'.$type);
        
    }
    
    
    image_crop($_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'.jpg', $_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'_preview.jpg'); # Предварительный просмотр
    image_resize($_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'_preview.jpg', 100, TRUE, $_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'_preview.jpg', 100); # Уменьшаем
    
    # Уменьшаем в популярные размеры экранов
    
    if($image[0] > 128 or $image[1] > 128)
        image_resize($_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'.jpg', 128, TRUE, $_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'_128.jpg', 128); # 128 px
    if($image[0] > 240 or $image[1] > 240)
        image_resize($_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'.jpg', 240, TRUE, $_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'_240.jpg', 240); # 240 px
    if($image[0] > 360 or $image[1] > 360)
        image_resize($_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'.jpg', 360, TRUE, $_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'_360.jpg', 360); # 360 px
    if($image[0] > 640 or $image[1] > 640)
        image_resize($_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'.jpg', 640, TRUE, $_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'.$photo_id.'_640.jpg', 640); # 640 px
    
}

die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

?>