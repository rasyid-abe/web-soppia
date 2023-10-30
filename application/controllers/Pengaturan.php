<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller { 
	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function tanda_tangan(){
	    permissions('mengatur-data-tanda-tangan');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>'Pengaturan Tanda Tangan',
			'titlepage'=>'Pengaturan Tanda Tangan',
			'subtitlepage'=>'Data Pengaturan Tanda Tangan',
			'titlebox'=>'Manage Pengaturan Tanda Tangan',
			'dt'=>$this->db->get("mst_ttd"),
		);
		recordlog("Mengakses halaman data Pengaturan Tanda Tangan");
		$this->templatecus->dashboard('pages/modul/pengaturan/tandatangan/index',$data);
	}
	
	public function store_tanda_tangan(){
	    permissions('mengatur-data-tanda-tangan');
	    $name = $this->input->post("nama");
	    $jabatan = $this->input->post("jabatan");
	    $count = count($name);
	    $cek = $this->db->get("mst_ttd");
	    if($cek->num_rows()>0){
	        $id = $this->input->post("id");
	        for($i=0;$i<$count;$i++){
	            if($id[$i] != "" || $id[$i] != null ){
        	        $data = array(
        	            'nama'=>$name[$i],
        	            'jabatan'=>$jabatan[$i],
    	            );
    	            $this->db->where(array('idttd'=>$id[$i]))->update("mst_ttd",$data);
	            }else{
	                $xcount = 0;
	                if($name[$i] != null || $name[$i] != ''){
	                    $xcount = $xcount+1;
	                }
	                if($jabatan[$i] != null || $jabatan[$i] != ''){
	                    $xcount = $xcount+1;
	                }
	                $xcount = $xcount;
	                if($xcount > 0){
    	                $data = array(
            	            'nama'=>$name[$i],
            	            'jabatan'=>$jabatan[$i],
            	            );
                        $this->db->set('idttd', 'UUID()', FALSE);
            	        $this->db->insert("mst_ttd",$data);
	                }
	            }
	        }
	    }else{
    	    for($i=0;$i<$count;$i++){
    	        $data = array(
    	            'nama'=>$name[$i],
    	            'jabatan'=>$jabatan[$i],
    	            );
                $this->db->set('idttd', 'UUID()', FALSE);
    	        $this->db->insert("mst_ttd",$data);
    	    }
	    }
		recordlog("Merubah/Menambahkan Data Tanda Tanggan");
		$this->session->set_flashdata('success', 'data berhasil di perbaharui');
		redirect(base_url('pengaturan/tanda-tangan'));
	}

    
}