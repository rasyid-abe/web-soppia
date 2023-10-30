<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_t extends CI_Controller {
 	protected  $name = 'Laporan T'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Kelas Pelatihan'; 
 	protected  $breadcrumb3 = 'Laporan T'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index($proforma){
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
			->where("trm_sub_journal_soppia.FId_Kelas_n_Angkatan",$proforma)
			->where("trm_sub_journal_soppia.Desc_Transaksi !=","Special Journal Proforma Kontrak")
			->where("trm_sub_journal_soppia.Flag_D_or_K","D")
			->get("trm_sub_journal_soppia"),
			
			'kredit'=> $this->db
			->select("trm_sub_journal_soppia.*,mst_subaccount_soppia.Desc_Account,mst_subaccount_soppia.Kode_SubAccount,mst_proformakontrak.*,mst_pershinstansi.Desc_PershInstansi")
			->join("mst_subaccount_soppia","mst_subaccount_soppia.Kd_SubAccount=trm_sub_journal_soppia.Fkd_SubAccount",'left')
			->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_sub_journal_soppia.FId_Proforma",'left')
			->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_proformakontrak.FId_PershInstansi",'left')
			->where("trm_sub_journal_soppia.FId_Kelas_n_Angkatan",$proforma)
			->where("trm_sub_journal_soppia.Flag_D_or_K","K")
			->get("trm_sub_journal_soppia"),
		
			'kelas'=> $this->db
			->select("trm_pembukaankelas_n_angkatan.*,mst_jenispelatihan.Desc_JenisPelatihan,mst_pershinstansi.Desc_PershInstansi,ref_kotatraining.Desc_KotaTraining,mst_formatpiagamsertifikat.Desc_Piagam_Sertifikat")
			->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
			->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
			->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
			->join("mst_formatpiagamsertifikat","mst_formatpiagamsertifikat.Id_FormatPiagamSertifikat=trm_pembukaankelas_n_angkatan.FId_FormatSertifikat",'left')
			->where("trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan",$proforma)
			->get("trm_pembukaankelas_n_angkatan")
		);
		recordlog("Mengakses Halaman ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/index',$data);
	}
}
