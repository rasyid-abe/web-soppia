<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengelolaan_alumni extends CI_Controller {
 	protected  $name = 'Pengelolaan Alumni'; 
    protected  $model = 'pelatihan/Ralumni_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Peserta'; 
 	protected  $breadcrumb3 = 'Pengelolaan Alumni'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-calon-peserta');
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
		$this->templatecus->dashboard('pages/modul/pelatihan/alumni/index',$data);
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
            $row[] = ($field->FilePhoto!= null)? '<img src="'.base_url("uploads/photo/".$field->FilePhoto).'" width="50px" height="50px"></img>' : '<code>N/A</code>';
            $row[] = $field->NIK;
            $row[] = $field->NamaLengkap_DgnGelar;
            $row[] = $field->NamaPershInstansi;     
            $row[] = $this->actiontable($field->Id_Peserta,$field->Flag_Deleted);

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

	public function actiontable($id,$del){
		if(accessperm('melihat-data-calon-peserta')){
			$btn = "<a href='".base_url('pengelolaan-alumni/view/'.$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a>";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
        return $btn;
	}

	public function view($id){
		permissions('melihat-data-calon-peserta');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		recordlog("Melihat Detail ".$this->name);
		$this->load->view("pages/modul/pelatihan/alumni/view",$data);
	}
	
}
