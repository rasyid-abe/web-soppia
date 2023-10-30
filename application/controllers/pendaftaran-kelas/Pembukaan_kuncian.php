<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembukaan_kuncian extends CI_Controller {
 	protected  $name = 'Pembukaan kuncian'; 
    protected  $model = 'pelatihan/pendaftaran-kelas/Rbukakunciankelas_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Pendaftaran Kelas'; 
 	protected  $breadcrumb3 = 'Pembukaan Kunci Kelas'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-pembukaan-kunci-entry');
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
		$this->templatecus->dashboard('pages/modul/pelatihan/pendaftaran-kelas/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->NIPP;
            $row[] = $field->NamaPershInstansi;
            $row[] = $field->NamaLengkap_TanpaGelar;    
            $row[] = $this->status($field->Id_Peserta);    
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
        echo json_encode($output);
	}
	
	public function status($id){
	    $cek = $this->db->where(array("Id_Peserta"=>$id))->get("mst_peserta_logbukakuncian");
	    if($cek->num_rows()>0){
	        if($cek->row()->Tgl_Pejabat1_BukaKunci != null && $cek->row()->Tgl_Pejabat2_BukaKunci != null ){
	            return "data telah dibuka";
	        }else if($cek->row()->Tgl_Pejabat1_BukaKunci != null && $cek->row()->Tgl_Pejabat2_BukaKunci == null ){
	            return "menunggu persetujuan pejabat kedua";
	        }else if($cek->row()->Tgl_Pejabat1_BukaKunci == null && $cek->row()->Tgl_Pejabat2_BukaKunci != null ){
	            return "menunggu persetujuan pejabat pertama";
	        }else{
	            return "Menunggu Persetujuan 2 Pejabat";
	        }
	    }else{
	        return "Menunggu Persetujuan 2 Pejabat";
	    }
	}

	public function actiontable($id){
	    $btn = '<div class="btn-group">';
		if(accessperm('melihat-data-pembukaan-kunci-entry')){
			$btn .= "<a href='".base_url('pendaftaran-kelas/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }
        if(accessperm('membuka-kuncian-data-pembukaan-kunci-entry')){
			$btn .= "<a href='".base_url('pendaftaran-kelas/'.url_title(strtolower($this->name))."/buka-kuncian/".$id)."' class='btn btn-xs btn-success' data-toggle='tooltip' title='Buka Kuncian Entry'> <i class='fa fa-key'></i> Buka Kunci </a>";
        }
        $btn .= '</div>';
        return $btn;
	}

	public function verifikasi($id){
		permissions('membuka-kuncian-data-pembukaan-kunci-entry');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		recordlog("Verifikasi Kunci Kelas");
		$this->load->view("pages/modul/pelatihan/pendaftaran-kelas/".url_title(strtolower($this->name))."/verifikasi",$data);
	}

	public function verifikasi_proses($id){

		$username = $this->security->xss_clean(html_escape($this->input->post("username")));
		$password = $this->security->xss_clean(html_escape($this->input->post("password")));

		if($username != "anonim" && $password != "anonim"){
			if(checkEmail($username)){
				$cekwhere  = array(
					'email' => $username,
					'password' => md5($password)
				);
			}else{
				$cekwhere  = array(
					'username' => $username,
					'password' => md5($password)
				);
			}
			$cek = (object) $this->checkauth($cekwhere);
			if($cek->status == false){
				$rsl = array(
					'status'=>'error',
					'msg'=> 'Anda tidak berhak membuka kuncian'
				);
			}else{
				if($cek->is_active == 1){						
					$rsl = array(
						'status'=>'sukses',
						'msg'=> base_url('pendaftaran-kelas/'.url_title(strtolower($this->name)).'/buka-kuncian/'.$id)
					);
				}else{				
					$rsl = array(
						'status'=>'error',
						'msg'=> 'Anda tidak berhak membuka kuncian'
					);
				}
			}
		}else{
			$rsl = array(
				'status'=>'sukses',
				'msg'=> base_url('pendaftaran-kelas/'.url_title(strtolower($this->name)).'/buka-kuncian/'.$id)
			);
		}	

		echo json_encode($rsl);
	}

	public function checkauth($where){
		$cekuser = $this->db->where($where)->get("user");
		if($cekuser->num_rows()>0){
			$dtuser = $cekuser->row();
			$rs = array(
				'status' => true,
				'username' => $dtuser->username,
				'is_active' => $dtuser->is_active,
			);
		}else{
			$rs = array(
				'status' => false
			);
		}
		return $rs;
	}

	public function buka_kuncian($id){
		permissions('membuka-kuncian-data-pembukaan-kunci-entry');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Buka Kunci',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		recordlog("Mengakses Halaman ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/pendaftaran-kelas/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function save_buka_kuncian($id){
		permissions('membuka-kuncian-data-pembukaan-kunci-entry');

		$flagdddk = $this->security->xss_clean(html_escape($this->input->post("flagdddk")));
		$pejabat1 = $this->security->xss_clean(html_escape($this->input->post("pejabat1")));
		$alasan1 = $this->security->xss_clean(html_escape($this->input->post("alasan1")));
		$pejabat2 = $this->security->xss_clean(html_escape($this->input->post("pejabat2")));
		$alasan2 = $this->security->xss_clean(html_escape($this->input->post("alasan2")));

		$this->form_validation->set_rules('flagdddk', 'Flag Daftar Data /Daftar Kelas', 'trim|xss_clean');
		$this->form_validation->set_rules('pejabat1', 'Nama Pejabat 1 Pembuka kuncian', 'trim|xss_clean');
		$this->form_validation->set_rules('alasan1', 'Alasan Pejabat 1 membuka kuncian', 'trim|xss_clean');
		$this->form_validation->set_rules('pejabat2', 'Nama Pejabat 1 Pembuka kuncian', 'trim|xss_clean');
		$this->form_validation->set_rules('alasan2', 'Alasan Pejabat 1 membuka kuncian', 'trim|xss_clean');


		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('pendaftaran-kelas/'.url_title(strtolower($this->name)).'/buka-kuncian/'.$id));
		}else{	
			$find = $this->db->where(array('Id_Peserta'=>$id))->get("mst_peserta_logbukakuncian");
			if($find->num_rows()>0){
				$data = array(
					'Id_Peserta'=> $id,
					'Flag_DaftarData_or_DaftarKelas'=>$flagdddk,
					'Pejabat_Pembuka_Kunci1'=> ($pejabat1 == '')? $find->row()->Pejabat_Pembuka_Kunci1 : $pejabat1,
					'Alasan_Pembukaan_Kuncian_Pejabat1'=> ($alasan1 == '')? $find->row()->Alasan_Pembukaan_Kuncian_Pejabat1 : $alasan1,
					'Tgl_Pejabat1_BukaKunci'=>($pejabat1 == '')? $find->row()->Tgl_Pejabat1_BukaKunci : date("Y-m-d"),
					'Pejabat_Pembuka_Kunci2'=> ($pejabat2 == '')? $find->row()->Pejabat_Pembuka_Kunci2 : $pejabat2,
					'Alasan_Pembukaan_Kuncian_Pejabat2'=>($alasan2 == '')? $find->row()->Alasan_Pembukaan_Kuncian_Pejabat2 : $alasan2,
					'Tgl_Pejabat2_BukaKunci'=>($pejabat2 == '')? $find->row()->Tgl_Pejabat2_BukaKunci : date("Y-m-d"),
					);
				$this->db->where(array("Id_Peserta"=>$id))->update("mst_peserta_logbukakuncian",$data);
			}else{
				$data = array(
					'Id_Peserta'=> $id,
					'Flag_DaftarData_or_DaftarKelas'=>$flagdddk,
					'Pejabat_Pembuka_Kunci1'=> ($pejabat1 == '')? null : $pejabat1,
					'Alasan_Pembukaan_Kuncian_Pejabat1'=> ($alasan1 == '')? null : $alasan1,
					'Tgl_Pejabat1_BukaKunci'=>($pejabat1 == '')? null : date("Y-m-d"),
					'Pejabat_Pembuka_Kunci2'=> ($pejabat2 == '')? null : $pejabat2,
					'Alasan_Pembukaan_Kuncian_Pejabat2'=>($alasan2 == '')? null : $alasan2,
					'Tgl_Pejabat2_BukaKunci'=>($pejabat2 == '')? null : date("Y-m-d"),
					);
				$this->db->insert("mst_peserta_logbukakuncian",$data);
			}

			$cekpst = $this->db->where(array('Id_Peserta'=>$id))->get("mst_peserta_logbukakuncian");
			if( $cekpst->row()->Alasan_Pembukaan_Kuncian_Pejabat1 != null && $cekpst->row()->Alasan_Pembukaan_Kuncian_Pejabat2 != null ){
				$this->db->where(array("Id_Peserta"=>$id))->update("mst_peserta",array(
					'Flag_SebabTerkunci'=>"N",
					'persyaratan'=>"1",
					)
				);
				
                recordlog("Membuka data pada halaman ".$this->name);
    			$this->session->set_flashdata('success', 'Data berhasil di simpan');
    			redirect(base_url('pendaftaran-kelas/'.url_title(strtolower($this->name))));
			}else{
                recordlog("Membuka data pada halaman ".$this->name);
    			$this->session->set_flashdata('success', 'Data berhasil di simpan');
    			redirect(base_url('pendaftaran-kelas/'.url_title(strtolower($this->name)).'/buka-kuncian/'.$id));
			}
		}
	}

	public function view($id){
		permissions('melihat-data-pembukaan-kunci-entry');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat Detail Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/pendaftaran-kelas/".url_title(strtolower($this->name))."/view",$data);
	}
	
	public function delete($id){
		permissions('menghapus-data-pembukaan-kunci-entry');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('pendaftaran-kelas/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-pembukaan-kunci-entry');

		$dt = $this->thismodel->getrecord($id);

		if($dt->FilePhoto != null || $dt->FilePhoto <> null || $dt->FilePhoto != '' || $dt->FilePhoto <> ''){
			if(file_exists('./uploads/photo/'.$dt->FilePhoto)){
				unlink('./uploads/photo/'.$dt->FilePhoto);
			}
		}
		$this->db->where(array('Id_Peserta'=>$id))->delete("mst_peserta_logbukakuncian");
        
        recordlog("Menghapus Data ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'pendaftaran-kelas/'.url_title(strtolower($this->name)) ) );
	}
}
