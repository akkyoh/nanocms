<?php

class files {
    
    public function get_image($filetype, $file_id){
        
        global $mime_types;
        
        if(substr_count($mime_types[$filetype], 'image') > 0 and file_exists($_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.intval($file_id).'.preview'))
            return '/modules/file_download/?id='.intval($file_id).'&amp;preview';
        
        if(substr_count($mime_types[$filetype], 'zip') > 0 or
           substr_count($mime_types[$filetype], 'rar') > 0 or
           substr_count($mime_types[$filetype], 'compressed') > 0 or
           substr_count($mime_types[$filetype], 'package') > 0 or
           substr_count($mime_types[$filetype], 'gtar') > 0 or
           substr_count($mime_types[$filetype], 'gzip') > 0 or
           substr_count($mime_types[$filetype], 'msdownload') > 0)
            return '/static/images/filetype/compressed.png';
        if(substr_count($mime_types[$filetype], 'image') > 0)
            return '/static/images/filetype/image.png';
        if(substr_count($mime_types[$filetype], 'audio') > 0)
            return '/static/images/filetype/music.png';
        if(substr_count($mime_types[$filetype], 'video') > 0)
            return '/static/images/filetype/movie.png';
        if(substr_count($mime_types[$filetype], 'css') > 0)
            return '/static/images/filetype/css.png';
        if(substr_count($mime_types[$filetype], 'x-asm') > 0 or
           substr_count($mime_types[$filetype], 'x-c') > 0 or
           substr_count($mime_types[$filetype], 'x-fortran') > 0 or
           substr_count($mime_types[$filetype], 'x-java-source') > 0 or
           substr_count($mime_types[$filetype], 'x-opml') > 0 or
           substr_count($mime_types[$filetype], 'x-pascal') > 0 or
           substr_count($mime_types[$filetype], 'x-nfo') > 0 or
           substr_count($mime_types[$filetype], 'x-setext') > 0 or
           substr_count($mime_types[$filetype], 'x-sfv') > 0 or
           substr_count($mime_types[$filetype], 'x-uuencode') > 0)
            return '/static/images/filetype/developer.png';
        if(substr_count($mime_types[$filetype], 'excel') > 0)
            return '/static/images/filetype/excel.png';
        if(substr_count($mime_types[$filetype], 'flash') > 0)
            return '/static/images/filetype/flash.png';
        if(substr_count($mime_types[$filetype], 'html') > 0 or
           substr_count($mime_types[$filetype], 'javascript') > 0 or
           substr_count($mime_types[$filetype], 'php') > 0 or
           $mime_types[$filetype] == 'application/xml')
            return '/static/images/filetype/code.png';
        if(substr_count($mime_types[$filetype], 'pdf') > 0)
            return '/static/images/filetype/pdf.png';
        if(substr_count($mime_types[$filetype], 'photoshop') > 0)
            return '/static/images/filetype/photoshop.png';
        if(substr_count($mime_types[$filetype], 'powerpoint') > 0)
            return '/static/images/filetype/powerpoint.png';
        if(substr_count($mime_types[$filetype], 'plain') > 0 or
           substr_count($mime_types[$filetype], 'djvu') > 0)
            return '/static/images/filetype/text.png';
        if(substr_count($mime_types[$filetype], 'word') > 0)
            return '/static/images/filetype/word.png';
        
        return '/static/images/filetype/fileicon.png';
        
    }
    
    public function get_mimetype($filetype){

        global $mime_types;
        
        return $mime_types[$filetype];
        
    }
    
