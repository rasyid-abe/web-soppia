<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_pegawai extends CI_Controller {
 	protected  $name = 'Data pegawai'; 
    protected  $model = 'kepegawaian/kepegawaian/Rdatapegawai_model';
 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Kepegawaian'; 
 	protected  $breadcrumb3 = 'Data Pegawai'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-data-pegawai');
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
            $row[] = ($field->foto!= null)? '<img src="'.base_url("uploads/photo/pegawai/".$field->foto).'" width="50px" height="50px"></img>' : '<code>N/A</code>';
            $row[] = $field->nama_pegawai;
            $row[] = $field->jabatan;
            $row[] = $field->email;
            $row[] = $field->kota_lahir;
            $row[] = $this->actiontable($field->id_pegawai);
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
		if(accessperm('melihat-data-data-pegawai')){
			$btn = "<a href='".base_url('kepegawaian/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-data-pegawai')){
			$btn .= "<a href='".base_url('kepegawaian/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-data-pegawai')){
			$btn .= "<a href='".base_url('kepegawaian/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-data-pegawai');
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
		$this->templatecus->dashboard('pages/modul/kepegawaian/kepegawaian/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-data-pegawai');	
		
		$nama = $this->security->xss_clean(html_escape($this->input->post("nama_pegawai")));
		$jk = $this->security->xss_clean(html_escape($this->input->post("jenis_kelamin")));
		$nik = $this->security->xss_clean(html_escape($this->input->post("nik")));
		$jabatan = $this->security->xss_clean(html_escape($this->input->post("jabatan")));
		$kota = $this->security->xss_clean(html_escape($this->input->post("kota_lahir")));
		$tgl_lahir = $this->security->xss_clean(html_escape($this->input->post("tgl_lahir")));
		$alamat = $this->security->xss_clean(html_escape($this->input->post("alamat")));
		$strata = $this->security->xss_clean(html_escape($this->input->post("strata_pendidikan")));
		$bidang = $this->security->xss_clean(html_escape($this->input->post("bidang_pendidikan")));
		$jmlanak = $this->security->xss_clean(html_escape($this->input->post("jml_anak")));
		$email = $this->security->xss_clean(html_escape($this->input->post("email")));
	
		$this->form_validation->set_rules('nama_pegawai','Nama Pegawai','trim|required|xss_clean');	
		$this->form_validation->set_rules('jenis_kelamin','Jenis Kelamin Pegawai','trim|xss_clean');	
		$this->form_validation->set_rules('nik','NIK Pegawai','trim|required|xss_clean');	
		$this->form_validation->set_rules('jabatan','Jabatan Pegawai','trim|xss_clean');	
		$this->form_validation->set_rules('kota_lahir','Kota Lahir Pegawai','trim|xss_clean');	
		$this->form_validation->set_rules('tgl_lahir','Tanggal Lahir Pegawai','trim|xss_clean');	
		$this->form_validation->set_rules('alamat','Alamat Pegawai','trim|xss_clean');	
		$this->form_validation->set_rules('strata_pendidikan','Strata Pendidikan','trim|xss_clean');	
		$this->form_validation->set_rules('bidang_pendidikan','Bidang Pendidikan','trim|xss_clean');	
		$this->form_validation->set_rules('jml_anak','Jumlah Anak','trim|xss_clean');	
		$this->form_validation->set_rules('email','Email','trim|xss_clean');	

		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('kepegawaian/'.url_title(strtolower($this->name)).'/add'));
		}else{
		    $this->load->library('upload');

			if( !empty($_FILES['lampiran']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/pegawai/',
					'allowed_types'=>'xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
					'max_size'=>1000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('lampiran') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('kepegawaian/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData = $this->upload->data();
					$filedocument = $uploadData['file_name'];
                	$filedocument = $filedocument;
				}
			}else{
				$filedocument = null;
			}	
			
			$this->load->library('upload');
			
			if( !empty($_FILES['foto']['name']) ){
				$config = array(
					'upload_path'=> './uploads/photo/pegawai/',
					'allowed_types'=>'png|gif|jpeg|jpg',
					'max_size'=>1000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('foto') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('kepegawaian/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData = $this->upload->data();
					$filephoto = $uploadData['file_name'];
				}
			}else{
				$filephoto = null;
			}			
			
			$data = array(
				'nama_pegawai'=>$nama,	
				'jenis_kelamin'=>$jk,	
				'nik'=>$nik,	
				'jabatan'=>$jabatan,	
				'kota_lahir'=>$kota,	
				'tgl_lahir'=>$tgl_lahir,	
				'alamat'=>$alamat,	
				'strata_pendidikan'=>$strata,	
				'bidang_pendidikan'=>$bidang,	
				'jml_anak'=>$jmlanak,	
				'email'=>$email,	
				'lampiran'=>$filedocument,	
				'foto'=>$filephoto,
				'created_at'=>date('Y-m-d')
			);
			recordlog("Menyimpan ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('kepegawaian/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-data-pegawai');
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
		$this->templatecus->dashboard('pages/modul/kepegawaian/kepegawaian/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-data-pegawai');
		
		$nama = $this->security->xss_clean(html_escape($this->input->post("nama_pegawai")));
		$jk = $this->security->xss_clean(html_escape($this->input->post("jenis_kelamin")));
		$nik = $this->security->xss_clean(html_escape($this->input->post("nik")));
		$jabatan = $this->security->xss_clean(html_escape($this->input->post("jabatan")));
		$kota = $this->security->xss_clean(html_escape($this->input->post("kota_lahir")));
		$tgl_lahir = $this->security->xss_clean(html_escape($this->input->post("tgl_lahir")));
		$alamat = $this->security->xss_clean(html_escape($this->input->post("alamat")));
		$strata = $this->security->xss_clean(html_escape($this->input->post("strata_pendidikan")));
		$bidang = $this->security->xss_clean(html_escape($this->input->post("bidang_pendidikan")));
		$jmlanak = $this->security->xss_clean(html_escape($this->input->post("jml_anak")));
		$email = $this->security->xss_clean(html_escape($this->input->post("email")));
	
		$this->form_validation->set_rules('nama_pegawai','Nama Pegawai','trim|required|xss_clean');	
		$this->form_validation->set_rules('jenis_kelamin','Jenis Kelamin Pegawai','trim|xss_clean');	
		$this->form_validation->set_rules('nik','NIK Pegawai','trim|required|xss_clean');	
		$this->form_validation->set_rules('jabatan','Jabatan Pegawai','trim|xss_clean');	
		$this->form_validation->set_rules('kota_lahir','Kota Lahir Pegawai','trim|xss_clean');	
		$this->form_validation->set_rules('tgl_lahir','Tanggal Lahir Pegawai','trim|xss_clean');	
		$this->form_validation->set_rules('alamat','Alamat Pegawai','trim|xss_clean');	
		$this->form_validation->set_rules('strata_pendidikan','Strata Pendidikan','trim|xss_clean');	
		$this->form_validation->set_rules('bidang_pendidikan','Bidang Pendidikan','trim|xss_clean');	
		$this->form_validation->set_rules('jml_anak','Jumlah Anak','trim|xss_clean');	
		$this->form_validation->set_rules('email','Email','trim|xss_clean');	

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('kepegawaian/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
			    'nama_pegawai'=>$nama,	
				'jenis_kelamin'=>$jk,	
				'nik'=>$nik,	
				'jabatan'=>$jabatan,	
				'kota_lahir'=>$kota,	
				'tgl_lahir'=>$tgl_lahir,	
				'alamat'=>$alamat,	
				'strata_pendidikan'=>$strata,	
				'bidang_pendidikan'=>$bidang,	
				'jml_anak'=>$jmlanak,	
				'email'=>$email,	
				'updated_at'=>date('Y-m-d')
			);
			recordlog("Merubah ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('kepegawaian/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-data-pegawai');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		recordlog("Mengakses Halaman Detail ".$this->name);
		$this->load->view("pages/modul/kepegawaian/kepegawaian/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-data-pegawai');

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
		permissions('menghapus-data-data-pegawai');
		recordlog("Menghapus ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'kepegawaian/'.url_title(strtolower($this->name)) ) );
	}

	
}
