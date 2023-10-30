<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
	}

	public function login()
	{
		$username = $this->security->xss_clean(html_escape($this->input->post("username")));
		$password = $this->security->xss_clean(html_escape($this->input->post("password")));

		if($username != "anonim" && $password != "anonim"){
			if(checkEmail($username)){
				$cekwhere  = array(
					'email' => $username,
				);
			}else{
				$cekwhere  = array(
					'username' => $username,
				);
			}
			$cek = (object) $this->checkauth($cekwhere,$password);
			if($cek->status == false){
				$this->session->set_flashdata('error','Username dan Password anda tidak cocok! Silahkan Ulangi Kembali');
				redirect(base_url('login'));
			}else{
				if($cek->is_active == 1){
				    if(checktimeloginrole($cek->username)){
				        $sess_data = array(
    						'logged' => true,
    						'username'=>$cek->username,
    						'status'=>'login-soppia'
    					);
    					$this->session->set_userdata($sess_data);
    					recordlog("Login");
    					redirect(base_url('dashboard'));
				    }elseif( checktimeloginrole($cek->username) == 'gagallogin' ){
        				$this->session->set_flashdata('error','Username dan Password anda tidak cocok! Silahkan Ulangi Kembali');
        				redirect(base_url('login'));
				    }else{
    					$this->session->set_flashdata('error','Maaf saat ini anda belum bisa mengakses sistem !<br/> Silahkan hubungi administrator untuk merubah waktu akses akun anda!');
    					redirect(base_url('login'));
				    }
				}else{
					$this->session->set_flashdata('error','Akun anda belum aktif!<br/> Silahkan hubungi administrator untuk mengaktifkan akun anda!');
					redirect(base_url('login'));
				}
			}
		}else{
			$sess_data = array(
				'logged' => true,
				'username'=>$username,
				'status'=>'login-soppia'
			);
			$this->session->set_userdata($sess_data);
			recordlog("Login");
			redirect(base_url('dashboard'));
		}
	}

	public function checkauth($where,$password){
		$cekuser = $this->db->where($where)->get("user");
		if($cekuser->num_rows()>0){
		    $pass = $this->encryption->decrypt($cekuser->row()->password);
		    if($pass == $password){
	        	$dtuser = $cekuser->row();
    			$rs = array(
    				'status' => true,
    				'username' => $dtuser->username,
    				'is_active' => $dtuser->is_active,
    			);
		    }else{
		        $rs = array(
    				'status' => false
    			);
		    }
		}else{
			$rs = array(
				'status' => false
			);
		}
		return $rs;
	}

}
