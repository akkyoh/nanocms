<?php

class install
{
    
    function status()
    {
        
        global $config;
    
        $status['result'] = TRUE;
        $status['config'] = TRUE;
        $status['avatar'] = TRUE;
        $status['files'] = TRUE;
        $status['photos'] = TRUE;
        $status['temporary'] = TRUE;
        $status['cache'] = TRUE;
        $status['logs'] = TRUE;
        $status['installed'] = TRUE;

        if(!is_writable($_SERVER['DOCUMENT_ROOT'].'/system/config.ini'))
            $status['result'] = $status['config'] = FALSE;

        if(!is_writable($_SERVER['DOCUMENT_ROOT'].'/system/files/avatars/'))
            $status['result'] = $status['avatar'] = FALSE;

        if(!is_writable($_SERVER['DOCUMENT_ROOT'].'/system/files/files/'))
            $status['result'] = $status['files'] = FALSE;

        if(!is_writable($_SERVER['DOCUMENT_ROOT'].'/system/files/photos/'))
            $status['result'] = $status['photos'] = FALSE;

        if(!is_writable($_SERVER['DOCUMENT_ROOT'].'/system/files/temporary/'))
            $status['result'] = $status['temporary'] = FALSE;

        if(!is_writable($_SERVER['DOCUMENT_ROOT'].'/system/files/cache/'))
            $status['result'] = $status['cache'] = FALSE;

        if(!is_writable($_SERVER['DOCUMENT_ROOT'].'/system/logs/'))
            $status['result'] = $status['logs'] = FALSE;

        if(!empty($config['db_host']))
            $status['result'] = $status['installed'] = FALSE;
            
        return $status;
        
    }
    
    function sql($file)
    {
        
        global $db;
        
        $f = fopen($file, 'r');
        if($f)
        {
            
            $db -> transaction_start();
            
            $q = '';

            while(!feof($f))
            {
                $q .= fgets($f);

                if(substr(rtrim($q), -1) == ';')
                {
                    
                    if($db -> query($q) == FALSE)
                    {
                        
                        $db -> transaction_cancel();
                        return FALSE;
                    }
                    $q = '';
                    
                }
            }
            
            $db -> transaction_complete();
            
            return TRUE;
            
        }else
            return FALSE;
        
    }
    
}

?>
