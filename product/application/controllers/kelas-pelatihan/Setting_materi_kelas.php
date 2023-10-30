<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_materi_kelas extends CI_Controller {
 	protected  $name = 'Setting materi kelas'; 
    protected  $model = 'pelatihan/kelas-pelatihan/Rpembukaankelas_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Kelas Pelatihan'; 
 	protected  $breadcrumb3 = 'Setting Materi Kelas'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-setting-materi-kelas');
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
            $row[] = '<a href="'.base_url("kelas-pelatihan/setting-materi-kelas/add/".$field->Id_Kelas_n_Angkatan).'">'.$field->DescBebas_Kelas_n_Angkatan.'</a>' ;
            $row[] = $field->Desc_PershInstansi;
            $kelas = "";
            if($field->idproforma != null){
                $kelas = "Kelas IHT";
            }
            if($field->idskreguler != null){
                $kelas = "Kelas Reguler";
            }
            $row[] = $kelas;
            
            $dok = "";
            if($field->idproforma != null){
                $dok = "Proforma Kontrak Nomor ".$field->No_ProformaKontrak;
            }
            if($field->idskreguler != null){
                $dok = "SK Pembukaan Kelas Reguler Nomor ".$field->No_Klsreguler;
            }
            $row[] = $dok;
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
		if(accessperm('melihat-data-setting-materi-kelas')){
			$btn = "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-box-tool view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a>";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-setting-materi-kelas')){
			$btn .= "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-box-tool' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a>";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-setting-materi-kelas')){
			$btn .= "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-box-tool delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add($id){
		permissions('menambahkan-data-setting-materi-kelas');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'FId_Kelas_n_Angkatan'=>$this->db->get("trm_pembukaankelas_n_angkatan"),
			'FKd_Sesi_Satuan'=>$this->db->get("ref_sesi_satuan"),
			'FKd_Materi_n_Aktifitas'=>$this->db->get("mst_materi_n_aktifitas"),
			'FId_Instruktur'=>$this->db->get("mst_instruktur"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-setting-materi-kelas');	

		$desc = $this->security->xss_clean(html_escape($this->input->post("DescBebas_Kelas_n_Angkatan")));
		$uhari = $this->security->xss_clean(html_escape($this->input->post("No_Urut_Hari")));
		$tgl = $this->security->xss_clean(html_escape($this->input->post("Tgl")));
		$hari = $this->security->xss_clean(html_escape($this->input->post("Hari")));
		$usesi = $this->security->xss_clean(html_escape($this->input->post("No_Urut_Sesi")));
		$sesi = $this->security->xss_clean(html_escape($this->input->post("FKd_Sesi_Satuan")));
		$materi = $this->security->xss_clean(html_escape($this->input->post("FKd_Materi_n_Aktifitas")));
		$ins = $this->security->xss_clean(html_escape($this->input->post("FId_Instruktur")));

		$this->form_validation->set_rules('DescBebas_Kelas_n_Angkatan','Nama Kelas','trim|required|xss_clean');	
		$this->form_validation->set_rules('No_Urut_Hari','Nomor Urut Hari','trim|xss_clean');	
		$this->form_validation->set_rules('Tgl','Tanggal','trim|xss_clean');	
		$this->form_validation->set_rules('Hari','Hari','trim|xss_clean');	
		$this->form_validation->set_rules('No_Urut_Sesi','Nomor Urut Sesi','trim|xss_clean');	
		$this->form_validation->set_rules('FKd_Sesi_Satuan','Deskripsi Sesi','trim|xss_clean');	
		$this->form_validation->set_rules('FKd_Materi_n_Aktifitas','Materi dan Aktifitas','trim|xss_clean');	
		$this->form_validation->set_rules('FId_Instruktur','Nama Instruktur','trim|xss_clean');	
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'DescBebas_Kelas_n_Angkatan'=>$desc,
				'No_Urut_Hari'=>$uhari,
				'Tgl'=>$tgl,
				'Hari'=>$hari,
				'No_Urut_Sesi'=>$usesi,
				'FKd_Sesi_Satuan'=>$sesi,
				'FKd_Materi_n_Aktifitas'=>$materi,
				'FId_Instruktur'=>$ins
			);
			
			recordlog("Menambahkan Data ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-setting-materi-kelas');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'FId_Kelas_n_Angkatan'=>$this->db->get("trm_pembukaankelas_n_angkatan"),
			'FKd_Sesi_Satuan'=>$this->db->get("ref_sesi_satuan"),
			'FKd_Materi_n_Aktifitas'=>$this->db->get("mst_materi_n_aktifitas"),
			'FId_Instruktur'=>$this->db->get("mst_instruktur"),
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-setting-materi-kelas');

		$desc = $this->security->xss_clean(html_escape($this->input->post("DescBebas_Kelas_n_Angkatan")));
		$uhari = $this->security->xss_clean(html_escape($this->input->post("No_Urut_Hari")));
		$tgl = $this->security->xss_clean(html_escape($this->input->post("Tgl")));
		$hari = $this->security->xss_clean(html_escape($this->input->post("Hari")));
		$usesi = $this->security->xss_clean(html_escape($this->input->post("No_Urut_Sesi")));
		$sesi = $this->security->xss_clean(html_escape($this->input->post("FKd_Sesi_Satuan")));
		$materi = $this->security->xss_clean(html_escape($this->input->post("FKd_Materi_n_Aktifitas")));
		$ins = $this->security->xss_clean(html_escape($this->input->post("FId_Instruktur")));

		$this->form_validation->set_rules('DescBebas_Kelas_n_Angkatan','Nama Kelas','trim|required|xss_clean');	
		$this->form_validation->set_rules('No_Urut_Hari','Nomor Urut Hari','trim|xss_clean');	
		$this->form_validation->set_rules('Tgl','Tanggal','trim|xss_clean');	
		$this->form_validation->set_rules('Hari','Hari','trim|xss_clean');	
		$this->form_validation->set_rules('No_Urut_Sesi','Nomor Urut Sesi','trim|xss_clean');	
		$this->form_validation->set_rules('FKd_Sesi_Satuan','Deskripsi Sesi','trim|xss_clean');	
		$this->form_validation->set_rules('FKd_Materi_n_Aktifitas','Materi dan Aktifitas','trim|xss_clean');	
		$this->form_validation->set_rules('FId_Instruktur','Nama Instruktur','trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'DescBebas_Kelas_n_Angkatan'=>$desc,
				'No_Urut_Hari'=>$uhari,
				'Tgl'=>$tgl,
				'Hari'=>$hari,
				'No_Urut_Sesi'=>$usesi,
				'FKd_Sesi_Satuan'=>$sesi,
				'FKd_Materi_n_Aktifitas'=>$materi,
				'FId_Instruktur'=>$ins		
			);
			recordlog("Merubah Data ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-setting-materi-kelas');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat Detail Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/kelas-pelatihan/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-setting-materi-kelas');

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
		permissions('menghapus-data-setting-materi-kelas');
		recordlog("Menghapus Data ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'kelas-pelatihan/'.url_title(strtolower($this->name)) ) );
	}

	
}
