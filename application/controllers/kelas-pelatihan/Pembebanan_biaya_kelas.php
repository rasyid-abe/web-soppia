<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembebanan_biaya_kelas extends CI_Controller {
 	protected  $name = 'Pembebanan biaya kelas'; 
    protected  $model = 'pelatihan/kelas-pelatihan/Rpembukaankelasiht_model'; 
    protected  $model2 = 'pelatihan/kelas-pelatihan/Rbebanbiaya_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Kelas Pelatihan'; 
 	protected  $breadcrumb3 = 'Pembebanan Biaya Kelas'; 

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
		permissions('melihat-data-pembebanan-biaya-kelas');
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
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = '<a href="'.base_url("kelas-pelatihan/pembebanan-biaya-kelas/detail/".$field->Id_Kelas_n_Angkatan).'">'.$field->DescBebas_Kelas_n_Angkatan.'</a>';
            $row[] = $field->nomor_kelas;
            $row[] = $field->No_Urut_Angkatan;
            $row[] = $field->Desc_JenisPelatihan ;
            $row[] = tgl_indo($field->Tgl_Mulai_Aktual)." s/d ".tgl_indo($field->Tgl_Selesai_Aktual);
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
		/*if(accessperm('melihat-data-pembebanan-biaya-kelas')){
			$btn = "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-box-tool view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a>";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }*/
		/*if(accessperm('merubah-data-pembebanan-biaya-kelas')){
			$btn .= "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-box-tool' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a>";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }*/
        return $btn;
	}
	
	public function detail($proforma){
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
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/pembebanan-biaya-kelas/detail',$data);
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
			'FId_Kelas_n_Angkatan'=>$this->db->where("idproforma !=","")->get("trm_pembukaankelas_n_angkatan"),
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
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/add',$data);
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
			'FId_Kelas_n_Angkatan'=>$this->db->where("idproforma !=","")->get("trm_pembukaankelas_n_angkatan"),
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
		recordlog("Mengakses Halaman Pendapatan ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/pendapatan',$data);
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
		
		$djurnal = $this->db->query("select * from trm_sub_journal_soppia where FId_Kelas_n_Angkatan='$fidkelas'")->row_array();
		$novoucher = $djurnal['No_Voucher_Journal'];
		$proform = $djurnal['FId_Proforma'];
		$fidpersh = $djurnal['FId_PershInstansi'];
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/add/'.$fidkelas));
		}else{
			$data = array(
			    'No_Voucher_Journal'=>$novoucher,
			    'Tgl_Transaksi'=>date('Y-m-d'),
				'Desc_Transaksi'=>$desc,
				'Fkd_SubAccount'=>"-",
				'Flag_D_or_K'=>"D",
				'Nilai_Rps'=>$rp,
				'Flag_Proforma_or_Kelas'=>"K",
				'FId_Proforma'=>$proform,
				'FId_Kelas_n_Angkatan'=>$fidkelas,
				'FId_PershInstansi'=>$fidpersh,
				'Keterangan'=>$ket
			);
			
			recordlog("Menambahkan Data ".$this->name);
			$this->thismodel2->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/add/'.$fidkelas));
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
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/pendapatan/'.$fidkelas));
		}else{
		    $djurnal = $this->db->query("select * from trm_sub_journal_soppia where FId_Kelas_n_Angkatan='$fidkelas'")->row_array();
    		$novoucher = $djurnal['No_Voucher_Journal'];
    		$proform = $djurnal['FId_Proforma'];
    		$fidpersh = $djurnal['FId_PershInstansi'];
    		
			$data = array(
			    'No_Voucher_Journal'=>$novoucher,
			    'Tgl_Transaksi'=>date('Y-m-d'),
				'Desc_Transaksi'=>$desc,
				'Fkd_SubAccount'=>"-",
				'Flag_D_or_K'=>"K",
				'Nilai_Rps'=>$rp,
				'Flag_Proforma_or_Kelas'=>"K",
				'FId_Proforma'=>$proform,
				'FId_Kelas_n_Angkatan'=>$fidkelas,
				'FId_PershInstansi'=>$fidpersh,
				'Keterangan'=>$ket
			);
			
			recordlog("Menambahkan Data ".$this->name);
			$this->thismodel2->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/pendapatan/'.$fidkelas));
		}
	}

	public function edit($id){
		permissions('merubah-data-pembebanan-biaya-kelas');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'Fkd_SubAccount'=>$this->db->get("mst_subaccount_soppia"),
			'FId_Proforma'=>$this->db->get("mst_proformakontrak"),
			'FId_Kelas_n_Angkatan'=>$this->db->get("trm_pembukaankelas_n_angkatan"),
			'FId_PershInstansi'=>$this->db->get("mst_pershinstansi"),
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-pembebanan-biaya-kelas');

		$desc = $this->security->xss_clean(html_escape($this->input->post("Desc_Transaksi")));
		$rp = $this->security->xss_clean(html_escape($this->input->post("Nilai_Rp")));
		$fidkelas = $this->security->xss_clean(html_escape($this->input->post("FId_Kelas_n_Angkatan")));
		$ket = $this->security->xss_clean(html_escape($this->input->post("Keterangan")));
	
		$this->form_validation->set_rules('Desc_Transaksi','Desc_Transaksi','trim|xss_clean');	
		$this->form_validation->set_rules('Nilai_Rp','Nilai_Rp','trim|xss_clean');	
		$this->form_validation->set_rules('FId_Kelas_n_Angkatan','FId_Kelas_n_Angkatan','trim|xss_clean');	
		$this->form_validation->set_rules('Keterangan','Keterangan','trim|xss_clean');	

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'Desc_Transaksi'=>$desc,
				'Nilai_Rp'=>$rp,
				'FId_Kelas_n_Angkatan'=>$fidkelas,
				'Keterangan'=>$ket
			);
			recordlog("Merubah Data ".$this->name);
			//$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-pembebanan-biaya-kelas');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat Detail Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/kelas-pelatihan/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-pembebanan-biaya-kelas');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-pembebanan-biaya-kelas');
		recordlog("Menghapus Data ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'kelas-pelatihan/'.url_title(strtolower($this->name)) ) );
	}

	
}
