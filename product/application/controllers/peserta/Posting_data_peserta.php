<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posting_data_peserta extends CI_Controller {
 	protected  $name = 'Data peserta'; 
    protected  $model = 'pelatihan/peserta/Rpostingdatapeserta_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Peserta'; 
 	protected  $breadcrumb3 = 'Data Peserta'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-peserta');
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
		$this->templatecus->dashboard('pages/modul/pelatihan/peserta/posting-data-peserta/index',$data);
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
            $sttus = $field->Flag_CalonPeserta;
            /*if($sttus == "N"){
	            $script = "
	            	<span class='add-bg-parent-color'></span>
	            	<script>
		            	$(function(){
		            		$(document).ready(function(){
		            			var cek = '".$sttus."';
		            			if(cek == 'N'){
		            				$('.add-bg-parent-color').parent().parent().addClass('bg-green color-palette');
		            			}
		            		});
		            	});
	            	</script>
	            ";
            }else{
            	$script = null;
            }*/

            $row[] = $no;
            $row[] = ($field->FilePhoto!= null)? '<img src="'.base_url("uploads/photo/".$field->FilePhoto).'" width="50px" height="50px"></img>' : '<code>N/A</code>';
            $row[] = $field->NIPP;
            $row[] = $field->NamaLengkap_DgnGelar;
            $row[] = ($field->NamaPershInstansi!= null)? $field->NamaPershInstansi : '<code>N/A</code>';
            $row[] = $this->actiontable($field->Id_Peserta,$field->Flag_Deleted,$field->Flag_CalonPeserta);
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

	public function actiontable($id,$del,$cln){
	    $btn = '<div class="btn-group">';
		if(accessperm('melihat-data-peserta')){
			$btn .= "<a href='".base_url('peserta/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> &nbsp;&nbsp;";
        }
		
		if(accessperm('merubah-data-peserta')){
			$btn .= "<a href='".base_url('peserta/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> &nbsp;&nbsp;";
        }
		if(accessperm('menghapus-data-peserta')){
			$btn .= "<a href='".base_url('peserta/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>&nbsp;&nbsp;";	
        }
        $btn .= '</div>';
        return $btn;
	}

	/*public function posting($id){
		$find = $this->db->where(array('Id_Peserta'=>$id))->get("mst_peserta");
		if($find->num_rows()>0){
			if($find->row()->Flag_CalonPeserta == "N"){
				$data = array(
					'Flag_CalonPeserta'=>"Y",
					'Last_Posting_Date'=>date("Y-m-d"),
					'Last_Posting_By'=>$this->session->userdata("username"),
				);
			}else{
				$data = array(
					'Flag_CalonPeserta'=>"N",
					'Last_Posting_Date'=>date("Y-m-d"),
					'Last_Posting_By'=>$this->session->userdata("username"),
				);
			}
			$this->db->where(array('Id_Peserta'=>$id))->update("mst_peserta",$data);
			echo "Sukses";
		}else{
			echo "Gagal";
		}
	}*/

	public function add(){
		permissions('menambahkan-data-peserta');
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
		$this->templatecus->dashboard('pages/modul/pelatihan/peserta/posting-data-peserta/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-peserta');	
		
		$nipp = $this->security->xss_clean(html_escape($this->input->post("nipp")));
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
		}else{

			$this->load->library('upload');

			if( !empty($_FILES['avatar']['name']) ){
				$config = array(
					'upload_path'=> './uploads/photo/',
					'allowed_types'=>'png|gif|jpeg|jpg',
					'max_size'=>1000000,
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
				'Flag_SebabTerkunci' => $terkunci,
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
				'Skor_Awal' => $skorawal,
				'Skor_Saat_Ini' => $skorsaatini,
				'Flag_SudahQIA' => $sudahqia,
				'Flag_SudahWisudaQIA' => $sudahwisudaqia,
				'Tgl_WisudaQIA' => (($tglwisudaqia != '')? $tglwisudaqia : null),
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
			
            recordlog("Menambahkan Data ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-peserta');
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
		$this->templatecus->dashboard('pages/modul/pelatihan/peserta/posting-data-peserta/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-peserta');

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
					'max_size'=>1000000,
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
                if($nipplama['Id_Peserta'] == $id) {
                } else {
                    $this->session->set_flashdata( 'error','Terdapat Nomer Induk Peserta Pelatihan Yang Sama.');
                    redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/edit/'.$id));
                }   
            }
            
            //cek nik
            $nikcek  = $this->db->query("select Id_Peserta from mst_peserta where NIK='$nik'")->num_rows();
            $niklama = $this->db->query("select Id_Peserta from mst_peserta where NIK='$nik'")->row_array();
            if($nikcek > 0){
                if($niklama['Id_Peserta'] == $id) {
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

            recordlog("Merubah Data ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('peserta/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-peserta');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		recordlog("Melihat Detail Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/peserta/posting-data-peserta/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-peserta');

		echo 'Anda yakin bermaksud menghapus data ini ? <br/> Kenapa data ini Dihapus? <br/><textarea name="reason-del" id="reason-del" class="form-control" placeholder="alasan di hapus?"></textarea>';
		echo '<hr/><div class="container-fluid" style="margin:0;padding:0">'; 
		echo '<div class="col-sm-12"> 
		          <div class="col-sm-6" style="margin:0;padding:0">
		            <a link-href="'.base_url('peserta/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat btn-delete-modal">Ya</a>
		          </div>
		          <div class="col-sm-6" style="margin:0;padding:0">
		            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
		          </div>
		        </div>';
		echo '</div>';

		echo '
		<script>
			$(document).ready(function(){				
			    $(document).on("click",".btn-delete-modal",function(){
			      var getdel = $("#reason-del").val();
			      var thislink = $(this).attr("link-href");
			      $.post( thislink, { "data": getdel } ,function(rs){
			      	if(rs == "sukses" || rs == "Sukses"){
			      	 $("#modal-default").modal("hide");
			      	 $("table.dt-table").DataTable().ajax.reload( null, false );
			      	}
			      });
			    });
			});
		</script>
		';
	}

	public function delete_exec($id){
		permissions('menghapus-data-peserta');

		$msg = $this->input->post("data");
		$dt = $this->thismodel->getrecord($id);
			$data = array(
				'Flag_Deleted'=>"Y",
				'Delete_Date'=>date("Y-m-d"),
				'Delete_By'=>$this->session->userdata("username"),
				'Reason_to_Delete'=>$msg,
			);
			recordlog("Menghapus Data ".$this->name);
			$this->thismodel->updatedt($data,$id);

		echo "Sukses";

		/* $this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'peserta/'.url_title(strtolower($this->name)) ) );*/
	}

	
}
