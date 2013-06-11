<?php

class news {
    
    function get_category(){
        
        global $db;
        
        $c = $db -> query("SELECT * from `news_category`");
        
        if(!empty($c)){
            
            return $c;
            
        }else{
            
            return false;
            
        }
        
    }
    
    function exist_category($id){
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `news_category` WHERE `id` = ?", $id);
        
        if($c[0]['count(*)'] > 0){
            
            return true;
            
        }else{
            
            return false;
            
        }
        
    }
    
    function exist_news($id){
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `news` WHERE `id` = ?", $id);
        
        if($c[0]['count(*)'] > 0){
            
            return true;
            
        }else{
            
            return false;
            
        }
        
    }
    
    function add_category($id, $name, $about){
        
        global $db;
        
        if(empty($id))
            $db -> query("INSERT INTO `news_category` (`name`, `about`) VALUES (?, ?);", $name, $about);
        else
            $db -> query("UPDATE `news_category` SET `name` = ?, `about` = ? WHERE `id` = ?", $name, $about, $id);
        
        return empty($id) ? $db -> query_info['insert_id'] : $id;
        
    }
    
    public function data_category($id){
        
        global $db;
        
        $c = $db -> query("SELECT * from `news_category` WHERE `id` = ?", $id);
        
        if(!empty($c)){
            
            return $c[0];
            
        }else{
            
            return false;
            
        }
        
    }
    
    function update($user, $id, $topic, $text, $category, $comments, $hide){
        
        global $db;
        
        if(empty($id))
            $db -> query("INSERT INTO `news` (`user`, `text`, `topic`, `category`, `comments`, `hide`, `date`) VALUES (?, ?, ?, ?, ?, ?, UNIX_TIMESTAMP());", $user, $text, $topic, $category, $comments, $hide);
        else
            $db -> query("UPDATE `news` SET `text` = ?, `topic` = ?, `category` = ?, `comments` = ?, `hide` = ? WHERE `id` = ?", $text, $topic, $category, $comments, $hide, $id);
        
        cache::delete('news_date');
        
        return (empty($id)) ? $db -> query_info['insert_id'] : $id;
        
    }
    
    function delete_category($id){
        
        global $db;
        
        $news = $db -> query("SELECT `id` from `news` WHERE `category` = ?", $id);
        
        $db -> transaction_start();
        
        if($db -> query("DELETE FROM `news_category` WHERE `id` = ?;", $id))
            if($db -> query("DELETE FROM `news` WHERE `category` = ?;", $id)){
             
                $db -> transaction_complete();
                
                comments::delete_category(db::generate_ins($news, 'id'), 'news');
                
            }else
                $db -> transaction_cancel();
        else
            $db -> transaction_cancel();
        
        cache::delete('news_date');
        
        return;
        
    }
    
    function delete($id){
        
        global $db;
        
        if($db -> query("DELETE FROM `news` WHERE `id` = ?;", $id))
            comments::delete_category($id, 'news');
        
        cache::delete('news_date');
        
    }
    
    function count_news($category, $hide){
        
        global $db;
     
        $q = $db -> query("SELECT count(*) from `news` WHERE `category` = ? and `hide` = ?", $category, $hide);
        
        return intval($q[0]['count(*)']);
        
    }
    
    public function read_count($id){
        
        global $db;
        
        return $db -> query('UPDATE `news` SET `read` = `read` + 1 WHERE `id` = ?', $id);
        
    }
    
    function get_news($category, $hide, $n){
        
        global $db;
        
        if(!empty($category))
            $news = $db -> query("SELECT `id`,`user`,`topic`,`text`,`date` from `news` WHERE `category` = ? and `hide` = ? ORDER by `date` DESC LIMIT ?,?", $category, $hide, $n, get_elements());
        else
            $news = $db -> query("SELECT `id`,`user`,`topic`,`text`,`date` from `news` WHERE `hide` = ? ORDER by `date` DESC LIMIT ?,?", $hide, $n, get_elements());
        
        if(!empty($news)){
        
            return $news;
        
        }else{
            
            return false;
            
        }
        
    }
    
    function get_last($hide){
        
        global $db;
        
        $news = $db -> query("SELECT `id`,`user`,`topic`,`text`,`date` from `news` WHERE `hide` = ? ORDER by `date` DESC LIMIT 0,5", $hide);
        
        if(!empty($news)){
        
            return $news;
        
        }else{
            
            return false;
            
        }
        
    }
    
    function substr($str){
        
        $d = explode('[page]', $str);
        
        return $d[0];
        
    }
    
    function current_news($id){
        
        global $db;
        
        $news = $db -> query("SELECT `user`,`topic`,`text`,`date`,`hide`,`comments`,`category`,`read` from `news` WHERE `id` = ?", $id);
        
        if(!empty($news)){
        
            return $news;
        
        }else{
            
            return false;
            
        }
        
    }
    
}

function news_date(){
    
    global $db;
    
    $cache = new cache('news_date');
    if($cache -> status == TRUE)
        return $cache -> read();
    else
    {
        
        $news = $db -> query("SELECT max(date) from `news` WHERE `hide` = 0");
        
        if(!empty($news[0]['max(date)']))
        {
            return $cache -> write(date('d.m.Y в H:i', $news[0]['max(date)']));
        }
        else
            return $cache -> write(FALSE);
        
    }
     
    
}

?>
