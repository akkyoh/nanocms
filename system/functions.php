<?php

define('SALT', '93/.+GgZp:I+]ue}HK?<)tiG}-ZNaO8№');
define('SALT_PASSWORD', '$2a$10$iROiOCyRmhyri6OViBr0ia');

function set_timezone($update = FALSE){
    
    global $timezones, $user_id, $db;
    
    if(isset($_COOKIE['timezone']) and !$update){
        
        $timezone = $_COOKIE['timezone'];
        
        if($timezone < 1 and $timezone > 34)
            $timezone = 20;
        
    }elseif(!empty($user_id)){
        
        $user_d = new users($user_id, 'timezone');
        
        $timezone = $user_d -> get_timezone();
        setcookie('timezone', $timezone, time()+3600*24*7, '/');
        
    }else{
        
        $timezone = 20;
        
    }
    
    date_default_timezone_set($timezones[$timezone]['system']);
    //$db -> query('SET `time_zone`= ?', date('P'));
    
}

function add_log($file, $text){

    $text = str_replace("\n", ' ', $text);
    $text = str_replace("\r", ' ', $text);
    
    $fp = fopen('./system/logs/'.$file.'.txt','a+');
    flock($fp,LOCK_EX);
    fputs($fp,date('d.m.y в H:i:s').': '.$text.PHP_EOL);
    fflush($fp);
    flock($fp,LOCK_UN);
    fclose($fp);

}

function get_elements($update = FALSE){
    
    global $user_id, $db;
    
    if(isset($_COOKIE['elements']) and !$update){
        
        $elements = $_COOKIE['elements'];
        
        if($elements != 5 and $elements != 10 and $elements != 15 and $elements != 20 and $elements != 25 and $elements != 30)
            $elements = 10;
        
    }elseif(!empty($user_id)){
        
        $user_d = new users($user_id, 'elements');
        
        $elements = $user_d -> get_elements();
        setcookie('elements', $elements, time()+3600*24*7, '/');
        
    }else{
        
        $elements = 10;
        
    }
    
    return $elements;
    
}

function get_sort($update = FALSE){
    
    global $user_id, $db;
    
    if(isset($_COOKIE['sort']) and !$update){
        
        $sort = $_COOKIE['sort'];
        
        if($sort != 1 and $sort != 2)
            $sort = 2;
        
    }elseif(!empty($user_id)){
        
        $user_d = new users($user_id, 'forum');
        
        $sort = $user_d -> get_forum();
        setcookie('sort', $sort, time()+3600*24*7, '/');
        
    }else{
        
        $sort = 2;
        
    }
    
    if($sort == 2)
        return 'DESC';
    else
        return 'ASC';
    
}

function my_substr($string, $len) {
    
    $len_n = (mb_strlen($string) > $len) ? mb_strripos(mb_substr($string, 0, $len), ' ') : $len;
    $cut = mb_substr($string, 0, $len_n);
    
    return (mb_strlen($string) > $len) ? '"' . $cut . '..."' : '"' . $cut . '"';
    
}

function set_variable($name, $value, $expire = NULL){
    
    global $db;
    
    return $db -> query('INSERT INTO `variables` (`name`, `value`, `expire`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = ?, `expire` = ?;', $name, $value, time()+$expire, $value, time()+$expire);
    
}

function get_variable($name){
    
    global $db;
    
    $q = $db -> query("SELECT `value` from `variables` WHERE `name` = ? and `expire` > UNIX_TIMESTAMP()", $name);
    
    return $q[0]['value'];
    
}

function clean_variable(){
    
    global $db;
    
    $expire = get_variable('clean_variables');
    
    if(empty($expire)){
        
        $db -> query('DELETE FROM `variables` WHERE `expire` <= UNIX_TIMESTAMP()');
        $db -> query('DELETE FROM `users_lost` WHERE `time` <= UNIX_TIMESTAMP()');
        set_variable('clean_variables', 1, 600);
        
    }
        
    
}

