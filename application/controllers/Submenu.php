<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submenu extends CI_Controller {

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta');   
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}

	public function index($id)
	{
		show_404();
		/*$menu = $this->db->where(array('idmenu'=>$id))->get("menu")->row();
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>ucfirst($menu->name),
			'titlepage'=>ucfirst($menu->name),
			'subtitlepage'=>ucfirst($menu->name),
			'menu'=>$menu,
			'childmenu'=>$this->db->where(array('parent'=>$id))->get("menu"),
		);
		$this->templatecus->dashboard('pages/modul/universalsubmenu',$data);*/
	}
}
