<?php

if(file_get_contents('http://nanocms.mobi/modules/licence_check/?domain='.$_SERVER['HTTP_HOST']) == 'TRUE')
     $config['licence'] = 'TRUE';

write_config($config, '.');

?>