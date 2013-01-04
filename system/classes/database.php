<?php

class db {
    
    var $connect;
    var $query_info;
    var $query_count = 0;
    
    function __construct($host, $user, $password, $name) {
        
        $this -> connect = mysqli_connect($host, $user, $password, $name);
        
        if ($this -> connect == FALSE)
            return FALSE;
        
        if($this -> connect)
            @mysqli_set_charset ($this -> connect, 'utf8');
        
        return $this -> connect;
        
    }
    
    private function simple_query($sql){
        
        return mysqli_query($this -> connect, $sql);
        
    }
    
    public function transaction_start(){
        
        mysqli_autocommit($this -> connect, false);
        
    }
    
    public function transaction_complete(){
        
        mysqli_commit($this -> connect);
        mysqli_autocommit($this -> connect, true);
        
    }
    
    public function transaction_cancel(){
        
        mysqli_rollback($this -> connect);
        mysqli_autocommit($this -> connect, true);
        
    }
    
    public function query(){
        
        if(!$this -> connect)
            return;
            
        $this -> query_count++;
        
        $arguments = func_get_args();
        $sql = $arguments[0];
        
//        if($sql[0] == 'S'){
//        
//            $arguments_explain = $arguments;
//            $arguments_explain[0] = str_replace('?', "'%s'", $arguments_explain[0]);
//            $sql_explain = call_user_func_array('sprintf', $arguments_explain);
//
//            if(strpos($sql_explain, 'LIMIT'))
//                $sql_explain = substr($sql_explain, 0, strpos($sql_explain, 'LIMIT'));
//            
//            $r = $this -> simple_query('EXPLAIN '.$sql_explain);
//            $rd = mysqli_fetch_assoc($r);
//            
//            if(empty($rd['key']) and $rd['key'] != 'PRIMARY' and $rd['rows'] > 0 and $rd['Extra'] != '')
//                add_log('mysql_explain', $sql_explain.' ('.$rd['key'].', '.$rd['possible_keys'].', '.$rd['Extra'].')');
//            
//        }
                
        if(count($arguments) > 1){
        
            $query = mysqli_prepare($this -> connect, $sql);
        
            array_shift($arguments); 
            
            foreach ($arguments as $key => $var) {
                $parametrs .= $this -> get_type($arguments[$key]);
            }
            
            array_unshift($arguments, $parametrs);
            array_unshift($arguments, $query);
            unset($parametrs);
            
            call_user_func_array('mysqli_stmt_bind_param', $this -> update($arguments));
            $results = mysqli_stmt_execute($query);
            
            if($sql[0] == 'S' and $sql[2] == 'L'){

                $result = mysqli_stmt_result_metadata($query); 
                $result_data = array();
                
                while ($field = mysqli_fetch_field($result))
                    $parametrs[] = &$result_data[$field -> name];
                
                array_unshift($parametrs, $query); 
                call_user_func_array('mysqli_stmt_bind_result', $this -> update($parametrs)); 
                array_shift($parametrs); 
                $results = array(); 
                
                while (mysqli_stmt_fetch($query)) { 
                    
                    foreach($result_data as $key => $value)
                        $row[$key] = $value;           
                    $results[] = $row;
                    
                } 
                
                $this -> query_info['num_rows'] = mysqli_stmt_num_rows($query);
                
            }elseif($sql[0] == 'I'){

                $this -> query_info['insert_id'] = mysqli_stmt_insert_id($query);
            
            }
            
            mysqli_stmt_close($query);
        
        }else{
            
            $query = $this -> simple_query($sql);
            if($sql[0] == 'S' and $sql[2] == 'L')
                while($d = mysqli_fetch_assoc($query))
                    $results[] = $d;
            else
                $results = $query;
            
        }
            
        return $results;
        
    }
        
    private function get_type($var){
        
        switch (gettype($var)) {
            
            case 'integer':
                
                $type = 'i';
            
            break;
            
            case 'double':
            
                $type = 'd';
                
            break;
            
            default:
                
                $type = 's';
                
        }
        
        return $type;
        
    }
    
    public function generate_ins($array, $field){
        
        $c = count($array);
        
        foreach ($array as $key => $value) {

            $sql .= $array[$key][$field];
            
            if($c-1 != $key)
                $sql .= ', ';

        }
        
        return $sql;
        
    }
    
    function update($arr){ 
        if (strnatcmp(phpversion(),'5.3') >= 0)
        { 
            $refs = array(); 
            foreach($arr as $key => $value) 
                $refs[$key] = &$arr[$key]; 
            return $refs; 
        } 
        return $arr; 
    } 
    
}

?>
