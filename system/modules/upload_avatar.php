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
$type = strtolower(substr(strrchr($name, '.'), 1));
$image = getimagesize($_FILES['file']['tmp_name']);
$list = array("jpg", "jpeg", "gif", "png");

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

unlink($_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'.jpg');
unlink($_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'_medium.jpg');
unlink($_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'_small.jpg');

if (!$part or $part == $parts - 1){
    
    rename($_SERVER['DOCUMENT_ROOT'].'/system/files/temporary/'.md5($name).'.part', $_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'.'.$type); # Перемещаем 
    if($image[0] > 1024 or $image[1] > 1024)
        image_resize($_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'.'.$type, 1024, TRUE, $_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'.'.$type, 1024);
    
    if($type != 'jpg'){
        
        image_convert($_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'.'.$type, $_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'.jpg', 'jpg');
        unlink($_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'.'.$type);
        
    }
    
    
    image_crop($_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'.jpg', $_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'_small.jpg');
    image_resize($_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'.jpg', 100, TRUE, $_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'_medium.jpg');
    image_resize($_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'_small.jpg', 0, TRUE, $_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'.$user_id.'_small.jpg', 100);
    
}

die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

?>