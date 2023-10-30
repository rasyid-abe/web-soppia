<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penugasan extends CI_Controller {
 	protected  $name = 'Penugasan'; 
    protected  $model = 'pelatihan/instruktur/Rtugas_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Instruktur'; 
 	protected  $breadcrumb3 = 'Penugasan'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-penugasan');
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
		recordlog("Mengakses Halaman Data Instruktur ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/instruktur/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = ($field->Tgl_Mengajar!= null)? tgl_indo($field->Tgl_Mengajar) : '<code>N/A</code>';
            $row[] = ($field->No_Urut_Sesi!= null)? $field->No_Urut_Sesi : '<code>N/A</code>';
            $row[] = ($field->NamaLengkap_DgnGelar!= null)? $field->NamaLengkap_DgnGelar : '<code>N/A</code>';
            $row[] = ($field->DescBebas_Kelas_n_Angkatan!= null)? $field->DescBebas_Kelas_n_Angkatan : '<code>N/A</code>';
            $row[] = ($field->Desc_Materi_n_Aktifitas!= null)? $field->Desc_Materi_n_Aktifitas : '<code>N/A</code>';
            $row[] = $this->actiontable($field->Id_InstrukturNgajar_diKelas);

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
		if(accessperm('melihat-data-penugasan')){
			$btn = "<a href='".base_url('instruktur/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> Detail </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-penugasan')){
			$btn .= "<a href='".base_url('instruktur/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a>";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-penugasan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'FId_Instruktur'=>$this->db->get("mst_instruktur"),
			'FId_Kelas_n_Angkatan'=>$this->db->get("trm_pembukaankelas_n_angkatan"),
			'FKd_Materi'=>$this->db->get("mst_materi_n_aktifitas"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add Instruktur ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/instruktur/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-penugasan');	

		$fidinst = $this->security->xss_clean(html_escape($this->input->post("FId_Instruktur")));
		$kelas = $this->security->xss_clean(html_escape($this->input->post("FId_Kelas_n_Angkatan")));
		$fkdakt = $this->security->xss_clean(html_escape($this->input->post("FKd_Materi")));
		$tgl = $this->security->xss_clean(html_escape($this->input->post("Tgl_Mengajar")));
		$mulai = $this->security->xss_clean(html_escape($this->input->post("Jam_Mulai")));
		$akhir = $this->security->xss_clean(html_escape($this->input->post("Jam_Berakhir")));
		$sesi = $this->security->xss_clean(html_escape($this->input->post("Jml_SesiJamLat")));
		$ket = $this->security->xss_clean(html_escape($this->input->post("Keterangan")));
		
		if($sesi == null){
		    $sesi = 0;
		} else $sesi = $sesi;

		$this->form_validation->set_rules('FId_Instruktur','FId_Instruktur','trim|required|xss_clean');	
		$this->form_validation->set_rules('FId_Kelas_n_Angkatan','FId_Kelas_n_Angkatan','trim|required|xss_clean');
		$this->form_validation->set_rules('FKd_Materi','FKd_Materi','trim|required|xss_clean');	
		$this->form_validation->set_rules('Tgl_Mengajar','Tgl_Mengajar','trim|xss_clean');	
		$this->form_validation->set_rules('Jam_Mulai','Jam_Mulai','trim|xss_clean');	
		$this->form_validation->set_rules('Jam_Berakhir','Jam_Berakhir','trim|xss_clean');	
		$this->form_validation->set_rules('Jml_SesiJamLat','Jml_SesiJamLat','trim|xss_clean');		
		$this->form_validation->set_rules('Keterangan','Keterangan','trim|xss_clean');	
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'FId_Instruktur'=>$fidinst,	
				'FId_Kelas_n_Angkatan'=>$kelas,				
				'FKd_Materi'=>$fkdakt,				
				'Tgl_Mengajar'=>$tgl,				
				'Jam_Mulai'=>$mulai,				
				'Jam_Berakhir'=>$akhir,				
				'Jml_SesiJamLat'=>$sesi,			
				'Keterangan'=>$ket		
			);
			recordlog("Menyimpan Data Instruktur ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-penugasan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'FId_Instruktur'=>$this->db->get("mst_instruktur"),
			'FId_Kelas_n_Angkatan'=>$this->db->get("trm_pembukaankelas_n_angkatan"),
			'FKd_Materi'=>$this->db->get("mst_materi_n_aktifitas"),
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit Instruktur ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/instruktur/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-penugasan');
		
		$ket = $this->security->xss_clean(html_escape($this->input->post("Keterangan")));

		$this->form_validation->set_rules('Keterangan','Keterangan','trim|xss_clean');	

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'Keterangan'=>$ket
			);
			recordlog("Merubah Data Instruktur ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-penugasan');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Mengakses Halaman Detail Instruktur ".$this->name);
		$this->load->view("pages/modul/pelatihan/instruktur/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-penugasan');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('instruktur/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-penugasan');
		recordlog("Menhapus Data Instruktur ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'instruktur/'.url_title(strtolower($this->name)) ) );
	}

	
}
