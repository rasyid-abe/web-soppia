<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_account extends CI_Controller {
 	protected  $name = 'Sub account'; 
    protected  $model = 'pelatihan/iht/Raccountingjurnal_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'IHT'; 
 	protected  $breadcrumb3 = 'Accounting Jurnal'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index($idpro){
		permissions('melihat-data-accounting-jurnal');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Manage '.$this->breadcrumb3,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
			'idpro'=>$idpro
		);
		recordlog("Mengakses Halaman ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/iht/sub-account/index',$data);
	}

	public function getdata($idpro){
		$csrf_name = $this->security->get_csrf_token_name();
		$csrf_hash = $this->security->get_csrf_hash(); 
		
		$list = $this->thismodel->get_datatables($idpro);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = tgl_indo($field->Tgl_Transaksi);
            $row[] = $field->Desc_Transaksi;
            $row[] = $field->Desc_Account;
            $dk = "";
            if($field->Flag_D_or_K == 'D'){
                $dk = "Debit";
            }
            elseif($field->Flag_D_or_K == 'K'){
                $dk = "Kredit";
            }
            $row[] = $dk;
            $row[] = number_format($field->Nilai_Rps);
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->thismodel->count_all($idpro),
            "recordsFiltered" => $this->thismodel->count_filtered($idpro),
            "data" => $data,
        );
        $output[$csrf_name] = $csrf_hash;
        echo json_encode($output);
	}
}
