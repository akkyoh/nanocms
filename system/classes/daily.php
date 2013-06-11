<?php

class daily {
    
    public function get_category($user){
        
        global $db;
        
        $c = $db -> query("SELECT * from `daily_category` WHERE `user` = ?", $user);
        
        if(!empty($c)){
            
            return $c;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function data_category($id){
        
        global $db;
        
        $c = $db -> query("SELECT * from `daily_category` WHERE `id` = ?", $id);
        
        if(!empty($c)){
            
            return $c[0];
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function read_count($id){
        
        global $db;
        
        return $db -> query('UPDATE `daily` SET `read` = `read` + 1 WHERE `id` = ?', $id);
        
    }
    
    public function exist_category($user, $id){
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `daily_category` WHERE `id` = ? and `user` = ?", $id, $user);
        
        if($c[0]['count(*)'] > 0){
            
            return true;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function exist_note($user, $id){
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `daily` WHERE `id` = ? and `user` = ?", $id, $user);
        
        if($c[0]['count(*)'] > 0){
            
            return true;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function add_category($id, $user, $name, $about){
        
        global $db;
        
        if(empty($id))
            $db -> query("INSERT INTO `daily_category` (`name`, `about`, `user`) VALUES (?, ?, ?);", $name, $about, $user);
        else
            $db -> query("UPDATE `daily_category` SET `name` = ?, `about` = ? WHERE `id` = ?", $name, $about, $id);
        
        return empty($id) ? $db -> query_info['insert_id'] : $id;
        
    }
    
    public function update($user, $id, $topic, $text, $category, $comments, $hide){
        
        global $db;
        
        if(empty($id))
            $db -> query("INSERT INTO `daily` (`user`, `text`, `topic`, `category`, `comments`, `hide`, `date`) VALUES (?, ?, ?, ?, ?, ?, UNIX_TIMESTAMP());", $user, $text, $topic, $category, $comments, $hide);
        else
            $db -> query("UPDATE `daily` SET `text` = ?, `topic` = ?, `category` = ?, `comments` = ?, `hide` = ? WHERE `id` = ?", $text, $topic, $category, $comments, $hide, $id);
        
        cache::delete('daily_count');
        
        return (empty($id)) ? $db -> query_info['insert_id'] : $id;
        
    }
    
    public function delete_category($id){
        
        global $db;
        
        $notes = $db -> query("SELECT `id` from `daily` WHERE `category` = ?", $id);
        
        $db -> transaction_start();
        
        if($db -> query("DELETE FROM `daily_category` WHERE `id` = ?;", $id))
            if($db -> query("DELETE FROM `daily` WHERE `category` = ?;", $id)){
                
                $db -> transaction_complete();
            
                comments::delete_category(db::generate_ins($notes, 'id'), 'daily');
                
            }else
                $db -> transaction_cancel();
        else
            $db -> transaction_cancel();
        
        cache::delete('daily_count');
        
        return;
        
    }
    
    public function delete($id){
        
        global $db;
        
        if($db -> query("DELETE FROM `daily` WHERE `id` = ?;", $id))
            comments::delete_category($id, 'daily');
        
        cache::delete('daily_count');
        
    }
    
    public function count_category($category, $hide){
        
        global $db;
     
        if(!empty($category))
            $q = $db -> query("SELECT count(*) from `daily` WHERE `category` = ? and `hide` = ?", $category, $hide);
        else
            $q = $db -> query("SELECT count(*) from `daily` WHERE `hide` = ?", $hide);
        
        return intval($q[0]['count(*)']);
        
    }
    
    public function count($user, $hide){
        
        global $db;
        
        if($user > 0)
            $q = $db -> query("SELECT count(*) from `daily` WHERE `hide` = ? and `user` = ?", $hide, $user);
        else
            $q = $db -> query("SELECT count(*) from `daily` WHERE `hide` = ?", $hide);
        
        return intval($q[0]['count(*)']);
        
    }
    
    public function get($user, $category, $hide, $n){
        
        global $db;

        if(!empty($category))
            $notes = $db -> query("SELECT `id`,`user`,`topic`,`text`,`date` from `daily` WHERE `category` = ? and `hide` = ? ORDER by `date` DESC LIMIT ?,?", $category, $hide, $n, get_elements());
        else
            $notes = $db -> query("SELECT `id`,`user`,`topic`,`text`,`date` from `daily` WHERE `hide` = ? and `user` = ? ORDER by `date` DESC LIMIT ?,?", $hide, $user, $n, get_elements());

        if(!empty($notes)){
        
            return $notes;
        
        }else{
            
            return false;
            
        }
        
    }
    
    public function get_last($user, $hide, $n){
        
        global $db;
        
        if($user > 0)
            $notes = $db -> query("SELECT `id`,`user`,`topic`,`text`,`date` from `daily` WHERE `hide` = ? and `user` = ? ORDER by `date` DESC LIMIT ?,?", $hide, $user, $n, get_elements());
        else
            $notes = $db -> query("SELECT `id`,`user`,`topic`,`text`,`date` from `daily` WHERE `hide` = ? ORDER by `date` DESC LIMIT ?,?", $hide, $n, get_elements());
        
        if(!empty($notes)){
        
            return $notes;
        
        }else{
            
            return false;
            
        }
        
    }
    
    public function substr($str){
        
        $d = explode('[page]', $str);
        
        return $d[0];
        
    }
    
    public function note_data($id){
        
        global $db;
        
        $n = $db -> query("SELECT `user`,`topic`,`text`,`date`,`hide`,`comments`,`category`,`read` from `daily` WHERE `id` = ?", $id);
        
        if(!empty($n)){
        
            return $n;
        
        }else{
            
            return false;
            
        }
        
    }
    
}

function daily_count(){
        
    global $db;
        
    $cache = new cache('daily_count');
    if($cache -> status == TRUE)
        return $cache -> read();
    else
    {
        $q = $db -> query("SELECT count(*) from `daily`");
        return $cache -> write(intval($q[0]['count(*)']));
    }
        
}
    
?>