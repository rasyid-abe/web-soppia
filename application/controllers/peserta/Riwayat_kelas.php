<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_kelas extends CI_Controller {
 	protected  $name = 'Riwayat kelas'; 
    protected  $model = 'pelatihan/peserta/Rkelasqia_model'; 
    protected  $model2 = 'pelatihan/peserta/Rkelasnonqia_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Peserta'; 
 	protected  $breadcrumb3 = 'Riwayat Kelas'; 

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
		permissions('melihat-data-riwayat-kelas-peserta');
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
		$this->templatecus->dashboard('pages/modul/pelatihan/peserta/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = ($field->FilePhoto!= null)? '<img src="'.base_url("uploads/photo/".$field->FilePhoto).'" width="50px" height="50px"></img>' : '<code>N/A</code>';
            $row[] = ($field->NIPP!= null)? $field->NIPP : '<code>N/A</code>';
            $row[] = ($field->NamaLengkap_DgnGelar!= null)? $field->NamaLengkap_DgnGelar : '<code>N/A</code>';
            $row[] = ($field->Kota_Lahir!= null)? $field->Kota_Lahir : '<code>N/A</code>';
            $row[] = ($field->eMail_Pribadi!= null)? $field->eMail_Pribadi : '<code>N/A</code>';
            $row[] = '<a class="btn btn-xs btn-primary" href="'.base_url("peserta/riwayat-kelas/detailqia/".$field->Id_Peserta).'"> <i class="fa fa-search-plus"></i> Lihat Riwayat </a>' ;

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
	
	public function getdata2(){
		$csrf_name = $this->security->get_csrf_token_name();
		$csrf_hash = $this->security->get_csrf_hash(); 
		
		$list = $this->thismodel2->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ($field->FilePhoto!= null)? '<img src="'.base_url("uploads/photo/".$field->FilePhoto).'" width="50px" height="50px"></img>' : '<code>N/A</code>';
            $row[] = ($field->NIPP!= null)? $field->NIPP : '<code>N/A</code>';
            $row[] = ($field->NamaLengkap_DgnGelar!= null)? $field->NamaLengkap_DgnGelar : '<code>N/A</code>';
            $row[] = ($field->Kota_Lahir!= null)? $field->Kota_Lahir : '<code>N/A</code>';
            $row[] = ($field->eMail_Pribadi!= null)? $field->eMail_Pribadi : '<code>N/A</code>';
            $row[] = '<a class="btn btn-xs btn-primary" href="'.base_url("peserta/riwayat-kelas/detailnonqia/".$field->Id_Peserta).'"> <i class="fa fa-search-plus"></i> Lihat Riwayat </a>' ;

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
	
	public function detailqia($detailqia){
		permissions('melihat-data-riwayat-kelas-peserta');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Detail '.$this->breadcrumb3,
			'peserta'=>$this->db
			        ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_qia.id_peserta",'left')
			        ->where("kelas_qia.id_peserta",$detailqia)
			        ->get("kelas_qia")->row(),
			'kelasqia'=>$this->db
			        ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_qia.id_peserta",'left')
                    ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=kelas_qia.id_kelas",'left')
                    ->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
                    ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
                    ->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
                    ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_pembukaankelas_n_angkatan.idproforma",'left')
                    ->join("mst_dokbukaklsreguler","mst_dokbukaklsreguler.Id_DokBukaKlsReguler=trm_pembukaankelas_n_angkatan.idskreguler",'left')
                    ->where("kelas_qia.id_peserta",$detailqia)
                    ->where("kelas_qia.kelulusan",1)
                    ->get("kelas_qia")->result(),
            'detailqia'=>$detailqia,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
		);
		recordlog("Mengakses Halaman Detail ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/peserta/'.url_title(strtolower($this->name)).'/detailqia',$data);
	}
	
	public function detailnonqia($detailnonqia){
		permissions('melihat-data-riwayat-kelas-peserta');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Detail '.$this->breadcrumb3,
			'peserta'=>$this->db
			        ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_nonqia.id_peserta",'left')
			        ->where("kelas_nonqia.id_peserta",$detailnonqia)
			        ->get("kelas_nonqia")->row(),
			'kelasnonqia'=>$this->db
			        ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_nonqia.id_peserta",'left')
                    ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=kelas_nonqia.id_kelas",'left')
                    ->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
                    ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
                    ->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
                    ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_pembukaankelas_n_angkatan.idproforma",'left')
                    ->join("mst_dokbukaklsreguler","mst_dokbukaklsreguler.Id_DokBukaKlsReguler=trm_pembukaankelas_n_angkatan.idskreguler",'left')
                    ->where("kelas_nonqia.id_peserta",$detailnonqia)
                    ->where("kelas_nonqia.kelulusan",1)
                    ->get("kelas_nonqia")->result(),
            'detailnonqia'=>$detailnonqia,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
		);
		recordlog("Mengakses Halaman Detail ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/peserta/'.url_title(strtolower($this->name)).'/detailnonqia',$data);
	}
}
