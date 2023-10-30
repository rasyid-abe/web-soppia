<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kota_training extends CI_Controller {
 	protected  $name = 'Kota training'; 
    protected  $model = 'referensi/data-daerah/RKota_training_model'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}

	public function index(){
		permissions('melihat-data-kota-training');
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
		recordlog("Mengakses halaman data Kota Training");
		$this->templatecus->dashboard('pages/modul/referensi/data-daerah/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->Desc_KotaTraining;
            $row[] = $field->Desc_Propinsi;
            $row[] = $this->actiontable($field->Kd_KotaTraining);

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
		if(accessperm('melihat-data-kota-training')){
			$btn = "<a href='".base_url('data-daerah/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-kota-training')){
			$btn .= "<a href='".base_url('data-daerah/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-kota-training')){
			$btn .= "<a href='".base_url('data-daerah/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-kota-training');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>'Data Daerah',
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Add '.$this->name,
			'propinsi'=>$this->db->get("ref_propinsi"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses halaman add data Kota Training");
		$this->templatecus->dashboard('pages/modul/referensi/data-daerah/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-kota-training');	

		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$propinsi = $this->security->xss_clean(html_escape($this->input->post("propinsi")));

		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[ref_kotatraining.Desc_KotaTraining]|xss_clean');
		$this->form_validation->set_rules('propinsi', 'Propinsi', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('data-daerah/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'Desc_KotaTraining'=>$name,
				'FKd_Propinsi'=>$propinsi
			);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'data berhasil di simpan');
			recordlog("Menambahkan data Kota Training");
			redirect(base_url('data-daerah/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-kota-training');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>'Data Daerah',
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Edit '.$this->name,
			'dtdefault'=>$this->thismodel->getrecord($id),
			'propinsi'=>$this->db->get("ref_propinsi"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses halaman edit data Kota Training");
		$this->templatecus->dashboard('pages/modul/referensi/data-daerah/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-kota-training');	

		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$propinsi = $this->security->xss_clean(html_escape($this->input->post("propinsi")));

		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('propinsi', 'Propinsi', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('data-daerah/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'Desc_KotaTraining'=>$name,
				'FKd_Propinsi'=>$propinsi
			);
			$this->thismodel->updatedt($data,$id);
			recordlog("Merubah data Kota Training");
			$this->session->set_flashdata('success', 'data berhasil  di perbaharui');
			redirect(base_url('data-daerah/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}


	public function view($id){
		permissions('melihat-data-kota-training');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat data Kota Training");
		$this->load->view("pages/modul/referensi/data-daerah/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-kota-training');

		echo "anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-12"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('data-daerah/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-kota-training');
		recordlog("Menghapus data Kota Training");
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'data berhasil di perbaharui');
		redirect(base_url('data-daerah/'.url_title(strtolower($this->name)) ));
	}


}