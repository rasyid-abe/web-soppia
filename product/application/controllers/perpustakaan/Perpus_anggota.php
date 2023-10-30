<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perpus_anggota extends CI_Controller {
 	protected  $name = 'Data anggota'; 
    protected  $model = 'umum/perpustakaan/Rperpusanggota_model';
 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Perpustakaan'; 
 	protected  $breadcrumb3 = 'Data Anggota'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-perpustakaan');
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
		$this->templatecus->dashboard('pages/modul/umum/perpustakaan/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->nama_anggota;
            $row[] = $field->alamat;
            $row[] = $field->nohp;
            $row[] = tgl_indo($field->tgl_daftar);
            $row[] = $this->actiontable($field->id_anggota);

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
		if(accessperm('melihat-data-perpustakaan')){
			$btn = "<a href='".base_url('perpustakaan/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-perpustakaan')){
			$btn .= "<a href='".base_url('perpustakaan/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-perpustakaan')){
			$btn .= "<a href='".base_url('perpustakaan/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-perpustakaan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/umum/perpustakaan/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-perpustakaan');	
		
		$ktp = $this->security->xss_clean(html_escape($this->input->post("noktp")));
		$nama = $this->security->xss_clean(html_escape($this->input->post("nama_anggota")));
		$alamat = $this->security->xss_clean(html_escape($this->input->post("alamat")));
		$hp = $this->security->xss_clean(html_escape($this->input->post("nohp")));
		
		$this->form_validation->set_rules('noktp', 'Nomor KTP', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nama_anggota', 'Nama Anggota', 'trim|xss_clean');
		$this->form_validation->set_rules('alamat', 'Alamat Anggota', 'trim|xss_clean');
		$this->form_validation->set_rules('no_hp', 'No HP Anggota', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('perpustakaan/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'noktp'=>$ktp,
				'nama_anggota'=>$nama,
				'alamat'=>$alamat,
				'nohp'=>$hp,
				'tgl_daftar'=>date('Y-m-d')
			);
			recordlog("Menyimpan ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('perpustakaan/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-perpustakaan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit ".$this->name);
		$this->templatecus->dashboard('pages/modul/umum/perpustakaan/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-perpustakaan');
		
		$ktp = $this->security->xss_clean(html_escape($this->input->post("noktp")));
		$nama = $this->security->xss_clean(html_escape($this->input->post("nama_anggota")));
		$alamat = $this->security->xss_clean(html_escape($this->input->post("alamat")));
		$hp = $this->security->xss_clean(html_escape($this->input->post("nohp")));
		
		$this->form_validation->set_rules('noktp', 'Nomor KTP', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nama_anggota', 'Nama Anggota', 'trim|xss_clean');
		$this->form_validation->set_rules('alamat', 'Alamat Anggota', 'trim|xss_clean');
		$this->form_validation->set_rules('no_hp', 'No HP Anggota', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('perpustakaan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
			    'noktp'=>$ktp,
				'nama_anggota'=>$nama,
				'alamat'=>$alamat,
				'nohp'=>$hp
			);
			recordlog("Merubah ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('perpustakaan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-perpustakaan');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		recordlog("Mengakses Halaman Detail ".$this->name);
		$this->load->view("pages/modul/umum/perpustakaan/".url_title(strtolower($this->name))."/view",$data);
	}
	
	public function delete($id){
		permissions('menghapus-data-perpustakaan');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('perpustakaan/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-perpustakaan');
		recordlog("Menghapus ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'perpustakaan/'.url_title(strtolower($this->name)) ) );
	}

	
}
