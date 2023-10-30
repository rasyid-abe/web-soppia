<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi_dan_aktifitas extends CI_Controller {
 	protected  $name = 'Materi dan aktifitas'; 
    protected  $model = 'data/materi/Rmateridanaktifitas_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Materi'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-materi-dan-aktifitas');
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
		$this->templatecus->dashboard('pages/modul/data/materi/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->Desc_Materi_n_Aktifitas;
            $row[] = $field->Singkatan;
            $row[] = $field->Skor;
            $row[] = ($field->Flag_Daftar_Nilai == "Y")? 'Ya':'Tidak';
            $row[] = $field->Menit_per_Sesi;
            $row[] = $this->actiontable($field->Kd_Materi_n_Aktifitas);

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
		if(accessperm('melihat-data-materi-dan-aktifitas')){
			$btn = "<a href='".base_url('materi/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-materi-dan-aktifitas')){
			$btn .= "<a href='".base_url('materi/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-materi-dan-aktifitas')){
			$btn .= "<a href='".base_url('materi/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-materi-dan-aktifitas');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Add '.$this->name,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/data/materi/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-materi-dan-aktifitas');	

		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$singkatan = $this->security->xss_clean(html_escape($this->input->post("singkatan")));
		$skor = $this->security->xss_clean(html_escape($this->input->post("skor")));
		$daftarnilai = $this->security->xss_clean(html_escape($this->input->post("daftarnilai")));
		$evaluasiinstruktur = $this->security->xss_clean(html_escape($this->input->post("evaluasiinstruktur")));
		$menit_sesi = $this->security->xss_clean(html_escape($this->input->post("menit_sesi")));

		$this->form_validation->set_rules('name', 'Name Description', 'trim|required|is_unique[mst_materi_n_aktifitas.Desc_Materi_n_Aktifitas]|xss_clean');
		$this->form_validation->set_rules('singkatan', 'Singkatan', 'trim|xss_clean');
		$this->form_validation->set_rules('skor', 'Skor', 'trim|xss_clean');
		$this->form_validation->set_rules('daftarnilai', 'Diperlukan Daftar Nilai', 'trim|required|xss_clean');
		$this->form_validation->set_rules('evaluasiinstruktur', 'Diperlukan Evaluasi Instruktur', 'trim|required|xss_clean');
		$this->form_validation->set_rules('menit_sesi', 'Menit Sesi', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('materi/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'Desc_Materi_n_Aktifitas'=>$name,
				'Singkatan'=>$singkatan,
				'Skor'=>$skor,
				'Flag_Daftar_Nilai'=>$daftarnilai,
				'Flag_Evaluasi_Instruktur'=>$evaluasiinstruktur,
				'Menit_per_Sesi'=>$menit_sesi
			);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('materi/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-materi-dan-aktifitas');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Edit '.$this->name,
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/data/materi/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-materi-dan-aktifitas');	

		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$singkatan = $this->security->xss_clean(html_escape($this->input->post("singkatan")));
		$skor = $this->security->xss_clean(html_escape($this->input->post("skor")));
		$daftarnilai = $this->security->xss_clean(html_escape($this->input->post("daftarnilai")));
		$evaluasiinstruktur = $this->security->xss_clean(html_escape($this->input->post("evaluasiinstruktur")));
		$menit_sesi = $this->security->xss_clean(html_escape($this->input->post("menit_sesi")));

		$this->form_validation->set_rules('name', 'Name Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('singkatan', 'Singkatan', 'trim|xss_clean');
		$this->form_validation->set_rules('skor', 'Skor', 'trim|xss_clean');
		$this->form_validation->set_rules('daftarnilai', 'Daftar Nilai', 'trim|required|xss_clean');
		$this->form_validation->set_rules('evaluasiinstruktur', 'Evaluasi Instruktur', 'trim|required|xss_clean');
		$this->form_validation->set_rules('menit_sesi', 'Menit Sesi', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('materi/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'Desc_Materi_n_Aktifitas'=>$name,
				'Singkatan'=>$singkatan,
				'Skor'=>$skor,
				'Flag_Daftar_Nilai'=>$daftarnilai,
				'Flag_Evaluasi_Instruktur'=>$evaluasiinstruktur,
				'Menit_per_Sesi'=>$menit_sesi
			);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('materi/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-materi-dan-aktifitas');
		$data = array(
			'dt'=>$this->thismodel->getrecord($id)
		);
		$this->load->view("pages/modul/data/materi/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-materi-dan-aktifitas');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('materi/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-materi-dan-aktifitas');
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'materi/'.url_title(strtolower($this->name)) ) );
	}

	
}
