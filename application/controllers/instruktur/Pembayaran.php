<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {
 	protected  $name = 'Pembayaran'; 
    protected  $model = 'pelatihan/instruktur/Rpembayaran_model'; 
    protected  $model2 = 'pelatihan/kelas-pelatihan/Rbebanbiaya_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Instruktur'; 
 	protected  $breadcrumb3 = 'Pembayaran'; 

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
		permissions('melihat-data-pembayaran');
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
		if(accessperm('melihat-data-pembayaran')){
			$btn = "<a href='".base_url('instruktur/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> Detail </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
        if(accessperm('menambahkan-data-pembayaran')){
			$btn .= "<a href='".base_url('instruktur/'.url_title(strtolower($this->name))."/biaya/".$id)."' class='btn btn-xs btn-danger' data-toggle='tooltip' title='Bayar Instruktur'> <i class='fa fa-money'></i> Bayar </a>";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
        return $btn;
	}
	
	public function biaya($id){
		permissions('merubah-data-pembayaran');
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
		recordlog("Mengakses Halaman Biaya Instruktur ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/instruktur/'.url_title(strtolower($this->name)).'/bayar',$data);
	}
	
	public function simpanbiaya($id){	
		permissions('merubah-data-pembayaran');
		
		$fidkelas = $this->security->xss_clean(html_escape($this->input->post("fidkelas")));
		$fidmateri = $this->security->xss_clean(html_escape($this->input->post("fidmateri")));
		$fidinst = $this->security->xss_clean(html_escape($this->input->post("fidinst")));
		$tglngajar = $this->security->xss_clean(html_escape($this->input->post("tglngajar")));
		$jml = $this->security->xss_clean(html_escape($this->input->post("Jumlah_Bayar")));
		$ktg = $this->security->xss_clean(html_escape($this->input->post("keterangan")));
		
		$biaya = str_replace(str_split(",."),"", $jml);
		
		$this->form_validation->set_rules('fidkelas','Nama Kelas','trim|xss_clean');	
		$this->form_validation->set_rules('Jumlah_Bayar','Jumlah Bayar','trim|xss_clean');	
		
		$djurnal = $this->db->query("select * from trm_sub_journal_soppia where FId_Kelas_n_Angkatan='$fidkelas'")->row_array();
		$novoucher = $djurnal['No_Voucher_Journal'];
		$proform = $djurnal['FId_Proforma'];
		$fidpersh = $djurnal['FId_PershInstansi'];
		
		if ($tglngajar == null){
		    $this->session->set_flashdata( 'error','Tanggal Mengajar Masing Kososng' );
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/biaya/'.$id));
		}
		
		if ($fidinst == null){
		    $this->session->set_flashdata( 'error','Instruktur Masing Kososng' );
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/biaya/'.$id));
		}
		
		if ($fidmateri == null){
		    $this->session->set_flashdata( 'error','Materi Masing Kososng' );
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/biaya/'.$id));
		}
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/biaya/'.$id));
		}else{
		    
		    $checkck = $this->db->where("Id_InstrukturNgajar_diKelas",$id)->get("trm_instrukturngajar_dikelas");
		    if($checkck->num_rows()>0){
		        $dtt = $checkck->row();
		        $catchget = $this->db->where(array(
		            'FId_Instruktur'=>$dtt->FId_Instruktur,
		            'FId_Kelas_n_Angkatan'=>$dtt->FId_Kelas_n_Angkatan,
		            'FKd_Materi'=>$dtt->FKd_Materi,
		            'Tgl_Mengajar'=>$dtt->Tgl_Mengajar,
		            ))->get("trm_instrukturngajar_dikelas");
		        if($catchget->num_rows()>0){
		            foreach($catchget->result() as $ctget){
            			$data = array(			
            				'Flag_SudahDibayar'=>"Y",				
            				'Tgl_Dibayar'=>date('Y-m-d'),
            				'Keterangan'=>$ktg
            			);
			            $this->thismodel->updatedt($data,$ctget->Id_InstrukturNgajar_diKelas);
		            }
		        }
		    }
			$data = array(
				'Jumlah_Bayar'=>$biaya,				
				'Flag_SudahDibayar'=>"Y",				
				'Tgl_Dibayar'=>date('Y-m-d'),
				'Keterangan'=>$ktg
			);
			
			$databiaya = array(
			    'No_Voucher_Journal'=>$novoucher,
			    'Tgl_Transaksi'=>date('Y-m-d'),
				'Desc_Transaksi'=>"Biaya Instruktur",
				'Fkd_SubAccount'=>"-",
				'Flag_D_or_K'=>"D",
				'Nilai_Rps'=>$biaya,
				'Flag_Proforma_or_Kelas'=>"K",
				'FId_Proforma'=>$proform,
				'FId_Kelas_n_Angkatan'=>$fidkelas,
				'FId_PershInstansi'=>$fidpersh,
				'Keterangan'=>"Biaya Cash"
			);
			recordlog("Merubah Data Instruktur ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->thismodel2->insertdt($databiaya);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/biaya/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-pembayaran');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Mengakses Halaman Detail Instruktur ".$this->name);
		$this->load->view("pages/modul/pelatihan/instruktur/".url_title(strtolower($this->name))."/view",$data);
	}
}
