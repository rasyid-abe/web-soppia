<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftaran extends CI_Controller {
 	protected  $name = 'Pendaftaran'; 
    protected  $model = 'pelatihan/instruktur/Rdaftar_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Instruktur'; 
 	protected  $breadcrumb3 = 'Pendaftaran'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-pendaftaran');
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
		recordlog("Mengakses Halaman Data Instruktur ".$this->name);
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
            $row[] = ($field->FilePhoto!= null)? '<img src="'.base_url("uploads/photo/".$field->FilePhoto).'" width="50px" height="50px"></img>' : '<code>N/A</code>';
            $row[] = ($field->NIIS!= null)? $field->NIIS : '<code>N/A</code>';
            $row[] = $field->NamaLengkap_DgnGelar;
            $row[] = ($field->NamaPershInstansi!= null)? $field->NamaPershInstansi : '<code>N/A</code>';
            $row[] = ($field->Jabatan_NamaUnitOrganisasi!= null)? $field->Jabatan_NamaUnitOrganisasi : '<code>N/A</code>';
            $row[] = $this->actiontable($field->Id_Instruktur,$field->Flag_Deleted);

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
		if(accessperm('melihat-data-pendaftaran')){
			$btn = "<a href='".base_url('instruktur/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-pendaftaran')){
			$btn .= "<a href='".base_url('instruktur/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-pendaftaran')){
			$btn .= "<a href='".base_url('instruktur/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-pendaftaran');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'gelar'=>$this->db->get("ref_gelar"),
			'sertifikasi'=>$this->db->get("ref_sertifikasi"),
			'jeniskelamin'=>$this->db->get("ref_jeniskelamin"),
			'agama'=>$this->db->get("ref_agama"),
			'stratapendidikan'=>$this->db->get("ref_stratapendidikan"),
			'bidangpendidikan'=>$this->db->get("ref_bidangpendidikan"),
			'perusahaaninstansi'=>$this->db->get("mst_pershinstansi"),
			'bidangunitorganisasi'=>$this->db->get("ref_bidang_of_unitorganisasi"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add Instruktur ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/instruktur/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-pendaftaran');	

		$niis = $this->security->xss_clean(html_escape($this->input->post("niis")));
		$nik = $this->security->xss_clean(html_escape($this->input->post("nik")));
		$nl_no_g = $this->security->xss_clean(html_escape($this->input->post("nl_no_g")));
		$nl_w_g = $this->security->xss_clean(html_escape($this->input->post("nl_w_g")));
		$np = $this->security->xss_clean(html_escape($this->input->post("np")));
		$gelar = $this->security->xss_clean(html_escape($this->input->post("gelar")));
		$sertifikasi = $this->security->xss_clean(html_escape($this->input->post("sertifikasi")));
		$photo = $this->security->xss_clean(html_escape($this->input->post("avatar")));
		$kotalahir = $this->security->xss_clean(html_escape($this->input->post("kotalahir")));
		$tgllahir = $this->security->xss_clean(html_escape($this->input->post("tgllahir")));
		$jeniskelamin = $this->security->xss_clean(html_escape($this->input->post("jeniskelamin")));
		$agama = $this->security->xss_clean(html_escape($this->input->post("agama")));
		$stratapendidikan = $this->security->xss_clean(html_escape($this->input->post("stratapendidikan")));
		$bidangpendidikan = $this->security->xss_clean(html_escape($this->input->post("bidangpendidikan")));
		$perusahaaninstansi = $this->security->xss_clean(html_escape($this->input->post("perusahaaninstansi")));
		$namaperusahaaninstansi = $this->security->xss_clean(html_escape($this->input->post("namaperusahaaninstansi")));
		$alamatkantor = $this->security->xss_clean(html_escape($this->input->post("alamatkantor")));
		$telpkantor = $this->security->xss_clean(html_escape($this->input->post("telpkantor")));
		$emailkantor = $this->security->xss_clean(html_escape($this->input->post("emailkantor")));
		$bidangunitorganisasi = $this->security->xss_clean(html_escape($this->input->post("bidangunitorganisasi")));
		$jabatanunitorganisasi = $this->security->xss_clean(html_escape($this->input->post("jabatanunitorganisasi")));
		$alamatrumah = $this->security->xss_clean(html_escape($this->input->post("alamatrumah")));
		$telprumah = $this->security->xss_clean(html_escape($this->input->post("telprumah")));
		$nohp = $this->security->xss_clean(html_escape($this->input->post("nohp")));
		$emailpribadi = $this->security->xss_clean(html_escape($this->input->post("emailpribadi")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("Keterangan")));

		$this->form_validation->set_rules('niis', 'Nomer Induk Instruktur YPIA', 'trim|required|is_unique[mst_instruktur.NIIS]|xss_clean');
		$this->form_validation->set_rules('nik', 'Nomer Induk Kependudukan', 'trim|required|is_unique[mst_instruktur.NIK]|xss_clean');
		$this->form_validation->set_rules('nl_no_g', 'Nama Lengkap Tanpa Gelar', 'trim|xss_clean');
		$this->form_validation->set_rules('nl_w_g', 'Nama Lengkap Dengan Gelar', 'trim|xss_clean');
		$this->form_validation->set_rules('np', 'Nama Panggilan', 'trim|xss_clean');
		$this->form_validation->set_rules('avatar', 'Foto Peserta', 'trim|xss_clean');
		$this->form_validation->set_rules('kotalahir', 'Kota Lahir', 'trim|xss_clean');
		$this->form_validation->set_rules('tgllahir', 'Tanggal Lahir', 'trim|xss_clean');
		$this->form_validation->set_rules('jeniskelamin', 'Jenis Kelamin', 'trim|xss_clean');
		$this->form_validation->set_rules('agama', 'Agama', 'trim|xss_clean');
		$this->form_validation->set_rules('namaperusahaaninstansi', 'Nama Perusahaan/Instansi', 'trim|xss_clean');
		$this->form_validation->set_rules('alamatkantor', 'Alamat Kantor', 'trim|xss_clean');
		$this->form_validation->set_rules('telpkantor', 'Telp Kantor', 'trim|xss_clean');
		$this->form_validation->set_rules('emailkantor', 'Email Kantor', 'trim|xss_clean');
		$this->form_validation->set_rules('bidangunitorganisasi', 'Bidang Unit Organisasi', 'trim|xss_clean');
		$this->form_validation->set_rules('jabatanunitorganisasi', 'Jabatan Bidang Unit Organisasi', 'trim|xss_clean');
		$this->form_validation->set_rules('alamatrumah', 'Alamat Rumah', 'trim|xss_clean');
		$this->form_validation->set_rules('telprumah', 'Telp Rumah', 'trim|xss_clean');
		$this->form_validation->set_rules('nohp', 'No Hp', 'trim|xss_clean');
		$this->form_validation->set_rules('emailpribadi', 'Email Pribadi', 'trim|xss_clean');
		$this->form_validation->set_rules('Keterangan', 'Keterangan', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$this->load->library('upload');

			if( !empty($_FILES['avatar']['name']) ){
				$config = array(
					'upload_path'=> './uploads/photo/',
					'allowed_types'=>'png|gif|jpeg|jpg',
					'max_size'=>3000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('avatar') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData = $this->upload->data();
					$filephoto = $uploadData['file_name'];
				}
			}else{
				$filephoto = null;
			}	

			$data = array(
				'NIIS' => $niis,
				'NIK' => $nik,
				'NamaLengkap_TanpaGelar' => $nl_no_g,
				'NamaLengkap_DgnGelar' => $nl_w_g,
				'NamaPanggilan' => $np,
				'FilePhoto' => $filephoto,
				'Kota_Lahir' => $kotalahir,
				'Tgl_Lahir' => $tgllahir,
				'FKd_JnsKelamin' => $jeniskelamin,
				'FKd_Agama' => $agama,
				'FKd_StrataPendidikanTerakhir' => $stratapendidikan,
				'FId_PershInstansi' => $perusahaaninstansi,
				'NamaPershInstansi' => $namaperusahaaninstansi,
				'Alamat_Kantor' => $alamatkantor,
				'Telp_Kantor' => $telpkantor,
				'eMail_Kantor' => $emailkantor,
				'FKd_BidangUnitOrganisasi' => $bidangunitorganisasi,
				'Jabatan_NamaUnitOrganisasi' => $jabatanunitorganisasi,
				'Alamat_Rumah' => $alamatrumah,
				'Telp_Rumah' => $telprumah,
				'No_HP' => $nohp,
				'eMail_Pribadi' => $emailpribadi,
				'Keterangan' => $keterangan,
				'Entry_Date'=>date("Y-m-d"),
				'Entry_By'=>$this->session->userdata('username'),
				'Flag_Deleted'=>'N'
			);

			$countgelar = count($this->input->post("gelar"));
			$gelargelar = array();
			for($i=0;$i<$countgelar;$i++){
				array_push($gelargelar,$this->input->post("gelar")[$i]);
			}
			$data['gelar']= serialize($gelargelar);

			$countsertifikasi = count($this->input->post("sertifikasi"));
			$serftk = array();
			for($as=0;$as<$countsertifikasi;$as++){
				array_push($serftk,$this->input->post("sertifikasi")[$as]);
			}
			$data['sertifikasi']= serialize($serftk);

			$countbidangpendidikan = count($this->input->post("bidangpendidikan"));
			$bpddk = array();
			for($ass=0;$ass<$countbidangpendidikan;$ass++){
			    array_push($bpddk,$this->input->post("bidangpendidikan")[$ass]);
			}
			$data['bidangpendidikan']= serialize($bpddk);
			
			recordlog("Menyimpan Data Instruktur ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-pendaftaran');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'gelar'=>$this->db->get("ref_gelar"),
			'sertifikasi'=>$this->db->get("ref_sertifikasi"),
			'jeniskelamin'=>$this->db->get("ref_jeniskelamin"),
			'agama'=>$this->db->get("ref_agama"),
			'stratapendidikan'=>$this->db->get("ref_stratapendidikan"),
			'bidangpendidikan'=>$this->db->get("ref_bidangpendidikan"),
			'perusahaaninstansi'=>$this->db->get("mst_pershinstansi"),
			'bidangunitorganisasi'=>$this->db->get("ref_bidang_of_unitorganisasi"),
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit Data Instruktur");
		$this->templatecus->dashboard('pages/modul/pelatihan/instruktur/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-pendaftaran');
		$niis = $this->security->xss_clean(html_escape($this->input->post("niis")));
		$nik = $this->security->xss_clean(html_escape($this->input->post("nik")));
		$nl_no_g = $this->security->xss_clean(html_escape($this->input->post("nl_no_g")));
		$nl_w_g = $this->security->xss_clean(html_escape($this->input->post("nl_w_g")));
		$np = $this->security->xss_clean(html_escape($this->input->post("np")));
		$gelar = $this->security->xss_clean(html_escape($this->input->post("gelar")));
		$sertifikasi = $this->security->xss_clean(html_escape($this->input->post("sertifikasi")));
		$photo = $this->security->xss_clean(html_escape($this->input->post("avatar")));
		$kotalahir = $this->security->xss_clean(html_escape($this->input->post("kotalahir")));
		$tgllahir = $this->security->xss_clean(html_escape($this->input->post("tgllahir")));
		$jeniskelamin = $this->security->xss_clean(html_escape($this->input->post("jeniskelamin")));
		$agama = $this->security->xss_clean(html_escape($this->input->post("agama")));
		$stratapendidikan = $this->security->xss_clean(html_escape($this->input->post("stratapendidikan")));
		$bidangpendidikan = $this->security->xss_clean(html_escape($this->input->post("bidangpendidikan")));
		$perusahaaninstansi = $this->security->xss_clean(html_escape($this->input->post("perusahaaninstansi")));
		$namaperusahaaninstansi = $this->security->xss_clean(html_escape($this->input->post("namaperusahaaninstansi")));
		$alamatkantor = $this->security->xss_clean(html_escape($this->input->post("alamatkantor")));
		$telpkantor = $this->security->xss_clean(html_escape($this->input->post("telpkantor")));
		$emailkantor = $this->security->xss_clean(html_escape($this->input->post("emailkantor")));
		$bidangunitorganisasi = $this->security->xss_clean(html_escape($this->input->post("bidangunitorganisasi")));
		$jabatanunitorganisasi = $this->security->xss_clean(html_escape($this->input->post("jabatanunitorganisasi")));
		$alamatrumah = $this->security->xss_clean(html_escape($this->input->post("alamatrumah")));
		$telprumah = $this->security->xss_clean(html_escape($this->input->post("telprumah")));
		$nohp = $this->security->xss_clean(html_escape($this->input->post("nohp")));
		$emailpribadi = $this->security->xss_clean(html_escape($this->input->post("emailpribadi")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("keterangan")));

		$this->form_validation->set_rules('niis', 'Nomer Induk Instruktur YPIA', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nik', 'Nomer Induk Kependudukan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nl_no_g', 'Nama Lengkap Tanpa Gelar', 'trim|xss_clean');
		$this->form_validation->set_rules('nl_w_g', 'Nama Lengkap Dengan Gelar', 'trim|xss_clean');
		$this->form_validation->set_rules('np', 'Nama Panggilan', 'trim|xss_clean');
		$this->form_validation->set_rules('avatar', 'Foto Peserta', 'trim|xss_clean');
		$this->form_validation->set_rules('kotalahir', 'Kota Lahir', 'trim|xss_clean');
		$this->form_validation->set_rules('tgllahir', 'Tanggal Lahir', 'trim|xss_clean');
		$this->form_validation->set_rules('jeniskelamin', 'Jenis Kelamin', 'trim|xss_clean');
		$this->form_validation->set_rules('agama', 'Agama', 'trim|xss_clean');
		$this->form_validation->set_rules('namaperusahaaninstansi', 'Nama Perusahaan/Instansi', 'trim|xss_clean');
		$this->form_validation->set_rules('alamatkantor', 'Alamat Kantor', 'trim|xss_clean');
		$this->form_validation->set_rules('telpkantor', 'Telp Kantor', 'trim|xss_clean');
		$this->form_validation->set_rules('emailkantor', 'Email Kantor', 'trim|xss_clean');
		$this->form_validation->set_rules('bidangunitorganisasi', 'Bidang Unit Organisasi', 'trim|xss_clean');
		$this->form_validation->set_rules('jabatanunitorganisasi', 'Jabatan Bidang Unit Organisasi', 'trim|xss_clean');
		$this->form_validation->set_rules('alamatrumah', 'Alamat Rumah', 'trim|xss_clean');
		$this->form_validation->set_rules('telprumah', 'Telp Rumah', 'trim|xss_clean');
		$this->form_validation->set_rules('nohp', 'No Hp', 'trim|xss_clean');
		$this->form_validation->set_rules('emailpribadi', 'Email Pribadi', 'trim|xss_clean');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$this->load->library('upload');

			$dt = $this->thismodel->getrecord($id);

			if( !empty($_FILES['avatar']['name']) ){
				$config = array(
					'upload_path'=> './uploads/photo/',
					'allowed_types'=>'png|gif|jpeg|jpg',
					'max_size'=>3000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('avatar') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData = $this->upload->data();
					$filephoto = $uploadData['file_name'];
					if($dt->FilePhoto != null || $dt->FilePhoto <> null || $dt->FilePhoto != '' || $dt->FilePhoto <> ''){
						if(file_exists('./uploads/photo/'.$dt->FilePhoto)){
							unlink('./uploads/photo/'.$dt->FilePhoto);
						}
					}
				}
			}else{
				$filephoto = $dt->FilePhoto;
			}				
			
			//cek niis
            $niiscek  = $this->db->query("select Id_Instruktur from mst_instruktur where NIIS='$niis'")->num_rows();
            $niislama = $this->db->query("select Id_Instruktur from mst_instruktur where NIIS='$niis'")->row_array();
            if($niiscek > 0){
                if($niislama['Id_Instruktur'] == $id) {
                } else {
                    $this->session->set_flashdata( 'error','Terdapat NIIS Yang Sama.');
                    redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/edit/'.$id));
                }   
            }
            
            //cek nik
            $nikcek  = $this->db->query("select Id_Instruktur from mst_instruktur where NIK='$nik'")->num_rows();
            $niklama = $this->db->query("select Id_Instruktur from mst_instruktur where NIK='$nik'")->row_array();
            if($nikcek > 0){
                if($niklama['Id_Instruktur'] == $id) {
                } else {
                    $this->session->set_flashdata( 'error','Terdapat Nomer Induk Kependudukan Yang Sama.');
                    redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/edit/'.$id));
                }   
            }

			$data = array(
				'NIIS' => $niis,
				'NIK' => $nik,
				'NamaLengkap_TanpaGelar' => $nl_no_g,
				'NamaLengkap_DgnGelar' => $nl_w_g,
				'NamaPanggilan' => $np,
				'FilePhoto' => $filephoto,
				'Kota_Lahir' => $kotalahir,
				'Tgl_Lahir' => $tgllahir,
				'FKd_JnsKelamin' => $jeniskelamin,
				'FKd_Agama' => $agama,
				'FKd_StrataPendidikanTerakhir' => $stratapendidikan,
				'FId_PershInstansi' => $perusahaaninstansi,
				'NamaPershInstansi' => $namaperusahaaninstansi,
				'Alamat_Kantor' => $alamatkantor,
				'Telp_Kantor' => $telpkantor,
				'eMail_Kantor' => $emailkantor,
				'FKd_BidangUnitOrganisasi' => $bidangunitorganisasi,
				'Jabatan_NamaUnitOrganisasi' => $jabatanunitorganisasi,
				'Alamat_Rumah' => $alamatrumah,
				'Telp_Rumah' => $telprumah,
				'No_HP' => $nohp,
				'eMail_Pribadi' => $emailpribadi,
				'Keterangan' => $keterangan,
				'Last_Update'=>date("Y-m-d"),
				'Last_Update_By'=>$this->session->userdata('username'),
				'Flag_Deleted'=>'N',
			);
			
			
		    $countgelar = count($this->input->post("gelar"));
			$gelargelar = array();
			for($i=0;$i<$countgelar;$i++){
				array_push($gelargelar,$this->input->post("gelar")[$i]);
			}
			$data['gelar']= serialize($gelargelar);

			$countsertifikasi = count($this->input->post("sertifikasi"));
			$serftk = array();
			for($as=0;$as<$countsertifikasi;$as++){
				array_push($serftk,$this->input->post("sertifikasi")[$as]);
			}
			$data['sertifikasi']= serialize($serftk);

			$countbidangpendidikan = count($this->input->post("bidangpendidikan"));
			$bpddk = array();
			for($ass=0;$ass<$countbidangpendidikan;$ass++){
			    array_push($bpddk,$this->input->post("bidangpendidikan")[$ass]);
			}
			$data['bidangpendidikan']= serialize($bpddk);
		
			recordlog("Merubah Data Instruktur ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('instruktur/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-pendaftaran');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		recordlog("Mengakses Halaman Detail Instruktur".$this->name);
		$this->load->view("pages/modul/pelatihan/instruktur/".url_title(strtolower($this->name))."/view",$data);
	}
	
	public function delete($id){
		permissions('menghapus-data-pendaftaran');

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
		permissions('menghapus-data-pendaftaran');
		recordlog("Menghapus Data Instruktur ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'instruktur/'.url_title(strtolower($this->name)) ) );
	}

	
}