function loading(&$config, &$db, &$start_time, &$user_id = 1){

    if(substr_count($_SERVER['HTTP_HOST'], 'www.') > 0)
    {
        
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: http://'.str_replace('www.', '', $_SERVER['HTTP_HOST']).$_SERVER['REQUEST_URI']);
        
        exit();
        
    }
    
    if(substr_count($_SERVER["REQUEST_URI"], 'index.php') > 0)
    {
        
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: http://'.$_SERVER['HTTP_HOST'].str_replace('index.php', '', $_SERVER['REQUEST_URI']));
        
        exit();
        
    }
    
    $start_time = microtime(TRUE);

    header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("X-Powered-CMS: NanoCMS");
    
    include './system/classes/database.php';
    include './system/classes/users.php';
    include './system/classes/menu.php';
    include './system/classes/messages.php';
    include './system/classes/news.php';
    include './system/classes/profile.php';
    include './system/classes/comments.php';
    include './system/classes/guestbook.php';
    include './system/classes/chat.php';
    include './system/classes/forum.php';
    include './system/classes/daily.php';
    include './system/classes/photos.php';
    include './system/classes/files.php';
    include './system/classes/pages.php';
    include './system/classes/install.php';
    include './system/classes/cache.php';
    
    include './system/classes/phpmailer/phpmailer.php';
    include './system/classes/phpmailer/smtp.php';

    $config = read_config();
    $db = new db($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);
    
    $classes  = opendir('./custom/classes');
    while ($file = readdir($classes)) {
       include_once './custom/classes/'.$file;
    }
    
    if(empty($config['db_host']) and !isset($_GET['modules']))
        $_GET['page'] = 'install';
    
    if((!$db -> connect) and $_GET['page'] != 'install' and !isset($_GET['modules'])){
        
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        header('Status: 503 Service Temporarily Unavailable');
        header('Retry-After: 60');
        
        head('Ошибка');
        
        ?>

        <div data-role="content">

            <ul data-role="listview" data-inset="true">

                 <li data-role="list-divider">Ошибка</li>
                 <li style="font-weight: normal">Извините, сайт временно не работает.<br><br>Возможно, в это время администрация устанавливает обновление или проводит профилактические работы.<br>Администрация приносит извинения за доставленные неудобства.</li>

            </ul>

            <? if(!isset($_GET['dialog'])){ ?>

                <ul data-role="listview" data-inset="true" data-divider-theme="c">

                     <li data-role="list-divider">Навигация</li>
                     <li><a href="/" data-ajax="false">Обновить</a></li>

                </ul>

            <? } ?>

        </div>
    
        <?
        
        footer();
        
    }
    
    if($config['demo'] == 'TRUE')
        $user_id = 1;
    elseif(!empty($_COOKIE['user']))
        $user_id = decrypt($_COOKIE['user']);
    
    set_timezone();
    get_elements();
    get_sort();
    clean_variable();
    
}

function read_config($path = '.'){
    
    return unserialize(decrypt(file_get_contents($path.'/system/config.ini')));
    
}

function write_config($array, $path = '.'){
    
    if ($f = fopen($path.'/system/config.ini', "w")) {
        fwrite($f, encrypt(serialize($array)));
        fclose($f);
    }
    
}

function encrypt_password($password){
    
    return crypt($password, SALT_PASSWORD);
    
}

function encrypt($decrypted) { 

    $key = hash('SHA256', SALT, true);

    srand(); $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
    if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) return false;

    $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));

    return $iv_base64 . $encrypted;
    
} 

function decrypt($encrypted) {

    $key = hash('SHA256', SALT, true);

    $iv = base64_decode(substr($encrypted, 0, 22) . '==');

    $encrypted = substr($encrypted, 22);

    $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");

    $hash = substr($decrypted, -32);

    $decrypted = substr($decrypted, 0, -32);

    if (md5($decrypted) != $hash) return false;

    return $decrypted;

}


function protect_echo($str){
    
    return htmlentities($str, ENT_QUOTES, 'UTF-8');
    
}

