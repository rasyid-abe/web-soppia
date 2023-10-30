<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelaksanaan_ujian extends CI_Controller {
 	protected  $name = 'Pelaksanaan ujian'; 
    protected  $model = 'pelatihan/cbt/Rpelaksanaan_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'CBT'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-pelaksanaan-ujian');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Pelaksanaan Ujian',
			'titlepage'=>'Pelaksanaan Ujian',
			'subtitlepage'=>'Data Pelaksanaan Ujian',
			'titlebox'=>'Manage Pelaksanaan Ujian',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/cbt/'.url_title(strtolower($this->name)).'/index',$data);
	}

	public function getdata(){
		
	}

	public function actiontable($id){
		if(accessperm('melihat-data-pelaksanaan-ujian')){
			$btn = "<a href='".base_url('cbt/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-box-tool view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a>";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-pelaksanaan-ujian')){
			$btn .= "<a href='".base_url('cbt/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-box-tool' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a>";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-pelaksanaan-ujian')){
			$btn .= "<a href='".base_url('cbt/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-box-tool delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-pelaksanaan-ujian');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Pelaksanaan Ujian',
			'titlepage'=>'Pelaksanaan Ujian',
			'subtitlepage'=>'Data Pelaksanaan Ujian',
			'titlebox'=>'Add Pelaksanaan Ujian',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/cbt/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-pelaksanaan-ujian');	
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				
			);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-pelaksanaan-ujian');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Pelaksanaan Ujian',
			'titlepage'=>'Pelaksanaan Ujian',
			'subtitlepage'=>'Data Pelaksanaan Ujian',
			'titlebox'=>'Edit Pelaksanaan Ujian',
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/cbt/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-pelaksanaan-ujian');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
			
			);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-pelaksanaan-ujian');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		$this->load->view("pages/modul/pelatihan/cbt/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-pelaksanaan-ujian');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('cbt/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-pelaksanaan-ujian');
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'cbt/'.url_title(strtolower($this->name)) ) );
	}

	
}
