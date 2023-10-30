<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kontrak_spk_resmi extends CI_Controller {
 	protected  $name = 'Kontrak spk resmi'; 
    protected  $model = 'pelatihan/iht/Rkontrakresmi_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'IHT'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	/* start old error */
		/*public function index(){
			permissions('melihat-data-kontrak-spk-resmi');
			$urlnow = uri_string();
			$data2 = array(
				'breadcrumb1'=>$this->breadcrumb1,
				'breadcrumb2'=>$this->breadcrumb2,
				'breadcrumb3'=>'Kontrak Resmi',
				'titlepage'=>'Kontrak Resmi',
				'subtitlepage'=>'Data Kontrak Resmi',
				'titlebox'=>'Manage Kontrak Resmi',
				'urlback'=>$this->db->where("url",$urlnow)->get("menu")
			);
			$this->templatecus->dashboard('pages/modul/pelatihan/iht/proforma-kontrak/index',$data2);
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
	            $row[] = $field->Desc_KontrakResmi;
	            //$row[] = $field->Desc_ProformaKontrak;
	            $row[] = $field->Desc_PershInstansi;
	            $row[] = number_format($field->Nilai_Rp);
	            $row[] = $field->Rencana_JmlPeserta;
	            $row[] = $field->Rencana_TempatSelenggara;            
	            $row[] = ($field->File_Lampiran != null)? '<a href="'.base_url('uploads/fileapps/'.$field->File_Lampiran).'" download><i class="fa fa-download"></i> File Lampiran</a>' : '<code>N/A</code>';
	            $row[] = $this->actiontable($field->Id_KontrakResmi);

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
			if(accessperm('melihat-data-kontrak-spk-resmi')){
				$btn = "<a href='".base_url('iht/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-box-tool view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a>";
	        }else{
				$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
	        }
			if(accessperm('merubah-data-kontrak-spk-resmi')){
				$btn .= "<a href='".base_url('iht/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-box-tool' data-toggle='tooltip'
	                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a>";
	        }else{
				$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
	        }
			if(accessperm('menghapus-data-kontrak-spk-resmi')){
				$btn .= "<a href='".base_url('iht/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-box-tool delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
	        }else{
				$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
	        }	
	        return $btn;
		}

		public function add(){
			permissions('menambahkan-data-kontrak-spk-resmi');
			$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
			$data = array(
				'breadcrumb1'=>$this->breadcrumb1,
				'breadcrumb2'=>$this->breadcrumb2,
				'breadcrumb3'=>'Kontrak Resmi',
				'titlepage'=>'Kontrak Resmi',
				'subtitlepage'=>'Data Kontrak Resmi',
				'titlebox'=>'Add Kontrak Resmi',
				'fid_pershinstansi'=>$this->db->get("mst_pershinstansi"),
				'fid_proformakontrak'=>$this->db->get("mst_proformakontrak"),
				'urlback'=>$this->db->where("url",$urlnow)->get("menu")
			);
			$this->templatecus->dashboard('pages/modul/pelatihan/iht/'.url_title(strtolower($this->name)).'/add',$data);
		}

		public function store(){	
			permissions('menambahkan-data-kontrak-spk-resmi');	

				$desc = $this->security->xss_clean(html_escape($this->input->post("Desc_KontrakResmi")));
				$fipro = $this->security->xss_clean(html_escape($this->input->post("FId_ProformaKontrak")));
				$fipers = $this->security->xss_clean(html_escape($this->input->post("FId_PershInstansi")));
				$nilai = $this->security->xss_clean(html_escape($this->input->post("Nilai_Rp")));
				$jmlpeserta = $this->security->xss_clean(html_escape($this->input->post("Rencana_JmlPeserta")));
				$tempat = $this->security->xss_clean(html_escape($this->input->post("Rencana_TempatSelenggara")));
				$file = $this->security->xss_clean(html_escape($this->input->post("File_Lampiran")));
				$filesblm = $this->security->xss_clean(html_escape($this->input->post("filesebelumnya")));

				$this->form_validation->set_rules('Desc_KontrakResmi', 'Description Kontrak Resmi', 'trim|required|xss_clean');
				$this->form_validation->set_rules('FId_ProformaKontrak', 'Description Proforma Kontrak', 'trim|required|xss_clean');
				$this->form_validation->set_rules('FId_PershInstansi', 'Perusahaan Instansi', 'trim|required|xss_clean');
				$this->form_validation->set_rules('Nilai_Rp', 'Nilai Rp', 'trim|required|xss_clean');
				$this->form_validation->set_rules('Rencana_JmlPeserta', 'Rencana Jml Peserta', 'trim|required|xss_clean');
				$this->form_validation->set_rules('Rencana_TempatSelenggara', 'Rencana Tempat Selenggara', 'trim|required|xss_clean');
				$this->form_validation->set_rules('File_Lampiran', 'File Lampiran', 'trim|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
				redirect(base_url('iht/'.url_title(strtolower($this->name)).'/add'));
			}else{

				$this->load->library('upload');

				if( !empty($_FILES['File_Lampiran']['name']) ){
					$config = array(
						'upload_path'=> './uploads/fileapps/kontrakresmi/',
						'allowed_types'=>'xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
						'max_size'=>1000000,
						'encrypt_name'=>true
					);
					$this->upload->initialize($config);
					if( !$this->upload->do_upload('File_Lampiran') ){
						$this->session->set_flashdata('error',$this->upload->display_errors());
						redirect(base_url('iht/'.url_title(strtolower($this->name)).'/add'));
					}else{
						$uploadData = $this->upload->data();
						$filedocument = $uploadData['file_name'];
	                	$filedocument = 'kontrakresmi/'.$filedocument;
					}
				}else{
					$filedocument = 'proformakontrak/'.$filesblm;
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
				$this->thismodel->insertdt($data);
				$this->session->set_flashdata('success', 'Data berhasil di simpan');
				redirect(base_url('iht/'.url_title(strtolower($this->name)).'/add'));
			}
		}

		public function edit($id){
			permissions('merubah-data-kontrak-spk-resmi');
			$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
			$data = array(
				'breadcrumb1'=>$this->breadcrumb1,
				'breadcrumb2'=>$this->breadcrumb2,
				'breadcrumb3'=>'Kontrak Resmi',
				'titlepage'=>'Kontrak Resmi',
				'subtitlepage'=>'Data Kontrak Resmi',
				'titlebox'=>'Edit Kontrak Resmi',		
				'dtdefault'=>$this->thismodel->getrecord($id),
				'fid_pershinstansi'=>$this->db->get("mst_pershinstansi"),
				'fid_proformakontrak'=>$this->db->get("mst_proformakontrak"),
				'urlback'=>$this->db->where("url",$urlnow)->get("menu")
			);
			$this->templatecus->dashboard('pages/modul/pelatihan/iht/'.url_title(strtolower($this->name)).'/edit',$data);
		}

		public function update($id){	
			permissions('merubah-data-kontrak-spk-resmi');	

				$desc = $this->security->xss_clean(html_escape($this->input->post("Desc_KontrakResmi")));
				$fipro = $this->security->xss_clean(html_escape($this->input->post("FId_ProformaKontrak")));
				$fipers = $this->security->xss_clean(html_escape($this->input->post("FId_PershInstansi")));
				$nilai = $this->security->xss_clean(html_escape($this->input->post("Nilai_Rp")));
				$jmlpeserta = $this->security->xss_clean(html_escape($this->input->post("Rencana_JmlPeserta")));
				$tempat = $this->security->xss_clean(html_escape($this->input->post("Rencana_TempatSelenggara")));
				$file = $this->security->xss_clean(html_escape($this->input->post("File_Lampiran")));
				$filesblm = $this->security->xss_clean(html_escape($this->input->post("filesebelumnya")));

				$this->form_validation->set_rules('Desc_KontrakResmi', 'Description Kontrak Resmi', 'trim|required|xss_clean');
				$this->form_validation->set_rules('FId_ProformaKontrak', 'Description Proforma Kontrak', 'trim|required|xss_clean');
				$this->form_validation->set_rules('FId_PershInstansi', 'Perusahaan Instansi', 'trim|required|xss_clean');
				$this->form_validation->set_rules('Nilai_Rp', 'Nilai Rp', 'trim|required|xss_clean');
				$this->form_validation->set_rules('Rencana_JmlPeserta', 'Rencana Jml Peserta', 'trim|required|xss_clean');
				$this->form_validation->set_rules('Rencana_TempatSelenggara', 'Rencana Tempat Selenggara', 'trim|required|xss_clean');
				$this->form_validation->set_rules('File_Lampiran', 'File Lampiran', 'trim|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
				redirect(base_url('iht/'.url_title(strtolower($this->name)).'/edit/'.$id));
			}else{
				$this->load->library('upload');
				$getfile = $this->thismodel->getrecord($id);
			
				if( !empty($_FILES['File_Lampiran']['name']) ){
					$config = array(
						'upload_path'=> './uploads/fileapps/kontrakresmi/',
						'allowed_types'=>'xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
						'max_size'=>1000000,
						'encrypt_name'=>true
					);
					$this->upload->initialize($config);
					if( !$this->upload->do_upload('File_Lampiran') ){
						$this->session->set_flashdata('error',$this->upload->display_errors());
						redirect(base_url('iht/'.url_title(strtolower($this->name)).'/add'));
					}else{
						$uploadData = $this->upload->data();
						$filedocument = $uploadData['file_name'];
	                	$filedocument = 'kontrakresmi/'.$filedocument;

						if($getfile->File_Lampiran != null || $getfile->File_Lampiran <> null || $getfile->File_Lampiran != '' || $getfile->File_Lampiran <> ''){
							if (strpos($getfile->File_Lampiran, 'proformakontrak') !== false) {

							}else{
								if(file_exists('./uploads/fileapps/'.$getfile->File_Lampiran)){
									unlink('./uploads/fileapps/'.$getfile->File_Lampiran);
								}				
							}
						}
					}
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

				$this->thismodel->updatedt($data,$id);
				$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
				redirect(base_url('iht/'.url_title(strtolower($this->name)).'/edit/'.$id));
			}
		}

		public function view($id){
			permissions('melihat-data-kontrak-spk-resmi');
			$data = array(
				'dtdefault'=>$this->thismodel->getrecordjoin($id)
			);
			$this->load->view("pages/modul/pelatihan/iht/".url_title(strtolower($this->name))."/view",$data);
		}
		
		public function delete($id){
			permissions('menghapus-data-kontrak-spk-resmi');

			echo "Anda yakin ini menghapus data ini ? <br/><hr/>";
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

		public function delete_exec($id){
			permissions('menghapus-data-kontrak-spk-resmi');
			$getfile = $this->thismodel->getrecord($id);
			if($getfile->File_Lampiran != null || $getfile->File_Lampiran <> null || $getfile->File_Lampiran != '' || $getfile->File_Lampiran <> ''){
				if (strpos($getfile->File_Lampiran, 'proformakontrak') !== false) {

				}else{
					if(file_exists('./uploads/fileapps/'.$getfile->File_Lampiran)){
						unlink('./uploads/fileapps/'.$getfile->File_Lampiran);
					}				
				}
			}
			$this->thismodel->deletedt($id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url( 'iht/'.url_title(strtolower($this->name)) ) );
		}

		*/
	/* end old error */

	/* new */
/*	public function indexnew($proforma){
		permissions('melihat-data-kontrak-spk-resmi');
		$urlnow = uri_string();
		$data2 = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Kontrak Resmi',
			'titlepage'=>'Kontrak Resmi',
			'subtitlepage'=>'Data Kontrak Resmi',
			'titlebox'=>'Manage Kontrak Resmi',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
			'kontrakresmi'=>$this->db
       		 ->select('mst_kontrakresmi.Id_KontrakResmi,mst_kontrakresmi.Desc_KontrakResmi, mst_proformakontrak.Desc_ProformaKontrak , mst_pershinstansi.Desc_PershInstansi , mst_kontrakresmi.Nilai_Rp , mst_kontrakresmi.Rencana_JmlPeserta , mst_kontrakresmi.Rencana_TempatSelenggara , mst_kontrakresmi.File_Lampiran')
	        ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_kontrakresmi.FId_PershInstansi",'left')
	        ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=mst_kontrakresmi.FId_ProformaKontrak",'left')
			->where("FId_ProformaKontrak",$proforma)->get("mst_kontrakresmi"),
			'nameproforma'=>$this->db			
        	->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_proformakontrak.FId_PershInstansi",'left')
			->where("Id_ProformaKontrak",$proforma)->get("mst_proformakontrak"),
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/iht/kontrak-spk-resmi/new/index',$data2);
	}

	public function editnew($proforma,$kontrak){
		permissions('merubah-data-kontrak-spk-resmi');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$mstproforma = $this->db->where(array("Id_ProformaKontrak"=>$proforma))->get("mst_proformakontrak");
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Kontrak Resmi',
			'titlepage'=>'Kontrak Resmi',
			'subtitlepage'=>'Data Kontrak Resmi',
			'titlebox'=>'Edit Kontrak Resmi',		
			'dtdefault'=>$this->thismodel->getrecord($kontrak),
			'fid_pershinstansi'=>$this->db->where(array("Id_PershInstansi"=>$mstproforma->row()->FId_PershInstansi))->get("mst_pershinstansi"),
			'fid_proformakontrak'=>$mstproforma,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/iht/'.url_title(strtolower($this->name)).'/new/edit',$data);
	}

	public function updatenew($proforma,$id){
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
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('iht/'.url_title(strtolower($this->name))."/".$proforma.'/edit/'.$id));
		}else{
			$this->load->library('upload');
			$getfile = $this->thismodel->getrecord($id);

			if( !empty($_FILES['File_Lampiran']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/kontrakresmi/',
					'allowed_types'=>'xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
					'max_size'=>1000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('File_Lampiran') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('iht/'.url_title(strtolower($this->name))."/".$proforma.'/edit/'.$id));
				}else{
					$uploadData = $this->upload->data();
					$filedocument = $uploadData['file_name'];
                	$filedocument = $filedocument;
				}
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

			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('iht/'.url_title(strtolower($this->name))."/".$proforma));
		}
	}

	public function addnew($proforma){
		permissions('menambahkan-data-kontrak-spk-resmi');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$mstproforma = $this->db->where(array("Id_ProformaKontrak"=>$proforma))->get("mst_proformakontrak");
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Kontrak Resmi',
			'titlepage'=>'Kontrak Resmi',
			'subtitlepage'=>'Data Kontrak Resmi',
			'titlebox'=>'Edit Kontrak Resmi',		
			'fid_pershinstansi'=>$this->db->where(array("Id_PershInstansi"=>$mstproforma->row()->FId_PershInstansi))->get("mst_pershinstansi"),
			'fid_proformakontrak'=>$mstproforma,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
			'proforma'=>$proforma
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/iht/'.url_title(strtolower($this->name)).'/new/add',$data);

	}

	public function storenew($proforma){			
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
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('iht/'.url_title(strtolower($this->name))."/".$proforma.'/add'));
		}else{
			$this->load->library('upload');

			if( !empty($_FILES['File_Lampiran']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/kontrakresmi/',
					'allowed_types'=>'xls|ppt|pptx|pdf|csv|pptx|txt|text|doc|docx|xlsx|word|xl',
					'max_size'=>1000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('File_Lampiran') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('iht/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData = $this->upload->data();
					$filedocument = $uploadData['file_name'];
                	$filedocument = $filedocument;
				}
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
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('iht/'.url_title(strtolower($this->name))."/".$proforma.''));
		}

	}


	public function deletenew($proforma,$id){
		permissions('menghapus-data-kontrak-spk-resmi');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('iht/'.url_title(strtolower($this->name))."/".$proforma."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_execnew($proforma,$id){
		permissions('menghapus-data-kontrak-spk-resmi');
		$getfile = $this->thismodel->getrecord($id);
		if($getfile->File_Lampiran != null || $getfile->File_Lampiran <> null || $getfile->File_Lampiran != '' || $getfile->File_Lampiran <> ''){
			/*if (strpos($getfile->File_Lampiran, 'proformakontrak') !== false) {

			}else{
				if(file_exists('./uploads/fileapps/kontrakresmi/'.$getfile->File_Lampiran)){
					unlink('./uploads/fileapps/kontrakresmi/'.$getfile->File_Lampiran);
				}				
			/*}
		}
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'iht/'.url_title(strtolower($this->name))."/".$proforma ) );
	}*/
	
}
