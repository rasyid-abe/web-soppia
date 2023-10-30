<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proforma_kontrak extends CI_Controller {
 	protected  $name = 'Proforma kontrak'; 
    protected  $model = 'pelatihan/iht/Rproformakontrak_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'IHT'; 
 	protected  $breadcrumb3 = 'Proforma Kontrak'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-proforma-kontrak');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>'Proforma Kontrak',
			'subtitlepage'=>'Data Proforma Kontrak',
			'titlebox'=>'Manage Proforma Kontrak',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/iht/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = '<a href="'.base_url("iht/sub-proforma/".$field->Id_ProformaKontrak).'">'.$field->Desc_ProformaKontrak.'</a>' ;
            $row[] = $field->No_ProformaKontrak;
            $row[] = $field->Desc_PershInstansi;
            $row[] = number_format($field->Nilai_Rp);
            $row[] = $this->actiontable($field->Id_ProformaKontrak);

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
		if(accessperm('melihat-data-proforma-kontrak')){
			$btn = "<a href='".base_url('iht/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
        
        
		$btn .= "<a href='".base_url('iht/'.url_title(strtolower($this->name))."/print/".$id)."' class='btn btn-xs btn-info' data-toggle='tooltip' title='Print Data'> <i class='fa fa-print'></i> Print </a> ";
        
		if(accessperm('merubah-data-proforma-kontrak')){
			$btn .= "<a href='".base_url('iht/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-proforma-kontrak')){
		    $cekkontrak = $this->db->where(array("FId_ProformaKontrak"=>$id))->get("mst_kontrakresmi");
		    if($cekkontrak->num_rows() > 0){
		        $btn .= "";
		    }else{
		    	
		        	$btn .= "<a href='".base_url('iht/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	 
		       
		    }
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-proforma-kontrak');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Proforma Kontrak',
			'titlepage'=>'Proforma Kontrak',
			'subtitlepage'=>'Data Proforma Kontrak',
			'titlebox'=>'Manage Proforma Kontrak',
			'fid_pershinstansi'=>$this->db->get("mst_pershinstansi"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/iht/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-proforma-kontrak');	

		$description = $this->security->xss_clean(html_escape($this->input->post("Desc_ProformaKontrak")));
		$fid = $this->security->xss_clean(html_escape($this->input->post("FId_PershInstansi")));
		$nilaiadatitik = $this->security->xss_clean(html_escape($this->input->post("Nilai_Rp")));
		$nilai = str_replace(".", "", $nilaiadatitik);
		if($nilai == ""){
			$nilai = 0;
		}else{
			$nilai = $nilai;
		}
		$jmlpeserta = $this->security->xss_clean(html_escape($this->input->post("Rencana_JmlPeserta")));
		$tempat = $this->security->xss_clean(html_escape($this->input->post("Rencana_TempatSelenggara")));
		$file = $this->security->xss_clean(html_escape($this->input->post("File_Lampiran")));

		$this->form_validation->set_rules('Desc_ProformaKontrak', 'Description', 'trim|xss_clean');
		$this->form_validation->set_rules('FId_PershInstansi', 'FId_PershInstansi', 'trim|xss_clean');
		$this->form_validation->set_rules('Nilai_Rp', 'Nilai_Rp', 'trim|xss_clean');
		$this->form_validation->set_rules('Rencana_JmlPeserta', 'Rencana_JmlPeserta', 'trim|xss_clean');
		$this->form_validation->set_rules('Rencana_TempatSelenggara', 'Rencana_TempatSelenggara', 'trim|xss_clean');
		$this->form_validation->set_rules('File_Lampiran', 'File_Lampiran', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('iht/'.url_title(strtolower($this->name)).'/add'));
		}else{

			$this->load->library('upload');
            
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
        					'upload_path'=> './uploads/fileapps/proformakontrak/',
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

			$this->load->library("Uuid");

			$proformaid = $this->uuid->v4();
			
			$maks  = $this->db->query("select max(No_ProformaKontrak) as Maks from mst_proformakontrak")->row_array();
			$count = $maks['Maks'] + 1;
            
			$data = array(
				'Id_ProformaKontrak'=>$proformaid,
				'Desc_ProformaKontrak'=>$description,
				'FId_PershInstansi'=>$fid,
				'Nilai_Rp'=>$nilai,
				'Rencana_JmlPeserta'=>$jmlpeserta,
				'No_ProformaKontrak'=>$count,
				'Rencana_TempatSelenggara'=>$tempat,
				'File_Lampiran'=>$filedocument
			);

			$this->db->insert("mst_proformakontrak",$data);
            $countaa = $this->db->select("any_value(trm_sub_journal_soppia.FId_Proforma)")->group_by("FId_Proforma")->get("trm_sub_journal_soppia")->num_rows();
			/* start insert to mst_subaccount_soppia */
			$xasda = 2;
			for($asda=1;$asda<=$xasda;$asda++){				
				$subaccountsoppia = $this->uuid->v4();
		        $datasubaacc = array(
		        	'Kd_SubAccount'=>$subaccountsoppia,
		        	'Desc_Account'=> ($asda == 1)? 'Tagihan ( Id Proforma No '.($count).')' : 'Pendapatan Proyek ( Id Proforma No '.($count).')',
		        	'Flag_GrupAccount'=> ($asda == 1)?'A':'R',
		        	'Flag_Proforma_or_Kelas'=>'P',
		        	'idproforma'=>$proformaid,
		        	);
		        $this->db->insert("mst_subaccount_soppia",$datasubaacc); 
		        
		        $datatrm = array(
					'Tgl_Transaksi'=>date("Y-m-d"),
					'Fkd_SubAccount'=>$subaccountsoppia,
					'No_Voucher_Journal'=>($countaa+1),
					'Desc_Transaksi'=>'Special Journal Proforma Kontrak',
					'Flag_D_or_K'=>($asda == 1)?'D':'K',
					'Nilai_Rps'=>$nilai,
					'Flag_Proforma_or_Kelas'=>'P',
					'FId_Proforma'=>$proformaid,
					'Keterangan'=>'Proforma Kesepakatan Pelatihan',
					);			
		        $this->db->set('Id_Voucher_Journal', 'UUID()', FALSE);
		        $this->db->insert("trm_sub_journal_soppia",$datatrm); 
		        
			}
			/* end insert to mst_subaccount_soppia */

			/* start insert to trm_sub_journal_soppia */
    			/*for($asd=1;$asd<=$xasda;$asd++){}*/
			/* end insert to trm_sub_journal_soppia */

			recordlog("Menambahkan Data ".$this->name);

			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('iht/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-proforma-kontrak');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Proforma Kontrak',
			'titlepage'=>'Proforma Kontrak',
			'subtitlepage'=>'Data Proforma Kontrak',
			'titlebox'=>'Edit Proforma Kontrak',			
			'dtdefault'=>$this->thismodel->getrecord($id),
			'fid_pershinstansi'=>$this->db->get("mst_pershinstansi"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/iht/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-proforma-kontrak');	

		$description = $this->security->xss_clean(html_escape($this->input->post("Desc_ProformaKontrak")));
		$fid = $this->security->xss_clean(html_escape($this->input->post("FId_PershInstansi")));
		$nilaiadatitik = $this->security->xss_clean(html_escape($this->input->post("Nilai_Rp")));
		$nilai = str_replace(",", "", $nilaiadatitik);
		if($nilai == ""){
			$nilai = 0;
		}else{
			$nilai = $nilai;
		}
		$jmlpeserta = $this->security->xss_clean(html_escape($this->input->post("Rencana_JmlPeserta")));
		$tempat = $this->security->xss_clean(html_escape($this->input->post("Rencana_TempatSelenggara")));
		$file = $this->security->xss_clean(html_escape($this->input->post("File_Lampiran")));

		$this->form_validation->set_rules('Desc_ProformaKontrak', 'Description', 'trim|xss_clean');
		$this->form_validation->set_rules('FId_PershInstansi', 'FId_PershInstansi', 'trim|xss_clean');
		$this->form_validation->set_rules('Nilai_Rp', 'Nilai_Rp', 'trim|xss_clean');
		$this->form_validation->set_rules('Rencana_JmlPeserta', 'Rencana_JmlPeserta', 'trim|xss_clean');
		$this->form_validation->set_rules('Rencana_TempatSelenggara', 'Rencana_TempatSelenggara', 'trim|xss_clean');
		$this->form_validation->set_rules('File_Lampiran', 'File_Lampiran', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('iht/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{

			$this->load->library('upload');
			$getfile = $this->db->where(array('Id_ProformaKontrak'=>$id))->get("mst_proformakontrak");
			/*if( !empty($_FILES['File_Lampiran']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/proformakontrak/',
					'allowed_types'=>'xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
					'max_size'=>1000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('File_Lampiran') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('iht/'.url_title(strtolower($this->name)).'/edit/'.$id));
				}else{
                	
					if($getfile->File_Lampiran != null || $getfile->File_Lampiran <> null || $getfile->File_Lampiran != '' || $getfile->File_Lampiran <> ''){
						if(file_exists('./uploads/fileapps/proformakontrak/'.$getfile->File_Lampiran)){
							unlink('./uploads/fileapps/proformakontrak/'.$getfile->File_Lampiran);
						}
					}

					$uploadData = $this->upload->data();
					$filedocument = $uploadData['file_name'];
                	$filedocument = $filedocument;
				}
			}else{
				$filedocument = $getfile->File_Lampiran;
			}	
            */
            
            $counting = count($_FILES['File_Lampiran']['name']);
            
            if($counting > 0){
                $filedocument = array();
                $getfile = $getfile->row();
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
        					'upload_path'=> './uploads/fileapps/proformakontrak/',
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
                
			    $filedocument = serialize($filedocument);
            }else{
                $getfile = $getfile->row();
				$filedocument = $getfile->File_Lampiran;
			}	
			
			$data = array(
				'Desc_ProformaKontrak'=>$description,
				'FId_PershInstansi'=>$fid,
				'Nilai_Rp'=>$nilai,
				'Rencana_JmlPeserta'=>$jmlpeserta,
				'Rencana_TempatSelenggara'=>$tempat,
				'File_Lampiran'=>$filedocument
			);
			$this->thismodel->updatedt($data,$id);


				$dataupdate = array(
					'Nilai_Rps'=>$nilai
					);
				$this->db->where("FId_Proforma",$id)->update("trm_sub_journal_soppia",$dataupdate);
				
			recordlog("Merubah Data ".$this->name);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('iht/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-proforma-kontrak');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/iht/".url_title(strtolower($this->name))."/view",$data);
	}
	
	public function delete($id){
		permissions('menghapus-data-proforma-kontrak');

		$cekkls = $this->db->where(array('idproforma'=>$id))->get('trm_pembukaankelas_n_angkatan');
    	if($cekkls->num_rows()>0){
    		//$qr = $cekkls->row();
    		$status = true;
    	}else{
    		$status = '';
    	}

    	if($status != ''){

			echo "<div class='alert alert-info'>
  				<strong>Info!</strong> Anda tidak bisa hapus ini karena kelas sudah dibuka
				</div>";

    	}else{
			echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
			echo '<div class="container-fluid" style="margin:0;padding:0">'; 
				echo '<div class="col-sm-i2"> 
		          <div class="col-sm-6" style="margin:0;padding:0">
		            <a href="'.base_url('iht/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
		          </div>
		          <div class="col-sm-6" style="margin:0;padding:0">
		            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
		          </div>
		        </div>';
			echo '</div>';
		}
	}

	public function delete_exec($id){
		permissions('menghapus-data-proforma-kontrak');		
		$getfile = $this->thismodel->getrecord($id);
		recordlog("Menghapus Data ".$this->name);
/*
		if($getfile->File_Lampiran != null || $getfile->File_Lampiran <> null || $getfile->File_Lampiran != '' || $getfile->File_Lampiran <> ''){
			if(file_exists('./uploads/fileapps/proformakontrak/'.$getfile->File_Lampiran)){
				unlink('./uploads/fileapps/proformakontrak/'.$getfile->File_Lampiran);
			}
		}*/

		$this->db->where(array("FId_ProformaKontrak"=>$id))->delete("mst_addendumkontrak");
		$this->db->where(array("FId_ProformaKontrak"=>$id))->delete("mst_kontrakresmi");
		$this->db->where(array("FId_Proforma"=>$id))->delete("trm_sub_journal_soppia");
		$this->db->where(array("idproforma"=>$id))->delete("mst_subaccount_soppia");
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'iht/'.url_title(strtolower($this->name)) ) );
	}
	
	public function delete_file($idperforma,$filename){
	    $check = $this->db->where(array('Id_ProformaKontrak'=>$idperforma))->get("mst_proformakontrak");
	    if($check->num_rows()>0){
	       $check = $check->row();
	       if( @unserialize($check->File_Lampiran) !=  false){
	           if(count(unserialize($check->File_Lampiran))>0){
    	           $file = array();
    	           foreach(unserialize($check->File_Lampiran) as $val){
    	               if($val == $filename){
        	                if($check->File_Lampiran != null || $check->File_Lampiran <> null || $check->File_Lampiran != '' || $check->File_Lampiran <> ''){
                    			if(file_exists('./uploads/fileapps/proformakontrak/'.$check->File_Lampiran)){
                    				unlink('./uploads/fileapps/proformakontrak/'.$check->File_Lampiran);
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
	           $this->db->where(array('Id_ProformaKontrak'=>$idperforma))->update("mst_proformakontrak",$data);
	       }else{
	           	if($check->File_Lampiran != null || $check->File_Lampiran <> null || $check->File_Lampiran != '' || $check->File_Lampiran <> ''){
        			if(file_exists('./uploads/fileapps/proformakontrak/'.$check->File_Lampiran)){
        				unlink('./uploads/fileapps/proformakontrak/'.$check->File_Lampiran);
        			}
        		}
        		$data = array(
	               'File_Lampiran'=>null
	               );
	            $this->db->where(array('Id_ProformaKontrak'=>$idperforma))->update("mst_proformakontrak",$data);
	       }
	    }
	}
	
	public function print_data($id){
		$urlnow = uri_string();
	    
	    $data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>'Proforma Kontrak',
			'subtitlepage'=>'Data Proforma Kontrak',
			'titlebox'=>'Print Proforma Kontrak',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
			'proforma'=>$this->db->where(array('mst_proformakontrak.id_ProformaKontrak'=>$id))
			->select("mst_pershinstansi.*,mst_holdinggruppershinstansi.Id_GrupPershInstansi,mst_holdinggruppershinstansi.Desc_GrupPershInstansi,mst_proformakontrak.*")
			->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_proformakontrak.FId_PershInstansi","left")
			->join("mst_holdinggruppershinstansi","mst_holdinggruppershinstansi.Id_GrupPershInstansi = mst_pershinstansi.FId_GrupPershInstansi","left")
			->get("mst_proformakontrak"),
			'kontrakresmi' => $this->db->where(array('FId_ProformaKontrak'=>$id))->get("mst_kontrakresmi"),
			'addendum' => $this->db->where(array('FId_ProformaKontrak'=>$id))->order_by('No_Urut_Add','ASC')->get("mst_addendumkontrak")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/iht/print_index',$data);
	}

	
}
