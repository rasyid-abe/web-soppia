<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluasi_instruktur extends CI_Controller {
 	protected  $name = 'Evaluasi instruktur'; 
    protected  $model = 'pelatihan/pencatatan-eskt/Revaluasiinstruktur_model'; 
    protected  $model2 = 'pelatihan/kelas-pelatihan/Rpembukaankelas_model'; 
    protected  $model3 = 'pelatihan/pencatatan-eskt/Rjadwalkelas_model'; 
    protected  $model4 = 'pelatihan/pencatatan-eskt/Reval_instruktur'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Pencatatan Eskt'; 
 	protected  $breadcrumb3 = 'Evaluasi Instruktur'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
        $this->load->model($this->model2,'thismodel2');  
        $this->load->model($this->model3,'thismodel3');  
        $this->load->model($this->model4,'thismodel4');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-evaluasi-instruktur');
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
		$this->templatecus->dashboard('pages/modul/pelatihan/pencatatan-eskt/'.url_title(strtolower($this->name)).'/index',$data);
	}
	
	public function materi($id){
		permissions('melihat-data-evaluasi-instruktur');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Manage '.$this->breadcrumb3,
			'id'=>$id,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pencatatan-eskt/'.url_title(strtolower($this->name)).'/materi',$data);
	}

	public function getdata(){
		$csrf_name = $this->security->get_csrf_token_name();
		$csrf_hash = $this->security->get_csrf_hash(); 
		
		$list = $this->thismodel2->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a href="'.base_url("pencatatan-eskt/evaluasi-instruktur/materi/".$field->Id_Kelas_n_Angkatan).'">'.$field->DescBebas_Kelas_n_Angkatan.'</a>';
            $row[] = $field->nomor_kelas;
            $row[] = $field->No_Urut_Angkatan;
            $row[] = $field->Desc_JenisPelatihan ;
            $row[] = tgl_indo($field->Tgl_Mulai_Aktual)." s/d ".tgl_indo($field->Tgl_Selesai_Aktual);

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->thismodel2->count_all(),
            "recordsFiltered" => $this->thismodel2->count_filtered(),
            "data" => $data,
        );
        $output[$csrf_name] = $csrf_hash;
        echo json_encode($output);
	}
	
	public function getmateri($id){
		$csrf_name = $this->security->get_csrf_token_name();
		$csrf_hash = $this->security->get_csrf_hash(); 
		
		$list = $this->thismodel4->get_datatables($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a href="'.base_url("pencatatan-eskt/evaluasi-instruktur/add/".$field->FId_Kelas_n_Angkatan.'/'.$field->idpembukaankelasangkatan).'">'.$field->NamaLengkap_DgnGelar.'</a>' ;
            $row[] = $field->Desc_Materi_n_Aktifitas;
            $row[] = $field->Singkatan;
            $row[] = $field->Skor;
            $row[] = ($field->Flag_Daftar_Nilai == "Y")? 'Ya':'Tidak';
            $row[] = $field->Menit_per_Sesi;

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->thismodel4->count_all($id),
            "recordsFiltered" => $this->thismodel4->count_filtered($id),
            "data" => $data,
        );
        $output[$csrf_name] = $csrf_hash;
        echo json_encode($output);
	}
	
	public function add(){
		permissions('menambahkan-data-evaluasi-instruktur');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$kelas = $this->uri->segment(4);
		$id = $this->uri->segment(5);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'eval'=>$this->db
                    ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=tre_pembukaankelas_n_angkatan_sesi.FId_Kelas_n_Angkatan",'left')
                    ->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
                    ->join("ref_sesi_satuan","ref_sesi_satuan.Kd_Sesi_Satuan=tre_pembukaankelas_n_angkatan_sesi.FKd_Sesi_Satuan",'left')
                    ->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas",'left')
                    ->join("mst_instruktur","mst_instruktur.Id_Instruktur=tre_pembukaankelas_n_angkatan_sesi.FId_Instruktur",'left')
                    ->where("tre_pembukaankelas_n_angkatan_sesi.idpembukaankelasangkatan",$id)
                    ->get("tre_pembukaankelas_n_angkatan_sesi")->row(),
            'pesertaqia'=>$this->db
			            ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_qia.id_peserta",'left')
                        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=kelas_qia.id_kelas",'left')
                        ->where("kelas_qia.id_kelas",$kelas)
                        ->get("kelas_qia"),
            'pesertanonqia'=>$this->db
			            ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_nonqia.id_peserta",'left')
                        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=kelas_nonqia.id_kelas",'left')
                        ->where("kelas_nonqia.id_kelas",$kelas)
                        ->get("kelas_nonqia"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pencatatan-eskt/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-evaluasi-instruktur');
		
		$ids = $this->security->xss_clean(html_escape($this->input->post("ids")));
		$kelas = $this->security->xss_clean(html_escape($this->input->post("kelas")));
		
		$id = $this->security->xss_clean(html_escape($this->input->post("idsesi")));
		$fidinst = $this->security->xss_clean(html_escape($this->input->post("idins")));
		$fidpes = $this->security->xss_clean(html_escape($this->input->post("idpeserta")));
		$eval1 = $this->security->xss_clean(html_escape($this->input->post("Jwb_Eval1")));
		$eval2 = $this->security->xss_clean(html_escape($this->input->post("Jwb_Eval2")));
		$eval31 = $this->security->xss_clean(html_escape($this->input->post("Jwb_Eval31")));
		$eval32 = $this->security->xss_clean(html_escape($this->input->post("Jwb_Eval32")));
		$eval33 = $this->security->xss_clean(html_escape($this->input->post("Jwb_Eval33")));
		$eval34 = $this->security->xss_clean(html_escape($this->input->post("Jwb_Eval34")));
		$eval35 = $this->security->xss_clean(html_escape($this->input->post("Jwb_Eval35")));
		$eval36 = $this->security->xss_clean(html_escape($this->input->post("Jwb_Eval36")));
		$eval4 = $this->security->xss_clean(html_escape($this->input->post("Jwb_Eval4")));
		$saran = $this->security->xss_clean(html_escape($this->input->post("Saran_Eval")));

		$this->form_validation->set_rules('FId_InstrukturNgajar_diKelas','FId_InstrukturNgajar_diKelas','trim|xss_clean');	
		$this->form_validation->set_rules('Saran_Eval','Saran_Eval','trim|xss_clean');	
		
		if ($eval1=="" and $eval2=="" and $eval31=="" and $eval32=="" and $eval33=="" and $eval34=="" and $eval35=="" and $eval36=="" and $eval4=="" and $saran=="") {
			$this->session->set_flashdata('error','Belum ada data evaluasi');
			redirect(base_url('pencatatan-eskt/'.url_title(strtolower($this->name)).'/add/'.$kelas.'/'.$ids));
		}
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('pencatatan-eskt/'.url_title(strtolower($this->name)).'/add/'.$kelas.'/'.$ids));
		}else{

			$data = array(
				'FId_InstrukturNgajar_diKelas'=>$fidinst,
				'FId_Kelas_n_Angkatan'=>$kelas,
				'FId_Peserta'=>$fidpes,
				'Jwb_Eval1'=>$eval1,
				'Jwb_Eval2'=>$eval2,
				'Jwb_Eval31'=>$eval31,
				'Jwb_Eval32'=>$eval32,
				'Jwb_Eval33'=>$eval33,
				'Jwb_Eval34'=>$eval34,
				'Jwb_Eval35'=>$eval35,
				'Jwb_Eval36'=>$eval36,
				'Jwb_Eval4'=>$eval4,
				'Saran_Eval'=>$saran,
			);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('pencatatan-eskt/'.url_title(strtolower($this->name)).'/add/'.$kelas.'/'.$ids));
		}
	}
	
	public function hasil(){
		permissions('menambahkan-data-evaluasi-penyelenggaraan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		
		$id = $this->uri->segment(5);
		$instruktur = $this->uri->segment(4);
		$class = $this->uri->segment(6);
		
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Hasil '.$this->breadcrumb3,
			'eval'=>$this->db
					->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=tre_pembukaankelas_n_angkatan_sesi.FId_Kelas_n_Angkatan",'left')
					->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
					->join("ref_sesi_satuan","ref_sesi_satuan.Kd_Sesi_Satuan=tre_pembukaankelas_n_angkatan_sesi.FKd_Sesi_Satuan",'left')
					->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas",'left')
					->join("mst_instruktur","mst_instruktur.Id_Instruktur=tre_pembukaankelas_n_angkatan_sesi.FId_Instruktur",'left')
					->where("tre_pembukaankelas_n_angkatan_sesi.idpembukaankelasangkatan",$id)
					->get("tre_pembukaankelas_n_angkatan_sesi")->row(),
            'hasil'=>$this->db
                    ->where("FId_InstrukturNgajar_diKelas",$instruktur)
                    ->get("tre_instrukturngajar_dikelas_evaluasi"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pencatatan-eskt/'.url_title(strtolower($this->name)).'/hasil',$data);
	}
}
