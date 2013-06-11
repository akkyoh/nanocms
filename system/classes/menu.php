<?php

class menu {
    
    public function get_menu(){
        
        global $db;
        
        $cache = new cache('menu::get_menu');
        if($cache -> status == TRUE)
            return $cache -> read();
        else
            return $cache -> write($db -> query('SELECT `id`,`name`,`module`,`image`,`about_function`,`sort`,`page_id` from `menu` ORDER by `sort` ASC;'));
        
    }
    
    public function get_data($id){
        
        global $db;
        
        $q = $db -> query('SELECT `id`,`name`,`module`,`image`,`about_function`,`sort` from `menu` WHERE `id` = ?;', $id);
        
        return $q[0];
        
    }
    
    private function get_sort($id){
        
        global $db;
        
        $q = $db -> query('SELECT `sort` from `menu` WHERE `id` = ?;', $id);
        
        return $q[0]['sort'];
        
    }
    
    public function max_sort(){
        
        global $db;
        
        $q = $db -> query('SELECT max(sort) from `menu`;');
        
        return $q[0]['max(sort)'];
        
    }
    
    public function add($id, $name, $module, $page_id, $image, $about){
        
        global $db;
        
        if(empty($id))
        {
            $max_sort = self::max_sort();
            $db -> query("INSERT INTO `menu` (`name`, `module`, `page_id`, `image`, `about_function`, `sort`) VALUES (?, ?, ?, ?, ?, ?);", $name, $module, $page_id, $image, $about, $max_sort+1);
        }
        else
            $db -> query("UPDATE `menu` SET `name` = ?, `module` = ?, `page_id` = ?, `image` = ?, `about_function` = ? WHERE `id` = ?", $name, $module, $page_id, $image, $about, $id);
        
        cache::delete('menu::get_menu');
        
        return empty($id) ? $db -> query_info['insert_id'] : $id;
        
    }
    
    public function update($position_old, $position_new, $id)
    {
        
        if($position_new == $position_old)
            return;
        
        global $db;
        
            $db -> transaction_start();

            if($db -> query('UPDATE `menu` SET `sort`=`sort`-1 WHERE `sort` > ?;', $position_old))
                if($db -> query('UPDATE `menu` SET `sort`=`sort`+1 WHERE `sort` >= ?;', $position_new))
                    if($db -> query('UPDATE `menu` SET `sort` = ? WHERE `id` = ?;', $position_new, $id))
                        $db -> transaction_complete();
                    else
                        $db -> transaction_cancel();
                else
                    $db -> transaction_cancel();
            else
                $db -> transaction_cancel();
     
        cache::delete('menu::get_menu');
            
    }
    
    public function delete($id)
    {
        
        $sort = self::get_sort($id);
        
        if($sort == '')
            return;
        
        global $db;
        
            $db -> transaction_start();

            if($db -> query("DELETE FROM `menu` WHERE `id` = ?;", $id))
                if($db -> query('UPDATE `menu` SET `sort`=`sort`-1 WHERE `sort` > ?;', $sort))
                    $db -> transaction_complete();
                else
                    $db -> transaction_cancel();
            else
                $db -> transaction_cancel();
        
        cache::delete('menu::get_menu');
            
    }
    
}

?>
