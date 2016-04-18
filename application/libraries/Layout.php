<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 
  
class Layout 
{ 
    
    var $obj; 
    var $layout; 
    
    function Layout($layout = array("common")) 
    {
        $this->obj =& get_instance(); 
        $this->layout = '_layouts/' . $layout[0]; 
    } 
  
    function setLayout($layout) 
    { 
      $this->layout = '_layouts/' .$layout; 
    } 
    
    function view($view, $data=null, $return=false) 
    { 
        $data['class'] = $this->uri->segment(1);
        $data['environment'] = ENVIRONMENT;
        $data['base_url'] = BASE_URL;
        $data['content_for_layout'] = $this->obj->load->view($view,$data,true); 

        if($return) 
        { 
            $output = $this->obj->load->view($this->layout,$data, true); 
            return $output; 
        } 
        else 
        { 
            $this->obj->load->view($this->layout,$data, false); 
        } 
    } 
}