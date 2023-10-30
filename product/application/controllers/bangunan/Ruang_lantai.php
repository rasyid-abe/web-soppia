<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang_lantai extends CI_Controller {
 	protected  $name = 'Ruang lantai'; 
    protected  $model = 'referensi/bangunan/RRuang_lantai_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Bangunan'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}

	public function index(){
		permissions('melihat-data-ruang-lantai');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Manage '.$this->name,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/bangunan/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->Desc_RuangLantai;
            $row[] = $field->Desc_Gedung;
            $row[] = $field->No_Lantai;
            $row[] = $field->Keterangan;
            $row[] = $this->actiontable($field->Kd_RuangLantai);

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
		if(accessperm('melihat-data-ruang-lantai')){
			$btn = "<a href='".base_url('bangunan/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-ruang-lantai')){
			$btn .= "<a href='".base_url('bangunan/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-ruang-lantai')){
			$btn .= "<a href='".base_url('bangunan/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-ruang-lantai');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Add '.$this->name,
			'gedung'=>$this->db->get("ref_gedung"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses halaman add data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/bangunan/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-ruang-lantai');	

		$gedung = $this->security->xss_clean(html_escape($this->input->post("gedung")));
		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$nolantai = $this->security->xss_clean(html_escape($this->input->post("nolantai")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("keterangan")));

		$this->form_validation->set_rules('name', 'Nama Ruang', 'trim|required|is_unique[ref_ruanglantai.Desc_RuangLantai]|xss_clean');
		$this->form_validation->set_rules('gedung', 'Gedung', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nolantai', 'No Lantai', 'trim|required|xss_clean');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('bangunan/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'Desc_RuangLantai'=>$name,
				'Fkd_Gedung'=>$gedung,
				'No_Lantai'=>$nolantai,
				'Keterangan'=>$keterangan
			);
			$this->thismodel->insertdt($data);
			recordlog("Menambahkan data ".$this->name);
			$this->session->set_flashdata('success', 'data berhasil di simpan');
			redirect(base_url('bangunan/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-ruang-lantai');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Edit '.$this->name,
			'dtdefault'=>$this->thismodel->getrecord($id),
			'gedung'=>$this->db->get("ref_gedung"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);

		recordlog("mengakses halaman edit data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/bangunan/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-ruang-lantai');	

		$gedung = $this->security->xss_clean(html_escape($this->input->post("gedung")));
		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$nolantai = $this->security->xss_clean(html_escape($this->input->post("nolantai")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("keterangan")));

		$this->form_validation->set_rules('name', 'Nama Ruang', 'trim|required|xss_clean');
		$this->form_validation->set_rules('gedung', 'Gedung', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nolantai', 'No Lantai', 'trim|required|xss_clean');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('bangunan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'Desc_RuangLantai'=>$name,
				'Fkd_Gedung'=>$gedung,
				'No_Lantai'=>$nolantai,
				'Keterangan'=>$keterangan
			);
			$this->thismodel->updatedt($data,$id);
			recordlog("Merubah data ".$this->name);
			$this->session->set_flashdata('success', 'data berhasil  di perbaharui');
			redirect(base_url('bangunan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}


	public function view($id){
		permissions('melihat-data-ruang-lantai');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat data ".$this->name);
		$this->load->view("pages/modul/referensi/bangunan/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-ruang-lantai');

		echo "anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-12"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('bangunan/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-ruang-lantai');
		$this->thismodel->deletedt($id);
		recordlog("Menghapus data ".$this->name);
		$this->session->set_flashdata('success', 'data berhasil di perbaharui');
		redirect(base_url('bangunan/'.url_title(strtolower($this->name)) ));
	}


}