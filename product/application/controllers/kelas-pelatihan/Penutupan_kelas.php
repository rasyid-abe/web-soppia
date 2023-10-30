<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penutupan_kelas extends CI_Controller {
 	protected  $name = 'Penutupan kelas'; 
    protected  $model = 'pelatihan/kelas-pelatihan/Rpenutupankelas_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Kelas Pelatihan'; 
 	protected  $breadcrumb3 = 'Penutupan Kelas'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-penutupan-kelas');
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
            $row[] = $field->DescBebas_Kelas_n_Angkatan;
            $row[] = $field->nomor_kelas;
            $row[] = ($field->Desc_PershInstansi!= null)? $field->Desc_PershInstansi : '<code>N/A</code>';
         
              $selesai = "";
              if($field->Flag_Selesai == "B"){
                $selesai = "Kelas Belum Dimulai";
              }
              elseif($field->Flag_Selesai == "L"){
                $selesai = "Kelas Sedang Berlangsung";
              }
              elseif($field->Flag_Selesai == "E"){
                $selesai = "Kelas Sudah Berakhir";
              }
              elseif($field->Flag_Selesai == "C"){
                $selesai = "Kelas Sudah Ditutup";
              }
   
            $row[] = $selesai;
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
		if(accessperm('melihat-data-penutupan-kelas')){
			$btn = "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-penutupan-kelas')){
			$btn .= "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil'></i> Ubah Status </a>";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
        return $btn;
	}

	public function edit($id){
		permissions('merubah-data-penutupan-kelas');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'FId_JenisPelatihan'=>$this->db->get("mst_jenispelatihan"),
			'FId_PershInstansi'=>$this->db->get("mst_pershinstansi"),
			'FKd_KotaTraining'=>$this->db->get("ref_kotatraining"),
			'FId_FormatPiagamSertifikat'=>$this->db->get("mst_formatpiagamsertifikat"),
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-penutupan-kelas');
		
		$selesai = $this->security->xss_clean(html_escape($this->input->post("Flag_Selesai")));
		$sumary = $this->security->xss_clean(html_escape($this->input->post("Summary_Jalannya_Kelas")));
		$ket = $this->security->xss_clean(html_escape($this->input->post("Keterangan")));
		$format = $this->security->xss_clean(html_escape($this->input->post("FId_FormatSertifikat")));

		$this->form_validation->set_rules('Flag_Selesai','Flag_Selesai','trim|xss_clean');
		$this->form_validation->set_rules('Summary_Jalannya_Kelas','Summary_Jalannya_Kelas','trim|xss_clean');
		$this->form_validation->set_rules('Keterangan','Keterangan','trim|xss_clean');
		$this->form_validation->set_rules('FId_FormatSertifikat','FId_FormatSertifikat','trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'Flag_Selesai'=>$selesai,
				'Summary_Jalannya_Kelas'=>$sumary,
				'Keterangan'=>$ket,
				'FId_FormatSertifikat'=>$format
			);
			recordlog("Merubah Data ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-penutupan-kelas');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat Detail Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/kelas-pelatihan/".url_title(strtolower($this->name))."/view",$data);
	}
}
