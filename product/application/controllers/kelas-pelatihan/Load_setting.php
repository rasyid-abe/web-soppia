<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Load_setting extends CI_Controller {
	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	public function loadformhari($hari){
	    $data = array(
	        'paket'=>$this->db->get("ref_paket_sesi_harian"),
	        'hari'=>$hari,
	        );
	    $this->load->view("pages/modul/pelatihan/kelas-pelatihan/jadwal-kelas/settings/formhari",$data);
	}
	public function formsesi($pkt,$tgl,$hari,$idkelas){
	    $find = $this->db->select("any_value(No_Urut_Hari) as No_Urut_Hari")->where(array('FId_Kelas_n_Angkatan'=>$idkelas))->group_by('No_Urut_Hari')->get("tre_pembukaankelas_n_angkatan_sesi");
	    if($find->num_rows()>0){
	        $cek = $this->db->where(array('Id_Kelas_n_Angkatan'=>$idkelas))->get("trm_pembukaankelas_n_angkatan");
	        if($cek->num_rows() > 0){
	            if($cek->row()->LamaHariPelatihan == $find->num_rows()){
	                
	            }
	        }
	    }else{
	        $harike = 1;
	    }
	    if($pkt != 'custom' || $pkt != '' ){
	        $cekpaket = 1;
	    }else{
	        $cekpaket = 0;
	    }
	    $paket = $this->db->where(array('FKd_Paket_Sesi_Harian'=>$pkt))->get("ref_detil_paket_sesi_harian");
	    $data = array(
			'FId_Kelas_n_Angkatan'=>$this->db->get("trm_pembukaankelas_n_angkatan"),
			'paket'=>$paket,
			'harike'=>$harike,
			'cekpaket'=>$cekpaket,
			'idkelas'=>$idkelas,
			'FKd_Sesi_Satuan'=>$this->db->get("ref_sesi_satuan"),
			'FKd_Materi_n_Aktifitas'=>$this->db->get("mst_materi_n_aktifitas"),
			'FId_Instruktur'=>$this->db->get("mst_instruktur"),
	        );
	    $this->load->view("pages/modul/pelatihan/kelas-pelatihan/jadwal-kelas/settings/formsesi",$data);
	}
}