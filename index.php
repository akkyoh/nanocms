<?php

error_reporting(0);

include $_SERVER['DOCUMENT_ROOT'].'/system/functions.php';
include $_SERVER['DOCUMENT_ROOT'].'/system/variables.php';

loading($config, $db, $start_time, $user_id);

if(isset($_GET['page']) && file_exists($_SERVER['DOCUMENT_ROOT'].'/custom/pages/'.$_GET['page'].'.php') && !preg_match('/[^A-Za-z0-9_]/', $_GET['page'])){

    include $_SERVER['DOCUMENT_ROOT'].'/custom/pages/'.$_GET['page'].'.php';

}elseif(isset($_GET['dialog']) && file_exists($_SERVER['DOCUMENT_ROOT'].'/custom/dialog/'.$_GET['dialog'].'.php') && !preg_match('/[^A-Za-z0-9_]/', $_GET['dialog'])){

    include $_SERVER['DOCUMENT_ROOT'].'/custom/dialog/'.$_GET['dialog'].'.php';

}elseif(isset($_GET['modules']) && file_exists($_SERVER['DOCUMENT_ROOT'].'/custom/modules/'.$_GET['modules'].'.php') && !preg_match('/[^A-Za-z0-9_]/', $_GET['modules'])){

    include $_SERVER['DOCUMENT_ROOT'].'/custom/modules/'.$_GET['modules'].'.php';

}elseif(isset($_GET['page']) && file_exists($_SERVER['DOCUMENT_ROOT'].'/system/pages/'.$_GET['page'].'.php') && !preg_match('/[^A-Za-z0-9_]/', $_GET['page'])){

    include $_SERVER['DOCUMENT_ROOT'].'/system/pages/'.$_GET['page'].'.php';

}elseif(isset($_GET['dialog']) && file_exists($_SERVER['DOCUMENT_ROOT'].'/system/dialog/'.$_GET['dialog'].'.php') && !preg_match('/[^A-Za-z0-9_]/', $_GET['dialog'])){

    include $_SERVER['DOCUMENT_ROOT'].'/system/dialog/'.$_GET['dialog'].'.php';

}elseif(isset($_GET['modules']) && file_exists($_SERVER['DOCUMENT_ROOT'].'/system/modules/'.$_GET['modules'].'.php') && !preg_match('/[^A-Za-z0-9_]/', $_GET['modules'])){

    include $_SERVER['DOCUMENT_ROOT'].'/system/modules/'.$_GET['modules'].'.php';

}elseif(empty($_GET['page']) and empty($_GET['modules']) and empty($_GET['dialog'])){

    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/custom/pages/index.php'))
        include $_SERVER['DOCUMENT_ROOT'].'/custom/pages/index.php';
    elseif($_GET['pages'] == '')
        include $_SERVER['DOCUMENT_ROOT'].'/system/pages/index.php';
    
}else{
    
    header('HTTP/1.0 404 Not Found');
    
}

?>