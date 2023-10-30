<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengantaran_permohonan extends CI_Controller {
 	protected  $name = 'Pengantaran permohonan'; 
    protected  $model = 'pelatihan/konektifitas-ds-qia/Rpengantaranpermohonan_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Konektifitas Ds Qia'; 
 	protected  $breadcrumb3 = 'Pengantaran Permohonan'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-pengantaran-permohonan');
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
            $row[] = $this->tablefile($field->Path_CV_Peserta);
            $row[] = tgl_indo($field->Tgl_Kirim_CV);
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

	public function tablefile($data){
		if($data != null){
			if(file_exists("./uploads/fileapps/dsqia/".$data)){
				return '<a href="'.base_url("./uploads/fileapps/dsqia/".$data).'" download > download file</a>';
			}else{
				$data = explode(',',$data);
				$rs = '';
				foreach ($data as $key => $value) {
					$dt = $this->db->where(array('idmeta'=>$value,'sourcefile'=>'pengantar_placement'))->get('meta_file_new')->row();
					$rs .= '<a href="'.base_url("./uploads/fileapps/dsqia/".$dt->namefile).'" download > download file '.($key+1).'</a><br/>';
				}
				return $rs;
			}
		}else{
			return '<code>N/A</code>';
		}
	}

	public function actiontable($id){
		if(accessperm('melihat-data-pengantaran-permohonan')){
			$btn = "<a href='".base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-pengantaran-permohonan')){
			$btn .= "<a href='".base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-pengantaran-permohonan')){
			$btn .= "<a href='".base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a> ";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }
        if(accessperm('melihat-data-pengantaran-permohonan')){
			$btn .= "<a href='#' class='btn btn-xs btn-success' data-toggle='tooltip' title='Kirim Data'> <i class='fa fa-send'></i> Kirim </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-send'></i> No Access </a>";
        }
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-pengantaran-permohonan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'FId_Peserta'=>$this->db->where(array("Flag_Deleted"=>"N","Flag_SebabTerkunci"=>"N","Flag_CalonPeserta"=>"N"))->get("mst_peserta"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-pengantaran-permohonan');	
		
		$fidpes = $this->security->xss_clean(html_escape($this->input->post("FId_Peserta")));
		$flag = $this->security->xss_clean(html_escape($this->input->post("Flag_PernahPelatihanQIASebelumnya")));
		$status = $this->security->xss_clean(html_escape($this->input->post("StatusKelasQIA_SaatIni")));
		$cv = $this->security->xss_clean(html_escape($this->input->post("Path_CV_Peserta")));
	
		$this->form_validation->set_rules('FId_Peserta','Nama Peserta','trim|required|xss_clean');	
		$this->form_validation->set_rules('Flag_PernahPelatihanQIASebelumnya','Pernah Pelatihan Sebelumnya ?','trim|xss_clean');	
		$this->form_validation->set_rules('StatusKelasQIA_SaatIni','Status Kelas QIA Saat Ini','trim|xss_clean');	
		
		$cek = $this->db->query("select * from mst_peserta_dgn_ds_qia where FId_Peserta='$fidpes'")->row_array();
		
		if($cek['FId_Peserta'] == $fidpes){
    		$this->db->query("update mst_peserta set permohonan='' where Id_Peserta='$fidpes'");
    		$this->db->query("update mst_peserta set ditempatkan='' where Id_Peserta='$fidpes'");
    		$this->db->query("update mst_peserta set persyaratan=0 where Id_Peserta='$fidpes'");
    		$this->db->query("update mst_peserta_dgn_ds_qia set Flag_Surat='N' where FId_Peserta='$fidpes'");
    		$this->thismodel->deletedt($fidpes);   
		}
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/add'));
		}else{
		    $this->load->library('upload');
/*
			if( !empty($_FILES['Path_CV_Peserta']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/dsqia/',
					'allowed_types'=>'png|jpg|xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
					'max_size'=>3000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('Path_CV_Peserta') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData = $this->upload->data();
					$filedocument = $uploadData['file_name'];
                	$filedocument = $filedocument;
				}
			}else{
				$filedocument = null;
			}	

			*/
            
            $counting = count($_FILES['Path_CV_Peserta']['name']);
            
            if($counting > 0){
                $filedocument = array();
                for($i=0;$i<$counting;$i++){
        			if( !empty($_FILES['Path_CV_Peserta']['name'][$i]) ){
        			    
                          // Define new $_FILES array - $_FILES['file']
                          $_FILES['file']['name'] = $_FILES['Path_CV_Peserta']['name'][$i];
                          $_FILES['file']['type'] = $_FILES['Path_CV_Peserta']['type'][$i];
                          $_FILES['file']['tmp_name'] = $_FILES['Path_CV_Peserta']['tmp_name'][$i];
                          $_FILES['file']['error'] = $_FILES['Path_CV_Peserta']['error'][$i];
                          $_FILES['file']['size'] = $_FILES['Path_CV_Peserta']['size'][$i];
                          
        				$config = array(
        					'upload_path'=> './uploads/fileapps/dsqia/',
        					'allowed_types'=>'*',
        					'max_size'=>3000000,
        					'encrypt_name'=>true,
        					'file_name' => $_FILES['Path_CV_Peserta']['name'][$i],
        				);

        				$this->upload->initialize($config);
        				
        				if( $this->upload->do_upload('file') ){
        					/*$this->session->set_flashdata('error',$this->upload->display_errors());
        					redirect(base_url('iht/'.url_title(strtolower($this->name)).'/add'));*/        					
        					$uploadData = $this->upload->data();
        					$metafile = array(
        					        'namefile'=>$uploadData['file_name'],
        					        'sourcefile'=>'pengantar_placement',
        					        'datefile'=>date("Y-m-d h:i:s"),
        					    );
        					$this->db->insert('meta_file_new',$metafile);
        					$idmeta = $this->db->insert_id();
        					array_push($filedocument,$idmeta);
        				}
        			} 
                }
                $filedocument = implode(",",$filedocument);
            }else{
            	$filedocument = null;
            }
			
			$this->db->query("update mst_peserta set permohonan='$status' where Id_Peserta='$fidpes'");
			
			$data = array(
				'FId_Peserta'=>$fidpes,				
				'Flag_PernahPelatihanQIASebelumnya'=>$flag,							
				'StatusKelasQIA_SaatIni'=>$status,				
				'Flag_AdaPermohonanPlacement'=>"Ada",				
				'Tgl_Kirim_CV'=>date('Y-m-d'),				
				'Path_CV_Peserta'=>$filedocument,
				'Flag_SuratPlacement_TelahTerbit'=>"N"
			);
			recordlog("Menambahkan Data ".$this->name);
			$this->db->query("update mst_peserta set Flag_SebabTerkunci='K' where Id_Peserta='$fidpes'");
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-pengantaran-permohonan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'FId_Peserta'=>$this->db->get("mst_peserta"),
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function getjson(){
		$id = $this->input->get("peserta");
		$file = $this->input->get("data");
		$get = $this->db->where(array('FId_Peserta'=>$id))->get("mst_peserta_dgn_ds_qia");
		$arrbaru = array();
		if($get->num_rows()>0){
			$data = $get->row()->Path_CV_Peserta;
			if(file_exists("uploads/fileapps/dsqia/".$data)){
            	$this->db->where(array('FId_Peserta'=>$id))->update("mst_peserta_dgn_ds_qia",array('Path_CV_Peserta'=>null));
            }else{

              if(substr_count($data, ',') <= 0){
	              $src = $this->db->where(array('idmeta'=>$data,'sourcefile'=>'pengantar_placement'))->get("meta_file_new");       
	              if($src->num_rows()>0){
	              	if( $this->db->where(array('idmeta'=>$data,'sourcefile'=>'pengantar_placement'))->delete("meta_file_new") ){
	              		$this->db->where(array('FId_Peserta'=>$id))->update("mst_peserta_dgn_ds_qia",array('Path_CV_Peserta'=>null));
	              	}
	              }
              }

              $data = explode(',',$data);
              foreach ($data as $key => $value) {
              	if($file == $value){	
              		$this->db->where(array('idmeta'=>$value,'sourcefile'=>'pengantar_placement'))->delete("meta_file_new");
              	}else{
              		array_push($arrbaru,$value);
              	}
              }
            }
		}

		if(count($arrbaru) > 0){
            $file = implode(",",$arrbaru);
            $this->db->where(array('FId_Peserta'=>$id))->update("mst_peserta_dgn_ds_qia",array('Path_CV_Peserta'=>$file));
		}

		$rs = array(
			'status'=>true
			);
		echo json_encode($rs);
	}

	public function update($id){	
		permissions('merubah-data-pengantaran-permohonan');
		
		$flag = $this->security->xss_clean(html_escape($this->input->post("Flag_PernahPelatihanQIASebelumnya")));
		$status = $this->security->xss_clean(html_escape($this->input->post("StatusKelasQIA_SaatIni")));
		$file = $this->security->xss_clean(html_escape($this->input->post("Path_CV_Peserta")));
	
		$this->form_validation->set_rules('Flag_PernahPelatihanQIASebelumnya','Pernah Pelatihan Sebelumnya ?','trim|xss_clean');	
		$this->form_validation->set_rules('StatusKelasQIA_SaatIni','Status Kelas QIA Saat Ini','trim|xss_clean');	

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
		    
		    $this->load->library('upload');
			$getfile = $this->thismodel->getrecord($id);
			
			/*if( !empty($_FILES['Path_CV_Peserta']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/dsqia/',
					'allowed_types'=>'png|jpg|xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
					'max_size'=>3000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('Path_CV_Peserta') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/edit/'.$id));
				}else{
                	
					if($getfile->Path_CV_Peserta != null || $getfile->Path_CV_Peserta <> null || $getfile->Path_CV_Peserta != '' || $getfile->Path_CV_Peserta <> ''){
						if(file_exists('./uploads/fileapps/dsqia/'.$getfile->Path_CV_Peserta)){
							unlink('./uploads/fileapps/dsqia/'.$getfile->Path_CV_Peserta);
						}
					}

					$uploadData = $this->upload->data();
					$filedocument = $uploadData['file_name'];
                	$filedocument = $filedocument;
				}
			}else{
				$filedocument = $getfile->Path_CV_Peserta;
			}	*/
            
            $counting = count($_FILES['Path_CV_Peserta']['name']);
            
            if($counting > 0){
                $filedocument = array();
            	if($getfile->Path_CV_Peserta != null){
            		/*if(file_exists("./uploads/fileapps/dsqia/".$getfile->Path_CV_Peserta)){
		            	$metafile = array(
						        'namefile'=>$getfile->Path_CV_Peserta,
						        'sourcefile'=>'pengantar_placement',
						        'datefile'=>date("Y-m-d h:i:s"),
						    );
						$this->db->insert('meta_file_new',$metafile);
						$idmeta = $this->db->insert_id();
						array_push($filedocument,$idmeta);
		            }

		            $data = explode(',',$getfile->Path_CV_Peserta);
	              	foreach ($data as $key => $value) {
						array_push($filedocument,$value);						
		            }*/

              		if(substr_count($getfile->Path_CV_Peserta, ',') > 0){
              			$data = explode(',',$getfile->Path_CV_Peserta);
		              	foreach ($data as $key => $value) {
							array_push($filedocument,$value);						
			            }
              		}else{
              			if(file_exists("uploads/fileapps/dsqia/".$getfile->Path_CV_Peserta)){              				
			            	$metafile = array(
							        'namefile'=>$getfile->Path_CV_Peserta,
							        'sourcefile'=>'pengantar_placement',
							        'datefile'=>date("Y-m-d h:i:s"),
							    );
							$this->db->insert('meta_file_new',$metafile);
							$idmeta = $this->db->insert_id();
							array_push($filedocument,$idmeta);
              			}else{
							array_push($filedocument,$getfile->Path_CV_Peserta);
              			}
              		}
              		
            	}
                for($i=0;$i<$counting;$i++){
        			if( !empty($_FILES['Path_CV_Peserta']['name'][$i]) ){        			    
                          // Define new $_FILES array - $_FILES['file']
                          $_FILES['file']['name'] = $_FILES['Path_CV_Peserta']['name'][$i];
                          $_FILES['file']['type'] = $_FILES['Path_CV_Peserta']['type'][$i];
                          $_FILES['file']['tmp_name'] = $_FILES['Path_CV_Peserta']['tmp_name'][$i];
                          $_FILES['file']['error'] = $_FILES['Path_CV_Peserta']['error'][$i];
                          $_FILES['file']['size'] = $_FILES['Path_CV_Peserta']['size'][$i];
                          
        				$config = array(
        					'upload_path'=> './uploads/fileapps/dsqia/',
        					'allowed_types'=>'*',
        					'max_size'=>3000000,
        					'encrypt_name'=>true,
        					'file_name' => $_FILES['Path_CV_Peserta']['name'][$i],
        				);

        				$this->upload->initialize($config);
        				
        				if( $this->upload->do_upload('file') ){
        					/*$this->session->set_flashdata('error',$this->upload->display_errors());
        					redirect(base_url('iht/'.url_title(strtolower($this->name)).'/add'));*/        					
        					$uploadData = $this->upload->data();
        					$metafile = array(
        					        'namefile'=>$uploadData['file_name'],
        					        'sourcefile'=>'pengantar_placement',
        					        'datefile'=>date("Y-m-d h:i:s"),
        					    );
        					$this->db->insert('meta_file_new',$metafile);
        					$idmeta = $this->db->insert_id();
        					array_push($filedocument,$idmeta);
        				}
        			} 
                }
                $filedocument = implode(",",$filedocument);
            }else{
            	$filedocument = $getfile->Path_CV_Peserta;
            }
			
			$this->db->query("update mst_peserta set permohonan='$status' where Id_Peserta='$id'");
			
			$data = array(			
				'Flag_PernahPelatihanQIASebelumnya'=>$flag,				
				'StatusKelasQIA_SaatIni'=>$status,
				'Path_CV_Peserta'=>$filedocument
			);
			recordlog("Merubah Data ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-pengantaran-permohonan');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat Detail Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/konektifitas-ds-qia/".url_title(strtolower($this->name))."/view",$data);
	}
	
	public function kirim($id){
		permissions('melihat-data-pengantaran-permohonan');
		
		$this->db->query("update mst_peserta set persyaratan=1 ,Flag_SebabTerkunci='N' where Id_Peserta='$id'");
		
		recordlog("Kirim Data ".$this->name);
		$this->session->set_flashdata('success', 'Data permohonan placement telah terkirim');
		redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name))));
	}

	public function delete($id){
		permissions('menghapus-data-pengantaran-permohonan');

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
		permissions('menghapus-data-pengantaran-permohonan');
		recordlog("Menghapus Data ".$this->name);
		$this->db->query("update mst_peserta set Flag_SebabTerkunci='N' where Id_Peserta='$id'");
		$this->db->query("update mst_peserta set permohonan='' where Id_Peserta='$id'");
		$this->db->query("update mst_peserta set ditempatkan='' where Id_Peserta='$id'");
		$this->db->query("update mst_peserta set persyaratan=0 where Id_Peserta='$id'");
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'konektifitas-ds-qia/'.url_title(strtolower($this->name)) ) );
	}
}
