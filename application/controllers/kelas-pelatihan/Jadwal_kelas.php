<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_kelas extends CI_Controller {
 	protected  $name = 'Jadwal kelas'; 
    protected  $model = 'pelatihan/kelas-pelatihan/Rpembukaankelas_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Kelas Pelatihan'; 
 	protected  $breadcrumb3 = 'Jadwal Kelas'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-jadwal-kelas');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Jadwal, Materi/Kegiatan & Instruktur Kelas tertentu',
			'titlepage'=>'Jadwal, Materi/Kegiatan & Instruktur Kelas tertentu',
			'subtitlepage'=>'',
			'titlebox'=>'Manage Jadwal, Materi/Kegiatan & Instruktur Kelas tertentu',
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
            $row[] = '<a href="'.base_url("kelas-pelatihan/jadwal-kelas/setting/".$field->Id_Kelas_n_Angkatan).'">'.$field->DescBebas_Kelas_n_Angkatan.'</a>' ;
            $row[] = $field->nomor_kelas;
            $row[] = ($field->Desc_PershInstansi!= null)? $field->Desc_PershInstansi : '<code>N/A</code>';
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
		if(accessperm('melihat-data-jadwal-kelas')){
			$btn = "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-box-tool view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a>";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-jadwal-kelas')){
			$btn .= "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-box-tool' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a>";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-jadwal-kelas')){
			$btn .= "<a href='".base_url('kelas-pelatihan/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-box-tool delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function setting($id){
		permissions('melihat-data-jadwal-kelas');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Jadwal, Materi/Kegiatan & Instruktur Kelas tertentu',
			'titlepage'=>'Jadwal, Materi/Kegiatan & Instruktur Kelas tertentu',
			'subtitlepage'=>'',
			'titlebox'=>'Jadwal, Materi/Kegiatan & Instruktur Kelas tertentu',
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'FId_Kelas_n_Angkatan'=>$this->db->get("trm_pembukaankelas_n_angkatan"),
			'FKd_Sesi_Satuan'=>$this->db->get("ref_sesi_satuan"),
			'FKd_Materi_n_Aktifitas'=>$this->db->get("mst_materi_n_aktifitas"),
			'FId_Instruktur'=>$this->db->get("mst_instruktur"),
	        'paket'=>$this->db->get("ref_paket_sesi_harian"),
			'id'=>$id,
			'tgl_print'=>$this->db->where(array('FId_Kelas_n_Angkatan'=>$id))->limit(1)->get("tre_pembukaankelas_n_angkatan_sesi"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Setting ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/setting',$data);
	}
	
	public function cekmateri($data){
	    $get = $this->db->where(array('Kd_Materi_n_Aktifitas'=>$data))->get("mst_materi_n_aktifitas");
	    if($get->num_rows() > 0){
	        $get = $get->row();
	        if($get->Flag_Daftar_Nilai != 'Y' && $get->Flag_Evaluasi_Instruktur != 'Y'){
	            echo 'true';
	        }else{
	            echo 'false';
	        }
	    }else{
	        echo 'false';
	    }
	}

	public function store($id){	
		permissions('pengaturan-data-jadwal-kelas');
		$idstore = $id;
		//echo "lagi bugging proses".br(3);
		$kelas = $this->security->xss_clean(html_escape($this->input->post("FId_Kelas_n_Angkatan")));
		$kelaslama = $this->security->xss_clean(html_escape($this->input->post("kelaslama")));
		$no_urut = $this->security->xss_clean(html_escape($this->input->post("No_Urut_Hari")));
		$tgl = $this->security->xss_clean(html_escape($this->input->post("Tgl")));
		$hari = $this->security->xss_clean(html_escape($this->input->post("Hari")));
		$no_sesi = $this->security->xss_clean(html_escape($this->input->post("No_Urut_Sesi")));
		$fkdsesi = $this->security->xss_clean(html_escape($this->input->post("FKd_Sesi_Satuan")));
		$fkdakt = $this->security->xss_clean(html_escape($this->input->post("FKd_Materi_n_Aktifitas")));
		$fidinst = $this->security->xss_clean(html_escape($this->input->post("FId_Instruktur")));
		
		$count = count($this->input->post("No_Urut_Hari")); 
		//echo '<pre>' . var_export($this->input->post(), true) . '</pre>';
		//die();
		 $dayList = array(
            '1' => 'Minggu',
            '2' => 'Senin',
            '3' => 'Selasa',
            '4' => 'Rabu',
            '5' => 'Kamis',
            '6' => 'Jumat',
            '7' => 'Sabtu'
          ); 
         $dayval = array(
            '1' => 'Sun',
            '2' => 'Mon',
            '3' => 'Tue',
            '4' => 'Wed',
            '5' => 'Thu',
            '6' => 'Fri',
            '7' => 'Sat'
          );
        $cekxx = $this->db->where(array('FId_Kelas_n_Angkatan'=>$kelaslama))->get("tre_pembukaankelas_n_angkatan_sesi");
        if($cekxx->num_rows()>0){
            foreach($cekxx->result() as $cektabelsatunya){
                $cekyy = $this->db->where(array('idpembukaankelasangkatan'=>$cektabelsatunya->idpembukaankelasangkatan))->get("trm_instrukturngajar_dikelas");
                if($cekyy->num_rows()>0){
                    foreach($cekyy->result() as $tblsatunya){
                        $this->db->where(array('idpembukaankelasangkatan'=>$tblsatunya->idpembukaankelasangkatan))->delete("trm_instrukturngajar_dikelas");
                    }
                }
            }
            $this->db->where(array('FId_Kelas_n_Angkatan'=>$kelaslama))->delete("tre_pembukaankelas_n_angkatan_sesi");
        }
		for( $i=1; $i<=$count; $i++ ){
		   if (array_key_exists($i, $this->input->post("FId_Kelas_n_Angkatan"))) {
		    $countzz = count($this->input->post("FId_Kelas_n_Angkatan")[$i]);
		    for($w=0;$w<$countzz;$w++){
		        $data['FId_Kelas_n_Angkatan'] = $this->input->post("FId_Kelas_n_Angkatan")[$i][$w];
		        $data['No_Urut_Hari'] = $i;
		        $data['idpaket'] = $this->input->post('paket')[$i];
		        if($this->input->post('tgl')[$i] ==''){
		            $tgl = null;
		        }else{
		            $tgl = $this->input->post('tgl')[$i];
		        }
		        $data['Tgl'] = $tgl ;
		        if($this->input->post('tgl')[$i] != ''){
                    $timestamp = strtotime($this->input->post('tgl')[$i]);
                    $day = date('D', $timestamp);
                    $hari = array_keys($dayval,$day);
                    $hari = $dayList[$hari[0]];        
		        }else{
		            $hari = null;
		        }
		        $data['Hari'] = $hari;
		        $data['No_Urut_Sesi'] = ((int)$w+1);
		        if($this->input->post("FKd_Sesi_Satuan") != null){
		            if (array_key_exists($i, $this->input->post("FKd_Sesi_Satuan"))) {
		                if (array_key_exists($w,$this->input->post("FKd_Sesi_Satuan")[$i])){
		                    $sesi_satuan = $this->input->post("FKd_Sesi_Satuan")[$i][$w];
		                }else{
		                    $sesi_satuan = null;
		                }
		            }else{
		                $sesi_satuan = null;
		            }
		        }else{
		            $sesi_satuan = null;   
		        }
		        $data['FKd_Sesi_Satuan'] = $sesi_satuan; 
		        
		        if($this->input->post("id") != null){
		            if (array_key_exists($i, $this->input->post("id"))) {
		                if (array_key_exists($w,$this->input->post("id")[$i])){
		                    $ida = $this->input->post("id")[$i][$w];
		                }else{
		                    $ida = null;
		                }
		            }else{
		                $ida = null;
		            }
		        }else{
		            $ida = null;   
		        }
		        $data ['id'] = $ida;  
		        
		        if($this->input->post("FKd_Materi_n_Aktifitas") != null){
		            if (array_key_exists($i, $this->input->post("FKd_Materi_n_Aktifitas"))) {
		                if (array_key_exists($w,$this->input->post("FKd_Materi_n_Aktifitas")[$i])){
		                    $materi_aktifitas = $this->input->post("FKd_Materi_n_Aktifitas")[$i][$w];
		                }else{
		                    $materi_aktifitas = null;
		                }
		            }else{
		                $materi_aktifitas = null;
		            }
		        }else{
		            $materi_aktifitas = null;   
		        }
		        $data ['FKd_Materi_n_Aktifitas'] = $materi_aktifitas;  
		        
		        if($this->input->post("FId_Instruktur") != null){
		            if (array_key_exists($i, $this->input->post("FId_Instruktur"))) {
		                if (array_key_exists($w,$this->input->post("FId_Instruktur")[$i])){
		                    $instruktur = $this->input->post("FId_Instruktur")[$i][$w];
		                }else{
		                    $instruktur = null;
		                }
		            }else{
		                $instruktur = null;
		            }
		        }else{
		            $instruktur = null;   
		        }
		        $data['FId_Instruktur'] = $instruktur; 
		        $data['tgl_print'] = $this->input->post('tgl_print'); 
		        
		        //if($data['id'] == null || $data['id'] == ''){
		            $data1 = $data;
		            unset($data1['id']);
		            $this->db->insert("tre_pembukaankelas_n_angkatan_sesi",$data1);
		            $insert_id = $this->db->insert_id();
		            $find = $this->db->where(array('Kd_Sesi_Satuan'=>$data ['FKd_Sesi_Satuan']))->get("ref_sesi_satuan");
		            if($find->num_rows()>0){
		                $str = $find->row()->Desc_Sesi;
		                $str = str_replace("(","",$str);
		                $str = str_replace(")","",$str);
		                $str = str_replace(" ","",$str);
		                $str = explode("-",$str);
		                //$start = str_replace(".",":",$str[0]);
		                $start = $str[0];
		                //$start = $start;
		                //$end = str_replace(".",":",$str[1]);
		                $end = $str[1];
		                //$end = $end;
		                /*$time1 = strtotime($start);
                        $time2 = strtotime($end);
                        $difference = round(abs($time2 - $time1) / 3600,2);*/
                        $array1 = explode('.', $start);
                        $array2 = explode('.', $end);
                    
                        $minutes1 = ($array1[0] * 60.0 + $array1[1]);
                        $minutes2 = ($array2[0] * 60.0 + $array2[1]);
                    
                        $difference = $minutes2 - $minutes1;
		            }else{
		                $start = null;
		                $end = null;
		                $difference =0;
		            }
		            $data2 = array(
		                'FId_Instruktur'=>$data['FId_Instruktur'],
		                'FId_Kelas_n_Angkatan'=>$data ['FId_Kelas_n_Angkatan'],
		                'FKd_Materi'=>$data['FKd_Materi_n_Aktifitas'],
		                'Tgl_Mengajar'=>$data['Tgl'],
		                'Jam_Mulai'=>$start,
		                'Jam_Berakhir'=>$end,
		                'Jml_SesiJamLat'=>$difference,
		                'Jumlah_Bayar'=>0,
		                'Flag_SudahDibayar'=>'N',
		                'idpembukaankelasangkatan'=>$insert_id,
		                );
		            $cekmateridlu = $this->db->where(array('Kd_Materi_n_Aktifitas'=>$data['FKd_Materi_n_Aktifitas']))->get("mst_materi_n_aktifitas");
    		        if($cekmateridlu->num_rows()>0){
    		          if($cekmateridlu->row()->Flag_Daftar_Nilai != "Y" && $cekmateridlu->row()->Flag_Evaluasi_Instruktur != "Y"){
    		          }else{
                        $this->db->set('Id_InstrukturNgajar_diKelas', 'UUID()', FALSE);
    		            $this->db->insert("trm_instrukturngajar_dikelas",$data2);
    		          }
    		        }
		        
		        //echo '<pre>' . var_export($data, true) . '</pre>';
		       // $this->db->insert("tre_pembukaankelas_n_angkatan_sesi",$data);
		    }
		   }
		}
		    recordlog("Menambahkan Data ".$this->name);
    		$this->session->set_flashdata(array('success'=>'Data berhasil di simpan','tab_active'=>2));
    		redirect(base_url('kelas-pelatihan/jadwal-kelas/setting/'.$idstore));
	}

	public function edit($id){
		permissions('pengaturan-data-jadwal-kelas');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'FId_Kelas_n_Angkatan'=>$this->db->get("trm_pembukaankelas_n_angkatan"),
			'FKd_Sesi_Satuan'=>$this->db->get("ref_sesi_satuan"),
			'FKd_Materi_n_Aktifitas'=>$this->db->get("mst_materi_n_aktifitas"),
			'FId_Instruktur'=>$this->db->get("mst_instruktur"),
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-jadwal-kelas');

		$kelas = $this->security->xss_clean(html_escape($this->input->post("FId_Kelas_n_Angkatan")));
		$no_urut = $this->security->xss_clean(html_escape($this->input->post("No_Urut_Hari")));
		$tgl = $this->security->xss_clean(html_escape($this->input->post("Tgl")));
		$hari = $this->security->xss_clean(html_escape($this->input->post("Hari")));
		$no_sesi = $this->security->xss_clean(html_escape($this->input->post("No_Urut_Sesi")));
		$fkdsesi = $this->security->xss_clean(html_escape($this->input->post("FKd_Sesi_Satuan")));
		$fkdakt = $this->security->xss_clean(html_escape($this->input->post("FKd_Materi_n_Aktifitas")));
		$fidinst = $this->security->xss_clean(html_escape($this->input->post("FId_Instruktur")));

		$this->form_validation->set_rules('FId_Kelas_n_Angkatan','Nama Kelas','trim|required|xss_clean');	
		$this->form_validation->set_rules('No_Urut_Hari','No Urut Hari','trim|xss_clean');	
		$this->form_validation->set_rules('Tgl','Tanggal','trim|xss_clean');	
		$this->form_validation->set_rules('Hari','Hari','trim|xss_clean');	
		$this->form_validation->set_rules('No_Urut_Sesi','No Urut Sesi','trim|xss_clean');	
		$this->form_validation->set_rules('FKd_Sesi_Satuan','FKd Sesi Satuan','trim|xss_clean');	
		$this->form_validation->set_rules('FKd_Materi_n_Aktifitas','Materi Pelatihan','trim|xss_clean');	
		$this->form_validation->set_rules('FId_Instruktur','Nama Instruktur','trim|xss_clean');	

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'FId_Kelas_n_Angkatan'=>$kelas,				
				'No_Urut_Hari'=>$no_urut,				
				'Tgl'=>$tgl,				
				'Hari'=>$hari,				
				'No_Urut_Sesi'=>$no_sesi,				
				'FKd_Sesi_Satuan'=>$fkdsesi,				
				'FKd_Materi_n_Aktifitas'=>$fkdakt,				
				'FId_Instruktur'=>$fidinst,				
			);
			recordlog("Merubah Data ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('kelas-pelatihan/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-jadwal-kelas');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Melihat Detail Data ".$this->name);
		$this->load->view("pages/modul/pelatihan/kelas-pelatihan/".url_title(strtolower($this->name))."/view",$data);
	}

	public function delete($id){
		permissions('menghapus-data-jadwal-kelas');

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
		permissions('menghapus-data-jadwal-kelas');
		recordlog("Menghapus Data ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'kelas-pelatihan/'.url_title(strtolower($this->name)) ) );
	}
	
	public function hapus($id){
	    $cek = 	$this->db->where(array('idpembukaankelasangkatan'=>$id))->delete('tre_pembukaankelas_n_angkatan_sesi');
	    $cek1 = $this->db->where(array('idpembukaankelasangkatan'=>$id))->delete('trm_instrukturngajar_dikelas');
	    if($cek && $cek1){
	        echo 'true';
	    }else{
	        echo 'false';
	    }
	}
	
	public function loadsesi(){
	    $paket = $this->input->post("paket");
	    $tgl = $this->input->post("tgl");
	    $harike = $this->input->post("nohari");
	    $idkelas = $this->input->post("kelas");
	    
	    $data = array(
	        'idkelas'=>$idkelas,
	        'paket'=>$paket,
	        'harike'=>$harike,
	        'tgl'=>$tgl,
			'FKd_Sesi_Satuan'=>$this->db->get("ref_sesi_satuan"),
			'FKd_Materi_n_Aktifitas'=>$this->db->get("mst_materi_n_aktifitas"),
			'FId_Instruktur'=>$this->db->get("mst_instruktur"),
	        );
	    $this->load->view("pages/modul/pelatihan/kelas-pelatihan/jadwal-kelas/settings/formsesi",$data);
	}

	
}
