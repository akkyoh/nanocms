<?php

class forum {
    
    public function get_categories () {
        
        global $db;
        
        $c = $db -> query("SELECT * from `forums`");
        
        if(!empty($c)){
            
            return $c;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function theme_delete($id){
        
        global $db;
        
        $db -> transaction_start();
        
        if($db -> query("DELETE FROM `forums_themes` WHERE `id` = ?;", $id))
            if($db -> query("DELETE FROM `forums_messages` WHERE `theme` = ?;", $id))
                $db -> transaction_complete();
            else
                $db -> transaction_cancel();
        else
            $db -> transaction_cancel();
                 
        cache::delete('forum_info');
        
        return;
        
    }
    
    public function theme_close($id){
        
        global $db;
        
        $theme = $db -> query("SELECT `close` from `forums_themes` WHERE `id` = ?", $id);
        
        if($theme[0]['close'] == 0){
            
            return $db -> query("UPDATE `forums_themes` SET `close` = 1 WHERE `id` = ?", $id);
            
        }else{
            
            return $db -> query("UPDATE `forums_themes` SET `close` = 0 WHERE `id` = ?", $id);
            
        }
        
    }
    
    public function theme_warning($id){
        
        global $db;
        
        $theme = $db -> query("SELECT `warning` from `forums_themes` WHERE `id` = ?", $id);
        
        if($theme[0]['warning'] == 0){
            
            return $db -> query("UPDATE `forums_themes` SET `warning` = 1 WHERE `id` = ?", $id);
            
        }else{
            
            return $db -> query("UPDATE `forums_themes` SET `warning` = 0 WHERE `id` = ?", $id);
            
        }
        
    }
    
    public function is_favorite($user, $theme){
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `forums_favorites` WHERE `user` = ? and `theme` = ?", $user, $theme);
        
        if($c[0]['count(*)'] > 0){
            
            return 1;
            
        }else{
            
            return 0;
            
        }
        
    }
    
    public function exist_category($id){
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `forums` WHERE `id` = ?", $id);
        
        if($c[0]['count(*)'] == 0){
            
            return false;
            
        }else{
            
            return true;
            
        }
        
    }
    
    public function add_category($id, $name, $description){
        
        global $db;
        
        if(empty($id))
            $db -> query("INSERT INTO `forums` (`name`, `description`) VALUES (?, ?);", $name, $description);
        else
            $db -> query("UPDATE `forums` SET `name` = ?, `description` = ? WHERE `id` = ?", $name, $description, $id);
        
        return empty($id) ? $db -> query_info['insert_id'] : $id;
        
    }
    
    public function message_delete($id){
        
        global $db;
        
        cache::delete('forum_info');
        
        return $db -> query("DELETE FROM `forums_messages` WHERE `id` = ?;", $id);
        
    }
    
    public function delete_favorite($user, $theme){
        
        global $db;
        
        return $db -> query("DELETE FROM `forums_favorites` WHERE `user` = ? and `theme` = ?;", $user, $theme);
        
    }
    
    public function delete_category($id){
        
        global $db;
        
        $categories = self::get_categories();
        $c_categories = count($categories);
        
        $sql_delete_messages = 'DELETE FROM `forums_messages` WHERE `theme` IN (';    
        $sql_select_themes = 'SELECT `id` FROM `forums_themes` WHERE `category` IN (';    
        
        foreach ($categories as $key => $value) {

            $sql_select_themes .= $categories[$key]['id'];
            
            if($c_categories-1 != $key)
                $sql_select_themes .= ', ';

        }

        $sql_select_themes .= ')'; // Запрос на выборку ID тем
        
        $themes_data = $db -> query($sql_select_themes);
        $themes_count = count($themes_data);
        
        foreach ($themes_data as $key => $value) {

            $sql_delete_messages .= $themes_data[$key]['id'];
            
            if($themes_count-1 != $key)
                $sql_delete_messages .= ', ';
                
        }
        
        $sql_delete_messages .= ')'; // Запрос на удаление сообщений
        
        $db -> transaction_start();
        
        if($db -> query("DELETE FROM `forums` WHERE `id` = ?;", $id))
            if($db -> query('DELETE FROM `forums_themes` WHERE `category` = ?', $id))
                if($db -> query($sql_delete_messages))
                    $db -> transaction_complete();
                else
                    $db -> transaction_cancel();
             else
                 $db -> transaction_cancel();
        else
            $db -> transaction_cancel();
        
        cache::delete('forum_info');
        
        return;
        
    }
    
    public function count_themes($id){
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `forums_themes` WHERE `category` = ?", $id);
        
        if(!empty($c)){
            
            return $c[0]['count(*)'];
            
        }else{
            
            return 0;
            
        }
        
    }
    
    public function count_messages($id){
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `forums_messages` WHERE `theme` = ?", $id);
        
        if(!empty($c)){
            
            return $c[0]['count(*)'];
            
        }else{
            
            return 0;
            
        }
        
    }
    
    public function get_themes ($category, $n) {
        
        global $db;
        
        if($category == 0)
            $c = $db -> query("SELECT `id`,`user`,`date`,`name`,`warning`,`close` from `forums_themes` ORDER by `date` DESC");
        else
            $c = $db -> query("SELECT `id`,`user`,`date`,`name`,`warning`,`close` from `forums_themes` WHERE `category` = ? ORDER by `warning` DESC, `date` DESC LIMIT ?,?", $category, $n, get_elements());
        
        if(!empty($c)){
            
            return $c;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function get_favorites ($user) {
        
        global $db;
        
        $c = $db -> query("SELECT `theme` from `forums_favorites` WHERE `user` = ?", $user);
        
        if(!empty($c))
        {
            
            $t = $db -> query("SELECT `id`,`user`,`date`,`name`,`warning`,`close` from `forums_themes` WHERE `id` IN (".db::generate_ins($c, 'theme').") ORDER by `date` DESC");
            
            if(!empty($t))
                return $t;
            else
                return false;
            
        }
        else
            return false;
                
    }
    
    public function get_themes_data($theme){
        
        global $db;
        
        $c = $db -> query("SELECT `id`,`user`,`date`,`name`,`warning`,`close`,`category` from `forums_themes` WHERE `id` = ? LIMIT 0,1", $theme);
        
        if(!empty($c)){
            
            return $c[0];
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function get_messages ($theme, $n) {
        
        global $db;
        
        $c = $db -> query("SELECT `id`,`user`,`date`,`text` from `forums_messages` WHERE `theme` = ? ORDER by `date` ".get_sort()." LIMIT ?,?", $theme, $n, get_elements());
        
        if(!empty($c)){
            
            return $c;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function add_theme($user, $name, $category){
        
        global $db;
        
        $db -> query("INSERT INTO `forums_themes` (`name`, `category`, `date`, `user`) VALUES (?, ?, UNIX_TIMESTAMP(), ?);", $name, $category, $user);
        
        cache::delete('forum_info');
        
        return $db -> query_info['insert_id'];
        
    }
    
    public function add_favorite($user, $theme){
        
        global $db;
        
        $db -> query("INSERT INTO `forums_favorites` (`user`, `theme`) VALUES (?, ?);", $user, $theme);
        
        return;
        
    }
    
    public function add_message($user, $text, $theme){
        
        global $db;
        
        $db -> query("INSERT INTO `forums_messages` (`text`, `theme`, `date`, `user`) VALUES (?, ?, UNIX_TIMESTAMP(), ?);", $text, $theme, $user);
        $db -> query("UPDATE `forums_themes` SET `date` = UNIX_TIMESTAMP() WHERE `id` = ?", $theme);
        
        cache::delete('forum_info');
        
        return $db -> query_info['insert_id'];
        
    }
    
    public function data_category($id){
        
        global $db;
        
        $c = $db -> query("SELECT * from `forums` WHERE `id` = ?", $id);
        
        if(!empty($c)){
            
            return $c[0];
            
        }else{
            
            return false;
            
        }
        
    }
    
}

function forum_info(){
    
    global $db;
    
    $cache = new cache('forum_info');
    if($cache -> status == TRUE)
        return $cache -> read();
    else
    {
        
        $messages = $db -> query("SELECT count(*) from `forums_messages`");
        $themes = $db -> query("SELECT count(*) from `forums_themes`");
    
        return $cache -> write($themes[0]['count(*)'].' '.word_format($themes[0]['count(*)'], array('тема', 'темы', 'тем')).' и '.$messages[0]['count(*)'].' '.word_format($messages[0]['count(*)'], array('сообщение', 'сообщения', 'сообщений')));
    }
    
}

?>
