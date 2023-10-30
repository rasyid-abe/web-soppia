<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_project_kelas extends CI_Controller {
 	protected  $name = 'Laporan project kelas'; 
    protected  $model = 'pelatihan/kelas-pelatihan/Rpembukaankelas_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Kelas Pelatihan'; 
 	protected  $breadcrumb3 = 'Laporan Project Kelas'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-laporan-project-kelas');
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
		recordlog("Mengakses Halaman ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/index',$data);
	}

	public function getdata(){
		$csrf_name = $this->security->get_csrf_token_name();
		$csrf_hash = $this->security->get_csrf_hash(); 
		
		$list = $this->thismodel->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a href="'.base_url("kelas-pelatihan/laporan-t/".$field->Id_Kelas_n_Angkatan).'">'.$field->DescBebas_Kelas_n_Angkatan.'</a>' ;
            $row[] = $field->nomor_kelas;
            $proforma = $field->No_ProformaKontrak;
            $skreg    = $field->No_Klsreguler;
            if($field->No_ProformaKontrak == ""){$proforma = '<code>N/A</code>';}
            if($field->No_Klsreguler == ""){$skreg = '<code>N/A</code>';}
            $row[] = $proforma;
            $row[] = $skreg;
            $row[] = $field->Desc_JenisPelatihan;
            $row[] = ($field->Desc_PershInstansi!= null)? $field->Desc_PershInstansi : '<code>N/A</code>';
            $row[] = $this->actiontable($field->Id_Kelas_n_Angkatan);

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->thismodel->count_all(),
            "recordsFiltered" => $this->thismodel->count_filtered(),
            "data" => $data,
        );
        $output[$csrf_name] = $csrf_hash;
        echo json_encode($output);
	}

	public function actiontable($id){
		if(accessperm('melihat-data-laporan-project-kelas')){
			$btn = "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a>";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
        return $btn;
	}

	public function view($id){
		permissions('melihat-data-laporan-project-kelas');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat Detail Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/kelas-pelatihan/".url_title(strtolower($this->name))."/view",$data);
	}
	
}
