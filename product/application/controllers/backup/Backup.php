<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {
 	protected  $name = 'Backup'; 
   /* protected  $model = 'referensi/backup/Rbackup_model';*/
 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Backup & Restore'; 
 	protected  $breadcrumb3 = 'Backup'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        //$this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-backup');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Manage '.$this->breadcrumb3,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
     	recordlog("Mengakses Halaman backup");
		$this->templatecus->dashboard('pages/modul/backup-restore/'.url_title(strtolower($this->name)).'/index',$data);
	}

	
}
