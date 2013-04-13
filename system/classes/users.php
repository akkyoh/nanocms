<?php

class users {
    
    var $user_data = NULL;
    var $update_fields = NULL;
    var $user;
        
    public function add_user($login, $password, $mail, $sex){
        
        global $db;
        
        cache::delete('users::count');
        
        return $db -> query("INSERT INTO `users` (`login`, `password`, `sex`, `mail`, `date_registration`) VALUES (?, ?, ?, ?, UNIX_TIMESTAMP());", $login, encrypt_password($password), $sex, $mail);
        
    }
    
    public function print_avatar($user, $size = 0, $o = 1){
        
        return '<img id="user_avatar" data-user="'.intval($user).'" class="image-radius" style="opacity: '.$o.'" src="/modules/get_avatar/?id='.intval($user).'&amp;size='.intval($size).'" alt="">';
        
    }
    
    public function is_friend($user_id, $user_g){
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `users_friends` WHERE `user` = ? and `friend` = ?", $user_id, $user_g);
        
        if($c[0]['count(*)'] > 0){
            
            return 1;
            
        }else{
            
            return 0;
            
        }
        
    }
    
    public function is_admin($user){
        
        global $auth_user;
        
        if(!users::is_auth($auth_user))
            return;
        
        global $db;
        
        $c = $db -> query("SELECT `level` from `users` WHERE `id` = ?", $user);
        
        if($c[0]['level'] == 7){
            
            return 1;
            
        }else{
            
            return 0;
            
        }
        
    }
    
    public function add_friend($user_id, $user_g){
        
        global $db;
        
        return $db -> query("INSERT INTO `users_friends` (`user`, `friend`) VALUES (?, ?);", $user_id, $user_g);
        
    }
    
    public function delete_friend($user_id, $user_g){
        
        global $db;
        
        return $db -> query("DELETE from `users_friends` WHERE `user` = ? and `friend` = ?;", $user_id, $user_g);
        
    }
    
