<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting_jurnal extends CI_Controller {
 	protected  $name = 'Accounting jurnal'; 
    protected  $model = 'pelatihan/iht/Raccountingjurnal_model'; 
    protected  $model2 = 'pelatihan/kelas-pelatihan/Rpembukaankelasreguler_model';

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'IHT'; 
 	protected  $breadcrumb3 = 'Accounting Jurnal'; 

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
		permissions('melihat-data-accounting-jurnal');
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
		$this->templatecus->dashboard('pages/modul/pelatihan/iht/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] =  '<a href="'.base_url("reguler/".url_title(strtolower($this->name))."/detail/".$field->Id_Kelas_n_Angkatan).'">'.$field->DescBebas_Kelas_n_Angkatan.'</a>';
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
	
	public function detail($id){
		permissions('melihat-data-pembukaan-kelas-pelatihan');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Manage '.$this->breadcrumb3,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
			
			'debet'=> $this->db
			->select("trm_sub_journal_soppia.*,mst_subaccount_soppia.Desc_Account,mst_subaccount_soppia.Kode_SubAccount,mst_proformakontrak.*,mst_pershinstansi.Desc_PershInstansi")
			->join("mst_subaccount_soppia","mst_subaccount_soppia.Kd_SubAccount=trm_sub_journal_soppia.Fkd_SubAccount",'left')
			->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_sub_journal_soppia.FId_Proforma",'left')
			->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_proformakontrak.FId_PershInstansi",'left')
			->where("trm_sub_journal_soppia.FId_Kelas_n_Angkatan",$id)
			->where("trm_sub_journal_soppia.Desc_Transaksi !=","Special Journal Proforma Kontrak")
			->where("trm_sub_journal_soppia.Flag_D_or_K","D")
			->get("trm_sub_journal_soppia"),
			
			'kredit'=> $this->db
			->select("trm_sub_journal_soppia.*,mst_subaccount_soppia.Desc_Account,mst_subaccount_soppia.Kode_SubAccount,mst_proformakontrak.*,mst_pershinstansi.Desc_PershInstansi")
			->join("mst_subaccount_soppia","mst_subaccount_soppia.Kd_SubAccount=trm_sub_journal_soppia.Fkd_SubAccount",'left')
			->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_sub_journal_soppia.FId_Proforma",'left')
			->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_proformakontrak.FId_PershInstansi",'left')
			->where("trm_sub_journal_soppia.FId_Kelas_n_Angkatan",$id)
			->where("trm_sub_journal_soppia.Flag_D_or_K","K")
			->get("trm_sub_journal_soppia"),
		
			'kelas'=> $this->db
			->select("trm_pembukaankelas_n_angkatan.*,mst_jenispelatihan.Desc_JenisPelatihan,mst_pershinstansi.Desc_PershInstansi,ref_kotatraining.Desc_KotaTraining,mst_formatpiagamsertifikat.Desc_Piagam_Sertifikat")
			->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
			->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
			->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
			->join("mst_formatpiagamsertifikat","mst_formatpiagamsertifikat.Id_FormatPiagamSertifikat=trm_pembukaankelas_n_angkatan.FId_FormatSertifikat",'left')
			->where("trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan",$id)
			->get("trm_pembukaankelas_n_angkatan")
		);
		recordlog("Mengakses Halaman ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/iht/'.url_title(strtolower($this->name)).'/detail',$data);
	}
	
	public function add($id){
		permissions('menambahkan-data-pembebanan-biaya-kelas');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'Fkd_SubAccount'=>$this->db->get("mst_subaccount_soppia"),
			'FId_Proforma'=>$this->db->get("mst_proformakontrak"),
			'FId_Kelas_n_Angkatan'=>$this->db->where("idskreguler !=","")->get("trm_pembukaankelas_n_angkatan"),
			'FId_PershInstansi'=>$this->db->get("mst_pershinstansi"),
			'kelas'=> $this->db
			->select("trm_pembukaankelas_n_angkatan.*,mst_jenispelatihan.Desc_JenisPelatihan,mst_pershinstansi.Desc_PershInstansi,ref_kotatraining.Desc_KotaTraining,mst_formatpiagamsertifikat.Desc_Piagam_Sertifikat")
			->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
			->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
			->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
			->join("mst_formatpiagamsertifikat","mst_formatpiagamsertifikat.Id_FormatPiagamSertifikat=trm_pembukaankelas_n_angkatan.FId_FormatSertifikat",'left')
			->where("trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan",$id)
			->get("trm_pembukaankelas_n_angkatan"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/iht/'.url_title(strtolower($this->name)).'/add',$data);
	}
	
	public function pendapatan($id){
		permissions('menambahkan-data-pembebanan-biaya-kelas');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'Fkd_SubAccount'=>$this->db->get("mst_subaccount_soppia"),
			'FId_Proforma'=>$this->db->get("mst_proformakontrak"),
			'FId_Kelas_n_Angkatan'=>$this->db->where("idskreguler !=","")->get("trm_pembukaankelas_n_angkatan"),
			'FId_PershInstansi'=>$this->db->get("mst_pershinstansi"),
			'kelas'=> $this->db
			->select("trm_pembukaankelas_n_angkatan.*,mst_jenispelatihan.Desc_JenisPelatihan,mst_pershinstansi.Desc_PershInstansi,ref_kotatraining.Desc_KotaTraining,mst_formatpiagamsertifikat.Desc_Piagam_Sertifikat")
			->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
			->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
			->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
			->join("mst_formatpiagamsertifikat","mst_formatpiagamsertifikat.Id_FormatPiagamSertifikat=trm_pembukaankelas_n_angkatan.FId_FormatSertifikat",'left')
			->where("trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan",$id)
			->get("trm_pembukaankelas_n_angkatan"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/iht/'.url_title(strtolower($this->name)).'/pendapatan',$data);
	}
	
	public function store(){	
		permissions('menambahkan-data-pembebanan-biaya-kelas');	

		$desc = $this->security->xss_clean(html_escape($this->input->post("Desc_Transaksi")));
		$nilaiadatitik = $this->security->xss_clean(html_escape($this->input->post("Nilai_Rp")));
		$fidkelas = $this->security->xss_clean(html_escape($this->input->post("FId_Kelas_n_Angkatan")));
		$ket = $this->security->xss_clean(html_escape($this->input->post("Keterangan")));
	    
	    $rp = str_replace(".", "", $nilaiadatitik);
		if($rp == ""){
			$rp = 0;
		}else{
			$rp = $rp;
		}
	    
		$this->form_validation->set_rules('Desc_Transaksi','Desc_Transaksi','trim|required|xss_clean');	
		$this->form_validation->set_rules('Nilai_Rp','Nilai_Rp','trim|required|xss_clean');	
		$this->form_validation->set_rules('FId_Kelas_n_Angkatan','FId_Kelas_n_Angkatan','trim|required|xss_clean');	
		$this->form_validation->set_rules('Keterangan','Keterangan','trim|xss_clean');	
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('reguler/'.url_title(strtolower($this->name)).'/add/'.$fidkelas));
		}else{
		    $count= $this->db->get("trm_sub_journal_soppia")->num_rows();
			$data = array(
			    'No_Voucher_Journal'=>($count+1),
			    'Tgl_Transaksi'=>date('Y-m-d'),
				'Desc_Transaksi'=>$desc,
				'Fkd_SubAccount'=>"-",
				'Flag_D_or_K'=>"D",
				'Nilai_Rps'=>$rp,
				'Flag_Proforma_or_Kelas'=>"K",
				'FId_Proforma'=>"",
				'FId_Kelas_n_Angkatan'=>$fidkelas,
				'FId_PershInstansi'=>"-",
				'Keterangan'=>$ket
			);
			
			recordlog("Menambahkan Data ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('reguler/'.url_title(strtolower($this->name)).'/add/'.$fidkelas));
		}
	}
	
	public function simpanbiaya(){	
		permissions('menambahkan-data-pembebanan-biaya-kelas');	

		$desc = $this->security->xss_clean(html_escape($this->input->post("Desc_Transaksi")));
		$nilaiadatitik = $this->security->xss_clean(html_escape($this->input->post("Nilai_Rp")));
		$fidkelas = $this->security->xss_clean(html_escape($this->input->post("FId_Kelas_n_Angkatan")));
		$ket = $this->security->xss_clean(html_escape($this->input->post("Keterangan")));
	    
	    $rp = str_replace(".", "", $nilaiadatitik);
		if($rp == ""){
			$rp = 0;
		}else{
			$rp = $rp;
		}
	    
		$this->form_validation->set_rules('Desc_Transaksi','Desc_Transaksi','trim|required|xss_clean');	
		$this->form_validation->set_rules('Nilai_Rp','Nilai_Rp','trim|required|xss_clean');	
		$this->form_validation->set_rules('FId_Kelas_n_Angkatan','FId_Kelas_n_Angkatan','trim|required|xss_clean');	
		$this->form_validation->set_rules('Keterangan','Keterangan','trim|xss_clean');	
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('reguler/'.url_title(strtolower($this->name)).'/pendapatan/'.$fidkelas));
		}else{
		    $djurnal = $this->db->query("select * from trm_sub_journal_soppia where FId_Kelas_n_Angkatan='$fidkelas'")->row_array();
		    $novoucher = $djurnal['No_Voucher_Journal'];
			$data = array(
			    'No_Voucher_Journal'=>$novoucher,
			    'Tgl_Transaksi'=>date('Y-m-d'),
				'Desc_Transaksi'=>$desc,
				'Fkd_SubAccount'=>"-",
				'Flag_D_or_K'=>"K",
				'Nilai_Rps'=>$rp,
				'Flag_Proforma_or_Kelas'=>"K",
				'FId_Proforma'=>"",
				'FId_Kelas_n_Angkatan'=>$fidkelas,
				'FId_PershInstansi'=>"-",
				'Keterangan'=>$ket
			);
			
			recordlog("Menambahkan Data ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('reguler/'.url_title(strtolower($this->name)).'/pendapatan/'.$fidkelas));
		}
	}

	public function actiontable($id){
		if(accessperm('melihat-data-accounting-jurnal')){
			$btn = "<a href='".base_url('iht/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-box-tool view-data' data-toggle='tooltip' title='Lihat Detail Data'> <i class='fa fa-search-plus'></i> Lihat Detail </a>";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
        return $btn;
	}

	public function view($id){
		permissions('melihat-data-accounting-jurnal');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/iht/".url_title(strtolower($this->name))."/view",$data);
	}
	
}
