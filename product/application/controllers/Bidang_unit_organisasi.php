<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bidang_unit_organisasi extends CI_Controller { 
    protected  $name = 'Bidang unit organisasi'; 
    protected  $model = 'referensi/Rbidang_unit_organisasi_model'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-bidang-unit-organisasi');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Manage '.$this->name,
		);
		recordlog("Mengakses Halaman Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->Desc_BidangUnitOrganisasi;
            $row[] = $this->actiontable($field->Kd_BidangUnitOrganisasi);
 
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
		if(accessperm('melihat-data-bidang-unit-organisasi')){
			$btn = "<a href='".base_url(url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-bidang-unit-organisasi')){
			$btn .= "<a href='".base_url(url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-bidang-unit-organisasi')){
			$btn .= "<a href='".base_url(url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-bidang-unit-organisasi');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Add '.$this->name,
		);
		recordlog("Mengakses Halaman Add Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-bidang-unit-organisasi');	

		$name = $this->security->xss_clean(html_escape($this->input->post("name")));

		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[ref_bidang_of_unitorganisasi.Desc_BidangUnitOrganisasi]|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url(url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'Desc_BidangUnitOrganisasi'=>$name
			);
			$this->thismodel->insertdt($data);
			recordlog("Menambahkan Data ".$this->name);
			$this->session->set_flashdata('success', 'data berhasil  di simpan');
			redirect(base_url(url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-bidang-unit-organisasi');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Edit '.$this->name,
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		recordlog("Mengakses Halaman Edit Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-bidang-unit-organisasi');	

		$name = $this->security->xss_clean(html_escape($this->input->post("name")));

		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url(url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'Desc_BidangUnitOrganisasi'=>$name
			);
			$this->thismodel->updatedt($data,$id);
			recordlog("Merubah Data ".$this->name);
			$this->session->set_flashdata('success', 'data berhasil  di perbaharui');
			redirect(base_url(url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-bidang-unit-organisasi');
		$data = array(
			'dt'=>$this->thismodel->getrecord($id)
		);
		recordlog("Melihat Data ".$this->name);
		$this->load->view("pages/modul/referensi/".url_title(strtolower($this->name))."/view",$data);
	}

	public function delete($id){
		permissions('menghapus-data-bidang-unit-organisasi');
		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-12"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url(url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-bidang-unit-organisasi');
		$this->thismodel->deletedt($id);
		recordlog("Menghapus Data ".$this->name);
		$this->session->set_flashdata('success', 'data berhasil di perbaharui');
		redirect(base_url(url_title(strtolower($this->name))));
	}
}