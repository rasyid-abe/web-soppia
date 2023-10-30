<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller { 
    protected  $name = 'Profil'; 
    protected  $model = 'User_model'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
	    $user = $this->db->where(array('username'=>$this->session->userdata("username")))->get("user");
	    $detail = $this->db->where(array('iduser'=>$user->row()->iduser))->get("detailuser");
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>$this->name,
			'user'=>$user,
			'detail'=>$detail,
		);
		$this->templatecus->dashboard('pages/modul/profil',$data);
	}
	
	public function store(){
	    $fullname = $this->input->post("fullname");
	    $username = $this->input->post("username");
	    $email = $this->input->post("email");
	    $iduser = $this->input->post("iduser");
	    
	    $dtold = $this->db->where(array('iduser'=>$iduser))->get("user");
	    $counting = 0;
	    if(!empty($this->input->post("password"))){
	        if($this->input->post("password") != $this->input->post("cpassword")){
    			$this->session->set_flashdata( array( 'error'=>'Password dan Konfirmasi Password Tidak Cocok!','tabact'=>'2') );
    			redirect(base_url(strtolower($this->name)));
	        }else{
	            $data['password'] = $this->encryption->encrypt( $this->input->post('password') );
	            $counting = 1;
	        }
	    }
	    $data['username'] = $username;
	    $data['email'] = $email;
	    $data1['fullname']=$fullname;
	    
	    if($dtold->row()->username != $username){
	        $counting = $counting +1;
	    }else if($dtold->row()->email != $email){
	        $counting = $counting +1;
	    }
	    $counting = $counting;
	    $this->db->where(array('iduser'=>$iduser))->update("user",$data);
	    $this->db->where(array('iduser'=>$iduser))->update("detailuser",$data1);
	    
	    if($counting >0){
            $this->session->sess_destroy();
	        redirect(base_url('login'));
	    }else{
			$this->session->set_flashdata( array( 'success'=>'Data berhasil diperbaharui','tabact'=>'2') );
			redirect(base_url(strtolower($this->name)));
	    }
	    
	}
}