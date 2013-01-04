<?php

error_reporting(0);

include './system/functions.php';
include './system/variables.php';

loading($config, $db, $start_time, $user_id);

if(isset($_GET['page']) && file_exists('./custom/pages/'.$_GET['page'].'.php') && !preg_match('/[^A-Za-z0-9_]/', $_GET['page'])){

    include './custom/pages/'.$_GET['page'].'.php';

}elseif(isset($_GET['dialog']) && file_exists('./custom/dialog/'.$_GET['dialog'].'.php') && !preg_match('/[^A-Za-z0-9_]/', $_GET['dialog'])){

    include './custom/dialog/'.$_GET['dialog'].'.php';

}elseif(isset($_GET['modules']) && file_exists('./custom/modules/'.$_GET['modules'].'.php') && !preg_match('/[^A-Za-z0-9_]/', $_GET['modules'])){

    include './custom/modules/'.$_GET['modules'].'.php';

}elseif(isset($_GET['page']) && file_exists('./system/pages/'.$_GET['page'].'.php') && !preg_match('/[^A-Za-z0-9_]/', $_GET['page'])){

    include './system/pages/'.$_GET['page'].'.php';

}elseif(isset($_GET['dialog']) && file_exists('./system/dialog/'.$_GET['dialog'].'.php') && !preg_match('/[^A-Za-z0-9_]/', $_GET['dialog'])){

    include './system/dialog/'.$_GET['dialog'].'.php';

}elseif(isset($_GET['modules']) && file_exists('./system/modules/'.$_GET['modules'].'.php') && !preg_match('/[^A-Za-z0-9_]/', $_GET['modules'])){

    include './system/modules/'.$_GET['modules'].'.php';

}elseif(empty($_GET['page']) and empty($_GET['modules']) and empty($_GET['dialog'])){

    if(file_exists('./custom/pages/index.php'))
        include './custom/pages/index.php';
    elseif($_GET['pages'] == '')
        include './system/pages/index.php';
    
}else{
    
    header('HTTP/1.0 404 Not Found');
    
}

?>