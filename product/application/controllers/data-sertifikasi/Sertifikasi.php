<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sertifikasi extends CI_Controller {
 	protected  $name = 'Sertifikasi'; 
    protected  $model = 'referensi/data-sertifikasi/Rsertifikasi_model'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}

	public function index(){
		permissions('melihat-data-sertifikasi');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>'Data Daerah',
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Manage '.$this->name,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/data-sertifikasi/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->Desc_Sertifikasi;
            $row[] = $field->Kode_Singkatan;
            $row[] = $field->ref_jenis_sertifikasi1Desc_Jns_Sertifikasi1;
            $row[] = $field->ref_jenis_sertifikasi2Desc_Jns_Sertifikasi2;
            $row[] = $field->Keterangan;
            $row[] = $this->actiontable($field->Kd_Sertifikasi);

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

	public function actiontable($id){
		if(accessperm('melihat-data-sertifikasi')){
			$btn = "<a href='".base_url('data-sertifikasi/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-sertifikasi')){
			$btn .= "<a href='".base_url('data-sertifikasi/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-sertifikasi')){
			$btn .= "<a href='".base_url('data-sertifikasi/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-sertifikasi');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>'Data Daerah',
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Add '.$this->name,
			'fkd_jns_sertifikasi1'=>$this->db->get("ref_jenis_sertifikasi1"),
			'fkd_jns_sertifikasi2'=>$this->db->get("ref_jenis_sertifikasi2"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/data-sertifikasi/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-sertifikasi');	

		$description = $this->security->xss_clean(html_escape($this->input->post("Desc_Sertifikasi")));
		$fkd1 = $this->security->xss_clean(html_escape($this->input->post("FKd_Jns_Sertifikasi1")));
		$kodes = $this->security->xss_clean(html_escape($this->input->post("Kode_Singkatan")));
		$fkd2 = $this->security->xss_clean(html_escape($this->input->post("FKd_Jns_Sertifikasi2")));
		$ktg = $this->security->xss_clean(html_escape($this->input->post("Keterangan")));

		$this->form_validation->set_rules('Desc_Sertifikasi', 'Description', 'trim|required|is_unique[ref_sertifikasi.Desc_Sertifikasi]|xss_clean');
		$this->form_validation->set_rules('Kode_Singkatan', 'Kode Singkatan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('FKd_Jns_Sertifikasi1', 'Jenis Sertifikasi 1', 'trim|required|xss_clean');
		$this->form_validation->set_rules('FKd_Jns_Sertifikasi2', 'Jenis Sertifikasi 2', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Keterangan', 'Keterangan', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('data-sertifikasi/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'Desc_Sertifikasi'=>$description,
				'Kode_Singkatan'=>$kodes,
				'FKd_Jns_Sertifikasi1'=>$fkd1,
				'FKd_Jns_Sertifikasi2'=>$fkd2,
				'Keterangan'=>$ktg
			);
			$this->thismodel->insertdt($data);
			recordlog("Menambahkan Data ".$this->name);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('data-sertifikasi/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-sertifikasi');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>'Data Daerah',
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Edit '.$this->name,
			'dtdefault'=>$this->thismodel->getrecord($id),
			'fkd_jns_sertifikasi1'=>$this->db->get("ref_jenis_sertifikasi1"),
			'fkd_jns_sertifikasi2'=>$this->db->get("ref_jenis_sertifikasi2"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit Data ".$this->name);

		$this->templatecus->dashboard('pages/modul/referensi/data-sertifikasi/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-sertifikasi');	

		$description = $this->security->xss_clean(html_escape($this->input->post("Desc_Sertifikasi")));
		$fkd1 = $this->security->xss_clean(html_escape($this->input->post("FKd_Jns_Sertifikasi1")));
		$kodes = $this->security->xss_clean(html_escape($this->input->post("Kode_Singkatan")));
		$fkd2 = $this->security->xss_clean(html_escape($this->input->post("FKd_Jns_Sertifikasi2")));
		$ktg = $this->security->xss_clean(html_escape($this->input->post("Keterangan")));

		$this->form_validation->set_rules('Desc_Sertifikasi', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Kode_Singkatan', 'Kode Singkatan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('FKd_Jns_Sertifikasi1', 'Jenis Sertifikasi 1', 'trim|required|xss_clean');
		$this->form_validation->set_rules('FKd_Jns_Sertifikasi2', 'Jenis Sertifikasi 2', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Keterangan', 'Keterangan', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('data-sertifikasi/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'Desc_Sertifikasi'=>$description,
				'Kode_Singkatan'=>$kodes,
				'FKd_Jns_Sertifikasi1'=>$fkd1,
				'FKd_Jns_Sertifikasi2'=>$fkd2,
				'Keterangan'=>$ktg
			);
			$this->thismodel->updatedt($data,$id);
			recordlog("Merubah Data ".$this->name);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('data-sertifikasi/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-sertifikasi');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Merubah Data ".$this->name);
		$this->load->view("pages/modul/referensi/data-sertifikasi/".url_title(strtolower($this->name))."/view",$data);
	}
	
	public function delete($id){
		permissions('menghapus-data-sertifikasi');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-12"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('data-sertifikasi/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-sertifikasi');
		$this->thismodel->deletedt($id);
		recordlog("Menghapus Data ".$this->name);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url('data-sertifikasi/'.url_title(strtolower($this->name)) ));
	}


}