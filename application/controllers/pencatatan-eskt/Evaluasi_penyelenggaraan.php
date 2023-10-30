<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluasi_penyelenggaraan extends CI_Controller {
 	protected  $name = 'Evaluasi penyelenggaraan'; 
    protected  $model = 'pelatihan/pencatatan-eskt/Revaluasipenyelenggaraan_model'; 
    protected  $model2 = 'pelatihan/kelas-pelatihan/Rpembukaankelas_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Pencatatan Eskt'; 
 	protected  $breadcrumb3 = 'Evaluasi Penyelenggaraan'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
        $this->load->model($this->model2,'thismodel2');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-evaluasi-penyelenggaraan');
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
            $row[] = '<a href="'.base_url("pencatatan-eskt/evaluasi-penyelenggaraan/add/".$field->Id_Kelas_n_Angkatan).'">'.$field->DescBebas_Kelas_n_Angkatan.'</a>';
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

	public function actiontable($id){
		if(accessperm('melihat-data-evaluasi-penyelenggaraan')){
			$btn = "<a href='".base_url('pencatatan-eskt/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-box-tool view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a>";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-evaluasi-penyelenggaraan')){
			$btn .= "<a href='".base_url('pencatatan-eskt/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-box-tool' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a>";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-evaluasi-penyelenggaraan')){
			$btn .= "<a href='".base_url('pencatatan-eskt/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-box-tool delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add($id){
		permissions('menambahkan-data-evaluasi-penyelenggaraan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'kelas'=>$this->db
                    ->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
                    ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
                    ->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
                    ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_pembukaankelas_n_angkatan.idproforma",'left')
                    ->where("trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan",$id)
                    ->get("trm_pembukaankelas_n_angkatan")->row(),
			'pesertaqia'=>$this->db
			            ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_qia.id_peserta",'left')
                        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=kelas_qia.id_kelas",'left')
                        ->where("kelas_qia.id_kelas",$id)
                        ->get("kelas_qia"),
            'pesertanonqia'=>$this->db
			            ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_nonqia.id_peserta",'left')
                        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=kelas_nonqia.id_kelas",'left')
                        ->where("kelas_nonqia.id_kelas",$id)
                        ->get("kelas_nonqia"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pencatatan-eskt/'.url_title(strtolower($this->name)).'/add',$data);
	}
	
	public function hasil($id){
		permissions('menambahkan-data-evaluasi-penyelenggaraan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Hasil '.$this->breadcrumb3,
			'kelas'=>$this->db
                    ->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
                    ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
                    ->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
                    ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_pembukaankelas_n_angkatan.idproforma",'left')
                    ->where("trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan",$id)
                    ->get("trm_pembukaankelas_n_angkatan")->row(),
			'peserta'=>$this->db->get("mst_peserta"),
			'hasil'=>$this->db
                    ->where("FId_Kelas_n_Angkatan",$id)
                    ->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya"),
			'dtdefault'=>$this->thismodel->getrecordjoin($id)->result(),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pencatatan-eskt/'.url_title(strtolower($this->name)).'/hasil',$data);
	}

	public function store(){	
		permissions('menambahkan-data-evaluasi-penyelenggaraan');	
		
		$fidkelas = $this->security->xss_clean(html_escape($this->input->post("idkelas")));
		$fidpes = $this->security->xss_clean(html_escape($this->input->post("idpeserta")));
		$eval1 = $this->security->xss_clean(html_escape($this->input->post("Jwb_Eval1")));
		$eval2 = $this->security->xss_clean(html_escape($this->input->post("Jwb_Eval2")));
		$eval3 = $this->security->xss_clean(html_escape($this->input->post("Jwb_Eval3")));
		$saran = $this->security->xss_clean(html_escape($this->input->post("Saran")));

		$this->form_validation->set_rules('idkelas','Nama Kelas','trim|required|xss_clean');	
		$this->form_validation->set_rules('idpeserta','Nama Peserta','trim|xss_clean');
		$this->form_validation->set_rules('Jwb_Eval1','Jawaban Eval 1','trim|xss_clean');
		$this->form_validation->set_rules('Jwb_Eval2','Jawaban Eval 2','trim|xss_clean');
		$this->form_validation->set_rules('Jwb_Eval3','Jawaban Eval 3','trim|xss_clean');
		$this->form_validation->set_rules('Saran','Saran','trim|xss_clean');	
		
		if ($eval1=="" and $eval2=="" and $eval3=="" and $saran=="") {
			$this->session->set_flashdata('error','Belum ada data evaluasi');
			redirect(base_url('pencatatan-eskt/'.url_title(strtolower($this->name)).'/add/'.$fidkelas));
		}
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('pencatatan-eskt/'.url_title(strtolower($this->name)).'/add/'.$fidkelas));
		}else{
			$data = array(
				'FId_Kelas_n_Angkatan'=>$fidkelas,
				'FId_Peserta'=>$fidpes,
				'Jwb_Eval1'=>$eval1,
				'Jwb_Eval2'=>$eval2,
				'Jwb_Eval3'=>$eval3,
				'Saran'=>$saran
			);
			
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('pencatatan-eskt/'.url_title(strtolower($this->name)).'/add/'.$fidkelas));
		}
	}
}
