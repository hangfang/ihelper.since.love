<?php

if(!function_exists('include_config')){
    function include_config($file_name){
        
        $config = array();
        $file_path = APPPATH.'config'.DIRECTORY_SEPARATOR.ENVIRONMENT.DIRECTORY_SEPARATOR.$file_name.'.php';
        if(file_exists($file_path)){
            return include($file_path);
        }
        
        $file_path = APPPATH.'config'.DIRECTORY_SEPARATOR.$file_name.'.php';
        if(file_exists($file_path)){
          
            return include($file_path);
        }
        
        throw new RuntimeException('Unable to locate the config file you have specified: '.$file_name.'.php');
    }
    
}