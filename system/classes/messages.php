<?php

class messages {
    
    public function send_message($from, $whom, $text){
        
       global $db;
        
       if(empty($text))
           return false;
       
       if($db -> query('INSERT INTO `messages` (`time`, `group`, `from`, `whom`, `text`) VALUES (UNIX_TIMESTAMP() , ?, ?, ?, ?);', self::generate_group($from, $whom), $from, $whom, $text) == TRUE)
            return true;
       else
           return false;
                    
    }
    
    private function generate_group($one_user, $two_user){
        
        if($one_user > $two_user)
            return $two_user.$one_user;
        else
            return $one_user.$two_user;
        
    }
    
    public function get_messages($one_user, $two_user, $n){
        
        global $db;
        
        $group = self::generate_group($one_user, $two_user);
        
        $messages = $db -> query("SELECT `id`,`from`,`whom`,`read`,`time`,`text` from `messages` WHERE `group` = ? and `delete` != ? ORDER by `time` DESC LIMIT ?,?", $group, $one_user, $n, get_elements());
        
        if(!empty($messages)){
        
            return $messages;
        
        }else{
            
            return false;
            
        }
        
    }
    
    public function count_messages($one_user, $two_user){
        
        global $db;
        
        $group = self::generate_group($one_user, $two_user);
        
        $messages = $db -> query("SELECT count(*) from `messages` WHERE `group` = ? and `delete` != ?", $group, $one_user);
        
        if(!empty($messages)){
        
            return $messages[0]['count(*)'];
        
        }else{
            
            return 0;
            
        }
        
    }
    
    public function unread($user){
        
        global $db;
        
        $messages = $db -> query("SELECT count(*) from `messages` WHERE `whom` = ? and `read` = 0 and `delete` != ?", $user, $user);
        
        if(!empty($messages)){
        
            return $messages[0]['count(*)'];
        
        }else{
            
            return 0;
            
        }
        
    }
    
    public function unread_group($user, $one_user, $two_user){
        
        global $db;
        
        $group = self::generate_group($one_user, $two_user);
        
        $messages = $db -> query("SELECT count(*) from `messages` WHERE `whom` = ? and `group` = ? and `read` = 0 and `delete` != ?", $user, $group, $one_user);
        
        if(!empty($messages)){
        
            return $messages[0]['count(*)'];
        
        }else{
            
            return 0;
            
        }
        
    }
    
    public function delete($user, $id){
        
        global $db;
        
        $messages = $db -> query("SELECT `delete` from `messages` WHERE `id` = ? and (`from` = ? or `whom` = ?)", $id, $user, $user);
        
        if($messages[0]['delete'] != $user and $messages[0]['delete'] != 0){
            
            $db -> query("DELETE FROM `messages` WHERE `id` = ? and (`from` = ? or `whom` = ?)", $id, $user, $user);
            
        }else{
            
            $db -> query("UPDATE `messages` SET `delete` = ? WHERE `id` = ? and (`from` = ? or `whom` = ?)", $user, $id, $user, $user);
            
        }
        
    }
    
    public function delete_dialog($user, $autor){
        
        global $db;
        
        $group = self::generate_group($user, $autor);
        
        $update = $db -> query("SELECT `id` from `messages` WHERE `delete` = 0 and `group` = ?", $group);
        $delete = $db -> query("SELECT `id` from `messages` WHERE `delete` != 0 and `delete` != ? and `group` = ?", $user, $group);
        
        $update_c = count($update);
        $delete_c = count($delete);
        
        if($update_c > 0){
            
            $db -> query('UPDATE `messages` SET `delete` = ? WHERE `id` IN ('.db::generate_ins($update, 'id').')', $user);
            
        }
        
        if($delete_c > 0){

            $db -> query('DELETE FROM `messages` WHERE `id` IN ('.db::generate_ins($delete, 'id').')');
            
        }
        
    }
    
    public function set_read($ids){
        
        global $db;
        
        if(is_array($ids)){
        
            $ids_c = count($ids);

            $sql_text = 'UPDATE `messages` SET `read` = 1 WHERE `id` IN (';

            foreach ($ids as $key => $value) {

                $sql_text .= $value;
                if($ids_c-1 != $key)
                    $sql_text .= ', ';

            }
            
            $sql_text .= ')';
        
        }else{
            
            $sql_text = 'UPDATE `messages` SET `read` = 1 WHERE `id` = '.$ids;
            
        }
        
        $db -> query($sql_text);
        
    }
    
    public function get_list($user){
        
        global $db;
        
        $messages = $db -> query("SELECT MAX(id) as `id` FROM `messages` WHERE (`from` = ? or `whom` = ?) and `delete` != ? GROUP BY `group`", $user, $user, $user);

        if(!empty($messages)){
            
            $messages_text = $db -> query('SELECT `text`,`from`,`whom`,`id`,`time`,`read` from `messages` WHERE `id` IN ('.db::generate_ins($messages, 'id').') ORDER by `time` DESC');
            
            foreach($messages_text as $key_t => $value_t){

                foreach($messages as $key => $value){
                    
                    if($messages[$key]['id'] == $messages[$key_t]['id']){
                        
                        $result[] = array('id' => $messages[$key]['id'], 
                                          'time' => $messages_text[$key_t]['time'],
                                          'text' => $messages_text[$key_t]['text'],
                                          'from' => $messages_text[$key_t]['from'],
                                          'whom' => $messages_text[$key_t]['whom'],
                                          'read' => $messages_text[$key_t]['read']);
                        
                    }
                    
                }
                
            }
        
        }else{
            
            $result = false;
            
        }
        
        return $result;
        
    }
    
}

?>