    public function data_category($id){
        
        global $db;
        
        $c = $db -> query("SELECT * from `files_category` WHERE `id` = ?", $id);
        
        if(!empty($c)){
            
            return $c[0];
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function file_data($id){
        
        global $db;
        
        $p = $db -> query("SELECT * from `files` WHERE `id` = ?", $id);
        
        if(!empty($p)){
        
            return $p[0];
        
        }else{
            
            return false;
            
        }
        
    }
    
    public function get_category($parent = NULL){
        
        global $db;
        
        if($parent != NULL)
            $c = $db -> query("SELECT `name`,`id`,`about` from `files_category` WHERE `parent` = ?", $parent);
        else
            $c = $db -> query("SELECT `name`,`id`,`about` from `files_category`");
        
        
        if(!empty($c)){
            
            return $c;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function add_file($name, $filetype, $category, $size, $width, $height, $bitrate, $frequency){
        
        global $db;
        
        $db -> query("INSERT INTO `files` (`name`, `filetype`, `category`, `date`, `size`, `width`, `height`, `bitrate`, `frequency`) VALUES (?, ?, ?, UNIX_TIMESTAMP(), ?, ?, ?, ?, ?);", $name, $filetype, $category, $size, $width, $height, $bitrate, $frequency);
         
        cache::delete('files_count');
        
        return $db -> query_info['insert_id'];
        
    }
    
    private function delete_list_files($list_categories){
        
        global $db;
        
        return $db -> query("SELECT `id` from `files` WHERE `category` IN (".db::generate_ins($list_categories, 'id').")");
        
    }
    
    private function delete_list_category($id, &$list = array()){
        
        global $db;
        
        $list[]['id'] = $id;
        
        $ids = $db -> query("SELECT `id` from `files_category` WHERE `parent` = ?", $id);
        
        if(!empty($ids))
        {
            foreach($ids as $field)
            {
                 $list[]['id'] = $field['id'];
                 self::delete_list_category($field['id'], $list);
            }
            
        }
        
        return $list;
        
    }
    
    public function delete_category($id){
        
        global $db;
        
        $category = self::delete_list_category($id);
        $files = self::delete_list_files($category);
        
        $db -> transaction_start();
        
        if($db -> query("DELETE FROM `files_category` WHERE `id` IN (".db::generate_ins($category, 'id').");"))
            if($db -> query("DELETE FROM `files` WHERE `id` IN (".db::generate_ins($files, 'id').");") and count($files) > 0){
                
                $db -> transaction_complete();
            
                comments::delete_category(db::generate_ins($files, 'id'), 'files');
                
                foreach($files as $ids)
                {
                    unlink($_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.intval($ids['id']).'.download');
                    unlink($_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.intval($ids['id']).'.preview');
                }
                
            }elseif(count($files) == 0)
                $db -> transaction_complete();
            else
                $db -> transaction_cancel();
        else
            $db -> transaction_cancel();
        
        cache::delete('files_count');
        
        return;
        
    }
    
    public function delete($id){
        
        global $db;
        
        if($db -> query("DELETE FROM `files` WHERE `id` = ?;", $id)){
        
            unlink($_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.intval($id).'.download');
            unlink($_SERVER['DOCUMENT_ROOT'].'/system/files/files/'.intval($id).'.preview');
         
            comments::delete_category($id, 'files');
            
        }
        
        cache::delete('files_count');
        
        return;
        
    }
    
    public function get_parent($category){
        
        global $db;
        
        $c = $db -> query("SELECT `parent` from `files_category` WHERE `id` = ?", $category);
        
        if(!empty($c)){
            
            return $c[0]['parent'];
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function get_filetypes($category){
        
        global $db;
        
        $c = $db -> query("SELECT `filetypes` from `files_category` WHERE `id` = ?", $category);
        
        if(!empty($c)){
            
            return $c[0]['filetypes'];
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function get($category, $n){
        
        global $db;

        if($category > 0)
            $files = $db -> query("SELECT `id`,`name`,`description`,`filetype`,`date` from `files` WHERE `category` = ? ORDER by `date` DESC LIMIT ?,?", $category, $n, get_elements());
        else
            $files = $db -> query("SELECT `id`,`name`,`description`,`filetype`,`date` from `files` ORDER by `date` DESC LIMIT ?,?", $n, get_elements());

        if(!empty($files)){
        
            return $files;
        
        }else{
            
            return false;
            
        }
        
    }
    
    public function exist_category($category){
        
        if($category == 0)
            return true;
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `files_category` WHERE `id` = ?", $category);
        
        if($c[0]['count(*)'] > 0){
            
            return true;
            
        }else{
            
            return false;
            
        }
        
    }
    
    public function add_category($id, $parent, $name, $about, $filetypes){
        
        global $db;
        
        if(empty($id))
            $db -> query("INSERT INTO `files_category` (`name`, `about`, `parent`, `filetypes`) VALUES (?, ?, ?, ?);", $name, $about, $parent, $filetypes);
        else
            $db -> query("UPDATE `files_category` SET `parent` = ?, `name` = ?, `about` = ?, `filetypes` = ? WHERE `id` = ?", $parent, $name, $about, $filetypes, $id);
        
        return empty($id) ? $db -> query_info['insert_id'] : $id;
        
    }
    
    public function count_category($category){
        
        global $db;
     
        if($category > 0)
            $q = $db -> query("SELECT count(*) from `files` WHERE `category` = ?", $category);
        else
            $q = $db -> query("SELECT count(*) from `files`");
        
        return intval($q[0]['count(*)']);
        
    }
    
    public function update($id, $field, $value){
        
        if($field != 'name' and $field != 'description')
            return;
        
        global $db;
        
        return $db -> query('UPDATE `files` SET `'.$field.'` = ? WHERE `id` = ?', $value, $id);
        
    }
    
    public function download_count($id){
        
        global $db;
        
        return $db -> query('UPDATE `files` SET `download` = `download` + 1 WHERE `id` = ?', $id);
        
    }
    
    public function exist_file($id){
        
        global $db;
        
        $c = $db -> query("SELECT count(*) from `files` WHERE `id` = ?", $id);
        
        if($c[0]['count(*)'] > 0){
            
            return true;
            
        }else{
            
            return false;
            
        }
        
    }
    
}

function files_count(){
       
    $cache = new cache('files_count');
    if($cache -> status == TRUE)
        return $cache -> read();
    else
        return $cache -> write(files::count_category(0));
        
}

?>