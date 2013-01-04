<?php

class profile {
    
    var $profile_data = NULL;
    var $update_fields = NULL;
    var $user;
    
    function __construct($user){
        
        global $db;
        
        $q = $db -> query("SELECT * from `profile` WHERE `user` = ?", $user);
        $this -> profile_data = $q[0];
        $this -> user = $user;
        
    }
    
    public function get_firsname(){
        
        return $this -> profile_data['firstname'];
    
    }
    
    public function get_lastname(){
        
        return $this -> profile_data['lastname'];
    
    }
    
    public function get_birthday(){
        
        return $this -> profile_data['birthday'];
    
    }
    
    public function get_city(){
        
        return $this -> profile_data['city'];
    
    }
    
    public function get_about(){
        
        return $this -> profile_data['about'];
    
    }
    
    public function get_phone(){
        
        return $this -> profile_data['phone'];
    
    }
    
    public function get_skype(){
        
        return $this -> profile_data['skype'];
    
    }
    
    public function get_icq(){
        
        return $this -> profile_data['icq'];
    
    }
    
    public function get_facebook(){
        
        return $this -> profile_data['facebook'];
    
    }
    
    public function get_vk(){
        
        return $this -> profile_data['vk'];
    
    }
    
    public function get_site(){
        
        return $this -> profile_data['site'];
    
    }
    
    public function get_twitter(){
        
        return $this -> profile_data['twitter'];
    
    }
    
    public function set_firstname($str){
        
        return $this -> update_field('firstname', $str);
        
    }
    
    public function set_lastname($str){
        
        return $this -> update_field('lastname', $str);
        
    }
    
    public function set_birthday($str){
        
        return $this -> update_field('birthday', $str);
        
    }
    
    public function set_city($str){
        
        return $this -> update_field('city', $str);
        
    }
    
    public function set_about($str){
        
        return $this -> update_field('about', $str);
        
    }
    
    public function set_phone($str){
        
        return $this -> update_field('phone', $str);
        
    }
    
    public function set_skype($str){
        
        return $this -> update_field('skype', $str);
        
    }
    
    public function set_icq($str){
        
        return $this -> update_field('icq', $str);
        
    }
    
    public function set_twitter($str){
        
        return $this -> update_field('twitter', $str);
        
    }
    
    public function set_facebook($str){
        
        return $this -> update_field('facebook', $str);
        
    }
    
    public function set_vk($str){
        
        return $this -> update_field('vk', $str);
        
    }
    
    public function set_site($str){
        
        return $this -> update_field('site', $str);
        
    }
    
    private function update_field($field, $value){
        
        $this -> update_fields[] = $field;
        $this -> profile_data[$field] = $value;
        
    }
    
    public function update(){
        
        global $db;
        
        $fields_count = count($this -> update_fields);
        $fields = $this -> update_fields;
        
        if($fields_count == 0)
            return false;
        
        $sql = 'INSERT INTO `profile` (`user`, ';
        
        $parametrs[] = $this -> user;
        
        for($i = 0; $i < $fields_count; $i++){
            
            $sql .= '`'.$fields[$i].'`';
            if($i != $fields_count-1)
                $sql .= ', ';
            
            $parametrs[] = $this -> profile_data[$fields[$i]];
            
        }
        
        $sql .= ') VALUES (?, ';
        
        for($i = 0; $i < $fields_count; $i++){
            
            $sql .= '?';
            if($i != $fields_count-1)
                $sql .= ', ';
            
        }
        
        $sql .= ') ON DUPLICATE KEY UPDATE';
        
        for($i = 0; $i < $fields_count; $i++){
            
            $sql .= ' `'.$fields[$i].'` = ?';
            if($i != $fields_count-1)
                $sql .= ',';
            
            $parametrs[] = $this -> profile_data[$fields[$i]];
            
        }
        
        array_unshift($parametrs, $sql);
        
        $this -> update_fields = NULL;
        
        return call_user_func_array(array($db, 'query'), $parametrs); 
        
    }
    
}

?>
