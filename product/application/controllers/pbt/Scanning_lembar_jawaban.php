<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scanning_lembar_jawaban extends CI_Controller {
 	protected  $name = 'Scanning lembar jawaban'; 
    protected  $model = 'pelatihan/pbt/Rscanjawaban_model'; 
    protected  $model2 = 'pelatihan/kelas-pelatihan/Rpembukaankelas_model';

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'PBT'; 

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
		permissions('melihat-data-scanning-lembar-jawaban');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Entry Data Ujian',
			'titlepage'=>'Entry Data Ujian',
			'subtitlepage'=>'Data Entry Ujian',
			'titlebox'=>'Manage Entry Data Ujian',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pbt/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = '<a href="'.base_url("pbt/scanning-lembar-jawaban/peserta/".$field->Id_Kelas_n_Angkatan).'">'.$field->DescBebas_Kelas_n_Angkatan.'</a>' ;
            $row[] = $field->nomor_kelas;
            $row[] = $field->No_Urut_Angkatan;
            $row[] = $field->Desc_JenisPelatihan;
            $row[] = tgl_indo($field->Tgl_Mulai_Aktual)." s/d ".tgl_indo($field->Tgl_Selesai_Aktual);

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

	public function actiontable($id){
		if(accessperm('melihat-data-scanning-lembar-jawaban')){
			$btn = "<a href='".base_url('pbt/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-box-tool view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a>";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-scanning-lembar-jawaban')){
			$btn .= "<a href='".base_url('pbt/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-box-tool' data-toggle='tooltip' title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a>";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-scanning-lembar-jawaban')){
			$btn .= "<a href='".base_url('pbt/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-box-tool delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}
	
	public function peserta(){
		permissions('melihat-data-scanning-lembar-jawaban');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$id_kelas = $this->uri->segment(4);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Entry Data Ujian',
			'titlepage'=>'Entry Data Ujian',
			'subtitlepage'=>'Data Entry Ujian',
			'titlebox'=>'Manage Entry Data Ujian',
			'kelas'=>$this->db
                        ->where("Id_Kelas_n_Angkatan",$id_kelas)
                        ->get("trm_pembukaankelas_n_angkatan")->row(),
            'qia'=>$this->db
                        ->where("kelas_qia.id_kelas",$id_kelas)
                        ->get("kelas_qia")->num_rows(),
            'nonqia'=>$this->db
			            ->where("kelas_nonqia.id_kelas",$id_kelas)
                        ->get("kelas_nonqia")->num_rows(),
			'pesertaqia'=>$this->db
			            ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_qia.id_peserta",'left')
                        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=kelas_qia.id_kelas",'left')
                        ->where("kelas_qia.id_kelas",$id_kelas)
                        ->get("kelas_qia")->result(),
            'pesertanonqia'=>$this->db
			            ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_nonqia.id_peserta",'left')
                        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=kelas_nonqia.id_kelas",'left')
                        ->where("kelas_nonqia.id_kelas",$id_kelas)
                        ->get("kelas_nonqia")->result(),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pbt/'.url_title(strtolower($this->name)).'/peserta',$data);
	}
	
	public function add(){
		permissions('menambahkan-data-scanning-lembar-jawaban');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$id_peserta = $this->uri->segment(4);
		$id_kelas = $this->uri->segment(5);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Entry Data Ujian',
			'titlepage'=>'Entry Data Ujian',
			'subtitlepage'=>'Data Entry Ujian',
			'titlebox'=>'Manage Entry Data Ujian',	
			'kelas'=>$this->db
                        ->where("Id_Kelas_n_Angkatan",$id_kelas)
                        ->get("trm_pembukaankelas_n_angkatan")->row(),	
			'peserta'=>$this->db
                        ->where("Id_Peserta",$id_peserta)
                        ->get("mst_peserta")->row(),
            'materi'=>$this->db
                        ->select("any_value(tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas) as FKd_Materi_n_Aktifitas, 
                                  any_value(mst_materi_n_aktifitas.Desc_Materi_n_Aktifitas) as Desc_Materi_n_Aktifitas")
                        ->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas",'left')
                        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=tre_pembukaankelas_n_angkatan_sesi.FId_Kelas_n_Angkatan",'left')
                        ->where("tre_pembukaankelas_n_angkatan_sesi.FId_Kelas_n_Angkatan",$id_kelas)
                        ->where("tre_pembukaankelas_n_angkatan_sesi.FId_Instruktur !=",'')
                        ->group_by("tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas")
                        ->get("tre_pembukaankelas_n_angkatan_sesi")->result(),
            'hasil'=>$this->db
            			->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=tre_bukakelasangkatan_peserta_hasilher.FKd_Materi_n_Aktifitas",'left')
            			->where("tre_bukakelasangkatan_peserta_hasilher.FId_Kelas_n_Angkatan",$id_kelas)
            			->where("tre_bukakelasangkatan_peserta_hasilher.FId_Peserta",$id_peserta)
            			->order_by("tre_bukakelasangkatan_peserta_hasilher.Ujian_Ke",'asc')
            			->get("tre_bukakelasangkatan_peserta_hasilher")->result(),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pbt/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function her(){
		permissions('menambahkan-data-scanning-lembar-jawaban');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$id_peserta = $this->uri->segment(4);
		$id_kelas = $this->uri->segment(5);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Entry Data Her',
			'titlepage'=>'Entry Data Her',
			'subtitlepage'=>'Data Entry Her',
			'titlebox'=>'Manage Entry Data Her',	
			'kelas'=>$this->db
                        ->where("Id_Kelas_n_Angkatan",$id_kelas)
                        ->get("trm_pembukaankelas_n_angkatan")->row(),	
			'peserta'=>$this->db
                        ->where("Id_Peserta",$id_peserta)
                        ->get("mst_peserta")->row(),    
            'hasil'=>$this->db
            			->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=tre_bukakelasangkatan_peserta_hasilujian.FKd_Materi_n_Aktifitas",'left')
            			->where("tre_bukakelasangkatan_peserta_hasilujian.FId_Kelas_n_Angkatan",$id_kelas)
            			->where("tre_bukakelasangkatan_peserta_hasilujian.FId_Peserta",$id_peserta)
            			->where("tre_bukakelasangkatan_peserta_hasilujian.Flag_LulusUjian1",'N')
            			->get("tre_bukakelasangkatan_peserta_hasilujian")->result(),   
            'her2'=>$this->db
            			->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=tre_bukakelasangkatan_peserta_hasilujian.FKd_Materi_n_Aktifitas",'left')
            			->where("tre_bukakelasangkatan_peserta_hasilujian.FId_Kelas_n_Angkatan",$id_kelas)
            			->where("tre_bukakelasangkatan_peserta_hasilujian.FId_Peserta",$id_peserta)
            			->where("tre_bukakelasangkatan_peserta_hasilujian.Flag_LulusHer1",'N')
            			->get("tre_bukakelasangkatan_peserta_hasilujian"),                 
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pbt/'.url_title(strtolower($this->name)).'/her',$data);
	}

	public function store(){	
		permissions('menambahkan-data-scanning-lembar-jawaban');	

		$kelas = $this->security->xss_clean(html_escape($this->input->post("FId_Kelas_n_Angkatan")));
		$peserta = $this->security->xss_clean(html_escape($this->input->post("FId_Peserta")));
		$materi = $this->security->xss_clean(html_escape($this->input->post("FKd_Materi_n_Aktifitas")));
		$hasil = $this->security->xss_clean(html_escape($this->input->post("Hasil_Ujian1")));
		$tanggal = $this->security->xss_clean(html_escape($this->input->post("Tgl_Ujian1")));
		$flag = $this->security->xss_clean(html_escape($this->input->post("Flag_LulusUjian1")));
		$ke = $this->security->xss_clean(html_escape($this->input->post("ujian_ke")));

		$this->form_validation->set_rules('FId_Kelas_n_Angkatan','FId_Kelas_n_Angkatan','trim|xss_clean');	
		$this->form_validation->set_rules('FId_Peserta','FId_Peserta','trim|xss_clean');	
		$this->form_validation->set_rules('FKd_Materi_n_Aktifitas','FKd_Materi_n_Aktifitas','trim|xss_clean');	
		$this->form_validation->set_rules('Hasil_Ujian1','Hasil_Ujian1','trim|xss_clean');	
		$this->form_validation->set_rules('Tgl_Ujian1','Tgl_Ujian1','trim|xss_clean');	
		$this->form_validation->set_rules('Flag_LulusUjian1','Flag_LulusUjian1','trim|xss_clean');	
		$this->form_validation->set_rules('ujian_ke','ujian_ke','trim|xss_clean');	
		

		$cek = $this->db->query("select * from tre_bukakelasangkatan_peserta_hasilher where Ujian_Ke='$ke' and FId_Kelas_n_Angkatan='$kelas' and FId_Peserta='$peserta' and FKd_Materi_n_Aktifitas='$materi'")->num_rows();	
		$cek2 = $this->db->query("select * from tre_bukakelasangkatan_peserta_hasilujian where FId_Kelas_n_Angkatan='$kelas' and FId_Peserta='$peserta' and FKd_Materi_n_Aktifitas='$materi'")->num_rows();		

		if($cek > 0){
			$this->db->query("update tre_bukakelasangkatan_peserta_hasilher set 
				Hasil_Ujian='$hasil',
				Tgl_Ujian='$tanggal',
				Flag_LulusUjian='$flag' 
				where 
				Ujian_Ke='$ke' and 
				FId_Kelas_n_Angkatan='$kelas' and 
				FId_Peserta='$peserta' and 
				FKd_Materi_n_Aktifitas='$materi'");						

			if($ke == 1){
				$this->db->query("update tre_bukakelasangkatan_peserta_hasilujian set 
					Hasil_Ujian1='$hasil',
					Tgl_Ujian1='$tanggal',
					Flag_LulusUjian1='$flag' 
					where 
					FId_Kelas_n_Angkatan='$kelas' and 
					FId_Peserta='$peserta' and 
					FKd_Materi_n_Aktifitas='$materi'");						

				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));	
			}
			if($ke == 2){
				$this->db->query("update tre_bukakelasangkatan_peserta_hasilujian set 
					Hasil_Her1='$hasil',
					Tgl_Her1='$tanggal',
					Flag_LulusHer1='$flag' 
					where 
					FId_Kelas_n_Angkatan='$kelas' and 
					FId_Peserta='$peserta' and 
					FKd_Materi_n_Aktifitas='$materi'");					

				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));	
			}

			if($ke == 3){
				$this->db->query("update tre_bukakelasangkatan_peserta_hasilujian set 
					Hasil_Her2='$hasil',
					Tgl_Her2='$tanggal',
					Flag_LulusHer2='$flag' 
					where 
					FId_Kelas_n_Angkatan='$kelas' and 
					FId_Peserta='$peserta' and 
					FKd_Materi_n_Aktifitas='$materi'");						

				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));	
			}

			if($ke == 4){
				$this->db->query("update tre_bukakelasangkatan_peserta_hasilujian set 
					Hasil_Extra_Her1='$hasil',
					Tgl_ExtraHer1='$tanggal',
					Flag_LulusExtraHer1='$flag' 
					where 
					FId_Kelas_n_Angkatan='$kelas' and 
					FId_Peserta='$peserta' and 
					FKd_Materi_n_Aktifitas='$materi'");						

				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));	
			}	
		}

		if($cek2 > 0){
			if($ke == 1){
				$this->db->query("update tre_bukakelasangkatan_peserta_hasilujian set 
					Hasil_Ujian1='$hasil',
					Tgl_Ujian1='$tanggal',
					Flag_LulusUjian1='$flag' 
					where 
					FId_Kelas_n_Angkatan='$kelas' and 
					FId_Peserta='$peserta' and 
					FKd_Materi_n_Aktifitas='$materi'");		

				$this->db->query("insert into tre_bukakelasangkatan_peserta_hasilher 
					(FId_Kelas_n_Angkatan,FId_Peserta,FKd_Materi_n_Aktifitas,Ujian_Ke,Hasil_Ujian,Tgl_Ujian,Flag_LulusUjian)
					values 
					('$kelas','$peserta','$materi','$ke','$hasil','$tanggal','$flag')");  

				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));	
			}
			if($ke == 2){
				$this->db->query("update tre_bukakelasangkatan_peserta_hasilujian set 
					Hasil_Her1='$hasil',
					Tgl_Her1='$tanggal',
					Flag_LulusHer1='$flag' 
					where 
					FId_Kelas_n_Angkatan='$kelas' and 
					FId_Peserta='$peserta' and 
					FKd_Materi_n_Aktifitas='$materi'");		

				$this->db->query("insert into tre_bukakelasangkatan_peserta_hasilher 
					(FId_Kelas_n_Angkatan,FId_Peserta,FKd_Materi_n_Aktifitas,Ujian_Ke,Hasil_Ujian,Tgl_Ujian,Flag_LulusUjian)
					values 
					('$kelas','$peserta','$materi','$ke','$hasil','$tanggal','$flag')");  

				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));	
			}

			if($ke == 3){
				$this->db->query("update tre_bukakelasangkatan_peserta_hasilujian set 
					Hasil_Her2='$hasil',
					Tgl_Her2='$tanggal',
					Flag_LulusHer2='$flag' 
					where 
					FId_Kelas_n_Angkatan='$kelas' and 
					FId_Peserta='$peserta' and 
					FKd_Materi_n_Aktifitas='$materi'");		

				$this->db->query("insert into tre_bukakelasangkatan_peserta_hasilher 
					(FId_Kelas_n_Angkatan,FId_Peserta,FKd_Materi_n_Aktifitas,Ujian_Ke,Hasil_Ujian,Tgl_Ujian,Flag_LulusUjian)
					values 
					('$kelas','$peserta','$materi','$ke','$hasil','$tanggal','$flag')");  

				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));	
			}

			if($ke == 4){
				$this->db->query("update tre_bukakelasangkatan_peserta_hasilujian set 
					Hasil_Extra_Her1='$hasil',
					Tgl_ExtraHer1='$tanggal',
					Flag_LulusExtraHer1='$flag' 
					where 
					FId_Kelas_n_Angkatan='$kelas' and 
					FId_Peserta='$peserta' and 
					FKd_Materi_n_Aktifitas='$materi'");		

				$this->db->query("insert into tre_bukakelasangkatan_peserta_hasilher 
					(FId_Kelas_n_Angkatan,FId_Peserta,FKd_Materi_n_Aktifitas,Ujian_Ke,Hasil_Ujian,Tgl_Ujian,Flag_LulusUjian)
					values 
					('$kelas','$peserta','$materi','$ke','$hasil','$tanggal','$flag')");  

				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));	
			}	
		}				
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));
		}else{
			$data = array(
				'FId_Kelas_n_Angkatan'=>$kelas,
				'FId_Peserta'=>$peserta,
				'FKd_Materi_n_Aktifitas'=>$materi,
				'Hasil_Ujian1'=>$hasil,
				'Tgl_Ujian1'=>$tanggal,
				'Flag_LulusUjian1'=>$flag
			);			
			$this->thismodel->insertdt($data);		

			$this->db->query("insert into tre_bukakelasangkatan_peserta_hasilher 
				(FId_Kelas_n_Angkatan,FId_Peserta,FKd_Materi_n_Aktifitas,Ujian_Ke,Hasil_Ujian,Tgl_Ujian,Flag_LulusUjian)
				values 
				('$kelas','$peserta','$materi','$ke','$hasil','$tanggal','$flag')");  

			$this->session->set_flashdata('success', 'Data berhasil disimpan');
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));
		}
	}

	public function nilaiher1(){	
		permissions('menambahkan-data-scanning-lembar-jawaban');	

		$kelas = $this->security->xss_clean(html_escape($this->input->post("FId_Kelas_n_Angkatan")));
		$peserta = $this->security->xss_clean(html_escape($this->input->post("FId_Peserta")));
		$materi = $this->security->xss_clean(html_escape($this->input->post("FKd_Materi_n_Aktifitas")));
		$hasil = $this->security->xss_clean(html_escape($this->input->post("Hasil_Her1")));
		$tanggal = $this->security->xss_clean(html_escape($this->input->post("Tgl_Her1")));
		$flag = $this->security->xss_clean(html_escape($this->input->post("Flag_LulusHer1")));

		$this->form_validation->set_rules('FId_Kelas_n_Angkatan','FId_Kelas_n_Angkatan','trim|xss_clean');	
		$this->form_validation->set_rules('FId_Peserta','FId_Peserta','trim|xss_clean');	
		$this->form_validation->set_rules('FKd_Materi_n_Aktifitas','FKd_Materi_n_Aktifitas','trim|xss_clean');	
		$this->form_validation->set_rules('Hasil_Her1','Hasil_Her1','trim|xss_clean');	
		$this->form_validation->set_rules('Tgl_Her1','Tgl_Her1','trim|xss_clean');	
		$this->form_validation->set_rules('Flag_LulusHer1','Flag_LulusHer1','trim|xss_clean');			
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/her/'.$peserta.'/'.$kelas));
		}else{
			$data = array(
				'FId_Kelas_n_Angkatan'=>$kelas,
				'FId_Peserta'=>$peserta,
				'FKd_Materi_n_Aktifitas'=>$materi,
				'Hasil_Her1'=>$hasil,
				'Tgl_Her1'=>$tanggal,
				'Flag_LulusHer1'=>$flag
			);
			$this->thismodel->updatedt($data,$kelas,$peserta,$materi);
			$this->session->set_flashdata('success', 'Data berhasil disimpan');
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/her/'.$peserta.'/'.$kelas));
		}
	}

	public function nilaiher2(){	
		permissions('menambahkan-data-scanning-lembar-jawaban');	

		$kelas = $this->security->xss_clean(html_escape($this->input->post("FId_Kelas_n_Angkatan")));
		$peserta = $this->security->xss_clean(html_escape($this->input->post("FId_Peserta")));
		$materi = $this->security->xss_clean(html_escape($this->input->post("FKd_Materi_n_Aktifitas")));
		$hasil = $this->security->xss_clean(html_escape($this->input->post("Hasil_Her2")));
		$tanggal = $this->security->xss_clean(html_escape($this->input->post("Tgl_Her2")));
		$flag = $this->security->xss_clean(html_escape($this->input->post("Flag_LulusHer2")));

		$this->form_validation->set_rules('FId_Kelas_n_Angkatan','FId_Kelas_n_Angkatan','trim|xss_clean');	
		$this->form_validation->set_rules('FId_Peserta','FId_Peserta','trim|xss_clean');	
		$this->form_validation->set_rules('FKd_Materi_n_Aktifitas','FKd_Materi_n_Aktifitas','trim|xss_clean');	
		$this->form_validation->set_rules('Hasil_Her1','Hasil_Her2','trim|xss_clean');	
		$this->form_validation->set_rules('Tgl_Her1','Tgl_Her2','trim|xss_clean');	
		$this->form_validation->set_rules('Flag_LulusHer1','Flag_LulusHer2','trim|xss_clean');			
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/her/'.$peserta.'/'.$kelas));
		}else{
			$data = array(
				'FId_Kelas_n_Angkatan'=>$kelas,
				'FId_Peserta'=>$peserta,
				'FKd_Materi_n_Aktifitas'=>$materi,
				'Hasil_Her2'=>$hasil,
				'Tgl_Her2'=>$tanggal,
				'Flag_LulusHer2'=>$flag
			);
			$this->thismodel->updatedt($data,$kelas,$peserta,$materi);
			$this->session->set_flashdata('success', 'Data berhasil disimpan');
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/her/'.$peserta.'/'.$kelas));
		}
	}

	public function hapusher1(){	
		permissions('merubah-data-scanning-lembar-jawaban');
		$kelas = $this->uri->segment(4);
		$peserta = $this->uri->segment(5);
		$materi = $this->uri->segment(6);

		$data = array(
				'Hasil_Her1'=>NULL,
				'Tgl_Her1'=>NULL,
				'Flag_LulusHer1'=>''
			);
		$this->thismodel->updatedt($data,$kelas,$peserta,$materi);
		$this->session->set_flashdata('success', 'Data berhasil dihapus');
		redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/her/'.$peserta.'/'.$kelas));
	}

	public function hapusher2(){	
		permissions('merubah-data-scanning-lembar-jawaban');
		$kelas = $this->uri->segment(4);
		$peserta = $this->uri->segment(5);
		$materi = $this->uri->segment(6);

		$data = array(
				'Hasil_Her2'=>NULL,
				'Tgl_Her2'=>NULL,
				'Flag_LulusHer2'=>''
			);
		$this->thismodel->updatedt($data,$kelas,$peserta,$materi);
		$this->session->set_flashdata('success', 'Data berhasil dihapus');
		redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/her/'.$peserta.'/'.$kelas));
	}
	
	public function delete(){
		permissions('menghapus-data-scanning-lembar-jawaban');
		$kelas = $this->uri->segment(4);
		$peserta = $this->uri->segment(5);
		$materi = $this->uri->segment(6);
		$ujianke = $this->uri->segment(7);		
		$this->db->query("delete from tre_bukakelasangkatan_peserta_hasilher where Ujian_Ke='$ujianke' and FId_Kelas_n_Angkatan='$kelas' and FId_Peserta='$peserta' and FKd_Materi_n_Aktifitas='$materi'");
		if($ujianke == 1){
			$this->thismodel->deletedt($kelas,$peserta,$materi);
			$this->session->set_flashdata('success', 'Data berhasil dihapus');
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));
		}		
		if($ujianke == 2){
			$data = array(
				'Hasil_Her1'=>NULL,
				'Tgl_Her1'=>NULL,
				'Flag_LulusHer1'=>NULL
			);
			$this->thismodel->updatedt($data,$kelas,$peserta,$materi);
			$this->session->set_flashdata('success', 'Data berhasil dihapus');
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));
		}
		if($ujianke == 3){			
			$data = array(
				'Hasil_Her2'=>NULL,
				'Tgl_Her2'=>NULL,
				'Flag_LulusHer2'=>NULL
			);
			$this->thismodel->updatedt($data,$kelas,$peserta,$materi);
			$this->session->set_flashdata('success', 'Data berhasil dihapus');
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));
		}
		if($ujianke == 4){			
			$data = array(
				'Hasil_Extra_Her1'=>NULL,
				'Tgl_ExtraHer1'=>NULL,
				'Flag_LulusExtraHer1'=>NULL
			);
			$this->thismodel->updatedt($data,$kelas,$peserta,$materi);
			$this->session->set_flashdata('success', 'Data berhasil dihapus');
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add/'.$peserta.'/'.$kelas));
		}
	}
}