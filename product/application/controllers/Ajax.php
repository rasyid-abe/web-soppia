<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller { 
	function __construct(){
		parent::__construct();
		if($this->session->userdata('status') != "login-service" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}

	public function proforma($id){
		permissions('melihat-data-proforma-kontrak');
		$profor = $this->db
			->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_proformakontrak.FId_PershInstansi",'left')
			->where("Id_ProformaKontrak",$id)->get("mst_proformakontrak");
		$data = array(
			"proforma"=>$profor,
			"acc_jur"=>$this->db->where(array("FId_Proforma"=>$id,"Flag_Proforma_or_Kelas"=>"P"))->get("trm_sub_journal_soppia")
		);
     	recordlog("Mengakses Halaman Proforma");
		$this->load->view("pages/ajax/proforma",$data);
	}

	/* start kontrakresmi*/
		public function kontrakresmi($proforma){
			permissions('melihat-data-kontrak-spk-resmi');
			$data = array(
				'kontrakresmi'=>$this->db
					->select('mst_kontrakresmi.Id_KontrakResmi,mst_kontrakresmi.Desc_KontrakResmi, mst_proformakontrak.Desc_ProformaKontrak , mst_pershinstansi.Desc_PershInstansi , mst_kontrakresmi.Nilai_Rp , mst_kontrakresmi.Rencana_JmlPeserta , mst_kontrakresmi.Rencana_TempatSelenggara , mst_kontrakresmi.File_Lampiran')
			        ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_kontrakresmi.FId_PershInstansi",'left')
			        ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=mst_kontrakresmi.FId_ProformaKontrak",'left')
					->where(array("mst_kontrakresmi.FId_ProformaKontrak"=>$proforma))->get("mst_kontrakresmi"),
				'proforma'=> $this->db->where(array("Id_ProformaKontrak"=>$proforma))->get("mst_proformakontrak"),
			    "acc_jur"=>$this->db->where(array("FId_Proforma"=>$proforma,"Flag_Proforma_or_Kelas"=>"P"))->get("trm_sub_journal_soppia")
			);
     		recordlog("Mengakses Halaman Kontrak resmi");
			$this->load->view("pages/ajax/kontrakresmi",$data);
		}
		public function deletekontrakresmi($proforma,$kontrakresmi){
			permissions('menghapus-data-kontrak-spk-resmi');

			echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
			echo '<div class="container-fluid" style="margin:0;padding:0">'; 
				echo '<div class="col-sm-i2"> 
		          <div class="col-sm-6" style="margin:0;padding:0">
		            <a href="'.base_url('ajax/deletekontrakresmiexe/'.$proforma.'/'.$kontrakresmi).'" class="btn btn-default btn-block btn-flat">Ya</a>
		          </div>
		          <div class="col-sm-6" style="margin:0;padding:0">
		            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
		          </div>
		        </div>';
			echo '</div>';
		}
		public function deletekontrakresmiexe($proforma,$kontrakresmi){
			permissions('menghapus-data-kontrak-spk-resmi');
     		recordlog("Menghapus Data Kontrak resmi");
			$getfile = $this->db->where("Id_KontrakResmi",$kontrakresmi)->get("mst_kontrakresmi")->row();
		/*	if($getfile->File_Lampiran != null || $getfile->File_Lampiran <> null || $getfile->File_Lampiran != '' || $getfile->File_Lampiran <> ''){
				if(file_exists('./uploads/fileapps/kontrakresmi/'.$getfile->File_Lampiran)){
					unlink('./uploads/fileapps/kontrakresmi/'.$getfile->File_Lampiran);
				}				
			}*/
			$this->db->where("Id_KontrakResmi",$kontrakresmi)->delete("mst_kontrakresmi");
			$this->db->where("FId_ProformaKontrak",$proforma)->delete("mst_addendumkontrak");
			        $cekproforma = $this->db->where(array("Id_ProformaKontrak"=>$proforma))->get("mst_proformakontrak");
    			    if($cekproforma->num_rows()>0){
    			     $dataupdate = array(
    					'Nilai_Rps'=>$cekproforma->row()->Nilai_Rp,
    					);
    				$this->db->where("FId_Proforma",$proforma)->update("trm_sub_journal_soppia",$dataupdate);
			        }
			  
			$this->session->set_flashdata(
				array(
					'success'=>'Data berhasil di perbaharui',
					'active'=>'kontrakresmi'
				)
			);
			redirect(base_url( 'iht/sub-proforma/'.$proforma ) );
		}

		public function kontrakresmiadd($proforma){
			permissions('menambahkan-data-kontrak-spk-resmi');
			$mstproforma = $this->db->where(array("Id_ProformaKontrak"=>$proforma))->get("mst_proformakontrak");
			$data = array(	
				'fid_pershinstansi'=>$this->db->where(array("Id_PershInstansi"=>$mstproforma->row()->FId_PershInstansi))->get("mst_pershinstansi"),
				'fid_proformakontrak'=>$mstproforma,
				'proforma'=>$proforma
			);
     		recordlog("Mengakses halaman add Kontrak resmi");
			$this->load->view("pages/ajax/kontrakresmiadd",$data);
		}

		public function kontrakresmistore($proforma){
			permissions('menambahkan-data-kontrak-spk-resmi');	

			$desc = $this->security->xss_clean(html_escape($this->input->post("Desc_KontrakResmi")));
			$fipro = $this->security->xss_clean(html_escape($this->input->post("FId_ProformaKontrak")));
			$fipers = $this->security->xss_clean(html_escape($this->input->post("FId_PershInstansi")));
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
			$filesblm = $this->security->xss_clean(html_escape($this->input->post("filesebelumnya")));

			$this->form_validation->set_rules('Desc_KontrakResmi', 'Description Kontrak Resmi', 'trim|required|xss_clean');
			$this->form_validation->set_rules('FId_ProformaKontrak', 'Description Proforma Kontrak', 'trim|xss_clean');
			$this->form_validation->set_rules('FId_PershInstansi', 'Perusahaan Instansi', 'trim|xss_clean');
			$this->form_validation->set_rules('Nilai_Rp', 'Nilai Rp', 'trim|xss_clean');
			$this->form_validation->set_rules('Rencana_JmlPeserta', 'Rencana Jml Peserta', 'trim|xss_clean');
			$this->form_validation->set_rules('Rencana_TempatSelenggara', 'Rencana Tempat Selenggara', 'trim|xss_clean');
			$this->form_validation->set_rules('File_Lampiran', 'File Lampiran', 'trim|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata(
					array(
						'error'=>validation_errors(),
						'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())),
						'active'=>'kontrakresmi'
					)
				);
				redirect(base_url( 'iht/sub-proforma/'.$proforma ) );
			}else{
				$this->load->library('upload');
/*
				if( !empty($_FILES['File_Lampiran']['name']) ){
					$config = array(
						'upload_path'=> './uploads/fileapps/kontrakresmi/',
						'allowed_types'=>'xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
						'encrypt_name'=>true
					);
					$this->upload->initialize($config);
					if( !$this->upload->do_upload('File_Lampiran') ){
						$this->session->set_flashdata(
							array(
								'error'=>$this->upload->display_errors(),
								'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())),
								'active'=>'kontrakresmi'
							)
						);
						redirect(base_url( 'iht/sub-proforma/'.$proforma ) );
					}else{
						$uploadData = $this->upload->data();
						$filedocument = $uploadData['file_name'];
	                	$filedocument = $filedocument;
					}
				}else{
					$filedocument = null;
				}	*/


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
        					'upload_path'=> './uploads/fileapps/kontrakresmi/',
        					'allowed_types'=>'*',
        					'max_size'=>10000000,
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
			
				$data = array(
					'Desc_KontrakResmi'=>$desc,
					'FId_ProformaKontrak'=>$fipro,
					'FId_PershInstansi'=>$fipers,
					'Nilai_Rp'=>$nilai,
					'Rencana_JmlPeserta'=>$jmlpeserta,
					'Rencana_TempatSelenggara'=>$tempat,
					'File_Lampiran'=>$filedocument,
				);
				$this->db->set('Id_KontrakResmi', 'UUID()', FALSE);
				$this->db->insert("mst_kontrakresmi",$data);

				$dataupdate = array(
					'Nilai_Rps'=>$nilai
					);
				$this->db->where("FId_Proforma",$proforma)->update("trm_sub_journal_soppia",$dataupdate);

				$this->session->set_flashdata(
					array(
						'success'=>'Data berhasil disimpan',
						'active'=>'kontrakresmi'
					)
				);
     			recordlog("Menambahkan data Kontrak resmi");
				redirect(base_url( 'iht/sub-proforma/'.$proforma ) );
			}
		}

		public function kontrakresmiedit($proforma,$kontrakresmi){
			permissions('merubah-data-kontrak-spk-resmi');
			$mstproforma = $this->db->where(array("Id_ProformaKontrak"=>$proforma))->get("mst_proformakontrak");
			$data = array(
				'dtdefault'=>$this->db->where("Id_KontrakResmi",$kontrakresmi)->get("mst_kontrakresmi")->row(),
				'fid_pershinstansi'=>$this->db->where(array("Id_PershInstansi"=>$mstproforma->row()->FId_PershInstansi))->get("mst_pershinstansi"),
				'fid_proformakontrak'=>$mstproforma,
			);
     		recordlog("Mengakses halaman edit Kontrak resmi");
			$this->load->view("pages/ajax/kontrakresmiedit",$data);
		}
		public function kontrakresmiupdate($proforma,$kontrakresmi){
			permissions('merubah-data-kontrak-spk-resmi');	

			$desc = $this->security->xss_clean(html_escape($this->input->post("Desc_KontrakResmi")));
			$fipro = $this->security->xss_clean(html_escape($this->input->post("FId_ProformaKontrak")));
			$fipers = $this->security->xss_clean(html_escape($this->input->post("FId_PershInstansi")));
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
			$filesblm = $this->security->xss_clean(html_escape($this->input->post("filesebelumnya")));

			$this->form_validation->set_rules('Desc_KontrakResmi', 'Description Kontrak Resmi', 'trim|required|xss_clean');
			$this->form_validation->set_rules('FId_ProformaKontrak', 'Description Proforma Kontrak', 'trim|xss_clean');
			$this->form_validation->set_rules('FId_PershInstansi', 'Perusahaan Instansi', 'trim|xss_clean');
			$this->form_validation->set_rules('Nilai_Rp', 'Nilai Rp', 'trim|xss_clean');
			$this->form_validation->set_rules('Rencana_JmlPeserta', 'Rencana Jml Peserta', 'trim|xss_clean');
			$this->form_validation->set_rules('Rencana_TempatSelenggara', 'Rencana Tempat Selenggara', 'trim|xss_clean');
			$this->form_validation->set_rules('File_Lampiran', 'File Lampiran', 'trim|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata(
					array(
						'error'=>validation_errors(),
						'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())),
						'active'=>'kontrakresmi'
					)
				);
				redirect(base_url( 'iht/sub-proforma/'.$proforma ) );
			}else{
				$this->load->library('upload');
				$getfile = $this->db->where("Id_KontrakResmi",$kontrakresmi)->get("mst_kontrakresmi")->row();

				/*if( !empty($_FILES['File_Lampiran']['name']) ){
					$config = array(
						'upload_path'=> './uploads/fileapps/kontrakresmi/',
						'allowed_types'=>'xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
						'encrypt_name'=>true
					);
					$this->upload->initialize($config);
					if( !$this->upload->do_upload('File_Lampiran') ){
						$this->session->set_flashdata(
							array(
								'error'=>$this->upload->display_errors(),
								'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())),
								'active'=>'kontrakresmi'
							)
						);
						redirect(base_url( 'iht/sub-proforma/'.$proforma ) );
					}else{

						if($getfile->File_Lampiran != null || $getfile->File_Lampiran <> null || $getfile->File_Lampiran != '' || $getfile->File_Lampiran <> ''){
							if(file_exists('./uploads/fileapps/kontrakresmi/'.$getfile->File_Lampiran)){
								unlink('./uploads/fileapps/kontrakresmi/'.$getfile->File_Lampiran);
							}				
						}

						$uploadData = $this->upload->data();
						$filedocument = $uploadData['file_name'];
	                	$filedocument = $filedocument;

	                	
					}
				}else{
					$filedocument = $getfile->File_Lampiran;
				}	*/
				

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
        					'upload_path'=> './uploads/fileapps/kontrakresmi/',
        					'allowed_types'=>'*',
        					'max_size'=>10000000,
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
					'Desc_KontrakResmi'=>$desc,
					'FId_ProformaKontrak'=>$fipro,
					'FId_PershInstansi'=>$fipers,
					'Nilai_Rp'=>$nilai,
					'Rencana_JmlPeserta'=>$jmlpeserta,
					'Rencana_TempatSelenggara'=>$tempat,
					'File_Lampiran'=>$filedocument,
				);

				$this->db->where("Id_KontrakResmi",$kontrakresmi)->update("mst_kontrakresmi",$data);

				$dataupdate = array(
					'Nilai_Rps'=>$nilai
					);
				$this->db->where("FId_Proforma",$proforma)->update("trm_sub_journal_soppia",$dataupdate);
				
				$this->session->set_flashdata(
					array(
						'success'=>'Data berhasil diperbaharui',
						'active'=>'kontrakresmi'
					)
				);
     			recordlog("Merubah data Kontrak resmi");
				redirect(base_url( 'iht/sub-proforma/'.$proforma ) );
			}
		}
	/* end kontrakresmi*/

	public function addendum($proforma,$nurot){
		permissions('melihat-data-addendum');
			$data = array(
				'addendum'=>$this->db
					->select('mst_addendumkontrak.Id_AddKontrak,mst_addendumkontrak.No_Urut_Add,mst_addendumkontrak.Desc_AddKontrak, mst_proformakontrak.Desc_ProformaKontrak , mst_pershinstansi.Desc_PershInstansi , mst_addendumkontrak.Nilai_Rp , mst_addendumkontrak.Rencana_JmlPeserta , mst_addendumkontrak.Rencana_TempatSelenggara , mst_addendumkontrak.File_Lampiran')
			        ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_addendumkontrak.FId_PershInstansi",'left')
			        ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=mst_addendumkontrak.FId_ProformaKontrak",'left')
					->where(array("mst_addendumkontrak.FId_ProformaKontrak"=>$proforma,"No_Urut_Add"=>$nurot))->get("mst_addendumkontrak"),
				'proforma'=> $this->db->where(array("Id_ProformaKontrak"=>$proforma))->get("mst_proformakontrak"),
			    "acc_jur"=>$this->db->where(array("FId_Proforma"=>$proforma,"Flag_Proforma_or_Kelas"=>"P"))->get("trm_sub_journal_soppia")
			);
     		recordlog("Mengakses Halaman addendum");
			$this->load->view("pages/ajax/addendum",$data);
	}
	public function deleteaddendum($proforma,$addendum){
		permissions('menghapus-data-addendum');
		$getfile = $this->db->where("Id_AddKontrak",$addendum)->get("mst_addendumkontrak")->row();
			echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
			echo '<div class="container-fluid" style="margin:0;padding:0">'; 
				echo '<div class="col-sm-i2"> 
		          <div class="col-sm-6" style="margin:0;padding:0">
		            <a href="'.base_url('ajax/deleteaddendumexe/'.$proforma.'/'.$addendum.'/'.$getfile->No_Urut_Add).'" class="btn btn-default btn-block btn-flat">Ya</a>
		          </div>
		          <div class="col-sm-6" style="margin:0;padding:0">
		            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
		          </div>
		        </div>';
			echo '</div>';
	}
	public function deleteaddendumexe($proforma,$addendum,$nourut){
			permissions('menghapus-data-addendum');
     		recordlog("Menghapus Data addendum");
			$getfile = $this->db->where("Id_AddKontrak",$addendum)->get("mst_addendumkontrak")->row();
			/*if($getfile->File_Lampiran != null || $getfile->File_Lampiran <> null || $getfile->File_Lampiran != '' || $getfile->File_Lampiran <> ''){
				if(file_exists('./uploads/fileapps/addendum/'.$getfile->File_Lampiran)){
					unlink('./uploads/fileapps/addendum/'.$getfile->File_Lampiran);
				}				
			}*/
			$this->db->where("Id_AddKontrak",$addendum)->delete("mst_addendumkontrak");
			$cekadd = $this->db->select("max(No_Urut_Add) as No_Urut_Add")->where(array("FId_ProformaKontrak"=>$proforma))->get("mst_addendumkontrak");
			if($cekadd->num_rows() > 0 && $cekadd->row()->No_Urut_Add != null){
			    $cekadd1 = $this->db->where(array("FId_ProformaKontrak"=>$proforma,"No_Urut_Add"=>$cekadd->row()->No_Urut_Add))->get("mst_addendumkontrak");
			    $dataupdate = array(
					'Nilai_Rps'=>$cekadd1->row()->Nilai_Rp,
					);
				$this->db->where("FId_Proforma",$proforma)->update("trm_sub_journal_soppia",$dataupdate);
			}else{
			    $cekkontrak = $this->db->where(array("FId_ProformaKontrak"=>$proforma))->get("mst_kontrakresmi");
			    if($cekkontrak->num_rows()>0){
			     $dataupdate = array(
					'Nilai_Rps'=>$cekkontrak->row()->Nilai_Rp,
					);
				$this->db->where("FId_Proforma",$proforma)->update("trm_sub_journal_soppia",$dataupdate);
			    }
			}
			$this->session->set_flashdata(
				array(
					'success'=>'Data berhasil di perbaharui',
				)
			);
			redirect(base_url( 'iht/sub-proforma/'.$proforma) );
		}
	public function addendumedit($proforma,$addendum){
			permissions('merubah-data-addendum');
			$mstproforma = $this->db->where(array("Id_ProformaKontrak"=>$proforma))->get("mst_proformakontrak");
			$data = array(
				'dtdefault'=>$this->db->where("Id_AddKontrak",$addendum)->get("mst_addendumkontrak")->row(),
				'fid_pershinstansi'=>$this->db->where(array("Id_PershInstansi"=>$mstproforma->row()->FId_PershInstansi))->get("mst_pershinstansi"),
				'fid_proformakontrak'=>$mstproforma,
			);
     		recordlog("Mengakses halaman edit addendum");
			$this->load->view("pages/ajax/addendumedit",$data);
		}
	public function addendumadd($proforma){
		permissions('menambahkan-data-addendum');

		$profor = $this->db
			->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_proformakontrak.FId_PershInstansi",'left')
			->where("Id_ProformaKontrak",$proforma)->get("mst_proformakontrak");

		$mstproforma = $this->db->where(array("Id_ProformaKontrak"=>$proforma))->get("mst_proformakontrak");
		$data = array(
			"proforma"=>$profor,
			'fid_pershinstansi'=>$this->db->where(array("Id_PershInstansi"=>$mstproforma->row()->FId_PershInstansi))->get("mst_pershinstansi"),
			'fid_proformakontrak'=>$mstproforma,
		);
     		recordlog("Mengakses halaman Add addendum");
		$this->load->view("pages/ajax/addendumadd",$data);
	}
	public function addendumupdate($proforma,$addendum){
		permissions('merubah-data-addendum');	

			$desc = $this->security->xss_clean(html_escape($this->input->post("Desc_KontrakResmi")));
			$fipro = $this->security->xss_clean(html_escape($this->input->post("FId_ProformaKontrak")));
			$fipers = $this->security->xss_clean(html_escape($this->input->post("FId_PershInstansi")));
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
			$filesblm = $this->security->xss_clean(html_escape($this->input->post("filesebelumnya")));

			$this->form_validation->set_rules('Desc_KontrakResmi', 'Description Addendum', 'trim|required|xss_clean');
			$this->form_validation->set_rules('FId_ProformaKontrak', 'Description Proforma Kontrak', 'trim|xss_clean');
			$this->form_validation->set_rules('FId_PershInstansi', 'Perusahaan Instansi', 'trim|xss_clean');
			$this->form_validation->set_rules('Nilai_Rp', 'Nilai Rp', 'trim|xss_clean');
			$this->form_validation->set_rules('Rencana_JmlPeserta', 'Rencana Jml Peserta', 'trim|xss_clean');
			$this->form_validation->set_rules('Rencana_TempatSelenggara', 'Rencana Tempat Selenggara', 'trim|xss_clean');
			$this->form_validation->set_rules('File_Lampiran', 'File Lampiran', 'trim|xss_clean');

			$getfile = $this->db->where("Id_AddKontrak",$addendum)->get("mst_addendumkontrak")->row();

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata(
					array(
						'error'=>validation_errors(),
						'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())),
						'active'=>'addendum_'.$getfile->No_Urut_Add
					)
				);
				redirect(base_url( 'iht/sub-proforma/'.$proforma ) );
			}else{
				$this->load->library('upload');

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
        					'upload_path'=> './uploads/fileapps/addendum/',
        					'allowed_types'=>'*',
        					'max_size'=>10000000,
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
					'Desc_AddKontrak'=>$desc,
					'FId_ProformaKontrak'=>$fipro,
					'FId_PershInstansi'=>$fipers,
					'Nilai_Rp'=>$nilai,
					'Rencana_JmlPeserta'=>$jmlpeserta,
					'Rencana_TempatSelenggara'=>$tempat,
					'File_Lampiran'=>$filedocument,
				);

				$this->db->where("Id_AddKontrak",$addendum)->update("mst_addendumkontrak",$data);

				$dataupdate = array(
					'Nilai_Rps'=>$nilai
					);
				$this->db->where("FId_Proforma",$proforma)->update("trm_sub_journal_soppia",$dataupdate);

				$this->session->set_flashdata(
					array(
						'success'=>'Data berhasil diperbaharui',
						'active'=>'addendum_'.$getfile->No_Urut_Add
					)
				);
     			recordlog("Merubah data addendum");
				redirect(base_url( 'iht/sub-proforma/'.$proforma ) );
			}
	}

	public function addendumstore($proforma){
			permissions('menambahkan-data-addendum');	

			$desc = $this->security->xss_clean(html_escape($this->input->post("Desc_KontrakResmi")));
			$fipro = $this->security->xss_clean(html_escape($this->input->post("FId_ProformaKontrak")));
			$fipers = $this->security->xss_clean(html_escape($this->input->post("FId_PershInstansi")));
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
			$filesblm = $this->security->xss_clean(html_escape($this->input->post("filesebelumnya")));

			$this->form_validation->set_rules('Desc_KontrakResmi', 'Description Addendum', 'trim|required|xss_clean');
			$this->form_validation->set_rules('FId_ProformaKontrak', 'Description Proforma Kontrak', 'trim|xss_clean');
			$this->form_validation->set_rules('FId_PershInstansi', 'Perusahaan Instansi', 'trim|xss_clean');
			$this->form_validation->set_rules('Nilai_Rp', 'Nilai Rp', 'trim|xss_clean');
			$this->form_validation->set_rules('Rencana_JmlPeserta', 'Rencana Jml Peserta', 'trim|xss_clean');
			$this->form_validation->set_rules('Rencana_TempatSelenggara', 'Rencana Tempat Selenggara', 'trim|xss_clean');
			$this->form_validation->set_rules('File_Lampiran', 'File Lampiran', 'trim|xss_clean');

				$ceknourut = $this->db->where(array("FId_ProformaKontrak"=>$proforma))->get("mst_addendumkontrak");
				if($ceknourut->num_rows()>0){
					$nourut = (int)$ceknourut->num_rows()+1;
				}else{
					$nourut = 1;
				}

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata(
					array(
						'error'=>validation_errors(),
						'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())),
						'active'=>'addendum_'.$nourut
					)
				);
				redirect(base_url( 'iht/sub-proforma/'.$proforma ) );
			}else{
				$this->load->library('upload');

				/*if( !empty($_FILES['File_Lampiran']['name']) ){
					$config = array(
						'upload_path'=> './uploads/fileapps/addendum/',
						'allowed_types'=>'xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
						'encrypt_name'=>true
					);
					$this->upload->initialize($config);
					if( !$this->upload->do_upload('File_Lampiran') ){
						$this->session->set_flashdata(
							array(
								'error'=>$this->upload->display_errors(),
								'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())),
								'active'=>'addendum_'.$nourut
							)
						);
						redirect(base_url( 'iht/sub-proforma/'.$proforma ) );
					}else{
						$uploadData = $this->upload->data();
						$filedocument = $uploadData['file_name'];
	                	$filedocument = $filedocument;
					}
				}else{
					$filedocument = null;
				}*/
				
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
        					'upload_path'=> './uploads/fileapps/addendum/',
        					'allowed_types'=>'*',
        					'max_size'=>10000000,
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
			
				$data = array(
					'Desc_AddKontrak'=>$desc,
					'FId_ProformaKontrak'=>$fipro,
					'FId_PershInstansi'=>$fipers,
					'No_Urut_Add'=>$nourut,
					'Nilai_Rp'=>$nilai,
					'Rencana_JmlPeserta'=>$jmlpeserta,
					'Rencana_TempatSelenggara'=>$tempat,
					'File_Lampiran'=>$filedocument,
				);
				$this->db->set('Id_AddKontrak', 'UUID()', FALSE);
				$this->db->insert("mst_addendumkontrak",$data);

				$dataupdate = array(
					'Nilai_Rps'=>$nilai
					);
				$this->db->where("FId_Proforma",$proforma)->update("trm_sub_journal_soppia",$dataupdate);

				$this->session->set_flashdata(
					array(
						'success'=>'Data berhasil disimpan',
						'active'=>'addendum_'.$nourut
					)
				);
     			recordlog("Menambahkan data addendum");
				redirect(base_url( 'iht/sub-proforma/'.$proforma ) );
			}
	}
	
	public function addendumcheck($num ,$id){
	    $cek = $this->db->where(array('FId_ProformaKontrak'=>$id))->get("mst_addendumkontrak");
	    if($cek->num_rows()>0){
	        $rs = array(
	               'status'=>true,
	               'jum'=>$cek->num_rows(),
	            );
	    }else{
	          $rs = array(
	               'status'=>false,
	               'jum'=>0,
	            );
	    }
	    
	    echo  json_encode($rs);
	}
	
	
	public function delete_file_kontrak_resmi($idperforma,$filename){
	    $check = $this->db->where(array('Id_KontrakResmi'=>$idperforma))->get("mst_kontrakresmi");
	    if($check->num_rows()>0){
	       $check = $check->row();
	       if( @unserialize($check->File_Lampiran) !=  false){
	           if(count(unserialize($check->File_Lampiran))>0){
    	           $file = array();
    	           foreach(unserialize($check->File_Lampiran) as $val){
    	               if($val == $filename){
        	                if($check->File_Lampiran != null || $check->File_Lampiran <> null || $check->File_Lampiran != '' || $check->File_Lampiran <> ''){
                    			if(file_exists('./uploads/fileapps/kontrakresmi/'.$check->File_Lampiran)){
                    				unlink('./uploads/fileapps/kontrakresmi/'.$check->File_Lampiran);
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
	           $this->db->where(array('Id_KontrakResmi'=>$idperforma))->update("mst_kontrakresmi",$data);
	       }else{
	           	if($check->File_Lampiran != null || $check->File_Lampiran <> null || $check->File_Lampiran != '' || $check->File_Lampiran <> ''){
        			if(file_exists('./uploads/fileapps/kontrakresmi/'.$check->File_Lampiran)){
        				unlink('./uploads/fileapps/kontrakresmi/'.$check->File_Lampiran);
        			}
        		}
        		$data = array(
	               'File_Lampiran'=>null
	               );
	            $this->db->where(array('Id_KontrakResmi'=>$idperforma))->update("mst_kontrakresmi",$data);
	       }
	    }
	}
	
	public function delete_file_addendum($idperforma,$filename){
	    $check = $this->db->where(array('Id_AddKontrak'=>$idperforma))->get("mst_addendumkontrak");
	    if($check->num_rows()>0){
	       $check = $check->row();
	       if( @unserialize($check->File_Lampiran) !=  false){
	           if(count(unserialize($check->File_Lampiran))>0){
    	           $file = array();
    	           foreach(unserialize($check->File_Lampiran) as $val){
    	               if($val == $filename){
        	                if($check->File_Lampiran != null || $check->File_Lampiran <> null || $check->File_Lampiran != '' || $check->File_Lampiran <> ''){
                    			if(file_exists('./uploads/fileapps/addendum/'.$check->File_Lampiran)){
                    				unlink('./uploads/fileapps/addendum/'.$check->File_Lampiran);
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
	           $this->db->where(array('Id_AddKontrak'=>$idperforma))->update("mst_addendumkontrak",$data);
	       }else{
	           	if($check->File_Lampiran != null || $check->File_Lampiran <> null || $check->File_Lampiran != '' || $check->File_Lampiran <> ''){
        			if(file_exists('./uploads/fileapps/addendum/'.$check->File_Lampiran)){
        				unlink('./uploads/fileapps/addendum/'.$check->File_Lampiran);
        			}
        		}
        		$data = array(
	               'File_Lampiran'=>null
	               );
	            $this->db->where(array('Id_AddKontrak'=>$idperforma))->update("mst_addendumkontrak",$data);
	       }
	    }
	}

}