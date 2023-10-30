<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemenuhan_persyaratan extends CI_Controller {
 	protected  $name = 'Pemenuhan persyaratan'; 
    protected  $model = 'pelatihan/konektifitas-ds-qia/Rsyarat_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Konektifitas Ds Qia'; 
 	protected  $breadcrumb3 = 'Pemenuhan Persyaratan'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-pemenuhan-persyaratan');
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
		$this->templatecus->dashboard('pages/modul/pelatihan/konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->NIPP;
            $row[] = $field->NamaLengkap_DgnGelar;
            $row[] = $field->NamaPershInstansi;
			$ket2 = "";
			if($field->Ditempatkan_diTingkatanKelas == "A"){
				$ket2 = "Dasar 1";
			}
			elseif($field->Ditempatkan_diTingkatanKelas == "B"){
				$ket2 = "Dasar 2";
			}
			elseif($field->Ditempatkan_diTingkatanKelas == "C"){
				$ket2 = "Lanjutan 1";
			}
			elseif($field->Ditempatkan_diTingkatanKelas == "D"){
				$ket2 = "Lanjutan 2";
			}
			elseif($field->Ditempatkan_diTingkatanKelas == "E"){
				$ket2 = "Manajerial";
			}
			elseif($field->Ditempatkan_diTingkatanKelas == "AA"){
				$ket2 = "DASAR";
			}
			elseif($field->Ditempatkan_diTingkatanKelas == "BB"){
				$ket2 = "LANJUTAN";
			}
			elseif($field->Ditempatkan_diTingkatanKelas == "CC"){
				$ket2 = "MANAJERIAL";
			} else $ket2 = "<code>N/A</code>";
            $row[] = $ket2;
            $row[] = $this->actiontable($field->FId_Peserta);
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
		if(accessperm('melihat-data-pemenuhan-persyaratan')){
			$btn = "<a href='".base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-pemenuhan-persyaratan')){
			$btn .= "<a href='".base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
        return $btn;
	}

	public function edit($id){
		permissions('merubah-data-pemenuhan-persyaratan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'FId_Peserta'=>$this->db->get("mst_peserta"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-pemenuhan-persyaratan');
		
		$flag1 = $this->security->xss_clean(html_escape($this->input->post("Flag_Syarat_Placement1_Dipenuhi")));
		$flag2 = $this->security->xss_clean(html_escape($this->input->post("Flag_Syarat_Placement2_Dipenuhi")));
		$flag3 = $this->security->xss_clean(html_escape($this->input->post("Flag_Syarat_Placement3_Dipenuhi")));
		$flag4 = $this->security->xss_clean(html_escape($this->input->post("Flag_Syarat_Placement4_Dipenuhi")));
		$flag5 = $this->security->xss_clean(html_escape($this->input->post("Flag_Syarat_Placement5_Dipenuhi")));
		
		$this->form_validation->set_rules('Flag_Syarat_Placement1_Dipenuhi','Flag Syarat 1 Depenuhi','trim|xss_clean');	
		$this->form_validation->set_rules('Flag_Syarat_Placement2_Dipenuhi','Flag Syarat 2 Depenuhi','trim|xss_clean');	
		$this->form_validation->set_rules('Flag_Syarat_Placement3_Dipenuhi','Flag Syarat 3 Depenuhi','trim|xss_clean');	
		$this->form_validation->set_rules('Flag_Syarat_Placement4_Dipenuhi','Flag Syarat 4 Depenuhi','trim|xss_clean');	
		$this->form_validation->set_rules('Flag_Syarat_Placement5_Dipenuhi','Flag Syarat 5 Depenuhi','trim|xss_clean');	

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
		    
		    if(isset($_POST["terpenuhi"])){ 
                $this->db->query("update mst_peserta set persyaratan=1 ,Flag_SebabTerkunci='N' where Id_Peserta='$id'");    
            }
            
		    $this->load->library('upload');
		    
		    $getfile = $this->thismodel->getrecord($id);
			if( !empty($_FILES['Path_LampPemenuhanSyarat1']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/dsqia/',
					'allowed_types'=>'png|jpg|xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
					'max_size'=>3000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('Path_LampPemenuhanSyarat1') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/add'));
				}else{
				    
				    if($getfile->Path_LampPemenuhanSyarat1 != null || $getfile->Path_LampPemenuhanSyarat1 <> null || $getfile->Path_LampPemenuhanSyarat1 != '' || $getfile->Path_LampPemenuhanSyarat1 <> ''){
						if(file_exists('./uploads/fileapps/dsqia/'.$getfile->Path_LampPemenuhanSyarat1)){
							unlink('./uploads/fileapps/dsqia/'.$getfile->Path_LampPemenuhanSyarat1);
						}
					}
					
					$uploadData = $this->upload->data();
					$filedocument1 = $uploadData['file_name'];
                	$filedocument1 = $filedocument1;
				}
			}else{
				$filedocument1 = $getfile->Path_LampPemenuhanSyarat1;
			}	
			
			$getfile2 = $this->thismodel->getrecord($id);
			if( !empty($_FILES['Path_LampPemenuhanSyarat2']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/dsqia/',
					'allowed_types'=>'png|jpg|xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
					'max_size'=>3000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('Path_LampPemenuhanSyarat2') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/add'));
				}else{
				    
				    if($getfile2->Path_LampPemenuhanSyarat2 != null || $getfile2->Path_LampPemenuhanSyarat2 <> null || $getfile2->Path_LampPemenuhanSyarat2 != '' || $getfile2->Path_LampPemenuhanSyarat2 <> ''){
						if(file_exists('./uploads/fileapps/dsqia/'.$getfile2->Path_LampPemenuhanSyarat2)){
							unlink('./uploads/fileapps/dsqia/'.$getfile2->Path_LampPemenuhanSyarat2);
						}
					}
					
					$uploadData2 = $this->upload->data();
					$filedocument2 = $uploadData2['file_name'];
                	$filedocument2 = $filedocument2;
				}
			}else{
				$filedocument2 = $getfile2->Path_LampPemenuhanSyarat2;
			}	
			
			if( !empty($_FILES['Path_LampPemenuhanSyarat3']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/dsqia/',
					'allowed_types'=>'png|jpg|xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
					'max_size'=>3000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('Path_LampPemenuhanSyarat3') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData3 = $this->upload->data();
					$filedocument3 = $uploadData3['file_name'];
                	$filedocument3 = $filedocument3;
				}
			}else{
				$filedocument3 = null;
			}	
			
			if( !empty($_FILES['Path_LampPemenuhanSyarat4']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/dsqia/',
					'allowed_types'=>'png|jpg|xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
					'max_size'=>3000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('Path_LampPemenuhanSyarat4') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData4 = $this->upload->data();
					$filedocument4 = $uploadData4['file_name'];
                	$filedocument4 = $filedocument4;
				}
			}else{
				$filedocument4 = null;
			}	
			
			if( !empty($_FILES['Path_LampPemenuhanSyarat5']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/dsqia/',
					'allowed_types'=>'png|jpg|xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
					'max_size'=>3000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('Path_LampPemenuhanSyarat5') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData5 = $this->upload->data();
					$filedocument5 = $uploadData5['file_name'];
                	$filedocument5 = $filedocument5;
				}
			}else{
				$filedocument5 = null;
			}	
			
			$data = array(
			    'Flag_Syarat_Placement1_Dipenuhi'=>$flag1,
			    'Flag_Syarat_Placement2_Dipenuhi'=>$flag2,
			    'Flag_Syarat_Placement3_Dipenuhi'=>$flag3,
			    'Flag_Syarat_Placement4_Dipenuhi'=>$flag4,
			    'Flag_Syarat_Placement5_Dipenuhi'=>$flag5,
				'Path_LampPemenuhanSyarat1'=>$filedocument1,
				'Path_LampPemenuhanSyarat2'=>$filedocument2,
				'Path_LampPemenuhanSyarat3'=>$filedocument3,
				'Path_LampPemenuhanSyarat4'=>$filedocument4,
				'Path_LampPemenuhanSyarat5'=>$filedocument5
			);
			recordlog("Merubah Data ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-pemenuhan-persyaratan');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat Detail Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/konektifitas-ds-qia/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-pemenuhan-persyaratan');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-pemenuhan-persyaratan');
		recordlog("Menghapus Data ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'konektifitas-ds-qia/'.url_title(strtolower($this->name)) ) );
	}

	
}
