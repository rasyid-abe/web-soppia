<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembukaan_kelas extends CI_Controller {
 	protected  $name = 'Pembukaan kelas'; 
    protected  $model = 'pelatihan/kelas-pelatihan/Rpembukaankelas_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Kelas Pelatihan'; 
 	protected  $breadcrumb3 = 'Pembukaan Kelas'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-pembukaan-kelas-pelatihan');
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
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->DescBebas_Kelas_n_Angkatan;
            $row[] = $field->nomor_kelas;
            $kelas = "";
            if($field->idproforma != null){
                $kelas = "Kelas IHT";
            }
            if($field->idskreguler != null){
                $kelas = "Kelas Reguler";
            }
            $row[] = $kelas;
            
            $dok = "";
            if($field->idproforma != null){
                $dok = "Proforma Kontrak Nomor ".$field->No_ProformaKontrak;
            }
            if($field->idskreguler != null){
                $dok = "SK Pembukaan Kelas Reguler Nomor ".$field->No_Klsreguler;
            }
            $row[] = $dok;
            $row[] = $this->actiontable($field->Id_Kelas_n_Angkatan);

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
		if(accessperm('melihat-data-pembukaan-kelas-pelatihan')){
			$btn = "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-pembukaan-kelas-pelatihan')){
			$btn .= "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-pembukaan-kelas-pelatihan')){
			$btn .= "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-pembukaan-kelas-pelatihan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'FId_JenisPelatihan'=>$this->db->get("mst_jenispelatihan"),
			'FId_PershInstansi'=>$this->db->get("mst_pershinstansi"),
			'FKd_KotaTraining'=>$this->db->get("ref_kotatraining"),
			'FId_FormatPiagamSertifikat'=>$this->db->get("mst_formatpiagamsertifikat"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-pembukaan-kelas-pelatihan');
		
	    $jeniskelas = $this->input->post("jenis_kelas");

        $noproforma = $this->security->xss_clean(html_escape($this->input->post("no_proforma")));
        $dokreguler = $this->security->xss_clean(html_escape($this->input->post("sk_pembukaankelas")));
		$idlatih = $this->security->xss_clean(html_escape($this->input->post("FId_JenisPelatihan")));
		if($jeniskelas == "NONIHT"){
		    $idpersh = null;
	    }else{
		    $idpersh = $this->security->xss_clean(html_escape($this->input->post("FId_PershInstansi")));
	    }
		$nourut = $this->security->xss_clean(html_escape($this->input->post("No_Urut_Angkatan")));
		$desbebas = $this->security->xss_clean(html_escape($this->input->post("DescBebas_Kelas_n_Angkatan")));
		$singkatan = $this->security->xss_clean(html_escape($this->input->post("KODE_Singkatan")));
		$kota = $this->security->xss_clean(html_escape($this->input->post("FKd_KotaTraining")));
		$lokasi = $this->security->xss_clean(html_escape($this->input->post("LokasiPenyelenggaraan")));
		$lat = $this->security->xss_clean(html_escape($this->input->post("Koordinat_Latitude")));
		$jml = $this->security->xss_clean(html_escape($this->input->post("Jml_Peserta")));
		$mulai = $this->security->xss_clean(html_escape($this->input->post("Tgl_Mulai_Aktual")));
		$akhir = $this->security->xss_clean(html_escape($this->input->post("Tgl_Selesai_Aktual")));
		$lama = $this->security->xss_clean(html_escape($this->input->post("LamaHariPelatihan")));
		
		if($jml == null){
		    $jml = 0;
		} else $jml = $jml;
		
		if($lama == null){
		    $lama = 0;
		} else $lama = $lama;

		$this->form_validation->set_rules('no_proforma','Nomor Proforma','trim|is_unique[trm_pembukaankelas_n_angkatan.idproforma]|xss_clean');	
		$this->form_validation->set_rules('sk_pembukaankelas','Dokumen Reguler','trim|is_unique[trm_pembukaankelas_n_angkatan.idskreguler]|xss_clean');	
		$this->form_validation->set_rules('FId_JenisPelatihan','Jenis Pelatihan','trim|required|xss_clean');
	    if($jeniskelas == "NONIHT"){
	    }else{
		    $this->form_validation->set_rules('FId_PershInstansi','Perusahaan/Instansi','trim|required|xss_clean');	
	    }
		$this->form_validation->set_rules('No_Urut_Angkatan','No Urut Angkatan','trim|required|xss_clean');	
		$this->form_validation->set_rules('DescBaku_Kelas_n_Angkatan','DescBaku_Kelas_n_Angkatan','trim|xss_clean');	
		$this->form_validation->set_rules('DescBebas_Kelas_n_Angkatan','Nama Kelas','trim|required|xss_clean');	
		$this->form_validation->set_rules('KODE_Singkatan','KODE_Singkatan','trim|xss_clean');	
		$this->form_validation->set_rules('FKd_KotaTraining','FKd_KotaTraining','trim|xss_clean');	
		$this->form_validation->set_rules('LokasiPenyelenggaraan','LokasiPenyelenggaraan','trim|xss_clean');
		$this->form_validation->set_rules('Koordinat_Latitude','Koordinat_Latitude','trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/add'));
		}else{
		    
    		$latih = $this->db->query("select Desc_JenisPelatihan from mst_jenispelatihan where Id_JenisPelatihan='$idlatih'")->row();
    		if($jeniskelas == "NONIHT"){
    		    $persh = '';
    		    $desbaku = $latih->Desc_JenisPelatihan. ', '.$nourut;
    		}else{
    		    $persh = $this->db->query("select Desc_PershInstansi from mst_pershinstansi where Id_PershInstansi='$idpersh'")->row();
    		    $desbaku = $latih->Desc_JenisPelatihan. ', '.$persh->Desc_PershInstansi. ', '.$nourut;
    		}
		    
			$data = array(
				'FId_JenisPelatihan'=>$idlatih,
				'FId_PershInstansi'=>$idpersh,
				'No_Urut_Angkatan'=>$nourut,
				'DescBaku_Kelas_n_Angkatan'=>$desbaku,
				'DescBebas_Kelas_n_Angkatan'=>$desbebas,
				'KODE_Singkatan'=>$singkatan,
				'FKd_KotaTraining'=>$kota,
				'LokasiPenyelenggaraan'=>$lokasi,
				'Koordinat_Latitude'=>$lat,
				'Kordinat_Longitude'=>"",
				'Jml_Peserta'=>$jml,
				'Tgl_Mulai_Aktual'=>$mulai,
				'Tgl_Selesai_Aktual'=>$akhir,
				'LamaHariPelatihan'=>$lama,
				'idproforma'=>$noproforma,
				'idskreguler'=>$dokreguler
			);
			recordlog("Menambahkan Data ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			
			if($noproforma != null){
			    $idkelas1 = $this->db->query("select Id_Kelas_n_Angkatan from trm_pembukaankelas_n_angkatan where idproforma='$noproforma'")->row_array();
			    $idkelas2 = $idkelas1['Id_Kelas_n_Angkatan'];
			    $this->db->query("update trm_sub_journal_soppia set FId_Kelas_n_Angkatan='$idkelas2', FId_PershInstansi='$idpersh' where FId_Proforma='$noproforma'");    
			}
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-pembukaan-kelas-pelatihan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'FId_JenisPelatihan'=>$this->db->get("mst_jenispelatihan"),
			'FId_PershInstansi'=>$this->db->get("mst_pershinstansi"),
			'FKd_KotaTraining'=>$this->db->get("ref_kotatraining"),
			'FId_FormatPiagamSertifikat'=>$this->db->get("mst_formatpiagamsertifikat"),
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-pembukaan-kelas-pelatihan');

        $jeniskelas = $this->input->post("jenis_kelas");
        
		$idlatih = $this->security->xss_clean(html_escape($this->input->post("FId_JenisPelatihan")));
	    $idpersh = $this->security->xss_clean(html_escape($this->input->post("FId_PershInstansi")));
		$nourut = $this->security->xss_clean(html_escape($this->input->post("No_Urut_Angkatan")));
		$desbebas = $this->security->xss_clean(html_escape($this->input->post("DescBebas_Kelas_n_Angkatan")));
		$singkatan = $this->security->xss_clean(html_escape($this->input->post("KODE_Singkatan")));
		$kota = $this->security->xss_clean(html_escape($this->input->post("FKd_KotaTraining")));
		$lokasi = $this->security->xss_clean(html_escape($this->input->post("LokasiPenyelenggaraan")));
		$lat = $this->security->xss_clean(html_escape($this->input->post("Koordinat_Latitude")));
		$jml = $this->security->xss_clean(html_escape($this->input->post("Jml_Peserta")));
		$mulai = $this->security->xss_clean(html_escape($this->input->post("Tgl_Mulai_Aktual")));
		$akhir = $this->security->xss_clean(html_escape($this->input->post("Tgl_Selesai_Aktual")));
		$lama = $this->security->xss_clean(html_escape($this->input->post("LamaHariPelatihan")));
		$selesai = $this->security->xss_clean(html_escape($this->input->post("Flag_Selesai")));
		
		$this->form_validation->set_rules('FId_JenisPelatihan','Jenis Pelatihan','trim|xss_clean');
	    $this->form_validation->set_rules('FId_PershInstansi','Perusahaan/Instansi','trim|xss_clean');	
	    $this->form_validation->set_rules('No_Urut_Angkatan','No Urut Angkatan','trim|required|xss_clean');	
		$this->form_validation->set_rules('DescBebas_Kelas_n_Angkatan','Nama Kelas','trim|required|xss_clean');	
		$this->form_validation->set_rules('KODE_Singkatan','KODE_Singkatan','trim|xss_clean');	
		$this->form_validation->set_rules('FKd_KotaTraining','FKd_KotaTraining','trim|xss_clean');	
		$this->form_validation->set_rules('LokasiPenyelenggaraan','LokasiPenyelenggaraan','trim|xss_clean');
		$this->form_validation->set_rules('Koordinat_Latitude','Koordinat_Latitude','trim|xss_clean');
		$this->form_validation->set_rules('Jml_Peserta','Jml_Peserta','trim|xss_clean');
		$this->form_validation->set_rules('Tgl_Mulai_Aktual','Tgl_Mulai_Aktual','trim|xss_clean');
		$this->form_validation->set_rules('Tgl_Selesai_Aktual','Tgl_Selesai_Aktual','trim|xss_clean');
		$this->form_validation->set_rules('LamaHariPelatihan','LamaHariPelatihan','trim|xss_clean');
		$this->form_validation->set_rules('Flag_Selesai','Flag_Selesai','trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
		    
		    $latih = $this->db->query("select Desc_JenisPelatihan from mst_jenispelatihan where Id_JenisPelatihan='$idlatih'")->row();
		    $pershcek = $this->db->query("select Desc_PershInstansi from mst_pershinstansi where Id_PershInstansi='$idpersh'")->num_rows();
		    $persh = $this->db->query("select Desc_PershInstansi from mst_pershinstansi where Id_PershInstansi='$idpersh'")->row();
		    
		    if($pershcek > 0){
		        $desbaku = $latih->Desc_JenisPelatihan.', '.$persh->Desc_PershInstansi.', '.$nourut;
		    } else $desbaku = $latih->Desc_JenisPelatihan.', '.$nourut;
    		
			$data = array(
			    'FId_JenisPelatihan'=>$idlatih,
				'FId_PershInstansi'=>$idpersh,
				'No_Urut_Angkatan'=>$nourut,
				'DescBaku_Kelas_n_Angkatan'=>$desbaku,
				'DescBebas_Kelas_n_Angkatan'=>$desbebas,
				'KODE_Singkatan'=>$singkatan,
				'FKd_KotaTraining'=>$kota,
				'LokasiPenyelenggaraan'=>$lokasi,
				'Koordinat_Latitude'=>$lat,
				'Kordinat_Longitude'=>"",
				'Jml_Peserta'=>$jml,
				'Tgl_Mulai_Aktual'=>$mulai,
				'Tgl_Selesai_Aktual'=>$akhir,
				'Flag_Selesai'=>$selesai,
				'LamaHariPelatihan'=>$lama,
			);
			recordlog("Merubah Data ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-pembukaan-kelas-pelatihan');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat Detail Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/kelas-pelatihan/".url_title(strtolower($this->name))."/view",$data);
	}
	
	public function delete($id){
		permissions('menghapus-data-pembukaan-kelas-pelatihan');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-pembukaan-kelas-pelatihan');
		recordlog("Menghapus Data ".$this->name);
		$this->db->where("Desc_Transaksi !=","Special Journal Proforma Kontrak")
		         ->where("FId_Kelas_n_Angkatan",$id)
		         ->delete("trm_sub_journal_soppia");      
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'kelas-pelatihan/'.url_title(strtolower($this->name)) ) );
	}
	
	public function getfromselect($kat){
	    if($kat == "IHT"){
	        $arr = array();
	        $term = $this->db->select("any_value(idproforma) as idproforma")->where(array('idproforma !='=>null))->group_by("idproforma")->get("trm_pembukaankelas_n_angkatan");
	        if($term->num_rows()>0){
    	        foreach( $term->result() as $tr){
    	            array_push($arr,$tr->idproforma);
    	        }
    	        $arr = $arr;
	        }else{
	            $arr = '';
	        }
            $data = array(
                'jenis'=>'IHT',
                'dt' => $this->db->where_not_in('Id_ProformaKontrak',$arr)->get("mst_proformakontrak"),
                );
	    }else if($kat == "NONIHT"){
	        $arr = array();
	        $term =  $this->db->select("any_value(idskreguler) as idskreguler")->where(array('idskreguler !='=>null))->group_by("idskreguler")->get("trm_pembukaankelas_n_angkatan");
	        if($term->num_rows()>0){
    	        foreach( $term->result() as $tr ){
    	            array_push($arr,$tr->idskreguler);
    	        }
	            $arr = $arr;
	        }else{
	            $arr = '';
	        }
	        $this->db->where_not_in('Id_DokBukaKlsReguler',$arr)->get("mst_dokbukaklsreguler");
            $data = array(
                'jenis'=>'NONIHT',
                'dt' => $this->db->where_not_in('Id_DokBukaKlsReguler',$arr)->get("mst_dokbukaklsreguler"),
                );
	    }
	      
	    $this->load->view( "pages/modul/pelatihan/kelas-pelatihan/".url_title(strtolower($this->name)).'/formselect',$data );
	}
	
}
