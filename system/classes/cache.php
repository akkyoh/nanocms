<?php

class cache
{
    
    var $file;
    var $cache;
    var $status;
    
    public function __construct($file)
    {
        
        $this -> file = $file;
        
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/system/files/cache/'.$this -> file))
        {
             $this -> cache = file_get_contents ($_SERVER['DOCUMENT_ROOT'].'/system/files/cache/'.$this -> file);
             $this -> status = TRUE;
        }
        else
        {
             $this -> status = FALSE;
        }
        
    }
    
    public function read()
    {
        
        if($this -> status == TRUE)
            return unserialize($this -> cache);
               
    }
    
    public function write($object)
    {
        
        $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/system/files/cache/'.$this -> file, 'w');
        flock($fp, LOCK_EX);
        fputs($fp, serialize($object));
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);
        
        $this -> status = TRUE;
        
        return $object;
        
    }
    
    private function remove()
    {
     
        if($this -> status == TRUE)
        {
            $this -> status = FALSE;
            unlink($_SERVER['DOCUMENT_ROOT'].'/system/files/cache/'.$this -> file);
        }
            
    }
    
    function delete($name)
    {
        
        $cache = new cache($name);
        $cache -> remove();
        
    }
    
}

?>
