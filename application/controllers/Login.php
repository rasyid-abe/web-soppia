<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
		if($this->session->userdata('status') == "login-soppia" && $this->session->userdata('logged')){
			redirect(base_url('dashboard'));
		}	
	}

	public function index()
	{
		$data = array(

		);
		$this->templatecus->login("pages/auth/login/index",$data);
	}
}