function format_echo($str, $nofollow = FALSE){
    
    $str = preg_replace("#\[b\](.+)\[/b\]#isU",'<strong>\\1</strong>', $str);
    $str = preg_replace("#\[i\](.+)\[/i\]#isU",'<em>\\1</em>', $str);
    $str = preg_replace("#\[u\](.+)\[/u\]#isU",'<u>\\1</u>', $str);
    $str = preg_replace("#\[s\](.+)\[/s\]#isU",'<s>\\1</s>', $str);
    $str = preg_replace("#\[img\](.+)\[/img\]#isU",'<img src="\\1">', $str);
    if($nofollow == FALSE)
        $str = preg_replace("#\[url=(.+)\](.+)\[/url\]#isU",'<a href="\\1">\\2</a>', $str);
    else
        $str = preg_replace("#\[url=(.+)\](.+)\[/url\]#isU",'<a rel="nofollow" href="\\1">\\2</a>', $str);
    
    $str = preg_replace("#\[youtube\]http://youtu\.be/([\w\d\-_]+)\[/youtube\]$#isU",'<object width="425" height="350"><param name="movie" value="http://www.youtube.com/v/\\1"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/\\1" type="application/x-shockwave-flash" wmode="transparent" width="425" height="350"></embed></object>', $str);
    
    return nl2br($str);
    
}

function clean_echo($str){
    
    $str = preg_replace("#\[b\](.+)\[/b\]#isU",'\\1', $str);
    $str = preg_replace("#\[i\](.+)\[/i\]#isU",'\\1', $str);
    $str = preg_replace("#\[u\](.+)\[/u\]#isU",'\\1', $str);
    $str = preg_replace("#\[s\](.+)\[/s\]#isU",'\\1', $str);
    $str = preg_replace("#\[img\](.+)\[/img\]#isU",'', $str);
    $str = preg_replace("#\[url=(.+)\](.+)\[/url\]#isU",'\\2 (\\1)', $str);
    
    return $str;
    
}

function head($title, $description = NULL, $keywords = NULL, $canonical = NULL){
    
    global $user_id,$auth_user,$db;
    
    header('Content-type: text/html; charset=UTF-8');
    
    if(isset($_GET['dialog']))
        $role = 'dialog';
    else
        $role = 'page';
    
    $id = '';
    
    if(isset($_GET['dialog']))
        $id = 'dialog_'.protect_echo($_GET['dialog']);
    elseif(isset($_GET['page']))
        $id = 'page_'.protect_echo($_GET['page']);
    else
        $id = 'page_index';
    
    if(users::is_auth($auth_user))
        $auth = 1;
    else
        $auth = 0;
    
    $array_elements = array('{title}', 
                            '{description}', 
                            '{keywords}', 
                            '{canonical}',
                            '{data-role}',
                            '{id}',
                            '{data-auth}',
                            '{data-user}',
                            '{data-admin}',
                            '{home}',
                            '{menu}');
    
    $array_replace[0] = protect_echo($title);
    (empty($description)) ? $array_replace[1] = '' : $array_replace[1] = '<meta name="description" content="'.protect_echo($description).'">';
    (empty($keywords)) ? $array_replace[2] = '' : $array_replace[2] = '<meta name="keywords" content="'.protect_echo($keywords).'">';
    ($canonical == NULL) ? $array_replace[3] = '' : $array_replace[3] = '<link rel="canonical" href="'.protect_echo($canonical).'">';
    $array_replace[4] = protect_echo($role);
    $array_replace[5] = $id;
    $array_replace[6] = $auth;
    $array_replace[7] = intval($user_id);
    $array_replace[8] = users::is_admin($user_id);
    if(isset($_GET['page']))
        $array_replace[9] = '<a href="/" data-icon="home" data-iconpos="notext" data-direction="reverse" rel="external">Главная</a>';
    if($db -> connect)
        if(($_GET['dialog'] != 'login' and $_GET['page'] != 'enter' and !users::is_auth($auth_user) and !isset($_GET['dialog'])) or $_GET['page'] == 'exit')
            $array_replace[10] = '<a href="/dialog/login/" data-icon="user" class="ui-btn-right" data-rel="dialog" data-transition="flip">Вход</a>';
        elseif(users::is_auth($auth_user) and !isset($_GET['dialog']) and $_GET['page'] != 'exit')
        {
            (messages::unread($user_id) > 0) ? $theme = 'b' : $theme = 'a';
            $array_replace[10] = '<a href="/dialog/profile/" data-icon="user" class="ui-btn-right" data-rel="dialog" data-theme="'.$theme.'" data-transition="flip">Профиль</a>';
        }
    
    if(file_exists('./custom/templates/head.tpl'))
        $content = file_get_contents('./custom/templates/head.tpl');
    else
        $content = file_get_contents('./system/templates/head.tpl');
        
    echo(str_ireplace($array_elements, $array_replace, $content));
    
}

