<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eskt extends CI_Controller {
 	protected  $name = 'Eskt'; 
    protected  $model = 'pelatihan/pencatatan-eskt/Rsarankomplain_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Pencatatan Eskt'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-pencatatan-eskt');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Pencatatan Eskt',
			'titlepage'=>'Pencatatan Eskt',
			'subtitlepage'=>'Pencatatan Eskt',
			'titlebox'=>'Manage Pencatatan Eskt',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/pencatatan-eskt/'.url_title(strtolower($this->name)).'/index',$data);
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
            $saran = "";
            $komplain = "";
            
            if($field->Isi_Saran==null) {
                $saran = "-";
            } else $saran = $field->Isi_Saran;
            
            if($field->Isi_Komplain==null) {
                $komplain = "-";
            } else $komplain = $field->Isi_Komplain;

            $row[] = $saran;
            $row[] = $komplain;
            $row[] = tgl_indo($field->Tanggal_ESKT);
            $row[] = $this->actiontable($field->Id_Saran_Komplain);

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
		if(accessperm('melihat-data-pencatatan-eskt')){
			$btn = "<a href='".base_url('pencatatan-eskt/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-pencatatan-eskt')){
			$btn .= "<a href='".base_url('pencatatan-eskt/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-pencatatan-eskt')){
			$btn .= "<a href='".base_url('pencatatan-eskt/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-pencatatan-eskt');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Pencatatan Eskt',
			'titlepage'=>'Pencatatan Eskt',
			'subtitlepage'=>'Pencatatan Eskt',
			'titlebox'=>'Add Pencatatan Eskt',
			'peserta'=>$this->db->get("mst_peserta"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/pencatatan-eskt/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-pencatatan-eskt');
		
		$peserta = $this->security->xss_clean(html_escape($this->input->post("FId_Peserta")));
		$nama = $this->security->xss_clean(html_escape($this->input->post("Nama_PemberiSaran")));
		$saran = $this->security->xss_clean(html_escape($this->input->post("Isi_Saran")));
		$komplain = $this->security->xss_clean(html_escape($this->input->post("Isi_Komplain")));
		
		$this->form_validation->set_rules('FId_Peserta', 'Nama Peserta', 'trim|xss_clean');
		$this->form_validation->set_rules('Nama_PemberiSaran', 'Nama Pemberi Saran/Komplain', 'trim|xss_clean');
		$this->form_validation->set_rules('Isi_Saran', 'Isi Saran', 'trim|xss_clean');
		$this->form_validation->set_rules('Isi_Komplain', 'Isi Komplain', 'trim|xss_clean');
		
		if($peserta != "" and $nama != ""){
		    $this->session->set_flashdata( 'error','Masukan Salah Satu Pemberi Saran');
			redirect(base_url('pencatatan-eskt/'.url_title(strtolower($this->name)).'/add'));
		}

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('pencatatan-eskt/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'FId_Peserta'=>$peserta,
				'Nama_PemberiSaran'=>$nama,
				'Isi_Saran'=>$saran,
				'Isi_Komplain'=>$komplain,
				'Tanggal_ESKT'=>date('Y-m-d')
			);
			recordlog("Menyimpan Data ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('pencatatan-eskt/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-pencatatan-eskt');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Pencatatan Eskt',
			'titlepage'=>'Pencatatan Eskt',
			'subtitlepage'=>'Pencatatan Eskt',
			'titlebox'=>'Edit Pencatatan Eskt',
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'peserta'=>$this->db->get("mst_peserta"),		
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/pencatatan-eskt/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-pencatatan-eskt');	
		
		$saran = $this->security->xss_clean(html_escape($this->input->post("Isi_Saran")));
		$komplain = $this->security->xss_clean(html_escape($this->input->post("Isi_Komplain")));
		$tl1 = $this->security->xss_clean(html_escape($this->input->post("Isi_TL_yg_sudah_dilakukan")));
		$tl2 = $this->security->xss_clean(html_escape($this->input->post("Isi_TL_yg_akan_dilakukan")));
		
		$this->form_validation->set_rules('Isi_Saran', 'Isi Saran', 'trim|xss_clean');
		$this->form_validation->set_rules('Isi_Komplain', 'Isi Komplain', 'trim|xss_clean');
		$this->form_validation->set_rules('Isi_TL_yg_sudah_dilakukan', 'Isi TL yg sudah dilakukan', 'trim|xss_clean');
		$this->form_validation->set_rules('Isi_TL_yg_akan_dilakukan', 'Isi TL yg akan dilakukan', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('pencatatan-eskt/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'Isi_Saran'=>$saran,
				'Isi_Komplain'=>$komplain,
				'Isi_TL_yg_sudah_dilakukan'=>$tl1,
				'Isi_TL_yg_akan_dilakukan'=>$tl2
			);
			recordlog("Merubah Data ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('pencatatan-eskt/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-pencatatan-eskt');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Mengakses Halaman Detail ".$this->name);
		$this->load->view("pages/modul/pelatihan/pencatatan-eskt/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-pencatatan-eskt');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('pencatatan-eskt/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-pencatatan-eskt');
		recordlog("Menghapus Data ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'pencatatan-eskt/'.url_title(strtolower($this->name)) ) );
	}

	
}
