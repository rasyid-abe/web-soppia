<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sesi_satuan extends CI_Controller {
 	protected  $name = 'Sesi satuan'; 
    protected  $model = 'referensi/data-sesi/Rsesisatuan_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Data Sesi'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-sesi-satuan');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Sesi Satuan',
			'titlepage'=>'Sesi Satuan',
			'subtitlepage'=>'Data Sesi Satuan',
			'titlebox'=>'Manage Sesi Satuan',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses halaman data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/data-sesi/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->Desc_Sesi;
            $row[] = ($field->Flag_Ramadhan == "Y")? 'YA':'TIDAK' ;
            $row[] = ($field->Flag_Jumat == "Y")? 'YA':'TIDAK' ;
            $row[] = ($field->Flag_RehatLunch == "Y")? 'YA':'TIDAK' ;
            $row[] = $field->Keterangan;
            $row[] = $this->actiontable($field->Kd_Sesi_Satuan);

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
		if(accessperm('melihat-data-sesi-satuan')){
			$btn = "<a href='".base_url('data-sesi/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-sesi-satuan')){
			$btn .= "<a href='".base_url('data-sesi/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-sesi-satuan')){
			$btn .= "<a href='".base_url('data-sesi/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-sesi-satuan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Sesi Satuan',
			'titlepage'=>'Sesi Satuan',
			'subtitlepage'=>'Data Sesi Satuan',
			'titlebox'=>'Add Sesi Satuan',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses halaman Add data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/data-sesi/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-sesi-satuan');	

		$description = $this->security->xss_clean(html_escape($this->input->post("Desc_Sesi")));
		$ramadhan = $this->security->xss_clean(html_escape($this->input->post("Flag_Ramadhan")));
		$jumat = $this->security->xss_clean(html_escape($this->input->post("Flag_Jumat")));
		$rehat = $this->security->xss_clean(html_escape($this->input->post("Flag_RehatLunch")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("Keterangan")));

		$this->form_validation->set_rules('Desc_Sesi', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Flag_Ramadhan', 'Flag Ramadhan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Flag_Jumat', 'Flag Jumat', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Flag_RehatLunch', 'Flag Rehat Lunch', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Keterangan', 'Keterangan', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('data-sesi/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'Desc_Sesi'=>$description,
				'Flag_Ramadhan'=>$ramadhan,
				'Flag_Jumat'=>$jumat,
				'Flag_RehatLunch'=>$rehat,
				'Keterangan'=>$keterangan
			);
			$this->thismodel->insertdt($data);
			recordlog("Menambahkan data ".$this->name);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('data-sesi/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-sesi-satuan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Sesi Satuan',
			'titlepage'=>'Sesi Satuan',
			'subtitlepage'=>'Data Sesi Satuan',
			'titlebox'=>'Edit Sesi Satuan',
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses halaman Edit data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/data-sesi/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-sesi-satuan');

		$description = $this->security->xss_clean(html_escape($this->input->post("Desc_Sesi")));
		$ramadhan = $this->security->xss_clean(html_escape($this->input->post("Flag_Ramadhan")));
		$jumat = $this->security->xss_clean(html_escape($this->input->post("Flag_Jumat")));
		$rehat = $this->security->xss_clean(html_escape($this->input->post("Flag_RehatLunch")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("Keterangan")));

		$this->form_validation->set_rules('Desc_Sesi', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Flag_Ramadhan', 'Flag Ramadhan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Flag_Jumat', 'Flag Jumat', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Flag_RehatLunch', 'Flag Rehat Lunch', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Keterangan', 'Keterangan', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('data-sesi/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'Desc_Sesi'=>$description,
				'Flag_Ramadhan'=>$ramadhan,
				'Flag_Jumat'=>$jumat,
				'Flag_RehatLunch'=>$rehat,
				'Keterangan'=>$keterangan
			);
			$this->thismodel->updatedt($data,$id);
			recordlog("Merubah data ".$this->name);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('data-sesi/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-sesi-satuan');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		recordlog("Melihat data ".$this->name);
		$this->load->view("pages/modul/referensi/data-sesi/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-sesi-satuan');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('data-sesi/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-sesi-satuan');
		$this->thismodel->deletedt($id);
		recordlog("Menghapus data ".$this->name);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'data-sesi/'.url_title(strtolower($this->name)) ) );
	}

	
}
