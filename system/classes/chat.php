<?php

class chat {
    
    public function add($user, $text){
        
       global $db;
        
       if(empty($text))
           return false;
       
       cache::delete('chat_count');
       
       if($db -> query('INSERT INTO `chat` (`user`, `date`, `text`) VALUES (?, UNIX_TIMESTAMP(), ?);', $user, $text) == TRUE)
            return true;
       else
           return false;
        
    }
    
    public function get($n){
        
        global $db;
        
        $messages = $db -> query("SELECT `id`,`user`,`text`,`date` from `chat` ORDER by `date` DESC LIMIT ?,?", $n, get_elements());
        
        if(!empty($messages)){
        
            return $messages;
        
        }else{
            
            return false;
            
        }
        
    }
    
    public function delete($id){
        
        global $db;
        
        $db -> query("DELETE FROM `chat` WHERE `id` = ?", $id);
        
        cache::delete('chat_count');
        
    }
    
    public function count(){
        
        global $db;
        
        $chat = $db -> query("SELECT count(*) from `chat`");
        
        if(!empty($chat)){
        
            return intval($chat[0]['count(*)']);
        
        }else{
            
            return 0;
            
        }
        
    }
    
}

function chat_count(){
    
    $cache = new cache('chat_count');
    if($cache -> status == TRUE)
        return $cache -> read();
    else
        return $cache -> write(chat::count());
    
}

?>
