<?php

class photos {
    
    public function get_size($array, $size){
        
        if($array['height'] >= $size and $array['height'] >= $array['width']){
    
            $p = $array['height']/$size;
            $height = $array['width']/$p;
            $weight = $size;

        }elseif($array['width'] >= $size and $array['width'] >= $array['height']){

            $p = $array['width']/$size;
            $weight = $array['height']/$p;
            $height = $size;

        }
        
        return intval($height).' x '.intval($weight);
        
    }
    
    public function get_last($user, $n){
        
         global $db;
        
        if($user > 0)
            $photos = $db -> query("SELECT `id`,`user`,`name`,`date`,`description` from `photos` WHERE `user` = ? ORDER by `date` DESC LIMIT ?,?", $user, $n, get_elements());
        else
            $photos = $db -> query("SELECT `id`,`user`,`name`,`date`,`description` from `photos` ORDER by `date` DESC LIMIT ?,?", $n, get_elements());
        
        if(!empty($photos)){
        
            return $photos;
        
        }else{
            
            return false;
            
        }
        
    }
    
    public function photo_data($id){
        
        global $db;
        
        $p = $db -> query("SELECT `id`,`name`,`description`,`date`,`category`,`user`,`width`,`height` from `photos` WHERE `id` = ?", $id);
        
        if(!empty($p)){
        
            return $p[0];
        
        }else{
            
            return false;
            
        }
        
    }
    
    public function count($user){
        
        global $db;
        
        if($user > 0)
            $q = $db -> query("SELECT count(*) from `photos` WHERE `user` = ?", $user);
        else
            $q = $db -> query("SELECT count(*) from `photos`");
        
        return intval($q[0]['count(*)']);
        
    }
    
    public function get_category($user){
        
        global $db;
        
        $c = $db -> query("SELECT * from `photos_category` WHERE `user` = ?", $user);
        
        if(!empty($c)){
            
            return $c;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function count_category($category){
        
        global $db;
     
        $q = $db -> query("SELECT count(*) from `photos` WHERE `category` = ?", $category);
        
        return intval($q[0]['count(*)']);
        
    }
    
    public function add_category($id, $user, $name, $about){
        
        global $db;
        
        if(empty($id))
            $db -> query("INSERT INTO `photos_category` (`name`, `about`, `user`) VALUES (?, ?, ?);", $name, $about, $user);
        else
            $db -> query("UPDATE `photos_category` SET `name` = ?, `about` = ? WHERE `id` = ?", $name, $about, $id);
        
        return empty($id) ? $db -> query_info['insert_id'] : $id;
        
    }
    
    public function exist_category($user, $id){
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `photos_category` WHERE `id` = ? and `user` = ?", $id, $user);
        
        if($c[0]['count(*)'] > 0){
            
            return true;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function data_category($id){
        
        global $db;
        
        $c = $db -> query("SELECT * from `photos_category` WHERE `id` = ?", $id);
        
        if(!empty($c)){
            
            return $c[0];
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function delete_category($id){

        global $db;
        
        $photos = $db -> query("SELECT `id`,`width`,`height` from `photos` WHERE `category` = ?", $id);
        
        $db -> transaction_start();
        
        if($db -> query("DELETE FROM `photos_category` WHERE `id` = ?;", $id))
            if($db -> query("DELETE FROM `photos` WHERE `category` = ?;", $id)){
             
                $db -> transaction_complete();
                
                foreach($photos as $data){
                    
                    unlink('./system/files/photos/'.$data['id'].'.jpg');
                    unlink('./system/files/photos/'.$data['id'].'_preview.jpg');
                    if($data['width'] >= 640 or $data['height'] >= 640)
                        unlink('./system/files/photos/'.$data['id'].'_640.jpg');
                    if($data['width'] >= 360 or $data['height'] >= 360)
                        unlink('./system/files/photos/'.$data['id'].'_360.jpg');
                    if($data['width'] >= 240 or $data['height'] >= 240)
                        unlink('./system/files/photos/'.$data['id'].'_240.jpg');
                    if($data['width'] >= 128 or $data['height'] >= 128)
                        unlink('./system/files/photos/'.$data['id'].'_128.jpg');
                    
                }
                
                comments::delete_category(db::generate_ins($photos, 'id'), 'photos');
                
            }else
                $db -> transaction_cancel();
        else
            $db -> transaction_cancel();
        
        cache::delete('photos_count');
        
        return;
        
    }
    
    public function delete($id){
        
        $id = intval($id);
        
        global $db;
        
        $photo = $db -> query("SELECT `width`,`height` from `photos` WHERE `id` = ?", $id);
        
        if($db -> query("DELETE FROM `photos` WHERE `id` = ?;", $id)){
        
            unlink('./system/files/photos/'.$id.'.jpg');
            unlink('./system/files/photos/'.$id.'_preview.jpg');
            if($photo[0]['width'] >= 640 or $photo[0]['height'] >= 640)
                unlink('./system/files/photos/'.$id.'_640.jpg');
            if($photo[0]['width'] >= 360 or $photo[0]['height'] >= 360)
                unlink('./system/files/photos/'.$id.'_360.jpg');
            if($photo[0]['width'] >= 240 or $photo[0]['height'] >= 240)
                unlink('./system/files/photos/'.$id.'_240.jpg');
            if($photo[0]['width'] >= 128 or $photo[0]['height'] >= 128)
                unlink('./system/files/photos/'.$id.'_128.jpg');
         
            comments::delete_category($id, 'photos');
            
        }
        
        cache::delete('photos_count');
        
        return;
        
    }
    
    public function add_photo($user, $category, $name, $size, $width, $height){
        
        global $db;
        
        $db -> query("INSERT INTO `photos` (`user`, `category`, `name`, `size`, `width`, `height`, `date`) VALUES (?, ?, ?, ?, ?, ?, UNIX_TIMESTAMP());", $user, $category, $name, $size, $width, $height);
         
        cache::delete('photos_count');
        
        return $db -> query_info['insert_id'];
        
    }
    
    public function get($user, $category, $n){
        
        global $db;

        if(!empty($category))
            $photos = $db -> query("SELECT `id`,`user`,`name`,`date`,`description` from `photos` WHERE `category` = ? ORDER by `date` DESC LIMIT ?,?", $category, $n, get_elements());
        else
            $photos = $db -> query("SELECT `id`,`user`,`name`,`date`,`description` from `photos` WHERE `user` = ? ORDER by `date` DESC LIMIT ?,?", $user, $n, get_elements());

        if(!empty($photos)){
        
            return $photos;
        
        }else{
            
            return false;
            
        }
        
    }
    
    public function update($id, $field, $value){
        
        if($field != 'name' and $field != 'description')
            return;
        
        global $db;
        
        return $db -> query('UPDATE `photos` SET `'.$field.'` = ? WHERE `id` = ?', $value, $id);
        
    }
    
    public function exist_photo($user, $id){
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `photos` WHERE `id` = ? and `user` = ?", $id, $user);
        
        if($c[0]['count(*)'] > 0){
            
            return true;
            
        }else{
            
            return false;
            
        }
        
    }
    
}

function photos_count(){
    
    global $db;
    
    $cache = new cache('photos_count');
    if($cache -> status == TRUE)
        return $cache -> read();
    else
    {
        
        $c = $db -> query("SELECT count(*) from `photos`");
        return $cache -> write($c[0]['count(*)']);
        
    }
        
}

?>
