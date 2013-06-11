<?php

class comments {
    
    public function count($category, $type){
        
        global $db;
        
        $comments = $db -> query("SELECT count(*) from `comments` WHERE `type` = ? and `category` = ?", $type, $category);
        
        if(!empty($comments)){
        
            return $comments[0]['count(*)'];
        
        }else{
            
            return 0;
            
        }
        
    }
    
    public function get_data($id){
        
        global $db;
        
        $messages = $db -> query("SELECT * from `comments` WHERE `id` = ? LIMIT 1", $id);
        
        if(!empty($messages)){
        
            return $messages[0];
        
        }else{
            
            return false;
            
        }
        
    }
    
    public function get($category, $type, $n){
        
        global $db;
        
        $messages = $db -> query("SELECT `id`,`user`,`text`,`date` from `comments` WHERE `category` = ? and `type` = ? ORDER by `date` DESC LIMIT ?,?", $category, $type, $n, get_elements());
        
        if(!empty($messages)){
        
            return $messages;
        
        }else{
            
            return false;
            
        }
        
    }
    
    public function add($category, $type, $user, $text){
        
       global $db;
        
       if(empty($text))
           return false;
       
       if($db -> query('INSERT INTO `comments` (`type`, `category`, `user`, `date`, `text`) VALUES (?, ?, ?, UNIX_TIMESTAMP(), ?);', $type, $category, $user, $text) == TRUE)
            return true;
       else
           return false;
        
    }
    
    public function delete($id){
        
        global $db;
        
        $db -> query("DELETE FROM `comments` WHERE `id` = ?", $id);
        
    }
    
    public function delete_category($id, $type){
        
        global $db;
        
        $db -> query("DELETE FROM `comments` WHERE `category` IN (".$id.") and `type` = ?", $type);
        
    }
    
    public function exist_type($type){
        
        $types = array('news','daily','photos','files');
        
        if(!in_array($type, $types))
            return false;
        else
            return true;
        
    }
    
}

?>
