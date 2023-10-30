<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Set_rencana_ujian extends CI_Controller {
 	protected  $name = 'Set rencana ujian'; 
    protected  $model = 'pelatihan/cbt/Rrencanaujian_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'CBT'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-set-rencana-ujian-cbt');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Setting Rencana Ujian',
			'titlepage'=>'Setting Rencana Ujian',
			'subtitlepage'=>'Data Setting Rencana Ujian',
			'titlebox'=>'Manage Setting Rencana Ujian',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/cbt/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->DescBebas_Kelas_n_Angkatan;
            $row[] = $field->nomor_kelas;
            $row[] = $field->Desc_JenisPelatihan;
            $row[] = ($field->Desc_PershInstansi!= null)? $field->Desc_PershInstansi : '<code>N/A</code>';
            $row[] = $this->actiontable($field->Kd_SettingRencanaUjian);

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
		if(accessperm('melihat-data-set-rencana-ujian-cbt')){
			$btn = "<a href='".base_url('cbt/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-set-rencana-ujian-cbt')){
			$btn .= "<a href='".base_url('cbt/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-set-rencana-ujian-cbt')){
			$btn .= "<a href='".base_url('cbt/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-set-rencana-ujian-cbt');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Setting Rencana Ujian',
			'titlepage'=>'Setting Rencana Ujian',
			'subtitlepage'=>'Data Setting Rencana Ujian',
			'titlebox'=>'Add Setting Rencana Ujian',
			'materi'=>$this->db->get("mst_materi_n_aktifitas"),
			'kelas'=> $this->db
			->select("trm_pembukaankelas_n_angkatan.*,mst_jenispelatihan.Desc_JenisPelatihan,mst_pershinstansi.Desc_PershInstansi,ref_kotatraining.Desc_KotaTraining,mst_formatpiagamsertifikat.Desc_Piagam_Sertifikat")
			->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
			->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
			->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
			->join("mst_formatpiagamsertifikat","mst_formatpiagamsertifikat.Id_FormatPiagamSertifikat=trm_pembukaankelas_n_angkatan.FId_FormatSertifikat",'left')
			->get("trm_pembukaankelas_n_angkatan"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/cbt/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-set-rencana-ujian-cbt');	
		
		$tglujian = $this->security->xss_clean(html_escape($this->input->post("Tgl_Ujian")));
		$kelas = $this->security->xss_clean(html_escape($this->input->post("FId_Kelas_n_Angkatan")));
		$materi = $this->security->xss_clean(html_escape($this->input->post("FKd_Materi_n_Aktifitas")));
		$username = $this->security->xss_clean(html_escape($this->input->post("UserNama_Pembuka")));
		$password = $this->security->xss_clean(html_escape($this->input->post("Password_Pembuka")));
		$nbenar = $this->security->xss_clean(html_escape($this->input->post("Skor_Benar")));
		$nsalah = $this->security->xss_clean(html_escape($this->input->post("Skor_Salah")));
		$ndefault = $this->security->xss_clean(html_escape($this->input->post("Skor_Default")));
		$pengumumanhasil = $this->security->xss_clean(html_escape($this->input->post("Flag_HasilTayangLangsung")));
		$bisamundur = $this->security->xss_clean(html_escape($this->input->post("Flag_BisaMundur")));
		$takterbatas = $this->security->xss_clean(html_escape($this->input->post("Flag_JmlSoalTakTerbatas")));
		$durasi = $this->security->xss_clean(html_escape($this->input->post("Lama_WaktuUjian")));
		$jmlsoal = $this->security->xss_clean(html_escape($this->input->post("Jml_SoalUjian")));
		$antarbab = $this->security->xss_clean(html_escape($this->input->post("Flag_BedaPersentaseAntarBab")));
		$catatan = $this->security->xss_clean(html_escape($this->input->post("CatatanPelaksanaanUjian")));
		$telah = $this->security->xss_clean(html_escape($this->input->post("Flag_TelahDiumumkan")));
		$tglumum = $this->security->xss_clean(html_escape($this->input->post("Tgl_pengumuman")));
		
		$this->form_validation->set_rules('Tgl_Ujian', 'Tgl_Ujian', 'trim|xss_clean');
		$this->form_validation->set_rules('FId_Kelas_n_Angkatan', 'FId_Kelas_n_Angkatan', 'trim|xss_clean');
		$this->form_validation->set_rules('FKd_Materi_n_Aktifitas', 'FKd_Materi_n_Aktifitas', 'trim|xss_clean');
		$this->form_validation->set_rules('UserNama_Pembuka', 'UserNama_Pembuka', 'trim|xss_clean');
		$this->form_validation->set_rules('Password_Pembuka', 'Password_Pembuka', 'trim|xss_clean');
		$this->form_validation->set_rules('Skor_Benar', 'Skor_Benar', 'trim|xss_clean');
		$this->form_validation->set_rules('Skor_Salah', 'Skor_Salah', 'trim|xss_clean');
		$this->form_validation->set_rules('Skor_Default', 'Skor_Default', 'trim|xss_clean');
		$this->form_validation->set_rules('Flag_HasilTayangLangsung', 'Flag_HasilTayangLangsung', 'trim|xss_clean');
		$this->form_validation->set_rules('Flag_BisaMundur', 'Flag_BisaMundur', 'trim|xss_clean');
		$this->form_validation->set_rules('Flag_JmlSoalTakTerbatas', 'Flag_JmlSoalTakTerbatas', 'trim|xss_clean');
		$this->form_validation->set_rules('Lama_WaktuUjian', 'Lama_WaktuUjian', 'trim|xss_clean');
		$this->form_validation->set_rules('Jml_SoalUjian', 'Jml_SoalUjian', 'trim|xss_clean');
		$this->form_validation->set_rules('Flag_BedaPersentaseAntarBab', 'Flag_BedaPersentaseAntarBab', 'trim|xss_clean');
		$this->form_validation->set_rules('CatatanPelaksanaanUjian', 'CatatanPelaksanaanUjian', 'trim|xss_clean');
		$this->form_validation->set_rules('Flag_TelahDiumumkan', 'Flag_TelahDiumumkan', 'trim|xss_clean');
		$this->form_validation->set_rules('Tgl_pengumuman', 'Tgl_pengumuman', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'Tgl_Ujian'=>$tglujian,
				'FId_Kelas_n_Angkatan'=>$kelas,
				'FKd_Materi_n_Aktifitas'=>$materi,
				'UserNama_Pembuka'=>$username,
				'Password_Pembuka'=>$password,
				'Skor_Benar'=>$nbenar,
				'Skor_Salah'=>$nsalah,
				'Skor_Default'=>$ndefault,
				'Flag_HasilTayangLangsung'=>$pengumumanhasil,
				'Flag_BisaMundur'=>$bisamundur,
				'Flag_JmlSoalTakTerbatas'=>$takterbatas,
				'Lama_WaktuUjian'=>$durasi,
				'Jml_SoalUjian'=>$jmlsoal,
				'Flag_BedaPersentaseAntarBab'=>$antarbab,
				'CatatanPelaksanaanUjian'=>$catatan,
				'Flag_TelahDiumumkan'=>$telah,
				'Tgl_pengumuman'=>(($tglumum !='')? $tglumum : null)
			);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data Berhasil Disimpan');
			redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-set-rencana-ujian-cbt');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Setting Rencana Ujian',
			'titlepage'=>'Setting Rencana Ujian',
			'subtitlepage'=>'Data Setting Rencana Ujian',
			'titlebox'=>'Edit Setting Rencana Ujian',
			'materi'=>$this->db->get("mst_materi_n_aktifitas"),
			'kelas'=> $this->db
			->select("trm_pembukaankelas_n_angkatan.*,mst_jenispelatihan.Desc_JenisPelatihan,mst_pershinstansi.Desc_PershInstansi,ref_kotatraining.Desc_KotaTraining,mst_formatpiagamsertifikat.Desc_Piagam_Sertifikat")
			->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
			->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
			->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
			->join("mst_formatpiagamsertifikat","mst_formatpiagamsertifikat.Id_FormatPiagamSertifikat=trm_pembukaankelas_n_angkatan.FId_FormatSertifikat",'left')
			->get("trm_pembukaankelas_n_angkatan"),
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/cbt/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-set-rencana-ujian-cbt');

		$tglujian = $this->security->xss_clean(html_escape($this->input->post("Tgl_Ujian")));
		$kelas = $this->security->xss_clean(html_escape($this->input->post("FId_Kelas_n_Angkatan")));
		$materi = $this->security->xss_clean(html_escape($this->input->post("FKd_Materi_n_Aktifitas")));
		$username = $this->security->xss_clean(html_escape($this->input->post("UserNama_Pembuka")));
		$password = $this->security->xss_clean(html_escape($this->input->post("Password_Pembuka")));
		$nbenar = $this->security->xss_clean(html_escape($this->input->post("Skor_Benar")));
		$nsalah = $this->security->xss_clean(html_escape($this->input->post("Skor_Salah")));
		$ndefault = $this->security->xss_clean(html_escape($this->input->post("Skor_Default")));
		$pengumumanhasil = $this->security->xss_clean(html_escape($this->input->post("Flag_HasilTayangLangsung")));
		$bisamundur = $this->security->xss_clean(html_escape($this->input->post("Flag_BisaMundur")));
		$takterbatas = $this->security->xss_clean(html_escape($this->input->post("Flag_JmlSoalTakTerbatas")));
		$durasi = $this->security->xss_clean(html_escape($this->input->post("Lama_WaktuUjian")));
		$jmlsoal = $this->security->xss_clean(html_escape($this->input->post("Jml_SoalUjian")));
		$antarbab = $this->security->xss_clean(html_escape($this->input->post("Flag_BedaPersentaseAntarBab")));
		$catatan = $this->security->xss_clean(html_escape($this->input->post("CatatanPelaksanaanUjian")));
		$telah = $this->security->xss_clean(html_escape($this->input->post("Flag_TelahDiumumkan")));
		$tglumum = $this->security->xss_clean(html_escape($this->input->post("Tgl_pengumuman")));
		
		$this->form_validation->set_rules('Tgl_Ujian', 'Tgl_Ujian', 'trim|xss_clean');
		$this->form_validation->set_rules('FId_Kelas_n_Angkatan', 'FId_Kelas_n_Angkatan', 'trim|xss_clean');
		$this->form_validation->set_rules('FKd_Materi_n_Aktifitas', 'FKd_Materi_n_Aktifitas', 'trim|xss_clean');
		$this->form_validation->set_rules('UserNama_Pembuka', 'UserNama_Pembuka', 'trim|xss_clean');
		$this->form_validation->set_rules('Password_Pembuka', 'Password_Pembuka', 'trim|xss_clean');
		$this->form_validation->set_rules('Skor_Benar', 'Skor_Benar', 'trim|xss_clean');
		$this->form_validation->set_rules('Skor_Salah', 'Skor_Salah', 'trim|xss_clean');
		$this->form_validation->set_rules('Skor_Default', 'Skor_Default', 'trim|xss_clean');
		$this->form_validation->set_rules('Flag_HasilTayangLangsung', 'Flag_HasilTayangLangsung', 'trim|xss_clean');
		$this->form_validation->set_rules('Flag_BisaMundur', 'Flag_BisaMundur', 'trim|xss_clean');
		$this->form_validation->set_rules('Flag_JmlSoalTakTerbatas', 'Flag_JmlSoalTakTerbatas', 'trim|xss_clean');
		$this->form_validation->set_rules('Lama_WaktuUjian', 'Lama_WaktuUjian', 'trim|xss_clean');
		$this->form_validation->set_rules('Jml_SoalUjian', 'Jml_SoalUjian', 'trim|xss_clean');
		$this->form_validation->set_rules('Flag_BedaPersentaseAntarBab', 'Flag_BedaPersentaseAntarBab', 'trim|xss_clean');
		$this->form_validation->set_rules('CatatanPelaksanaanUjian', 'CatatanPelaksanaanUjian', 'trim|xss_clean');
		$this->form_validation->set_rules('Flag_TelahDiumumkan', 'Flag_TelahDiumumkan', 'trim|xss_clean');
		$this->form_validation->set_rules('Tgl_pengumuman', 'Tgl_pengumuman', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'Tgl_Ujian'=>$tglujian,
				'FId_Kelas_n_Angkatan'=>$kelas,
				'FKd_Materi_n_Aktifitas'=>$materi,
				'UserNama_Pembuka'=>$username,
				'Skor_Benar'=>$nbenar,
				'Skor_Salah'=>$nsalah,
				'Skor_Default'=>$ndefault,
				'Flag_HasilTayangLangsung'=>$pengumumanhasil,
				'Flag_BisaMundur'=>$bisamundur,
				'Flag_JmlSoalTakTerbatas'=>$takterbatas,
				'Lama_WaktuUjian'=>$durasi,
				'Jml_SoalUjian'=>$jmlsoal,
				'Flag_BedaPersentaseAntarBab'=>$antarbab,
				'CatatanPelaksanaanUjian'=>$catatan,
				'Flag_TelahDiumumkan'=>$telah,
				'Tgl_pengumuman'=>(($tglumum !='')? $tglumum : null)
			);
			if( $this->input->post('Password_Pembuka') != null || $this->input->post('Password_Pembuka') != '' ){
				$data['Password_Pembuka'] = $password;
			}
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-set-rencana-ujian-cbt');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		$this->load->view("pages/modul/pelatihan/cbt/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-set-rencana-ujian-cbt');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('cbt/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-set-rencana-ujian-cbt');
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'cbt/'.url_title(strtolower($this->name)) ) );
	}

	
}