function footer(){

    global $db,$config,$start_time,$auth_user;
    
    if(!isset($_GET['dialog'])){
    
        $array_elements = array('{date}', 
                                '{name}',
                                '{copyright}');
        
        $array_replace[0] = date('Y');
        ($config['name'] == '') ? $array_replace[1] = 'Карта сайта' : $array_replace[1] = protect_echo($config['name']);
        if(strstr($_SERVER['SCRIPT_NAME'], 'index.php') == 'index.php' and empty($_GET['page']) and empty($_GET['dialog']) and !users::is_auth($auth_user) and $config['licence'] != 'TRUE')
            $array_replace[2] = '<br><span style="font-size: 10px; color: #8E8E8E">Разработано в <a style="color: #8E8E8E" href="http://nanocms.mobi" data-ajax="false">NanoCMS.MOBI</a></span>';
        else
            $array_replace[2] = '';
            
        if(file_exists('./custom/templates/footer.tpl'))
            $content = file_get_contents('./custom/templates/footer.tpl');
        else
            $content = file_get_contents('./system/templates/footer.tpl');

        echo(str_ireplace($array_elements, $array_replace, $content));
        
        list($msec,$sec)=explode(chr(32),microtime());
        echo PHP_EOL.'<!-- Generate: '.round((($sec+$msec)-$start_time),3).' -->';
        echo PHP_EOL.'<!-- DB count: '.$db -> query_count.' -->';
        echo PHP_EOL.'<!-- Memory: '.round(memory_get_usage()/1024/1024,2).' -->';
        
    }
    else
    {
        
        echo '</div></body></html>';
        
    }
    
    exit;

}

function page_auth(){
    
    global $auth_user;
    
    if(!users::is_auth($auth_user)){

        head('Ошибка доступа');

        ?>

<div data-role="content">

    <p>Ошибка. Вы не авторизированы.</p>
    <a href="/dialog/login/" data-role="button" data-rel="dialog" data-icon="arrow-l">Авторизация</a>

</div>

        <?

        footer();

    }
    
}

function random_string($length, $chartypes) {

    $chartypes_array = explode(',', $chartypes);

    $lower = 'abcdefghijklmnopqrstuvwxyz';
    $upper = strtoupper('abcdefghijklmnopqrstuvwxyz');
    $numbers = '1234567890';
    $special = '^@*+-+%()!?';

    if(in_array('all', $chartypes_array))
        $chars = $lower.$upper.$numbers.$special;
    else
    {
        if(in_array('lower', $chartypes_array))
            $chars = $lower;
        if(in_array('upper', $chartypes_array))
            $chars .= $upper;
        if(in_array('numbers', $chartypes_array))
            $chars .= $numbers;
        if(in_array('special', $chartypes_array))
            $chars .= $special;
    }
    
    $chars_length = (strlen($chars) - 1);
    $string = $chars{rand(0, $chars_length)};

    for ($i = 1; $i < $length; $i = strlen($string))
    {

        $random = $chars{rand(0, $chars_length)};
        if ($random != $string{$i - 1}) $string .= $random;

    }

    return $string;

}

function pages(){

        echo '<fieldset class="ui-grid-a" id="navigation_page">
                  <div class="ui-block-a"><a href="#" data-role="button" id="next" data-icon="arrow-l" data-mini="true">Назад</a></div>	   
                  <div class="ui-block-b"><a href="#" data-role="button" id="back" data-icon="arrow-r" data-iconpos="right" data-mini="true">Вперед</a></div>
              </fieldset>';
    
}

