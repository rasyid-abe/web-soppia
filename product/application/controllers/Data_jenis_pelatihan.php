<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_jenis_pelatihan extends CI_Controller {
 	protected  $name = 'Data Jenis Pelatihan'; 
    protected  $model = 'data/Rdatajenispelatihan_model'; 

 	protected  $breadcrumb1 = 'Dashboard';  

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-data-jenis-pelatihan');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>$this->name,
			'titlebox'=>'Manage '.$this->name,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/data/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->Desc_JenisPelatihan;
                $status_pel = $field->status_pel;
                if($status_pel == 'dsr1'){$tingkatan = "Dasar I";}
                else if($status_pel == 'dsr2'){$tingkatan = "Dasar II";}
                else if($status_pel == 'DSR'){$tingkatan = "DASAR";}
                else if($status_pel == 'lnjt1'){$tingkatan = "Lanjutan I";}
                else if($status_pel == 'lnjt2'){$tingkatan = "Lanjutan II";}
                else if($status_pel == 'LNJT'){$tingkatan = "LANJUTAN";}
                else if($status_pel == 'mnj'){$tingkatan = "Manajerial";}
                else if($status_pel == 'MNJT'){$tingkatan = "MANAJERIAL";}else{ $tingkatan = ""; }
            $row[] = $tingkatan;
            $row[] = $field->ref_kelompokpelatihanDesc_KelompokPelatihan;
            $row[] = (($field->Flag_IHT == "Y")? 'Ya':'Tidak');
            $row[] = (($field->Flag_QIA == "Y")? 'Ya':'Tidak');
            $row[] = (($field->Flag_DefaultAwalQIA == "Y")? 'Ya':'Tidak');
            $row[] = $this->actiontable($field->Id_JenisPelatihan);

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
		if(accessperm('melihat-data-data-jenis-pelatihan')){
			$btn = "<a href='".base_url(url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-data-jenis-pelatihan')){
			$btn .= "<a href='".base_url(url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-data-jenis-pelatihan')){
			$btn .= "<a href='".base_url(url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-data-jenis-pelatihan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>$this->name,
			'titlebox'=>'Add '.$this->name,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
			'kelompokpelatihan'=>$this->db->get("ref_kelompokpelatihan"),
			'jenispelatihan1'=>$this->db->get("ref_jenispelatihan1"),
			'jenispelatihan2'=>$this->db->get("ref_jenispelatihan2"),
			'jenispelatihan3'=>$this->db->get("ref_jenispelatihan3"),
		);
		recordlog("Mengakses Halaman Add Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/data/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-data-jenis-pelatihan');	

		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$kelompokpelatihan = $this->security->xss_clean(html_escape($this->input->post("kelompokpelatihan")));
		$iht = $this->security->xss_clean(html_escape($this->input->post("iht")));
		$qia = $this->security->xss_clean(html_escape($this->input->post("qia")));
		$tingkatanpelatian = $this->security->xss_clean(html_escape($this->input->post("tingkatanpelatian")));
		$defaultawalqia = $this->security->xss_clean(html_escape($this->input->post("defaultawalqia")));
		$jenispelatihan1 = $this->security->xss_clean(html_escape($this->input->post("jenispelatihan1")));
		$jenispelatihan2 = $this->security->xss_clean(html_escape($this->input->post("jenispelatihan2")));
		$jenispelatihan3 = $this->security->xss_clean(html_escape($this->input->post("jenispelatihan3")));
		$kodesingkat = $this->security->xss_clean(html_escape($this->input->post("kodesingkat")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("keterangan")));

		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[mst_jenispelatihan.Desc_JenisPelatihan]|xss_clean');
		$this->form_validation->set_rules('kelompokpelatihan', 'Kelompok Pelatihan', 'trim|xss_clean');
		$this->form_validation->set_rules('iht', 'IHT', 'trim|xss_clean');
		$this->form_validation->set_rules('tingkatanpelatian', 'Tingkat Pelatihan', 'trim|xss_clean');
		$this->form_validation->set_rules('qia', 'QIA', 'trim|xss_clean');
		$this->form_validation->set_rules('defaultawalqia', 'Default Awal QIA', 'trim|xss_clean');
		$this->form_validation->set_rules('jenispelatihan1', 'Jenis Pelatihan 1', 'trim|xss_clean');
		$this->form_validation->set_rules('jenispelatihan2', 'Jenis Pelatihan 2', 'trim|xss_clean');
		$this->form_validation->set_rules('jenispelatihan3', 'Jenis Pelatihan 3', 'trim|xss_clean');
		$this->form_validation->set_rules('kodesingkat', 'Kode Singkat', 'trim|xss_clean');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url(url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'Desc_JenisPelatihan'=>$name,
				'FKd_KelompokPelatihan'=>$kelompokpelatihan,
				'status_pel'=>$tingkatanpelatian,
				'Flag_IHT'=>$iht,
				'Flag_QIA'=>$qia,
				'Flag_DefaultAwalQIA'=>$defaultawalqia,
				'FKd_JnsPelatihan1'=>$jenispelatihan1,
				'FKd_JnsPelatihan2'=>$jenispelatihan2,
				'FKd_JnsPelatihan3'=>$jenispelatihan3,
				'KODE_Singkatan'=>$kodesingkat,
				'Keterangan'=>$keterangan,
			);
			$this->thismodel->insertdt($data);
			recordlog("Menambahkan Data ".$this->name);
			$this->session->set_flashdata('success', 'data berhasil di simpan');
			redirect(base_url(url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-data-jenis-pelatihan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>$this->name,
			'titlebox'=>'Edit '.$this->name,
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
			'kelompokpelatihan'=>$this->db->get("ref_kelompokpelatihan"),
			'jenispelatihan1'=>$this->db->get("ref_jenispelatihan1"),
			'jenispelatihan2'=>$this->db->get("ref_jenispelatihan2"),
			'jenispelatihan3'=>$this->db->get("ref_jenispelatihan3"),
		);
		recordlog("Mengakses Halaman Edit Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/data/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-data-jenis-pelatihan');	

		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$kelompokpelatihan = $this->security->xss_clean(html_escape($this->input->post("kelompokpelatihan")));
		$iht = $this->security->xss_clean(html_escape($this->input->post("iht")));
		$qia = $this->security->xss_clean(html_escape($this->input->post("qia")));
		$tingkatanpelatian = $this->security->xss_clean(html_escape($this->input->post("tingkatanpelatian")));
		$defaultawalqia = $this->security->xss_clean(html_escape($this->input->post("defaultawalqia")));
		$jenispelatihan1 = $this->security->xss_clean(html_escape($this->input->post("jenispelatihan1")));
		$jenispelatihan2 = $this->security->xss_clean(html_escape($this->input->post("jenispelatihan2")));
		$jenispelatihan3 = $this->security->xss_clean(html_escape($this->input->post("jenispelatihan3")));
		$kodesingkat = $this->security->xss_clean(html_escape($this->input->post("kodesingkat")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("keterangan")));

		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('kelompokpelatihan', 'Kelompok Pelatihan', 'trim|xss_clean');
		$this->form_validation->set_rules('iht', 'IHT', 'trim|xss_clean');
		$this->form_validation->set_rules('qia', 'QIA', 'trim|xss_clean');
		$this->form_validation->set_rules('tingkatanpelatian', 'Tingkat Pelatihan', 'trim|xss_clean');
		$this->form_validation->set_rules('defaultawalqia', 'Default Awal QIA', 'trim|xss_clean');
		$this->form_validation->set_rules('jenispelatihan1', 'Jenis Pelatihan 1', 'trim|xss_clean');
		$this->form_validation->set_rules('jenispelatihan2', 'Jenis Pelatihan 2', 'trim|xss_clean');
		$this->form_validation->set_rules('jenispelatihan3', 'Jenis Pelatihan 3', 'trim|xss_clean');
		$this->form_validation->set_rules('kodesingkat', 'Kode Singkat', 'trim|xss_clean');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url(url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'Desc_JenisPelatihan'=>$name,
				'FKd_KelompokPelatihan'=>$kelompokpelatihan,
				'status_pel'=>$tingkatanpelatian,
				'Flag_IHT'=>$iht,
				'Flag_QIA'=>$qia,
				'Flag_DefaultAwalQIA'=>$defaultawalqia,
				'FKd_JnsPelatihan1'=>$jenispelatihan1,
				'FKd_JnsPelatihan2'=>$jenispelatihan2,
				'FKd_JnsPelatihan3'=>$jenispelatihan3,
				'KODE_Singkatan'=>$kodesingkat,
				'Keterangan'=>$keterangan,
			);
			$this->thismodel->updatedt($data,$id);
			recordlog("Merubah data ".$this->name);
			$this->session->set_flashdata('success', 'data berhasil  di perbaharui');
			redirect(base_url(url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-data-jenis-pelatihan');
		$data = array(
			'dt'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat data ".$this->name);
		$this->load->view("pages/modul/data/".url_title(strtolower($this->name))."/view",$data);
	}

	public function delete($id){
		permissions('menghapus-data-data-jenis-pelatihan');

		echo "anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-12"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url(url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-data-jenis-pelatihan');
		$this->thismodel->deletedt($id);
		recordlog("Menghapus data ".$this->name);
		$this->session->set_flashdata('success', 'data berhasil di perbaharui');
		redirect( base_url(url_title(strtolower($this->name)) ));
	}
	
}