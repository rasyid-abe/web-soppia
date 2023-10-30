<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pencatatan_aktifitas extends CI_Controller {
 	protected  $name = 'Pencatatan aktifitas'; 
    protected  $model = 'pelatihan/instruktur/Rcatatan_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Instruktur'; 
 	protected  $breadcrumb3 = 'Pencatatan Aktifitas'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-pencatatan-aktifitas');
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
            $row[] = $field->NamaLengkap_DgnGelar;
            $row[] = $field->Desc_Aktifitas;
            $row[] = $field->Tanggal;
            $row[] = $field->Jam_Mulai;
            $row[] = $field->Jam_Berakhir;
            $row[] = $this->actiontable($field->Id_Aktifitas);

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
		if(accessperm('melihat-data-pencatatan-aktifitas')){
			$btn = "<a href='".base_url('instruktur/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-pencatatan-aktifitas')){
			$btn .= "<a href='".base_url('instruktur/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-pencatatan-aktifitas')){
			$btn .= "<a href='".base_url('instruktur/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-pencatatan-aktifitas');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'FId_Instruktur'=>$this->db->get("mst_instruktur"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/instruktur/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-pencatatan-aktifitas');	

		$fidinst = $this->security->xss_clean(html_escape($this->input->post("FId_Instruktur")));
		$desc = $this->security->xss_clean(html_escape($this->input->post("Desc_Aktifitas")));
		$tgl = $this->security->xss_clean(html_escape($this->input->post("Tanggal")));
		$wk = $this->security->xss_clean(html_escape($this->input->post("Jam_Mulai")));
		$wk2 = $this->security->xss_clean(html_escape($this->input->post("Jam_Berakhir")));
		$ket = $this->security->xss_clean(html_escape($this->input->post("Keterangan_Aktifitas")));
		$optional = $this->security->xss_clean(html_escape($this->input->post("optional")));

		$this->form_validation->set_rules('FId_Instruktur','FId_Instruktur','trim|required|xss_clean');	
		$this->form_validation->set_rules('Desc_Aktifitas','Desc_Aktifitas','trim|required|xss_clean');	
		$this->form_validation->set_rules('Tanggal','Tanggal','trim|required|xss_clean');	
		$this->form_validation->set_rules('Jam_Mulai','Jam_Mulai','trim|xss_clean');	
		$this->form_validation->set_rules('Jam_Berakhir','Jam_Berakhir','trim|xss_clean');	
		$this->form_validation->set_rules('Keterangan_Aktifitas','Keterangan_Aktifitas','trim|xss_clean');	
		$this->form_validation->set_rules('optional','Optional','trim|xss_clean');	
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'FId_Instruktur'=>$fidinst,	
				'Desc_Aktifitas'=>$desc,	
				'Tanggal'=>$tgl,	
				'Jam_Mulai'=>$wk,	
				'Jam_Berakhir'=>$wk2,	
				'Keterangan_Aktifitas'=>$ket,
				'optional'=>$optional
			);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-pencatatan-aktifitas');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'FId_Instruktur'=>$this->db->get("mst_instruktur"),
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/instruktur/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-pencatatan-aktifitas');

		$fidinst = $this->security->xss_clean(html_escape($this->input->post("FId_Instruktur")));
		$desc = $this->security->xss_clean(html_escape($this->input->post("Desc_Aktifitas")));
		$tgl = $this->security->xss_clean(html_escape($this->input->post("Tanggal")));
		$wk = $this->security->xss_clean(html_escape($this->input->post("Jam_Mulai")));
		$wk2 = $this->security->xss_clean(html_escape($this->input->post("Jam_Berakhir")));
		$ket = $this->security->xss_clean(html_escape($this->input->post("Keterangan_Aktifitas")));
		$optional = $this->security->xss_clean(html_escape($this->input->post("optional")));

		$this->form_validation->set_rules('FId_Instruktur','FId_Instruktur','trim|required|xss_clean');	
		$this->form_validation->set_rules('Desc_Aktifitas','Desc_Aktifitas','trim|required|xss_clean');	
		$this->form_validation->set_rules('Tanggal','Tanggal','trim|required|xss_clean');	
		$this->form_validation->set_rules('Jam_Mulai','Jam_Mulai','trim|xss_clean');	
		$this->form_validation->set_rules('Jam_Berakhir','Jam_Berakhir','trim|xss_clean');
		$this->form_validation->set_rules('Keterangan_Aktifitas','Keterangan_Aktifitas','trim|xss_clean');
		$this->form_validation->set_rules('optional','optional','trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'FId_Instruktur'=>$fidinst,	
				'Desc_Aktifitas'=>$desc,	
				'Tanggal'=>$tgl,	
				'Jam_Mulai'=>$wk,	
				'Jam_Berakhir'=>$wk2,	
				'Keterangan_Aktifitas'=>$ket,
				'optional'=>$optional
			);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-pencatatan-aktifitas');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		$this->load->view("pages/modul/pelatihan/instruktur/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-pencatatan-aktifitas');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('instruktur/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-pencatatan-aktifitas');
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'instruktur/'.url_title(strtolower($this->name)) ) );
	}

	
}
