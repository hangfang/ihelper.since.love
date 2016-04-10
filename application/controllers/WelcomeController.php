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


		$im = new Imagick(dirname(BASEPATH)."/upload/images/test.png");

		/* Thumbnail the image */
		$im->thumbnailImage(200, null);

		/* Create a border for the image */
		$im->borderImage(new ImagickPixel("white"), 5, 5);

		/* Clone the image and flip it */
		$reflection = clone $im;
		$reflection->flipImage();

		/* Create gradient. It will be overlayed on the reflection */
		$gradient = new Imagick();

		/* Gradient needs to be large enough for the image and the borders */
		$gradient->newPseudoImage($reflection->getImageWidth() + 10, $reflection->getImageHeight() + 10, "gradient:transparent-black");

		/* Composite the gradient on the reflection */
		$reflection->compositeImage($gradient, imagick::COMPOSITE_OVER, 0, 0);

		/* Add some opacity. Requires ImageMagick 6.2.9 or later */
		$reflection->setImageOpacity( 0.3 );

		/* Create an empty canvas */
		$canvas = new Imagick();

		/* Canvas needs to be large enough to hold the both images */
		$width = $im->getImageWidth() + 40;
		$height = ($im->getImageHeight() * 2) + 30;
		$canvas->newImage($width, $height, new ImagickPixel("black"));
		$canvas->setImageFormat("png");

		/* Composite the original image and the reflection on the canvas */
		$canvas->compositeImage($im, imagick::COMPOSITE_OVER, 20, 10);
		$canvas->compositeImage($reflection, imagick::COMPOSITE_OVER, 20, $im->getImageHeight() + 10);

		/* Output the image*/
		header("Content-Type: image/png");
		echo $canvas;
	}
}