function get_ip(){

    if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){

        preg_match_all('|([0-9]{1,3}\.){3}[0-9]{1,3}|', $_SERVER['HTTP_X_FORWARDED_FOR'], $array_ip);  
        
        $ip = $array_ip[0][0];
        
        if(empty($ip) or !filter_var($ip, FILTER_VALIDATE_IP)){
            
            $ip = $_SERVER['REMOTE_ADDR'];
            
        }

    }elseif(isset($_SERVER['REMOTE_ADDR']) && filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)){

        $ip = $_SERVER['REMOTE_ADDR'];

    }

    return $ip;

}

function image_resize($file_original, $max_weight, $file_save = FALSE, $file_path = '', $max_height = 0)
{

    $info = getimagesize($file_original);
    
    if($info[0] > $max_height and $max_weight != 0){
    
        $p = $info[0]/$max_weight;
        $weight = $max_weight;
        $height = $info[1]/$p;
        
    }
    
    if($info[1] > $max_weight and $max_height != 0){
        
        $p = $info[1]/$max_height;
        $height = $max_height;
        $weight = $info[0]/$p;
        
    }
    
    $img = imagecreatetruecolor($weight, $height);
    
    if($info[2] == 1)
        $img_src = imagecreatefromgif($file_original);
    if($info[2] == 2)
        $img_src = imagecreatefromjpeg($file_original);
    if($info[2] == 3)
        $img_src = imagecreatefrompng($file_original);
    
    imagecopyresampled($img, $img_src, 0,0,0,0, $weight, $height, $info[0], $info[1]);
    
    if($file_save){
        
        if($info[2] == 1) 
            imagegif($img, $file_path);
        if($info[2] == 2)
            imagejpeg($img, $file_path);
        if($info[2] == 3)
            imagepng($img, $file_path);
        
    }else{
        
        header('Content-type: image/gif');
        imagegif($img);
        
    }
    
}

function image_crop($file_original, $file_path, $crop = 'square', $percent = FALSE, $input_format = NULL) {
        
        $info = getimagesize($file_original);
        if($input_format == NULL)
            $type = str_replace('jpg', 'jpeg', substr(strrchr($file_original, '.'), 1));
        else
            $type = str_replace('jpg', 'jpeg', $input_format);
        
        $function = 'imagecreatefrom'.$type;
    	$image = $function($file_original);

	if ($crop == 'square') {
		
            unset($crop);
            
            $min = $info[0];
            if ($info[0] > $info[1])
                $min = $info[1];
            $crop[2] = $crop[3] = $min;
            
            if($info[0] > $info[1])
                $crop[0] = round(($info[0]-$info[1])/2);
            else
                $crop[1] = round(($info[1]-$info[0])/2);
            
            echo $crop[1].'|';
            
	}else{
	
            if ($percent) {
                
                $crop[2] *= $info[0] / 100;
		$crop[3] *= $info[1] / 100;
		$crop[0] *= $info[0] / 100;
		$crop[1] *= $info[1] / 100;
                
            }
            
    	    if ($crop[2] < 0) $crop[2] += $info[0];
	        $crop[2] -= $crop[0];
	    if ($crop[3] < 0) $crop[3] += $info[1];
		$crop[3] -= $crop[1];
                
	}

	$image_output = imagecreatetruecolor(intval($crop[2]), intval($crop[3]));
	imagecopy($image_output, $image, 0, 0, intval($crop[0]), intval($crop[1]), intval($crop[2]), intval($crop[3]));
        
        if($info[3] == 2){
            
            return imagejpeg($image_output, $file_path, 100);
            
	}else{
            
            $function = 'image'.$type;
            return $function($image_output, $file_path);
            
	}
        
}

