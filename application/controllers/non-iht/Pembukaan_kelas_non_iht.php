<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembukaan_kelas_non_iht extends CI_Controller {
 	protected  $name = 'Pembukaan kelas non iht'; 
    protected  $model = 'pelatihan/non-iht/Rnoniht_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Non-IHT'; 
 	protected  $breadcrumb3 = 'SK Pembukaan Kelas Reguler'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-pembukaan-kelas-non-iht');
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
		recordlog("Melihat Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/non-iht/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->Desc_DokBukaKlsReguler;
            $row[] = "SK Pembukaan Kelas Reguler Nomor ".$field->No_Klsreguler;
            $row[] = $field->Rencana_TempatSelenggara; 
            $row[] = $this->multiplefile($field->File_Lampiran);
            $row[] = $this->actiontable($field->Id_DokBukaKlsReguler);

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
	
	public function multiplefile($data)
	{
	    if($data != null){
	        $check = @unserialize($data);
            if ($check !== false) {
                $data = unserialize($data);
                $rs = '';
                $i =1;
                $find = 0;
                foreach($data as $dt){
                    if($dt == '' || $dt == 'a:0:{}' || $dt == 'a_0_{}'){ 
                        $find = $find+1;
                    }else{
                        $rs .= '<a href="'.base_url('uploads/fileapps/non-iht/'.$dt).'" download><i class="fa fa-download"></i> File Lampiran '.($i-$find).'</a><br>';
                    }
                    $i++;
                }
                return $rs;
            } else {
                return '<a href="'.base_url('uploads/fileapps/non-iht/'.$data).'" download><i class="fa fa-download"></i> File Lampiran</a>';
            }
	    }else{
	        return '<code>N/A</code>';
	    }
	    
	   // ($field->File_Lampiran != null)? '<a href="'.base_url('uploads/fileapps/non-iht/'.$field->File_Lampiran).'" download><i class="fa fa-download"></i> File Lampiran</a>' : '<code>N/A</code>';
	}

	public function actiontable($id){
		if(accessperm('melihat-data-pembukaan-kelas-non-iht')){
			$btn = "<a href='".base_url('non-iht/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-pembukaan-kelas-non-iht')){
			$btn .= "<a href='".base_url('non-iht/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-pembukaan-kelas-non-iht')){
			$btn .= "<a href='".base_url('non-iht/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-pembukaan-kelas-non-iht');
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
		recordlog("Mengakses Data Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/non-iht/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-pembukaan-kelas-non-iht');	
		
		$description = $this->security->xss_clean(html_escape($this->input->post("Desc_DokBukaKlsReguler")));
		$tempat = $this->security->xss_clean(html_escape($this->input->post("Rencana_TempatSelenggara")));
		$file = $this->security->xss_clean(html_escape($this->input->post("File_Lampiran")));

		$this->form_validation->set_rules('Desc_DokBukaKlsReguler', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Rencana_TempatSelenggara', 'Rencana_TempatSelenggara', 'trim|required|xss_clean');
		$this->form_validation->set_rules('File_Lampiran', 'File_Lampiran', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('non-iht/'.url_title(strtolower($this->name)).'/add'));
		}else{

			$this->load->library('upload');

			/*if( !empty($_FILES['File_Lampiran']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/non-iht/',
					'allowed_types'=>'xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
					'max_size'=>1000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('File_Lampiran') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('non-iht/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData = $this->upload->data();
					$filedocument = $uploadData['file_name'];
                	$filedocument = $filedocument;
				}
			}else{
				$filedocument = null;
			}	
            */
            
              $counting = count($_FILES['File_Lampiran']['name']);
            
            if($counting > 0){
                $filedocument = array();
                for($i=0;$i<$counting;$i++){
        			if( !empty($_FILES['File_Lampiran']['name'][$i]) ){
        			    
                          // Define new $_FILES array - $_FILES['file']
                          $_FILES['file']['name'] = $_FILES['File_Lampiran']['name'][$i];
                          $_FILES['file']['type'] = $_FILES['File_Lampiran']['type'][$i];
                          $_FILES['file']['tmp_name'] = $_FILES['File_Lampiran']['tmp_name'][$i];
                          $_FILES['file']['error'] = $_FILES['File_Lampiran']['error'][$i];
                          $_FILES['file']['size'] = $_FILES['File_Lampiran']['size'][$i];
                          
                        
                          
        				$config = array(
        					'upload_path'=> './uploads/fileapps/non-iht/',
        					'allowed_types'=>'*',
        					'max_size'=>3000000,
        					'encrypt_name'=>true,
        					'file_name' => $_FILES['File_Lampiran']['name'][$i],
        				);
        				$this->upload->initialize($config);
        				
        				if( $this->upload->do_upload('file') ){
        					/*$this->session->set_flashdata('error',$this->upload->display_errors());
        					redirect(base_url('iht/'.url_title(strtolower($this->name)).'/add'));*/
        					
        					$uploadData = $this->upload->data();
        					//$filedocument = $uploadData['file_name'];
        					array_push($filedocument,$uploadData['file_name']);
        					
        					$metafile = array(
        					        'namefile'=>$uploadData['file_name'],
        					        'datefile'=>date("Y-m-d h:i:s"),
        					    );
        					$this->db->insert('meta_file',$metafile);
        				}
        			} 
                }
            }else{
				$filedocument = null;
			}	
			
			if($filedocument != null){
			    $filedocument = serialize($filedocument);
			}else{
			    $filedocument = null;
			}
            
            $maks  = $this->db->query("select max(No_Klsreguler) as Maks from mst_dokbukaklsreguler")->row_array();
			$count = $maks['Maks'] + 1;
            
			$data = array(
				'No_Klsreguler'=>$count,
				'Desc_DokBukaKlsReguler'=>$description,
				'Rencana_TempatSelenggara'=>$tempat,
				'File_Lampiran'=>$filedocument
			);
            
            recordlog("Menambahkan Data ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('non-iht/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-pembukaan-kelas-non-iht');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Data Edit ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/non-iht/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-pembukaan-kelas-non-iht');

		
		$description = $this->security->xss_clean(html_escape($this->input->post("Desc_DokBukaKlsReguler")));
		$tempat = $this->security->xss_clean(html_escape($this->input->post("Rencana_TempatSelenggara")));
		$file = $this->security->xss_clean(html_escape($this->input->post("File_Lampiran")));

		$this->form_validation->set_rules('Desc_DokBukaKlsReguler', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('Rencana_TempatSelenggara', 'Rencana_TempatSelenggara', 'trim|required|xss_clean');
		$this->form_validation->set_rules('File_Lampiran', 'File_Lampiran', 'trim|xss_clean');


		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('non-iht/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{

			$this->load->library('upload');
			$getfile = $this->thismodel->getrecord($id);
			
			$counting = count($_FILES['File_Lampiran']['name']);
            
            if($counting > 0){
                $filedocument = array();
                if( @unserialize($getfile->File_Lampiran) !=  false){
	                if(count(unserialize($getfile->File_Lampiran))>0){
	                    foreach(unserialize($getfile->File_Lampiran) as $val){
        	               array_push($filedocument,$val);
        	            }
	                }
                }else{
                    if($getfile->File_Lampiran != null || $getfile->File_Lampiran <> null || $getfile->File_Lampiran != '' || $getfile->File_Lampiran <> '' || $getfile->File_Lampiran != 'a:0:{}'){
                        array_push($filedocument,$getfile->File_Lampiran);
                    }
                }
                for($i=0;$i<$counting;$i++){
        			if( !empty($_FILES['File_Lampiran']['name'][$i]) ){
        			    
                          // Define new $_FILES array - $_FILES['file']
                          $_FILES['file']['name'] = $_FILES['File_Lampiran']['name'][$i];
                          $_FILES['file']['type'] = $_FILES['File_Lampiran']['type'][$i];
                          $_FILES['file']['tmp_name'] = $_FILES['File_Lampiran']['tmp_name'][$i];
                          $_FILES['file']['error'] = $_FILES['File_Lampiran']['error'][$i];
                          $_FILES['file']['size'] = $_FILES['File_Lampiran']['size'][$i];
                          
        				$config = array(
        					'upload_path'=> './uploads/fileapps/non-iht/',
        					'allowed_types'=>'*',
        					'max_size'=>1000000,
        					'encrypt_name'=>true,
        					'file_name' => $_FILES['File_Lampiran']['name'][$i],
        				);
        				$this->upload->initialize($config);
        				
        				if( $this->upload->do_upload('file') ){
        					/*$this->session->set_flashdata('error',$this->upload->display_errors());
        					redirect(base_url('iht/'.url_title(strtolower($this->name)).'/add'));*/
        					
        					$uploadData = $this->upload->data();
        					//$filedocument = $uploadData['file_name'];
        					array_push($filedocument,$uploadData['file_name']);
        					
        					$metafile = array(
        					        'namefile'=>$uploadData['file_name'],
        					        'datefile'=>date("Y-m-d h:i:s"),
        					    );
        					$this->db->insert('meta_file',$metafile);
        				}
        			} 
                }
                
			    $filedocument = serialize($filedocument);
            }else{
				$filedocument = $getfile->File_Lampiran;
			}	


			$data = array(
				'Desc_DokBukaKlsReguler'=>$description,
				'Rencana_TempatSelenggara'=>$tempat,
				'File_Lampiran'=>$filedocument
			);
			
			recordlog("Merubah Data ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('non-iht/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-pembukaan-kelas-non-iht');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		recordlog("Melihat Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/non-iht/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-pembukaan-kelas-non-iht');

		$cekkls = $this->db->where(array('idskreguler'=>$id))->get('trm_pembukaankelas_n_angkatan');
    	if($cekkls->num_rows()>0){
    		$qr = $cekkls->row();
    		$status = 'true';
    	}else{
    		$status = '';
    	}

    	if($status == 'true'){

			echo "<div class='alert alert-info'>
  				<strong>Info!</strong> Anda tidak bisa hapus ini karena kelas sudah dibuka
				</div>";

    	}else{

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('non-iht/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
		}
	}

	public function delete_exec($id){
		permissions('menghapus-data-pembukaan-kelas-non-iht');
		$getfile = $this->thismodel->getrecord($id);
	/*	if($getfile->File_Lampiran != null || $getfile->File_Lampiran <> null || $getfile->File_Lampiran != '' || $getfile->File_Lampiran <> ''){
			if(file_exists('./uploads/fileapps/non-iht/'.$getfile->File_Lampiran)){
				unlink('./uploads/fileapps/non-iht/'.$getfile->File_Lampiran);
			}
		}*/
		recordlog("Menghapus Data ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'non-iht/'.url_title(strtolower($this->name)) ) );
	}
	
	public function delete_file($idperforma,$filename){
	    $check = $this->db->where(array('Id_DokBukaKlsReguler'=>$idperforma))->get("mst_dokbukaklsreguler");
	    if($check->num_rows()>0){
	       $check = $check->row();
	       if( @unserialize($check->File_Lampiran) !=  false){
	           if(count(unserialize($check->File_Lampiran))>0){
    	           $file = array();
    	           foreach(unserialize($check->File_Lampiran) as $val){
    	               if($val == $filename){
        	                if($check->File_Lampiran != null || $check->File_Lampiran <> null || $check->File_Lampiran != '' || $check->File_Lampiran <> ''){
                    			if(file_exists('./uploads/fileapps/non-iht/'.$check->File_Lampiran)){
                    				unlink('./uploads/fileapps/non-iht/'.$check->File_Lampiran);
                    			}
                    		} 
    	               }else{
    	                   array_push($file,$val);
    	               }
    	           }
	               $fileaa = serialize($file);
	           }else{
	               $fileaa = null;
	           }
	           $data = array(
	               'File_Lampiran'=>$fileaa
	               );
	           $this->db->where(array('Id_DokBukaKlsReguler'=>$idperforma))->update("mst_dokbukaklsreguler",$data);
	       }else{
	           	if($check->File_Lampiran != null || $check->File_Lampiran <> null || $check->File_Lampiran != '' || $check->File_Lampiran <> ''){
        			if(file_exists('./uploads/fileapps/non-iht/'.$check->File_Lampiran)){
        				unlink('./uploads/fileapps/non-iht/'.$check->File_Lampiran);
        			}
        		}
        		$data = array(
	               'File_Lampiran'=>null
	               );
	            $this->db->where(array('Id_DokBukaKlsReguler'=>$idperforma))->update("mst_dokbukaklsreguler",$data);
	       }
	    }
	}

	
}
