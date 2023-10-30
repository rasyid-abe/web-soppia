<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penarikan_surat extends CI_Controller {
 	protected  $name = 'Penarikan surat'; 
    protected  $model = 'pelatihan/konektifitas-ds-qia/Rpenarikansurat_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Konektifitas Ds Qia'; 
 	protected  $breadcrumb3 = 'Penarikan Surat'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-penarikan-surat');
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
            $tglsura = "";
            if($field->Tgl_SuratPlacement == null){
                $tglsura = "<code>N/A</code>";
            } else $tglsura = tgl_indo($field->Tgl_SuratPlacement);
            $row[] = $tglsura;
            $row[] = $this->tablefile($field->Path_SuratPlacement);
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
		//return $data;
		if($data != null){
			if(file_exists("./uploads/fileapps/dsqia/".$data)){
				return '<a href="'.base_url("./uploads/fileapps/dsqia/".$data).'" download > download file</a>';
			}else{
				$data = explode(',',$data);
				$rs = '';
				foreach ($data as $key => $value) {
					$dt = $this->db->where(array('idmeta'=>$value,'sourcefile'=>'penarikan_placement'))->get('meta_file_new')->row();
					$rs .= '<a href="'.base_url("./uploads/fileapps/dsqia/".$dt->namefile).'" download > download file '.($key+1).'</a><br/>';
				}
				return $rs;
			}
		}else{
			return '<code>N/A</code>';
		}
	}

	public function actiontable($id){
		if(accessperm('melihat-data-penarikan-surat')){
			$btn = "<a href='".base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-penarikan-surat')){
			$btn .= "<a href='".base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
        return $btn;
	}

	public function getjson(){
		$id = $this->input->get("peserta");
		$file = $this->input->get("data");
		$get = $this->db->where(array('FId_Peserta'=>$id))->get("mst_peserta_dgn_ds_qia");
		$arrbaru = array();
		if($get->num_rows()>0){
			$data = $get->row()->Path_SuratPlacement;
			if(file_exists("uploads/fileapps/dsqia/".$data)){
            	$this->db->where(array('FId_Peserta'=>$id))->update("mst_peserta_dgn_ds_qia",array('Path_SuratPlacement'=>null));
            }else{

              if(substr_count($data, ',') <= 0){
	              $src = $this->db->where(array('idmeta'=>$data,'sourcefile'=>'penarikan_placement'))->get("meta_file_new");       
	              if($src->num_rows()>0){
	              	if( $this->db->where(array('idmeta'=>$data,'sourcefile'=>'penarikan_placement'))->delete("meta_file_new") ){
	              		$this->db->where(array('FId_Peserta'=>$id))->update("mst_peserta_dgn_ds_qia",array('Path_SuratPlacement'=>null));
	              	}
	              }
              }

              $data = explode(',',$data);
              foreach ($data as $key => $value) {
              	if($file == $value){	
              		$this->db->where(array('idmeta'=>$value,'sourcefile'=>'penarikan_placement'))->delete("meta_file_new");
              	}else{
              		array_push($arrbaru,$value);
              	}
              }
            }
		}

		if(count($arrbaru) > 0){
            $file = implode(",",$arrbaru);
            $this->db->where(array('FId_Peserta'=>$id))->update("mst_peserta_dgn_ds_qia",array('Path_SuratPlacement'=>$file));
		}

		$rs = array(
			'status'=>true
			);
		echo json_encode($rs);
	}
	
	public function edit($id){
		permissions('merubah-data-penarikan-surat');
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

	public function update($id){	
		permissions('merubah-data-penarikan-surat');

		$flag = $this->security->xss_clean(html_escape($this->input->post("Flag_SuratPlacement_TelahTerbit")));
		$tglsurat = $this->security->xss_clean(html_escape($this->input->post("Tgl_SuratPlacement")));
		$nosur = $this->security->xss_clean(html_escape($this->input->post("No_Surat_Placement")));
		$tglsr = $this->security->xss_clean(html_escape($this->input->post("Tgl_SuratPlacement")));
		$kelas = $this->security->xss_clean(html_escape($this->input->post("Ditempatkan_diTingkatanKelas")));
		$syarat1 = $this->security->xss_clean(html_escape($this->input->post("Syarat_Placement_1")));
		$syarat2 = $this->security->xss_clean(html_escape($this->input->post("Syarat_Placement_2")));
		$syarat3 = $this->security->xss_clean(html_escape($this->input->post("Syarat_Placement_3")));
		$syarat4 = $this->security->xss_clean(html_escape($this->input->post("Syarat_Placement_4")));
		$syarat5 = $this->security->xss_clean(html_escape($this->input->post("Syarat_Placement_5")));
		$path = $this->security->xss_clean(html_escape($this->input->post("Path_SuratPlacement")));
	
		$this->form_validation->set_rules('Flag_SuratPlacement_TelahTerbit','Flag_SuratPlacement_TelahTerbit','trim|xss_clean');		
		$this->form_validation->set_rules('Tgl_SuratPlacement','Tgl_SuratPlacement','trim|xss_clean');
		$this->form_validation->set_rules('No_Surat_Placement','No_Surat_Placement','trim|xss_clean');		
		$this->form_validation->set_rules('Tgl_SuratPlacement','Tgl_SuratPlacement','trim|xss_clean');		
		$this->form_validation->set_rules('Ditempatkan_diTingkatanKelas','Ditempatkan_diTingkatanKelas','trim|xss_clean');		
		$this->form_validation->set_rules('Syarat_Placement_1','Syarat_Placement_1','trim|xss_clean');
		$this->form_validation->set_rules('Syarat_Placement_2','Syarat_Placement_2','trim|xss_clean');
		$this->form_validation->set_rules('Syarat_Placement_3','Syarat_Placement_3','trim|xss_clean');
		$this->form_validation->set_rules('Syarat_Placement_4','Syarat_Placement_4','trim|xss_clean');
		$this->form_validation->set_rules('Syarat_Placement_5','Syarat_Placement_5','trim|xss_clean');
		
		$sudah = "";
		if($nosur != NULL){
		    $sudah = "Y";
		}

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
		    
		    $this->load->library('upload');
		    
			/*if( !empty($_FILES['Path_SuratPlacement']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/dsqia/',
					'allowed_types'=>'png|jpg|xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
					'max_size'=>3000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('Path_SuratPlacement') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData = $this->upload->data();
					$filedocument = $uploadData['file_name'];
                	$filedocument = $filedocument;
				}
			}else{
				$filedocument = null;
			}	*/

			$getfile = $this->thismodel->getrecord($id);

			$counting = count($_FILES['Path_SuratPlacement']['name']);
            
            if($counting > 0){
                $filedocument = array();
            	if($getfile->Path_SuratPlacement != null){
            		
              		if(substr_count($getfile->Path_SuratPlacement, ',') > 0){
              			$data = explode(',',$getfile->Path_SuratPlacement);
		              	foreach ($data as $key => $value) {
							array_push($filedocument,$value);						
			            }
              		}else{
              			if(file_exists("uploads/fileapps/dsqia/".$getfile->Path_SuratPlacement)){              				
			            	$metafile = array(
							        'namefile'=>$getfile->Path_SuratPlacement,
							        'sourcefile'=>'penarikan_placement',
							        'datefile'=>date("Y-m-d h:i:s"),
							    );
							$this->db->insert('meta_file_new',$metafile);
							$idmeta = $this->db->insert_id();
							array_push($filedocument,$idmeta);
              			}else{
							array_push($filedocument,$getfile->Path_SuratPlacement);
              			}
              		}

            	}
                for($i=0;$i<$counting;$i++){
        			if( !empty($_FILES['Path_SuratPlacement']['name'][$i]) ){        			    
                          // Define new $_FILES array - $_FILES['file']
                          $_FILES['file']['name'] = $_FILES['Path_SuratPlacement']['name'][$i];
                          $_FILES['file']['type'] = $_FILES['Path_SuratPlacement']['type'][$i];
                          $_FILES['file']['tmp_name'] = $_FILES['Path_SuratPlacement']['tmp_name'][$i];
                          $_FILES['file']['error'] = $_FILES['Path_SuratPlacement']['error'][$i];
                          $_FILES['file']['size'] = $_FILES['Path_SuratPlacement']['size'][$i];
                          
        				$config = array(
        					'upload_path'=> './uploads/fileapps/dsqia/',
        					'allowed_types'=>'*',
        					'max_size'=>3000000,
        					'encrypt_name'=>true,
        					'file_name' => $_FILES['Path_SuratPlacement']['name'][$i],
        				);

        				$this->upload->initialize($config);
        				
        				if( $this->upload->do_upload('file') ){
        					/*$this->session->set_flashdata('error',$this->upload->display_errors());
        					redirect(base_url('iht/'.url_title(strtolower($this->name)).'/add'));*/        					
        					$uploadData = $this->upload->data();
        					$metafile = array(
        					        'namefile'=>$uploadData['file_name'],
        					        'sourcefile'=>'penarikan_placement',
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
			
			$data = array(
				'Flag_SuratPlacement_TelahTerbit'=>$sudah,
				'Tgl_Tarik_SuratPlacement'=>date('Y-m-d'),
				'No_Surat_Placement'=>$nosur,
				'Tgl_SuratPlacement'=>$tglsurat,
				'Ditempatkan_diTingkatanKelas'=>$kelas,
				'Path_SuratPlacement'=>$filedocument
			);
			
			$countsyarat = count($this->input->post("Syarat_Placement"));
			for($i=0;$i<$countsyarat;$i++){
				$no = $i+1;
				$str = "Syarat_Placement_{$no}";
				$data[$str] = $this->input->post("Syarat_Placement")[$i];
			}
			
			$this->db->query("update mst_peserta set ditempatkan='$kelas' where Id_Peserta='$id'");
            
            recordlog("Merubah Data ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('konektifitas-ds-qia/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-penarikan-surat');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat Detail Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/konektifitas-ds-qia/".url_title(strtolower($this->name))."/view",$data);
	}	
}
