<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot extends CI_Controller {

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
	}

	public function password()
	{
		$data = array(

		);
		$this->templatecus->login("pages/auth/forgot/index",$data);
	}
}
