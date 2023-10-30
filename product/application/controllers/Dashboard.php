<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta');   
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
        $this->load->model('Loghistory','thismodel');  
	}

	public function index()
	{
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>'Welcome',
			'titlepage'=>'Dashboard',
			'subtitlepage'=>'Welcome',
		);
		recordlog("Mengakses Halaman Dashboard");
		$this->templatecus->dashboard('pages/auth/dashboard/index',$data);
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
            $row[] = $field->name;
            $row[] = tgl_indo(date("Y-m-d",strtotime($field->ontime)));
            $row[] = date("H:i:s",strtotime($field->ontime));
            $row[] = ucwords($field->keterangan);
 
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->thismodel->count_all(),
            "recordsFiltered" => $this->thismodel->count_filtered(),
            "data" => $data,
        );
        $output[$csrf_name] = $csrf_hash;
        //output dalam format JSON
        echo json_encode($output);
	}
}
