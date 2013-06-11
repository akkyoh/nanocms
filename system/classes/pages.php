<?php

class pages {
    
    public function add($id, $title, $description, $keywords, $page)
    {
        
        global $db;
        
        if(empty($id))
            $db -> query("INSERT INTO `pages` (`title`, `description`, `keywords`, `text`) VALUES (?, ?, ?, ?);", $title, $description, $keywords, $page);
        else
            $db -> query("UPDATE `pages` SET `title` = ?, `description` = ?, `keywords` = ?, `text` = ? WHERE `id` = ?", $title, $description, $keywords, $page, $id);
        
        return (empty($id)) ? $db -> query_info['insert_id'] : $id;
        
        
    }
    
    public function exist_page($id)
    {
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `pages` WHERE `id` = ?", $id);
        
        if($c[0]['count(*)'] > 0){
            
            return true;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function delete($id)
    {
        
        global $db;
        
        $db -> query("DELETE FROM `pages` WHERE `id` = ?;", $id);
        
    }
    
    public function get($id)
    {
        
        global $db;
        
        $c = $db -> query("SELECT * from `pages` WHERE `id` = ?", $id);
        
        if(!empty($c)){
            
            return $c[0];
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function get_list($n)
    {
        
        global $db;
        
        if($n != NULL)
            $c = $db -> query("SELECT * from `pages` LIMIT ?,?", $n, get_elements());
        else
            $c = $db -> query("SELECT * from `pages`");
        
        if(!empty($c)){
            
            return $c;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function count()
    {
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `pages`");
        
        if(!empty($c)){
            
            return $c[0]['count(*)'];
            
        }else{
            
            return 0;
            
        }
        
    }
    
}

?>
