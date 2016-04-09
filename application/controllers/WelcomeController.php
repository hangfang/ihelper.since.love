<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WelcomeController extends MY_Controller{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $data['title'] = '测试layout';
		$this->layout->view('welcome_message', $data);
	}

	public function image(){
		/* Read the image */
		$im = new Imagick();

		$Imagick=new class_imagick();
        $Imagick->open(dirname(BASEPATH)."/upload/images/test.png");
        $Imagick->resize_to(100,100,'scale_fill');
        $Imagick->add_text('since.love',10,20);
        $Imagick->add_watermark('sonce.love',10,50);
        $Imagick->save_to('x.png');
        unset($Imagick);

        /* Output the image*/
		header("Content-Type: image/png");
		echo dirname(BASEPATH)."/upload/images/x.png"
	}
}
