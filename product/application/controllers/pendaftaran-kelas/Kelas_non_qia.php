<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_non_qia extends CI_Controller {
 	protected  $name = 'Kelas non qia'; 
    protected  $model = 'pelatihan/pendaftaran-kelas/Rkelasnonqia_model'; 
    protected  $model2 = 'pelatihan/pendaftaran-kelas/Rpembukaankelasnonqia'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Pendaftaran Kelas'; 
 	protected  $breadcrumb3 = 'Kelas Non QIA'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
        $this->load->model($this->model2,'thismodel2');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-kelas-non-qia');
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
	
	public function detail($nonqia){
		permissions('menambahkan-data-kelas-non-qia');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Detail '.$this->breadcrumb3,
			'peserta'=>$this->db
			            ->where("Flag_Deleted","N")
			            ->where("Flag_SebabTerkunci","N")
			            ->where("Flag_CalonPeserta","N")
			            ->get("mst_peserta"),
			'kelas'=> $this->db
            			->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
            			->where("mst_jenispelatihan.Flag_QIA","N")
            			->where("trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan",$nonqia)
            			->get("trm_pembukaankelas_n_angkatan")->row(),
            'idkelasnonqia'=>$nonqia,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Detail ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/pendaftaran-kelas/'.url_title(strtolower($this->name)).'/detail',$data);
	}

	public function print($nonqia){
        permissions('menambahkan-data-kelas-qia');
        $urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
        $data = array(
            'breadcrumb1'=>$this->breadcrumb1,
            'breadcrumb2'=>$this->breadcrumb2,
            'breadcrumb3'=>$this->breadcrumb3,
            'titlepage'=>$this->breadcrumb3,
            'subtitlepage'=>'Data '.$this->breadcrumb3,
            'titlebox'=>'Detail '.$this->breadcrumb3,
            'kelas'=> $this->db
                        ->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
                        ->where("mst_jenispelatihan.Flag_QIA","N")
                        ->where("trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan",$nonqia)
                        ->get("trm_pembukaankelas_n_angkatan")->row(),
            'pesertanonqia'=> $this->db
                        ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_nonqia.id_peserta",'left')
                        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=kelas_nonqia.id_kelas",'left')
                        ->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
                        ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
                        ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_pembukaankelas_n_angkatan.idproforma",'left')
                        ->where("kelas_nonqia.kelulusan",0)        
                        ->where("kelas_nonqia.id_kelas",$nonqia)  
                        ->get("kelas_nonqia"),
            'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
        );
        recordlog("Mencetak Absensi Peserta");
        $this->templatecus->dashboard('pages/modul/pelatihan/pendaftaran-kelas/'.url_title(strtolower($this->name)).'/print',$data);
    }

	public function getpeserta(){
        $peserta  = $this->db
                        ->like('NamaLengkap_DgnGelar',$this->input->get('q'))
                        ->or_like('NIPP',$this->input->get('q'))
                        ->where("Flag_Deleted","N")
                        ->where("Flag_SebabTerkunci","N")
                        ->where("Flag_CalonPeserta","N")
                        ->get("mst_peserta");
        $dt['result'] = array();
         foreach ($peserta->result() as $key => $data) {
              $nik = "-";
              $nipp = "-";
              $nama = "-";
              if($data->NIK != null){
                  $nik = $data->NIK;
              }
              if($data->NIPP != null){
                  $nipp = $data->NIPP;
              }
              if($data->NamaLengkap_DgnGelar != null){
                  $nama = $data->NamaLengkap_DgnGelar;
              }
              $rs = $nipp.' | '.$nik.' | '.$nama;
              array_push($dt['result'],array('id'=>$data->Id_Peserta,'text'=>$rs));       
         }
        $dt['paginate'] = array('more'=>true);
        echo json_encode($dt) ;
    }

	public function getdata(){
		$csrf_name = $this->security->get_csrf_token_name();
		$csrf_hash = $this->security->get_csrf_hash(); 
		
		$list = $this->thismodel2->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a href="'.base_url("pendaftaran-kelas/kelas-non-qia/detail/".$field->Id_Kelas_n_Angkatan).'">'. $field->DescBebas_Kelas_n_Angkatan.'</a>' ;
            $row[] = $field->nomor_kelas;
            $row[] = $field->No_Urut_Angkatan;
            $row[] = $field->Desc_JenisPelatihan;
            $row[] = tgl_indo($field->Tgl_Mulai_Aktual)." s/d ".tgl_indo($field->Tgl_Selesai_Aktual);
            $row[] = $this->actiontable($field->Id_Kelas_n_Angkatan);

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->thismodel2->count_all(),
            "recordsFiltered" => $this->thismodel2->count_filtered(),
            "data" => $data,
        );
        $output[$csrf_name] = $csrf_hash;
        echo json_encode($output);
	}
	
	public function getdatanonqia($nonqia){
		$csrf_name = $this->security->get_csrf_token_name();
		$csrf_hash = $this->security->get_csrf_hash(); 
		$kelas = $this->uri->segment(4);
		
		$list = $this->thismodel->get_datatables($nonqia);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $nik = "-";
            $nipp = "-";
            if($field->NIK != null){
                $nik = $field->NIK;
            }
            if($field->NIPP != null){
                $nipp = $field->NIPP;
            }
            $row[] = $nik;      
            $row[] = $nipp;      
            $row[] = ($field->NamaLengkap_DgnGelar!= null)? $field->NamaLengkap_DgnGelar : '<code>N/A</code>';
            $row[] = ($field->NamaPershInstansi!= null)? $field->NamaPershInstansi : '<code>N/A</code>';
            $row[] = '<a href="'.base_url("pendaftaran-kelas/kelas-non-qia/peserta/".$field->Id_Peserta).'" class="btn btn-xs btn-primary view-data" data-toggle="tooltip" title="View Data"><i class="fa fa-search-plus"></i> View </a>
                     <a href="'.base_url("pendaftaran-kelas/kelas-non-qia/delete_peserta/".$field->Id_Peserta.'/'.$kelas).'" class="btn btn-xs btn-danger delete-data" data-toggle="tooltip" title="Delete Data"> <i class="fa fa-trash"></i> Delete </a>';
            $data[] = $row;
		}

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->thismodel->count_all($nonqia),
            "recordsFiltered" => $this->thismodel->count_filtered($nonqia),
            "data" => $data,
        );
        $output[$csrf_name] = $csrf_hash;
        echo json_encode($output);
	}

	public function actiontable($id){
		if(accessperm('melihat-data-kelas-non-qia')){
			$btn = "<a href='".base_url('pendaftaran-kelas/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
        return $btn;
	}
	
	public function actiontablenonqia($id){
		if(accessperm('melihat-data-kelas-non-qia')){
			$btn = "<a href='".base_url('pendaftaran-kelas/'.url_title(strtolower($this->name))."/peserta/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-kelas-non-qia')){
			$btn .= "<a href='".base_url('pendaftaran-kelas/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function store(){	
		permissions('menambahkan-data-kelas-non-qia');	
		
		$nonqia = $this->security->xss_clean(html_escape($this->input->post("nonqia")));	
		$peserta = $this->security->xss_clean(html_escape($this->input->post("id_peserta")));	
		$kelas = $this->security->xss_clean(html_escape($this->input->post("id_kelas")));
		$defaultqia = $this->security->xss_clean(html_escape($this->input->post("defaultqia")));	
		$status_pel = $this->security->xss_clean(html_escape($this->input->post("status_pel")));	
		
		$this->form_validation->set_rules('id_peserta', 'Peserta', 'trim|xss_clean');
		$this->form_validation->set_rules('id_kelas', 'Kelas', 'trim|xss_clean');
		
		$cek2 = $this->db->query("select * from kelas_nonqia")->result();
		foreach($cek2 as $datas){
		    if($peserta == $datas->id_peserta and $nonqia == $datas->id_kelas){
    		    $this->session->set_flashdata( 'error','Peserta Sudah Ada Pada Kelas Ini');
    			redirect(base_url('pendaftaran-kelas/'.url_title(strtolower($this->name)).'/detail/'.$nonqia));
    		}   
		}
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('pendaftaran-kelas/'.url_title(strtolower($this->name)).'/detail/'.$nonqia));
		}else{
			$data = array(
				'id_peserta'=>$peserta,
				'id_kelas'=>$kelas
			);
			recordlog("Menyimpan Data ".$this->name);
			$this->thismodel->insertdt($data);
			$this->db->query("update mst_peserta set status_kelas='Y' where Id_Peserta='$peserta'");
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('pendaftaran-kelas/'.url_title(strtolower($this->name)).'/detail/'.$nonqia));
		}
	}
	
	public function view($id){
		permissions('melihat-data-kelas-non-qia');
		$data = array(
			'dtdefault'=>$this->db
			            ->get("mst_peserta")->row(),
			'kelas'=> $this->db
            			->select("trm_pembukaankelas_n_angkatan.*,mst_jenispelatihan.Desc_JenisPelatihan,mst_pershinstansi.Desc_PershInstansi,ref_kotatraining.Desc_KotaTraining,
                        mst_formatpiagamsertifikat.Desc_Piagam_Sertifikat,mst_proformakontrak.No_ProformaKontrak,mst_proformakontrak.Desc_ProformaKontrak,
                        mst_dokbukaklsreguler.Desc_DokBukaKlsReguler,mst_dokbukaklsreguler.No_Klsreguler")
                        ->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
                        ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
                        ->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
                        ->join("mst_formatpiagamsertifikat","mst_formatpiagamsertifikat.Id_FormatPiagamSertifikat=trm_pembukaankelas_n_angkatan.FId_FormatSertifikat",'left')
                        ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_pembukaankelas_n_angkatan.idproforma",'left')
                        ->join("mst_dokbukaklsreguler","mst_dokbukaklsreguler.Id_DokBukaKlsReguler=trm_pembukaankelas_n_angkatan.idskreguler",'left')
            			->where("trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan",$id)
            			->get("trm_pembukaankelas_n_angkatan")->row()
		);
		recordlog("Mengakses Halaman Detail ".$this->name);
		$this->load->view("pages/modul/pelatihan/pendaftaran-kelas/".url_title(strtolower($this->name))."/view",$data);
	}
	
	public function peserta($id){
		permissions('melihat-data-kelas-qia');
		$data = array(
			'dtdefault'=>$this->db
                        ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_nonqia.id_peserta",'left')
                        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=kelas_nonqia.id_kelas",'left')
                        ->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
                        ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
                        ->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
                        ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_pembukaankelas_n_angkatan.idproforma",'left')
                        ->where("kelas_nonqia.id_peserta",$id)    
			            ->get("kelas_nonqia")->row(),
		);
		recordlog("Mengakses Halaman Detail ".$this->name);
		$this->load->view("pages/modul/pelatihan/pendaftaran-kelas/".url_title(strtolower($this->name))."/peserta",$data);
	}
	
	public function delete($id){
		permissions('menghapus-data-kelas-non-qia');

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
	
	public function delete_peserta($id){
		permissions('menghapus-data-kelas-non-qia');
        $kelas = $this->uri->segment(5);
		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('pendaftaran-kelas/'.url_title(strtolower($this->name))."/delete-act/".$id.'/'.$kelas).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}
	
	public function delete_act($id){
		permissions('menghapus-data-kelas-non-qia');
		recordlog("Menghapus Data Peserta Di Kelas".$this->name);
		$kelas = $this->uri->segment(5);
		$this->db->query("update mst_peserta set status_kelas='N' where Id_Peserta='$id'");
		$this->db->query("delete from kelas_nonqia where id_peserta='$id' and id_kelas='$kelas'");
		$this->session->set_flashdata('success', 'Peserta berhasil dihapus');
		redirect(base_url( 'pendaftaran-kelas/'.url_title(strtolower($this->name)).'/detail/'.$kelas));
	}
}