function image_convert($file_original, $file_output, $format, $input_format = NULL){
    
    if($input_format == NULL)
        $type = substr(strrchr($file_original, '.'), 1);
    else
        $type = str_replace('jpg', 'jpeg', $input_format);
    
    switch ($type) {

        case('jpeg'):
            $image = imagecreatefromjpeg($file_original);
        break;
    
        case('jpg'):
            $image = imagecreatefromjpeg($file_original);
        break;

        case('gif'):
            $image = imagecreatefromgif($file_original);
        break;

        case('png'):
            $image = imagecreatefrompng($file_original);
        break;
    
    }

    switch ($format) {

        case('jpeg'):
            imagejpeg($image, $file_output);
        break;
    
        case('jpg'):
            imagejpeg($image, $file_output);
        break;

        case('gif'):
            imagegif($image, $file_output);
        break;

        case('png'):
            imagepng($image, $file_output);
        break;
    
    }
    
}

function word_format($num, $words)
{
	$num = $num % 100;
	if ($num > 19) 
	{
		$num = $num % 10;
	}
	switch ($num) 
	{
		case 1: 
		{
			return($words[0]);
		}
		case 2: case 3: case 4: 
		{
				return($words[1]);
		}
		default: 
		{
			return($words[2]);
		}
	}
}

function size_format($filesize)
{
    
    if($filesize < 1024)
        return $filesize.' байт';
    elseif($filesize >= 1024 and $filesize < 1024*1024)
        return round($filesize/1024,2).' кбайт';
    elseif($filesize >= 1024*1024 and $filesize < 1024*1024*1024)
        return round($filesize/1024/1024,2).' мбайт';
    elseif($filesize >= 1024*1024*1024)
        return round($filesize/1024/1024/1024,2).' гбайт';
    
}

function get_bitrate($filename)
{
    if (!file_exists($filename)) {
        return false;
    }

    $bitRates = array(
                      array(0,0,0,0,0),
                      array(32,32,32,32,8),
                      array(64,48,40,48,16),
                      array(96,56,48,56,24),
                      array(128,64,56,64,32),
                      array(160,80,64,80,40),
                      array(192,96,80,96,48),
                      array(224,112,96,112,56),
                      array(256,128,112,128,64),
                      array(288,160,128,144,80),
                      array(320,192,160,160,96),
                      array(352,224,192,176,112),
                      array(384,256,224,192,128),
                      array(416,320,256,224,144),
                      array(448,384,320,256,160),
                      array(-1,-1,-1,-1,-1),
                    );
    $sampleRates = array(
                         array(11025,12000,8000),
                         array(0,0,0),
                         array(22050,24000,16000),
                         array(44100,48000,32000),
                        );
    $bToRead = 1024 * 12;

    $fileData = array(0, 0);
    $fp = fopen($filename, 'r');
    if (!$fp) {
        return false;
    }

    fseek($fp, -1 * $bToRead, SEEK_END);
    $data = fread($fp, $bToRead);

    $bytes = unpack('C*', $data);
    $frames = array();
    $lastFrameVerify = null;

    for ($o = 1; $o < count($bytes) - 4; $o++) {

        if (($bytes[$o] & 255) == 255 && ($bytes[$o+1] & 224) == 224) {
            $frame = array();
            $frame['version'] = ($bytes[$o+1] & 24) >> 3;
            $frame['layer'] = abs((($bytes[$o+1] & 6) >> 1) - 4);
            $srIndex = ($bytes[$o+2] & 12) >> 2;
            $brRow = ($bytes[$o+2] & 240) >> 4;
            $frame['padding'] = ($bytes[$o+2] & 2) >> 1;
            if ($frame['version'] != 1 && $frame['layer'] > 0 && $srIndex < 3 && $brRow != 15 && $brRow != 0 &&
                (!$lastFrameVerify || $lastFrameVerify === $bytes[$o+1])) {

                $frame['sampleRate'] = $sampleRates[$frame['version']][$srIndex];
                if ($frame['version'] & 1 == 1) {
                    $frame['bitRate'] = $bitRates[$brRow][$frame['layer']-1];
                } else {
                    $frame['bitRate'] = $bitRates[$brRow][($frame['layer'] & 2 >> 1)+3];
                }

                if ($frame['layer'] == 1) {
                    $frame['frameLength'] = (12 * $frame['bitRate'] * 1000 / $frame['sampleRate'] + $frame['padding']) * 4;
                } else {
                    $frame['frameLength'] = 144 * $frame['bitRate'] * 1000 / $frame['sampleRate'] + $frame['padding'];
                }

                $frames[] = $frame;
                $lastFrameVerify = $bytes[$o+1];
                $o += floor($frame['frameLength'] - 1);
            } else {
                $frames = array();
                $lastFrameVerify = null;
            }
        }
        if (count($frames) < 3) {
            continue;
        }

        $header = array_pop($frames);
        $fileData[0] = $header['sampleRate'];
        $fileData[1] = $header['bitRate'];

        break;
    }

    return $fileData;
}

