<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_template extends CI_Controller {
 	protected  $name = 'Setting template'; 
    protected  $model = 'pelatihan/pengelolaan-psl/Rsettingtemplate_model';
    protected  $model2 = 'pelatihan/kelas-pelatihan/Rpembukaankelas_model';

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Pengelolaan PSL'; 
 	protected  $breadcrumb3 = 'Setting Template'; 

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
		permissions('melihat-data-setting-template');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Setting Template',
			'titlepage'=>'Setting Template',
			'subtitlepage'=>'Data Setting Template',
			'titlebox'=>'Manage Setting Template',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pengelolaan-psl/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = '<a href="'.base_url("pengelolaan-psl/setting-template/add/".$field->Id_Kelas_n_Angkatan).'">'.$field->DescBebas_Kelas_n_Angkatan.'</a>' ;
            $row[] = $field->nomor_kelas;
            $row[] = $field->No_Urut_Angkatan;
            $row[] = $field->Desc_JenisPelatihan;
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
		if(accessperm('melihat-data-setting-template')){
			$btn = "<a href='".base_url('pengelolaan-psl/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-box-tool view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a>";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-setting-template')){
			$btn .= "<a href='".base_url('pengelolaan-psl/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-box-tool' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a>";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-setting-template')){
			$btn .= "<a href='".base_url('pengelolaan-psl/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-box-tool delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add($id){
		permissions('menambahkan-data-setting-template');
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
            'format'=>$this->db
                    ->join("mst_peserta","mst_peserta.Id_Peserta=mst_formatpiagamsertifikat.id_peserta",'left')
                    ->where("mst_formatpiagamsertifikat.id_kelas",$id)
                    ->get("mst_formatpiagamsertifikat")->num_rows(),
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
		$this->templatecus->dashboard('pages/modul/pelatihan/pengelolaan-psl/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-setting-template');	
		
		$kelas = $this->security->xss_clean(html_escape($this->input->post("id_kelas")));
		$peserta = $this->security->xss_clean(html_escape($this->input->post("id_peserta")));
		$tanggal = $this->security->xss_clean(html_escape($this->input->post("tanggal")));
		$pembina = $this->security->xss_clean(html_escape($this->input->post("pembina")));
		$jabatan = $this->security->xss_clean(html_escape($this->input->post("jabatan")));
		$atas = $this->security->xss_clean(html_escape($this->input->post("Desc_Piagam_Sertifikat")));
		$font = $this->security->xss_clean(html_escape($this->input->post("font")));
		
		$this->form_validation->set_rules('id_kelas', 'Nama Kelas', 'trim|required|is_unique[mst_formatpiagamsertifikat.id_kelas]|xss_clean');
		$this->form_validation->set_rules('id_peserta', 'Nama Peserta', 'trim|xss_clean');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|xss_clean');
		$this->form_validation->set_rules('pembina', 'Pembina', 'trim|xss_clean');
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|xss_clean');
		$this->form_validation->set_rules('Desc_Piagam_Sertifikat', 'Deskripsi Pertama', 'trim|xss_clean');
		$this->form_validation->set_rules('font', 'font', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('pengelolaan-psl/'.url_title(strtolower($this->name)).'/add/'.$kelas));
		}else{
			$data = array(
				'id_kelas'=>$kelas,
				'id_peserta'=>$peserta,
				'tanggal'=>$tanggal,
				'pembina'=>$pembina,
				'jabatan'=>$jabatan,
				'Desc_Piagam_Sertifikat'=>$atas,
				'font'=>$font
			);
			$this->thismodel->insertdt($data);
			recordlog("Menambahkan Data Format Sertifikasi");
			$this->session->set_flashdata('success', 'Data berhasil disimpan');
			redirect(base_url('pengelolaan-psl/'.url_title(strtolower($this->name)).'/add/'.$kelas));
		}
	}

	public function edit($id){
		permissions('merubah-data-setting-template');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Setting Template',
			'titlepage'=>'Setting Template',
			'subtitlepage'=>'Data Setting Template',
			'titlebox'=>'Edit Setting Template',
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pengelolaan-psl/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-setting-template');
		
		$kelas = $this->security->xss_clean(html_escape($this->input->post("id_kelas")));
		$peserta = $this->security->xss_clean(html_escape($this->input->post("id_peserta")));
		$tanggal = $this->security->xss_clean(html_escape($this->input->post("tanggal")));
		$pembina = $this->security->xss_clean(html_escape($this->input->post("pembina")));
		$jabatan = $this->security->xss_clean(html_escape($this->input->post("jabatan")));
		$atas = $this->security->xss_clean(html_escape($this->input->post("Desc_Piagam_Sertifikat")));
		$font = $this->security->xss_clean(html_escape($this->input->post("font")));
		
		$this->form_validation->set_rules('id_kelas', 'Nama Kelas', 'trim|xss_clean');
		$this->form_validation->set_rules('id_peserta', 'Nama Peserta', 'trim|xss_clean');
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|xss_clean');
		$this->form_validation->set_rules('pembina', 'Pembina', 'trim|xss_clean');
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|xss_clean');
		$this->form_validation->set_rules('Desc_Piagam_Sertifikat', 'Deskripsi Pertama', 'trim|xss_clean');
		$this->form_validation->set_rules('font', 'font', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('pengelolaan-psl/'.url_title(strtolower($this->name)).'/add/'.$id));
		}else{
			$data = array(
			    'id_kelas'=>$kelas,
				'id_peserta'=>$peserta,
				'tanggal'=>$tanggal,
				'pembina'=>$pembina,
				'jabatan'=>$jabatan,
				'Desc_Piagam_Sertifikat'=>$atas,
				'font'=>$font
			);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data sertifikat berhasil diperbaharui');
			redirect(base_url('pengelolaan-psl/'.url_title(strtolower($this->name)).'/add/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-setting-template');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		$this->load->view("pages/modul/pelatihan/pengelolaan-psl/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-setting-template');

		echo "Anda yakin ini menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('pengelolaan-psl/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-setting-template');
		$this->thismodel->deletedt($id);
		recordlog("Menghapus Data Format Sertifikasi");
		$this->session->set_flashdata('success', 'Data Sertifikat Berhasil Dihapus');
		redirect(base_url( 'pengelolaan-psl/'.url_title(strtolower($this->name)).'/add/'.$id));
	}

	
}
