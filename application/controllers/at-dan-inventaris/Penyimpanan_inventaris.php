<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyimpanan_inventaris extends CI_Controller {
 	protected  $name = 'Penyimpanan inventaris'; 
    protected  $model = 'umum/at-dan-inventaris/Rpengadaaninventaris_model';
 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'At Dan Inventaris'; 
 	protected  $breadcrumb3 = 'Penyimpanan Inventaris'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-penyimpanan-inventaris');
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
		$this->templatecus->dashboard('pages/modul/umum/at-dan-inventaris/'.url_title(strtolower($this->name)).'/index',$data);
	}

	public function getdata(){
		$csrf_name = $this->security->get_csrf_token_name();
		$csrf_hash = $this->security->get_csrf_hash(); 
		
		$list = $this->thismodel->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            if($field->Flag_AT_or_Inv != null){
                if($field->Flag_AT_or_Inv == "AT"){
                   $Flag_AT_or_Inv  = "Aktiva Tetap";
                }else{
                   $Flag_AT_or_Inv = "Inventory";
                }
            }else{
                $Flag_AT_or_Inv = "";
            }
            if( $field->FKd_Lokasi_Simpan == null){
                $fkdloksim = "<span style='color:red'>Belum Ditentukan</span>";
            }else{
                $fkdloksim = "<span style='color:green'>Sudah Ditentukan</span>";
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->no_at_inv;
            $row[] = $Flag_AT_or_Inv;
            $row[] = $field->Desc_AT_n_Invent;
            $row[] = $field->Desc_Lokasi_Simpan;
            $row[] = $fkdloksim;
            $row[] = $this->actiontable($field->Id_AT_n_Invent);

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
		/*if(accessperm('melihat-data-penyimpanan-inventaris')){
			$btn = "<a href='".base_url('at-dan-inventaris/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-box-tool view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a>";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }*/
		if(accessperm('merubah-data-penyimpanan-inventaris')){
			$btn = "<a href='".base_url('at-dan-inventaris/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a>";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		/*if(accessperm('menghapus-data-penyimpanan-inventaris')){
			$btn .= "<a href='".base_url('at-dan-inventaris/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-box-tool delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	*/
        return $btn;
	}

	/*public function add(){
		permissions('menambahkan-data-penyimpanan-inventaris');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/umum/at-dan-inventaris/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-penyimpanan-inventaris');	
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				
			);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/add'));
		}
	}*/

	public function edit($id){
		permissions('merubah-data-penyimpanan-inventaris');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'ref_lokasi_simpan'=>$this->db->get("ref_lokasi_simpan"),
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/umum/at-dan-inventaris/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-penyimpanan-inventaris');
		$lokasi = $this->security->xss_clean(html_escape($this->input->post("lok_penyimpanan")));
			
		$this->form_validation->set_rules('lok_penyimpanan','Lokasi Penyimpanan','trim|xss_clean');	
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
			    "FKd_Lokasi_Simpan"=>$lokasi
			);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

/*	public function view($id){
		permissions('melihat-data-penyimpanan-inventaris');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		$this->load->view("pages/modul/umum/at-dan-inventaris/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-penyimpanan-inventaris');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('at-dan-inventaris/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-penyimpanan-inventaris');
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'at-dan-inventaris/'.url_title(strtolower($this->name)) ) );
	}*/

	
}