function send_mail($name_from, // имя отправителя
                   $email_from, // email отправителя
                   $name_to, // имя получателя
                   $email_to, // email получателя
                   $data_charset, // кодировка переданных данных
                   $send_charset, // кодировка письма
                   $subject, // тема письма
                   $body, // текст письма
                   $unsubscribe = NULL) {
    
    $mail = new PHPMailer(false);
    
    if(!empty($unsubscribe)){

        $mail -> addCustomHeader('List-Unsubscribe: <'.$unsubscribe.'>');

    }

    $mail -> AddReplyTo($email_from, $name_from);
    $mail -> AddAddress($email_to, $name_to);
    $mail -> SetFrom($email_from, $name_from);
    $mail -> Subject = $subject;
    $mail -> Body = $body;
    //$mail -> MsgHTML($body);
    $mail -> Send();
    $mail -> ClearAddresses();
    $mail -> ClearAttachments();
    
}

function generate_keywords($string){
    
    $string = str_replace(array('?','_','!','.',',',':',';','*','(',')','{','}','[',']','%','#','№','@','$','^','-','+','/','\\','=','|','"','\''), '', $string);
    $array = explode(' ', $string);
    $array_c = count($array);
    $keywords = NULL;
    
    for($i = 0; $i < $array_c; $i++){
        
        if(!empty($array[$i]))
        {
        
            $keywords .= $array[$i];
            if($i != $array_c-1 and !empty($array[$i+1]))
                $keywords .= ', ';
        
        }
        
    }
    
    return $keywords;
    
}

function generate_url($string){
    
    $string = mb_strtolower($string, 'UTF-8');
    $string = str_replace(array('?','!','.',',',':',';','*','(',')','{','}','[',']','%','#','№','@','$','^','-','+','/','\\','=','|','"','\'','а','б','в','г','д','е','ё','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ъ','ы','э',' ','ж','ц','ч','ш','щ','ь','ю','я'), array('_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','a','b','v','g','d','e','e','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','j','i','e','_','zh','ts','ch','sh','shch','','yu','ya'), $string);
    $string = preg_replace('/[^a-z0-9_]/', '', $string);
    $string = trim($string, '_');

    $prev_st = NULL;
    do
    {
        $prev_st = $string;
        $string = preg_replace('/_[a-z0-9]_/', '_', $string);
    }
    while($string != $prev_st);

    $string = preg_replace('/_{2,}/', '_', $string);
    
    return protect_echo($string);
    
}

function antiflood($m, $text, $user){

    $array_antiflood = explode('|', get_variable('antiflood_'.$m.'::'.$user));
    
    $last = $array_antiflood[0];
    $count = $array_antiflood[1];
    $block = intval($array_antiflood[2]);
    $time = intval($array_antiflood[3]);
    
    if(md5($text) == $last)
        return FALSE;

    if($count >= 10 or $block > 0)
        return FALSE;

    if(time()-$time <= 10)
    { 
        $count++; 
        
        if($count >= 10)
        { 
            $block = time()+60; 
            $count = 0; 
        }
    }
    else
    { 
        $count = 0; 
    }
        
    $time = time();
    $last = md5($text);

    set_variable('antiflood_'.$m.'::'.$user, $last.'|'.$count.'|'.$block.'|'.$time, 60);
    
    return TRUE;

}

?>