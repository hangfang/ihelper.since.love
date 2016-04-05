<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require "BaseController.php";
class ExpressController extends BaseController {

	public function index()
	{
        if($this->input->is_ajax){
            
            
        }
        $data['title'] = '物流查询';
		$this->layout->view('index', $data);
	}
}
