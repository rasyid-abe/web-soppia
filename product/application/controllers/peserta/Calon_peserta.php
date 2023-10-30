<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calon_peserta extends CI_Controller {
 	protected  $name = 'Calon peserta'; 
    protected  $model = 'pelatihan/peserta/Rcalonpeserta_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Peserta'; 
 	protected  $breadcrumb3 = 'Calon Peserta'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-calon-peserta');
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
		$this->templatecus->dashboard('pages/modul/pelatihan/peserta/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = ($field->NIPP!= null)? $field->NIPP : '<code>N/A</code>';
            $row[] = ($field->NamaLengkap_DgnGelar!= null)? $field->NamaLengkap_DgnGelar : '<code>N/A</code>';
            $row[] = ($field->NamaPershInstansi!= null)? $field->NamaPershInstansi : '<code>N/A</code>';
            $row[] = $this->actiontable($field->Id_Peserta,$field->Flag_Deleted);

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

	public function actiontable($id,$del){
	    $btn = '<div class="btn-group">';
		if(accessperm('melihat-data-calon-peserta')){
			$btn .= "<a href='".base_url('peserta/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }
		if(accessperm('merubah-data-calon-peserta')){
			$btn .= "<a href='".base_url('peserta/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }
		if(accessperm('posting-calon-peserta')){
			$btn .= "<a data-href='".base_url('peserta/'.url_title(strtolower($this->name))."/posting/".$id)."' class='btn btn-xs btn-success posting-data-posting' data-toggle='tooltip' title='Posting Data'> <i class='fa fa-legal'></i> Posting </a> ";	
        }	
		if(accessperm('menghapus-data-calon-peserta')){
			$btn .= "<a href='".base_url('peserta/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }	
        $btn .= '</div>';
  
        return $btn;
	}

	public function posting($id){
		$find = $this->db->where(array('Id_Peserta'=>$id))->get("mst_peserta");		
		if($find->num_rows()>0){
			/*if($find->row()->Flag_CalonPeserta == "N"){
				$data = array(
					'Flag_CalonPeserta'=>"Y",
					'Last_Posting_Date'=>date("Y-m-d"),
					'Last_Posting_By'=>$this->session->userdata("username"),
				);
			}else{*/
				$data = array(
					'Flag_CalonPeserta'=>"N",
					'Last_Posting_Date'=>date("Y-m-d"),
					'Last_Posting_By'=>$this->session->userdata("username"),
				);
			/*}*/
			$this->db->where(array('Id_Peserta'=>$find->row()->Id_Peserta))->update("mst_peserta",$data);
			echo "Sukses";
		}else{
			echo "Gagal";
		}
	}

	public function notifsendto($role){
		$user = $this->db->where(array('idrole'=>$role))->get("roleuser");
		$data = array(
			'to_id'=>$user->row()->iduser,
			'jenis'=>'pembukaanpeserta',
			);
        $this->db->set('idnotif', 'UUID()', FALSE);
		$this->db->insert("tb_notif",$data);
	}

	public function add(){
		permissions('menambahkan-data-calon-peserta');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
			'gelar'=>$this->db->get("ref_gelar"),
			'sertifikasi'=>$this->db->get("ref_sertifikasi"),
			'jeniskelamin'=>$this->db->get("ref_jeniskelamin"),
			'agama'=>$this->db->get("ref_agama"),
			'stratapendidikan'=>$this->db->get("ref_stratapendidikan"),
			'bidangpendidikan'=>$this->db->get("ref_bidangpendidikan"),
			'perusahaaninstansi'=>$this->db->get("mst_pershinstansi"),
			'bidangunitorganisasi'=>$this->db->get("ref_bidang_of_unitorganisasi"),
		);
		recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/peserta/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-calon-peserta');	

		$nipp = checknullpost($this->security->xss_clean(html_escape($this->input->post("nipp"))));
		$nik = checknullpost($this->security->xss_clean(html_escape($this->input->post("nik"))));		
		$nl_no_g = checknullpost($this->security->xss_clean(html_escape($this->input->post("nl_no_g"))));
		$nl_w_g = checknullpost($this->security->xss_clean(html_escape($this->input->post("nl_w_g"))));
		$np = checknullpost($this->security->xss_clean(html_escape($this->input->post("np"))));
		$gelar = checknullpost($this->security->xss_clean(html_escape($this->input->post("gelar"))));
		$sertifikasi = checknullpost($this->security->xss_clean(html_escape($this->input->post("sertifikasi"))));
		$photo = checknullpost($this->security->xss_clean(html_escape($this->input->post("avatar"))));
		$kotalahir = checknullpost($this->security->xss_clean(html_escape($this->input->post("kotalahir"))));
		$tgllahir = checknullpost($this->security->xss_clean(html_escape($this->input->post("tgllahir"))));
		$jeniskelamin = checknullpost($this->security->xss_clean(html_escape($this->input->post("jeniskelamin"))));
		$agama = checknullpost($this->security->xss_clean(html_escape($this->input->post("agama"))));
		$stratapendidikan = checknullpost($this->security->xss_clean(html_escape($this->input->post("stratapendidikan"))));
		$bidangpendidikan = checknullpost($this->security->xss_clean(html_escape($this->input->post("bidangpendidikan"))));
		$perusahaaninstansi = checknullpost($this->security->xss_clean(html_escape($this->input->post("perusahaaninstansi"))));
		$namaperusahaaninstansi = checknullpost($this->security->xss_clean(html_escape($this->input->post("namaperusahaaninstansi"))));
		$alamatkantor = checknullpost($this->security->xss_clean(html_escape($this->input->post("alamatkantor"))));
		$telpkantor = checknullpost($this->security->xss_clean(html_escape($this->input->post("telpkantor"))));
		$emailkantor = checknullpost($this->security->xss_clean(html_escape($this->input->post("emailkantor"))));
		$bidangunitorganisasi = checknullpost($this->security->xss_clean(html_escape($this->input->post("bidangunitorganisasi"))));
		$jabatanunitorganisasi = checknullpost($this->security->xss_clean(html_escape($this->input->post("jabatanunitorganisasi"))));
		$alamatrumah = checknullpost($this->security->xss_clean(html_escape($this->input->post("alamatrumah"))));
		$telprumah = checknullpost($this->security->xss_clean(html_escape($this->input->post("telprumah"))));
		$nohp = checknullpost($this->security->xss_clean(html_escape($this->input->post("nohp"))));
		$emailpribadi = checknullpost($this->security->xss_clean(html_escape($this->input->post("emailpribadi"))));
		$keterangan = checknullpost($this->security->xss_clean(html_escape($this->input->post("keterangan"))));

		$this->form_validation->set_rules('nipp', 'Nomer Induk Peserta Pelatihan', 'trim|required|is_unique[mst_peserta.NIPP]|xss_clean');
		$this->form_validation->set_rules('nik', 'Nomer Induk Kependudukan', 'trim|required|is_unique[mst_peserta.NIK]|xss_clean');
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
			redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/add'));
		} else {

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
					redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData = $this->upload->data();
					$filephoto = $uploadData['file_name'];
				}
			}else{
				$filephoto = null;
			}				

			$data = array(
				'Flag_CalonPeserta' => "Y",
				'NIPP' => $nipp,
				'NIK' => $nik,
				'NamaLengkap_TanpaGelar' => $nl_no_g,
				'NamaLengkap_DgnGelar' => $nl_w_g,
				'NamaPanggilan' => $np,
				'FilePhoto' => $filephoto,
				'Kota_Lahir' => $kotalahir,
				'Tgl_Lahir' => $tgllahir,
				'FKd_JnsKelamin' => $jeniskelamin,
				'FKd_Agama' => $agama,
				'Fkd_StrataPendidikanTerakhir' => $stratapendidikan,
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
				'Flag_Deleted'=>'N',
			);

			$countgelar = count($this->input->post("gelar"));
			for($i=0;$i<$countgelar;$i++){
				$no = $i+1;
				$str = "FKd_Gelar{$no}";
				$data[$str] = $this->input->post("gelar")[$i];
			}

			$countsertifikasi = count($this->input->post("sertifikasi"));
			for($as=0;$as<$countsertifikasi;$as++){
				$no = $as+1;
				$str = "FKd_Sertifikasi{$no}";
				$data[$str] = $this->input->post("sertifikasi")[$as];
			}

			$countbidangpendidikan = count($this->input->post("bidangpendidikan"));
			for($ass=0;$ass<$countbidangpendidikan;$ass++){
				$no = $ass+1;
				$str = "FKd_BidangPendidikan{$no}";
				$data[$str] = $this->input->post("bidangpendidikan")[$ass];
			}
			
			if($nl_no_g != null || $nl_no_g != ''){
    			$nmexplode = explode(" ",$nl_no_g);
    			$namadepan = $nmexplode[0];
			}else{
			    $namadepan = null;
			}
			
			$nono = 0;
			
			$wherenik= array(
			    'NIK'=>$nik,
			    );
			$ceknik = $this->db->where($wherenik)->get("mst_peserta");
		    if($ceknik->num_rows()>0){
		        $data['Flag_SebabTerkunci'] = 'D';
    	        $this->thismodel->insertdt($data);
		        recordlog("Menambahkan Data ".$this->name." dan terjadi pengucian data");
				$this->session->set_flashdata(array('error'=>'Entrian data ini terkunci karena terdapat kemiripan dengan data peserta yang telah terdaftar di Database','oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ) );
				redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/add'));
		    }else{
		        $nono= $nono+0;
		    }
		    
		    $wherenip= array(
			    'NIPP'=>$nipp,
			    );
			$ceknik = $this->db->where($wherenip)->get("mst_peserta");
		    if($ceknik->num_rows()>0){
		        $data['Flag_SebabTerkunci'] = 'D';
    	        $this->thismodel->insertdt($data);
		        recordlog("Menambahkan Data ".$this->name." dan terjadi pengucian data");
				$this->session->set_flashdata(array('error'=>'Entrian data ini terkunci karena terdapat kemiripan dengan data peserta yang telah terdaftar di Database','oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ) );
				redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/add'));
		    }else{
		        $nono= $nono+0;
		    }
		    
		    $wherenama = array(
		        'NamaLengkap_TanpaGelar'=>$nl_no_g,
		        );
		    $ceknama = $this->db->where($wherenama)->get("mst_peserta");
		    if($ceknama->num_rows()>0){
		        $data['Flag_SebabTerkunci'] = 'D';
    	        $this->thismodel->insertdt($data);
		        recordlog("Menambahkan Data ".$this->name." dan terjadi pengucian data");
				$this->session->set_flashdata(array('error'=>'Entrian data ini terkunci karena terdapat kemiripan dengan data peserta yang telah terdaftar di Database','oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ) );
				redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/add'));
		    }else{
		        $nono= $nono+0;
		    }
		    
		    $wherefull = array(
		        'NamaLengkap_TanpaGelar'=>$nl_no_g,
		        'Kota_Lahir' => $kotalahir,
				'Tgl_Lahir' => $tgllahir,
				'FKd_Agama' => $agama,
		        );
		    $ceknama = $this->db->where($wherefull)->get("mst_peserta");
		    if($ceknama->num_rows()>0){
		        $data['Flag_SebabTerkunci'] = 'D';
    	        $this->thismodel->insertdt($data);
		        recordlog("Menambahkan Data ".$this->name." dan terjadi pengucian data");
				$this->session->set_flashdata(array('error'=>'Entrian data ini terkunci karena terdapat kemiripan dengan data peserta yang telah terdaftar di Database','oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ) );
				redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/add'));
		    }else{
		        $nono= $nono+0;
		    }
		    
		    $wherevarian = array(
		        'NamaPanggilan'=>$np,
                'Kota_Lahir'=>$kotalahir,
                'Tgl_Lahir'=>$tgllahir,
			    'Flag_CalonPeserta'=>'N',
		        );
		    $likenamadepan = array(
		        'NamaLengkap_TanpaGelar'=>$namadepan,
		        );
			$cekvarian = $this->db->where($wherevarian)->like($likenamadepan)->get("mst_peserta");
			if($cekvarian->num_rows()>0){
			    $data['Flag_SebabTerkunci'] = 'D';
    	        $this->thismodel->insertdt($data);
		        recordlog("Menambahkan Data ".$this->name." dan terjadi pengucian data");
				$this->session->set_flashdata(array('error'=>'Entrian data ini terkunci karena terdapat kemiripan dengan data peserta yang telah terdaftar di Database','oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ) );
				redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/add'));
			}else{
		        $nono = $nono+0;
			}
			
			$wheresamedata12 = array(
                'NIK'=>$nik,
                'NamaLengkap_TanpaGelar'=>$nl_no_g,
                'NamaLengkap_DgnGelar'=>$nl_w_g,
                'NamaPanggilan'=>$np,
                'Kota_Lahir'=>$kotalahir,
                'Tgl_Lahir'=>$tgllahir,
                'FKd_Agama'=>$agama, 
                'eMail_Pribadi'=>$emailpribadi,
                'Flag_CalonPeserta'=>'Y',
    	    );
    	    $checksamedata =  $this->db->where($wheresamedata12)->get("mst_peserta");
    	    
			if($checksamedata->num_rows()>0){
    	    	recordlog("Menambahkan Data ".$this->name);
    	    	$this->session->set_flashdata(array('error'=>'Maaf! Data Calon Peserta Sudah Ada','oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ) );
				redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/add'));
    	    }else{
    	        $nono = $nono+0;
    	    }
    	    
			if($nono == 0){
			    $data['Flag_SebabTerkunci'] = 'N';
    	        $this->thismodel->insertdt($data);
				$this->session->set_flashdata('success', 'Data Berhasil Disimpan');
				redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/add'));
			}
		}
	}

	public function edit($id){
		permissions('merubah-data-calon-peserta');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
			'gelar'=>$this->db->get("ref_gelar"),
			'sertifikasi'=>$this->db->get("ref_sertifikasi"),
			'jeniskelamin'=>$this->db->get("ref_jeniskelamin"),
			'agama'=>$this->db->get("ref_agama"),
			'stratapendidikan'=>$this->db->get("ref_stratapendidikan"),
			'bidangpendidikan'=>$this->db->get("ref_bidangpendidikan"),
			'perusahaaninstansi'=>$this->db->get("mst_pershinstansi"),
			'bidangunitorganisasi'=>$this->db->get("ref_bidang_of_unitorganisasi"),
		);
		recordlog("Mengakses Halaman Edit Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/peserta/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-calon-peserta');

		$ids = checknullpost($this->security->xss_clean(html_escape($this->input->post("id_peserta"))));
		$nipp = checknullpost($this->security->xss_clean(html_escape($this->input->post("nipp"))));
		$nik = checknullpost($this->security->xss_clean(html_escape($this->input->post("nik"))));
		$nl_no_g = checknullpost($this->security->xss_clean(html_escape($this->input->post("nl_no_g"))));
		$nl_w_g = checknullpost($this->security->xss_clean(html_escape($this->input->post("nl_w_g"))));
		$np = checknullpost($this->security->xss_clean(html_escape($this->input->post("np"))));
		$gelar = checknullpost($this->security->xss_clean(html_escape($this->input->post("gelar"))));
		$sertifikasi = checknullpost($this->security->xss_clean(html_escape($this->input->post("sertifikasi"))));
		$photo = checknullpost($this->security->xss_clean(html_escape($this->input->post("avatar"))));
		$kotalahir = checknullpost($this->security->xss_clean(html_escape($this->input->post("kotalahir"))));
		$tgllahir = checknullpost($this->security->xss_clean(html_escape($this->input->post("tgllahir"))));
		$jeniskelamin = checknullpost($this->security->xss_clean(html_escape($this->input->post("jeniskelamin"))));
		$agama = checknullpost($this->security->xss_clean(html_escape($this->input->post("agama"))));
		$stratapendidikan = checknullpost($this->security->xss_clean(html_escape($this->input->post("stratapendidikan"))));
		$bidangpendidikan = checknullpost($this->security->xss_clean(html_escape($this->input->post("bidangpendidikan"))));
		$perusahaaninstansi = checknullpost($this->security->xss_clean(html_escape($this->input->post("perusahaaninstansi"))));
		$namaperusahaaninstansi = checknullpost($this->security->xss_clean(html_escape($this->input->post("namaperusahaaninstansi"))));
		$alamatkantor = checknullpost($this->security->xss_clean(html_escape($this->input->post("alamatkantor"))));
		$telpkantor = checknullpost($this->security->xss_clean(html_escape($this->input->post("telpkantor"))));
		$emailkantor = checknullpost($this->security->xss_clean(html_escape($this->input->post("emailkantor"))));
		$bidangunitorganisasi = checknullpost($this->security->xss_clean(html_escape($this->input->post("bidangunitorganisasi"))));
		$jabatanunitorganisasi = checknullpost($this->security->xss_clean(html_escape($this->input->post("jabatanunitorganisasi"))));
		$alamatrumah = checknullpost($this->security->xss_clean(html_escape($this->input->post("alamatrumah"))));
		$telprumah = checknullpost($this->security->xss_clean(html_escape($this->input->post("telprumah"))));
		$nohp = checknullpost($this->security->xss_clean(html_escape($this->input->post("nohp"))));
		$emailpribadi = checknullpost($this->security->xss_clean(html_escape($this->input->post("emailpribadi"))));
		$keterangan = checknullpost($this->security->xss_clean(html_escape($this->input->post("keterangan"))));

		$this->form_validation->set_rules('nipp', 'Nomer Induk Peserta Pelatihan', 'trim|required|xss_clean');
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
			redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/edit/'.$id));
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
					redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/add'));
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

            //cek nipp
            $nippcek  = $this->db->query("select Id_Peserta from mst_peserta where NIPP='$nipp'")->num_rows();
            $nipplama = $this->db->query("select Id_Peserta from mst_peserta where NIPP='$nipp'")->row_array();
            if($nippcek > 0){
                if($nipplama['Id_Peserta'] == $ids) {
                } else {
                    $this->session->set_flashdata( 'error','Terdapat Nomer Induk Peserta Pelatihan Yang Sama.');
                    redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/edit/'.$id));
                }   
            }
            
            //cek nik
            $nikcek  = $this->db->query("select Id_Peserta from mst_peserta where NIK='$nik'")->num_rows();
            $niklama = $this->db->query("select Id_Peserta from mst_peserta where NIK='$nik'")->row_array();
            if($nikcek > 0){
                if($niklama['Id_Peserta'] == $ids) {
                } else {
                    $this->session->set_flashdata( 'error','Terdapat Nomer Induk Kependudukan Yang Sama.');
                    redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/edit/'.$id));
                }   
            }
            
			$data = array(
				'NIPP' => $nipp,
				'NIK' => $nik,
				'NamaLengkap_TanpaGelar' => $nl_no_g,
				'NamaLengkap_DgnGelar' => $nl_w_g,
				'NamaPanggilan' => $np,
				'FilePhoto' => $filephoto,
				'Kota_Lahir' => $kotalahir,
				'Tgl_Lahir' => $tgllahir,
				'FKd_JnsKelamin' => $jeniskelamin,
				'FKd_Agama' => $agama,
				'Fkd_StrataPendidikanTerakhir' => $stratapendidikan,
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
                'Flag_CalonPeserta'=>'Y',
                'Flag_Deleted'=>'N',
			);

			$countgelar = count($this->input->post("gelar"));
			for($i=0;$i<$countgelar;$i++){
				$no = $i+1;
				$str = "FKd_Gelar{$no}";
				$data[$str] = $this->input->post("gelar")[$i];
			}

			$countsertifikasi = count($this->input->post("sertifikasi"));
			for($as=0;$as<$countsertifikasi;$as++){
				$no = $as+1;
				$str = "FKd_Sertifikasi{$no}";
				$data[$str] = $this->input->post("sertifikasi")[$as];
			}

			$countbidangpendidikan = count($this->input->post("bidangpendidikan"));
			for($ass=0;$ass<$countbidangpendidikan;$ass++){
				$no = $ass+1;
				$str = "FKd_BidangPendidikan{$no}";
				$data[$str] = $this->input->post("bidangpendidikan")[$ass];
			}
            $wheresamedata = array(
                'NIK'=>$nik,
                'NamaLengkap_TanpaGelar'=>$nl_no_g,
                'NamaLengkap_DgnGelar'=>$nl_w_g,
                'NamaPanggilan'=>$np,
                'Kota_Lahir'=>$kotalahir,
                'Tgl_Lahir'=>$tgllahir,
                'FKd_Agama'=>$agama, 
                'FKd_JnsKelamin'=>$jeniskelamin,
                'eMail_Pribadi'=>$emailpribadi,
                'FId_PershInstansi'=>$perusahaaninstansi,
                'Fkd_StrataPendidikanTerakhir'=>$stratapendidikan,
                'Flag_CalonPeserta'=>'N',
    	    );
            $wheresamedata12 = array(
                'NIK'=>$nik,
                'NamaLengkap_TanpaGelar'=>$nl_no_g,
                'NamaLengkap_DgnGelar'=>$nl_w_g,
                'NamaPanggilan'=>$np,
                'Kota_Lahir'=>$kotalahir,
                'Tgl_Lahir'=>$tgllahir,
                'FKd_Agama'=>$agama, 
                'FKd_JnsKelamin'=>$jeniskelamin,
                'eMail_Pribadi'=>$emailpribadi,
                'FId_PershInstansi'=>$perusahaaninstansi,
                'Fkd_StrataPendidikanTerakhir'=>$stratapendidikan,
                'Flag_CalonPeserta'=>'Y',
                'Id_Peserta !='=>$id,
    	    );
    	    $checksamedata2 =  $this->db->where($wheresamedata)->get("mst_peserta");
    	    $checksamedata =  $this->db->where($wheresamedata12)->get("mst_peserta");
    	    if($checksamedata2->num_rows()>0){
    	        $data['Flag_SebabTerkunci'] = 'D';
    	        $this->thismodel->updatedt($data,$id);
    	        /*$getrole = $this->db->where(array('is_khusus'=>2))->get("role");
    	        if($getrole->num_rows()>0){    	        	
	    	        foreach ($getrole->result() as $role) {
	    	        	$this->notifsendto($role->idrole);
	    	        }
    	        }*/
		        recordlog("Merubah Data ".$this->name." dan terjadi pengucian data");
				$this->session->set_flashdata('error', 'Data Terkunci! Terdapat kemiripan data peserta' );
				redirect(base_url('peserta/'.url_title(strtolower($this->name)).''));
    	    }else if($checksamedata->num_rows()>0){
		        recordlog("Merubah Data ".$this->name."");
				$this->session->set_flashdata('error', 'Maaf ! data tersebut sudah ada' );
				redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/edit/'.$id));
    	    }else{
	            recordlog("Merubah Data ".$this->name);
				$this->thismodel->updatedt($data,$id);
				$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
				redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/edit/'.$id));
			}
		}
	}

	public function view($id){
		permissions('melihat-data-calon-peserta');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		recordlog("Melihat Detail Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/peserta/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-calon-peserta');
		echo 'Anda yakin bermaksud menghapus data ini ?';
		echo '<hr/><div class="container-fluid" style="margin:0;padding:0">'; 
		echo '<div class="col-sm-12"> 
		          <div class="col-sm-6" style="margin:0;padding:0">
		            <a href="'.base_url('peserta/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
		          </div>
		          <div class="col-sm-6" style="margin:0;padding:0">
		            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
		          </div>
		        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-calon-peserta');
		
		$dt = $this->thismodel->getrecord($id);

		if($dt->FilePhoto != null || $dt->FilePhoto <> null || $dt->FilePhoto != '' || $dt->FilePhoto <> ''){
			if(file_exists('./uploads/photo/'.$dt->FilePhoto)){
				unlink('./uploads/photo/'.$dt->FilePhoto);
			}
		}
		$this->thismodel->deletedt($id);
		recordlog("Menghapus Data ".$this->name);

		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'peserta/'.url_title(strtolower($this->name)) ) );
	}

	
}
