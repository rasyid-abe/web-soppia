<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lembur_pegawai extends CI_Controller {
 	protected  $name = 'Lembur pegawai'; 
    protected  $model = 'kepegawaian/kepegawaian/Rlemburpegawai_model';
 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Kepegawaian'; 
 	protected  $breadcrumb3 = 'Lembur Pegawai'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-lembur-pegawai');
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
		$this->templatecus->dashboard('pages/modul/kepegawaian/kepegawaian/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->nama_pegawai;
            $row[] = tgl_indo($field->tgl_lembur);
            $row[] = $field->jam_awal;
            $row[] = $field->jam_akhir;
            $row[] = $field->petugas;
            $row[] = $this->actiontable($field->id_lembur);
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
		if(accessperm('melihat-data-lembur-pegawai')){
			$btn = "<a href='".base_url('kepegawaian/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-lembur-pegawai')){
			$btn .= "<a href='".base_url('kepegawaian/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-lembur-pegawai')){
			$btn .= "<a href='".base_url('kepegawaian/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-lembur-pegawai');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'pegawai'=>$this->db->get("data_pegawai"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/kepegawaian/kepegawaian/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-lembur-pegawai');	
		
		$peg = $this->security->xss_clean(html_escape($this->input->post("id_pegawai")));
		$lem = $this->security->xss_clean(html_escape($this->input->post("tgl_lembur")));
		$awl = $this->security->xss_clean(html_escape($this->input->post("jam_awal")));
		$akh = $this->security->xss_clean(html_escape($this->input->post("jam_akhir")));
		$pet = $this->security->xss_clean(html_escape($this->input->post("petugas")));
		$ket = $this->security->xss_clean(html_escape($this->input->post("keterangan")));
		
		$this->form_validation->set_rules('id_pegawai','Nama Pegawai','trim|required|xss_clean');	
		$this->form_validation->set_rules('tgl_lembur','Tanggal Lembur','trim|required|xss_clean');	
		$this->form_validation->set_rules('jam_awal','Jam Mulai','trim|required|xss_clean');	
		$this->form_validation->set_rules('jam_akhir','Jam Selesai','trim|required|xss_clean');	
		$this->form_validation->set_rules('petugas','Petugas','trim|required|xss_clean');	
		$this->form_validation->set_rules('keterangan','Keterangan','trim|xss_clean');	
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('kepegawaian/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'id_pegawai'=>$peg,		
				'tgl_lembur'=>$lem,		
				'jam_awal'=>$awl,		
				'jam_akhir'=>$akh,		
				'petugas'=>$pet,		
				'keterangan'=>$ket
			);
			recordlog("Menyimpan Data ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('kepegawaian/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-lembur-pegawai');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'pegawai'=>$this->db->get("data_pegawai"),
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit ".$this->name);
		$this->templatecus->dashboard('pages/modul/kepegawaian/kepegawaian/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-lembur-pegawai');
		
		$peg = $this->security->xss_clean(html_escape($this->input->post("id_pegawai")));
		$lem = $this->security->xss_clean(html_escape($this->input->post("tgl_lembur")));
		$awl = $this->security->xss_clean(html_escape($this->input->post("jam_awal")));
		$akh = $this->security->xss_clean(html_escape($this->input->post("jam_akhir")));
		$pet = $this->security->xss_clean(html_escape($this->input->post("petugas")));
		$ket = $this->security->xss_clean(html_escape($this->input->post("keterangan")));
		
		$this->form_validation->set_rules('id_pegawai','Nama Pegawai','trim|required|xss_clean');	
		$this->form_validation->set_rules('tgl_lembur','Tanggal Lembur','trim|required|xss_clean');	
		$this->form_validation->set_rules('jam_awal','Jam Mulai','trim|required|xss_clean');	
		$this->form_validation->set_rules('jam_akhir','Jam Selesai','trim|required|xss_clean');	
		$this->form_validation->set_rules('petugas','Petugas','trim|required|xss_clean');	
		$this->form_validation->set_rules('keterangan','Keterangan','trim|xss_clean');	

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('kepegawaian/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
			    'id_pegawai'=>$peg,		
				'tgl_lembur'=>$lem,		
				'jam_awal'=>$awl,		
				'jam_akhir'=>$akh,		
				'petugas'=>$pet,		
				'keterangan'=>$ket
			);
			recordlog("Merubah Data ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('kepegawaian/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-lembur-pegawai');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Mengakses Halaman Detail ".$this->name);
		$this->load->view("pages/modul/kepegawaian/kepegawaian/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-lembur-pegawai');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('kepegawaian/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-lembur-pegawai');
		recordlog("Menghapus Data ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'kepegawaian/'.url_title(strtolower($this->name)) ) );
	}

	
}
