<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holding_group extends CI_Controller {
 	protected  $name = 'Holding group'; 
    protected  $model = 'data/perusahaan-instansi/Rholdinggroup_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Perusahaan instansi'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-holding-group');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Manage '.$this->name,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Holding Group");
		$this->templatecus->dashboard('pages/modul/data/perusahaan-instansi/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->Desc_GrupPershInstansi;
            $row[] = $field->Alamat_Utama_Kantor;
            $row[] = $field->Telp;
            $row[] = $field->Fax;
            $row[] = $field->email;
            $row[] = $this->actiontable($field->Id_GrupPershInstansi);

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->thismodel->count_all(),
            "recordsFiltered" => $this->thismodel->count_filtered(),
            "data" => $data,
        );
        $output[$csrf_name] = $csrf_hash;
        //output dalam format JSON
        echo json_encode($output);
	}

	public function actiontable($id){
		if(accessperm('melihat-data-holding-group')){
			$btn = "<a href='".base_url('perusahaan-instansi/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-holding-group')){
			$btn .= "<a href='".base_url('perusahaan-instansi/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-holding-group')){
			$btn .= "<a href='".base_url('perusahaan-instansi/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-holding-group');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Add '.$this->name,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add Holding Group");
		$this->templatecus->dashboard('pages/modul/data/perusahaan-instansi/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-holding-group');	

		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$alamat = $this->security->xss_clean(html_escape($this->input->post("alamat")));
		$telp = $this->security->xss_clean(html_escape($this->input->post("telp")));
		$fax = $this->security->xss_clean(html_escape($this->input->post("fax")));
		$email = $this->security->xss_clean(html_escape($this->input->post("email")));
		$kontakperson = $this->security->xss_clean(html_escape($this->input->post("kontak_person")));
		$hpkontakperson = $this->security->xss_clean(html_escape($this->input->post("hp_kontak_person")));
		$kodesingkat = $this->security->xss_clean(html_escape($this->input->post("kode_singkat")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("keterangan")));

		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[mst_holdinggruppershinstansi.Desc_GrupPershInstansi]|xss_clean');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|xss_clean');
		$this->form_validation->set_rules('telp', 'Telp', 'trim|xss_clean');
		$this->form_validation->set_rules('fax', 'Fax', 'trim|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean');
		$this->form_validation->set_rules('kontak_person', 'Kontak Person', 'trim|xss_clean');
		$this->form_validation->set_rules('hp_kontak_person', 'Hp Kontak Person', 'trim|xss_clean');
		$this->form_validation->set_rules('kode_singkat', 'Kode Singkat', 'trim|xss_clean');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('perusahaan-instansi/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'Desc_GrupPershInstansi'=>$name,
				'Alamat_Utama_Kantor'=>$alamat,
				'Telp'=>$telp,
				'Fax'=>$fax,
				'email'=>$email,
				'Contact_Person'=>$kontakperson,
				'HP_Contact_Person'=>$hpkontakperson,
				'Kode_Singkatan'=>$kodesingkat,
				'Keterangan'=>$keterangan,
			);
			$this->thismodel->insertdt($data);
			recordlog("Menambahkan data Holding Group");
			$this->session->set_flashdata('success', 'data berhasil di simpan');
			redirect(base_url('perusahaan-instansi/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-holding-group');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Edit '.$this->name,
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit Holding Group");
		$this->templatecus->dashboard('pages/modul/data/perusahaan-instansi/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-holding-group');	

		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$alamat = $this->security->xss_clean(html_escape($this->input->post("alamat")));
		$telp = $this->security->xss_clean(html_escape($this->input->post("telp")));
		$fax = $this->security->xss_clean(html_escape($this->input->post("fax")));
		$email = $this->security->xss_clean(html_escape($this->input->post("email")));
		$kontakperson = $this->security->xss_clean(html_escape($this->input->post("kontak_person")));
		$hpkontakperson = $this->security->xss_clean(html_escape($this->input->post("hp_kontak_person")));
		$kodesingkat = $this->security->xss_clean(html_escape($this->input->post("kode_singkat")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("keterangan")));


		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|xss_clean');
		$this->form_validation->set_rules('telp', 'Telp', 'trim|xss_clean');
		$this->form_validation->set_rules('fax', 'Fax', 'trim|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean');
		$this->form_validation->set_rules('kontak_person', 'Kontak Person', 'trim|xss_clean');
		$this->form_validation->set_rules('hp_kontak_person', 'Hp Kontak Person', 'trim|xss_clean');
		$this->form_validation->set_rules('kode_singkat', 'Kode Singkat', 'trim|xss_clean');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('perusahaan-instansi/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(				
				'Desc_GrupPershInstansi'=>$name,
				'Alamat_Utama_Kantor'=>$alamat,
				'Telp'=>$telp,
				'Fax'=>$fax,
				'email'=>$email,
				'Contact_Person'=>$kontakperson,
				'HP_Contact_Person'=>$hpkontakperson,
				'Kode_Singkatan'=>$kodesingkat,
				'Keterangan'=>$keterangan,
			);
			$this->thismodel->updatedt($data,$id);
			recordlog("Merubah Data Holding Group");
			$this->session->set_flashdata('success', 'data berhasil  di perbaharui');
			redirect(base_url('perusahaan-instansi/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-holding-group');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		recordlog("Melihat Data Holding Group");
		$this->load->view("pages/modul/data/perusahaan-instansi/".url_title(strtolower($this->name))."/view",$data);
	}

	public function delete($id){
		permissions('menghapus-data-holding-group');

		echo "anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-12"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('perusahaan-instansi/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-holding-group');
		$this->thismodel->deletedt($id);
		recordlog("Menghapus data Holding Group");
		$this->session->set_flashdata('success', 'data berhasil di perbaharui');
		redirect( base_url('perusahaan-instansi/'.url_title(strtolower($this->name)) ));
	}
	
}