    public function get_friends($user){
        
        global $db;
        
        $c = $db -> query("SELECT * from `users_friends` WHERE `user` = ?", $user);
        
        if(!empty($c)){
            
            return $c;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function count_friends($user){
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `users_friends` WHERE `user` = ?", $user);
        
        if(!empty($c)){
            
            return $c[0]['count(*)'];
            
        }else{
            
            return 0;
            
        }
        
    }
    
    public function auth($login, $password){
        
        global $db;
        
        $q_login = $db -> query("SELECT `password`,`id`,`level` from `users` WHERE `login` = ?", $login);
        $q_mail = $db -> query("SELECT `password`,`id`,`level` from `users` WHERE `mail` = ?", $login);
        
        if(!empty($q_login))
            $q = $q_login;
        if(!empty($q_mail))
            $q = $q_mail;
        
        if($q[0]['level'] <= 0)
            return false;
        
        if($q[0]['password'] == encrypt_password($password)){
            
            $key = random_string(32, 'all');
            
            setcookie('user', encrypt($q[0]['id']), time()+3600*24*366, '/');
            setcookie('key', encrypt($key), time()+3600*24*7, '/');
            
            $db -> query('INSERT INTO `users_auth` (`user`, `key`, `ip`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `key` = ?, `ip` = ?;', $q[0]['id'], $key, ip2long(get_ip()), $key, ip2long(get_ip()));
            
            return true;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function unauth(){
        
        global $user_id, $db;
        
        setcookie('user', '', time()-3600*24*366, '/');
        setcookie('key', '', time()-3600*24*366, '/');
        
        $db -> query('DELETE FROM `users_auth` WHERE `user` = ?', $user_id);
        
    }
    
    public function is_auth(&$auth_user){
        
        if($auth_user == 1)
            return TRUE;
        elseif($auth_user == 2)
            return FALSE;
        
        global $db, $user_id, $config;
        
        if($config['demo'] == 'TRUE')
            return TRUE;
        
        if(empty($user_id) or empty($_COOKIE['key']))
            return false;
        
        $key = decrypt($_COOKIE['key']);

        $q = $db -> query("SELECT `ip`,`key` from `users_auth` WHERE `user` = ?", $user_id);

        if(get_ip() == long2ip($q[0]['ip']) and $q[0]['key'] == $key){
         
            $last_update = get_variable('online_change::'.$user_id);
            
            if(empty($last_update)){
            
                $user = new users($user_id, 'last_update');
                $user -> set_online();
                $user -> update();
            
                set_variable('online_change::'.$user_id, 1, 300);
                
            }
            
            $auth_user = 1;
            
            return TRUE;
            
        }else{
            
            $auth_user = 2;
            
            return FALSE;
            
        }
            
            
        
    }
    
    function __construct($user, $fields = '*'){
        
        global $db;
        
        if($fields !== false){
        
            $q = $db -> query("SELECT ".$fields." from `users` WHERE `id` = ?", $user);
            $this -> user_data = $q[0];
        
        }
        
        $this -> user = $user;
        
    }
    
    public function get($n){
        
        global $db;
        
        return $db -> query("SELECT `id`,`login`,`last_update` from `users` ORDER by `date_registration` DESC LIMIT ?,?", $n, get_elements());
        
    }
    
    public function get_online($n){
        
        global $db;
        
        return $db -> query("SELECT `id`,`login`,`last_update` from `users` WHERE `last_update` >= UNIX_TIMESTAMP()-60*15 ORDER by `date_registration` DESC LIMIT ?,?", $n, get_elements());
        
    }
    
    public function is_online(){
        
        if($this -> user_data['last_update'] < time()-60*15)
            return FALSE;
        else
            return TRUE;
        
    }
    
    public function count(){
        
        global $db;
        
        $cache = new cache('users::count');
        if($cache -> status == TRUE)
            return $cache -> read();
        else
        {
            
            $q = $db -> query("SELECT count(*) from `users`");
            return $cache -> write($q[0]['count(*)']);
            
        }
        
    }
    
    public function count_online(){
        
        global $db;
        
        $q = $db -> query("SELECT count(*) from `users` WHERE `last_update` >= UNIX_TIMESTAMP()-60*15");
        
        return $q[0]['count(*)'];
        
    }
    
    public function get_sex(){
        
        return $this -> user_data['sex'];
        
    }
    
    public function get_name(){
        
        return $this -> user_data['login'];
        
    }
    
    public function get_mail(){
        
        return $this -> user_data['mail'];
        
    }
    
    public function get_forum(){
        
        return $this -> user_data['forum'];
        
    }
    
    public function get_elements(){
        
        return $this -> user_data['elements'];
        
    }
    
    public function get_timezone(){
        
        return $this -> user_data['timezone'];
        
    }
    
    public function get_level(){
        
        return $this -> user_data['level'];
        
    }
    
    public function get_online_time(){
        
        return $this -> user_data['last_update'];
        
    }
    
    public function get_registration(){
        
        return $this -> user_data['date_registration'];
        
    }
    
    public function set_sex($str){
        
        return $this -> update_field('sex', $str);
        
    }
    
    public function set_password($str){
        
        return $this -> update_field('password', $str);
        
    }
    
    public function set_forum($str){
        
        return $this -> update_field('forum', $str);
        
    }
    
    public function set_mail($str){
        
        return $this -> update_field('mail', $str);
        
    }
    
    public function set_timezone($str){
        
        return $this -> update_field('timezone', $str);
        
    }
    
    public function set_elements($str){
        
        return $this -> update_field('elements', $str);
        
    }
    
    public function set_level($str){
        
        return $this -> update_field('level', $str);
        
    }
    
    public function set_online(){
        
        return $this -> update_field('last_update', time());
        
    }
    
    private function update_field($field, $value){
        
        $this -> update_fields[] = $field;
        $this -> user_data[$field] = $value;
        
    }
    
    public function update(){
        
        global $db;
        
        $fields_count = count($this -> update_fields);
        $fields = $this -> update_fields;
        
        if($fields_count == 0)
            return false;
        
        $sql = 'UPDATE `users` SET';
        
        for($i = 0; $i < $fields_count; $i++){
            
            $sql .= ' `'.$fields[$i].'` = ?';
            if($i != $fields_count-1)
                $sql .= ',';
            
            $parametrs[] = $this -> user_data[$fields[$i]];
            
        }
        
        $sql .= ' WHERE `id` = ?';
        
        array_unshift($parametrs, $sql);
        $parametrs[] = $this -> user;
        
        $this -> update_fields = NULL;
        
        return call_user_func_array(array($db, 'query'), $parametrs); 
        
    }
    
}

function users_info(){
    
    return users::count_online().' / '.users::count();
    
}

?>
