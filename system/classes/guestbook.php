<?php

class guestbook {
    
    public function add($user, $text){
        
       global $db,$auth_user;
        
       if(empty($text))
           return false;
       if(!users::is_auth($auth_user))
           $user = SYSTEM_ID;
       
       cache::delete('guestbook_count');
       
       if($db -> query('INSERT INTO `guestbook` (`user`, `date`, `text`) VALUES (?, UNIX_TIMESTAMP(), ?);', $user, $text) == TRUE)
            return true;
       else
           return false;
        
    }
    
    public function get($n){
        
        global $db;
        
        $messages = $db -> query("SELECT `id`,`user`,`text`,`date` from `guestbook` ORDER by `date` DESC LIMIT ?,?", $n, get_elements());
        
        if(!empty($messages)){
        
            return $messages;
        
        }else{
            
            return false;
            
        }
        
    }
    
    public function delete($id){
        
        global $db;
        
        $db -> query("DELETE FROM `guestbook` WHERE `id` = ?", $id);
        
        cache::delete('guestbook_count');
        
    }
    
    public function count(){
        
        global $db;
        
        $guestbook = $db -> query("SELECT count(*) from `guestbook`");
        
        if(!empty($guestbook)){
        
            return intval($guestbook[0]['count(*)']);
        
        }else{
            
            return 0;
            
        }
        
    }
    
}

function guestbook_count(){
    
    $cache = new cache('guestbook_count');
    if($cache -> status == TRUE)
        return $cache -> read();
    else
        return $cache -> write(guestbook::count());
    
}

?>
