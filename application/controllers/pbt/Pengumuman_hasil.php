<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman_hasil extends CI_Controller {
 	protected  $name = 'Pengumuman hasil'; 
    protected  $model = 'pelatihan/pbt/Rhasil_model'; 
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
		permissions('melihat-data-pengumuman-hasil-pbt');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Pengumuman Hasil Ujian',
			'titlepage'=>'Pengumuman Hasil Ujian',
			'subtitlepage'=>'Data Pengumuman Hasil Ujian',
			'titlebox'=>'Manage Pengumuman Hasil Ujian',
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
            $row[] = '<a href="'.base_url("pbt/pengumuman-hasil/hasil/".$field->Id_Kelas_n_Angkatan).'">'.$field->DescBebas_Kelas_n_Angkatan.'</a>' ;
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
		if(accessperm('melihat-data-pengumuman-hasil-pbt')){
			$btn = "<a href='".base_url('pbt/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-box-tool view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a>";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-pengumuman-hasil-pbt')){
			$btn .= "<a href='".base_url('pbt/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-box-tool' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a>";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-pengumuman-hasil-pbt')){
			$btn .= "<a href='".base_url('pbt/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-box-tool delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-pengumuman-hasil-pbt');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Pengumuman Hasil',
			'titlepage'=>'Pengumuman Hasil',
			'subtitlepage'=>'Data Pengumuman Hasil',
			'titlebox'=>'Add Pengumuman Hasil',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pbt/'.url_title(strtolower($this->name)).'/add',$data);
	}
	
	public function hasil(){
		permissions('melihat-data-scanning-lembar-jawaban');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$id_kelas = $this->uri->segment(4);

		$qia = $this->db
			->join("kelas_qia","kelas_qia.id_kelas = trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan")
			->where(array('trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan'=>$id_kelas))
			->get('trm_pembukaankelas_n_angkatan');

		if($qia->num_rows()>0){
			$peserta = $this->db
			->join("kelas_qia","kelas_qia.id_kelas = trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan")
			->join("mst_peserta","mst_peserta.Id_Peserta = kelas_qia.id_peserta")
			->where(array('trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan'=>$id_kelas))
			->get('trm_pembukaankelas_n_angkatan');
		}else{
			$peserta = $this->db
			->join("kelas_nonqia","kelas_nonqia.id_kelas = trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan")
			->join("mst_peserta","mst_peserta.Id_Peserta = kelas_nonqia.id_peserta")
			->where(array('trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan'=>$id_kelas))
			->get('trm_pembukaankelas_n_angkatan');
		}

		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Pengumuman Hasil Ujian',
			'titlepage'=>'Pengumuman Hasil Ujian',
			'subtitlepage'=>'Data Pengumuman Hasil Ujian',
			'titlebox'=>'Manage Pengumuman Hasil Ujian',
			'kelas'=>$this->db
                        ->where("Id_Kelas_n_Angkatan",$id_kelas)
                        ->get("trm_pembukaankelas_n_angkatan")->row(),
            /*'hasil'=>$this->db
			            ->join("mst_peserta","mst_peserta.Id_Peserta=tre_bukakelasangkatan_peserta_hasilujian.FId_Peserta",'left')
                        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=tre_bukakelasangkatan_peserta_hasilujian.FId_Kelas_n_Angkatan",'left')
                        ->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=tre_bukakelasangkatan_peserta_hasilujian.FKd_Materi_n_Aktifitas",'left')
                        ->where("tre_bukakelasangkatan_peserta_hasilujian.FId_Kelas_n_Angkatan",$id_kelas)
                        ->get("tre_bukakelasangkatan_peserta_hasilujian")->result(),*/
            	'hasil'=> $peserta,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pbt/'.url_title(strtolower($this->name)).'/hasil',$data);
	}

	public function store(){	
		permissions('menambahkan-data-pengumuman-hasil-pbt');	
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				
			);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-pengumuman-hasil-pbt');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Pengumuman Hasil',
			'titlepage'=>'Pengumuman Hasil',
			'subtitlepage'=>'Data Pengumuman Hasil',
			'titlebox'=>'Edit Pengumuman Hasil',
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pbt/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-pengumuman-hasil-pbt');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
			
			);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('pbt/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-pengumuman-hasil-pbt');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		$this->load->view("pages/modul/pelatihan/pbt/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-pengumuman-hasil-pbt');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('pbt/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-pengumuman-hasil-pbt');
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'pbt/'.url_title(strtolower($this->name)) ) );
	}

	public function hasilhh($id,$idd){
		permissions('melihat-data-scanning-lembar-jawaban');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$id_kelas = $this->uri->segment(4);
		$peserta = $this->uri->segment(5);

		$qia = $this->db
			->join("kelas_qia","kelas_qia.id_kelas = trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan")
			->where(array('trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan'=>$id_kelas))
			->get('trm_pembukaankelas_n_angkatan');

		if($qia->num_rows()>0){
			$peserta = $this->db
			->join("kelas_qia","kelas_qia.id_kelas = trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan")
			->join("mst_peserta","mst_peserta.Id_Peserta = kelas_qia.id_peserta")
			->where(array('trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan'=>$id_kelas,'mst_peserta.Id_Peserta'=>$peserta))
			->get('trm_pembukaankelas_n_angkatan');
		}else{
			$peserta = $this->db
			->join("kelas_nonqia","kelas_nonqia.id_kelas = trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan")
			->join("mst_peserta","mst_peserta.Id_Peserta = kelas_nonqia.id_peserta")
			->where(array('trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan'=>$id_kelas,'mst_peserta.Id_Peserta'=>$peserta))
			->get('trm_pembukaankelas_n_angkatan');
		}

		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Pengumuman Hasil Ujian',
			'titlepage'=>'Pengumuman Hasil Ujian',
			'subtitlepage'=>'Data Pengumuman Hasil Ujian',
			'titlebox'=>'Manage Pengumuman Hasil Ujian',
			'kelas'=>$this->db
                        ->where("Id_Kelas_n_Angkatan",$id_kelas)
                        ->get("trm_pembukaankelas_n_angkatan")->row(),
            	'hasil'=> $peserta,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/pbt/'.url_title(strtolower($this->name)).'/hasilhh',$data);
	}

	public function printddasd($id,$idd){

		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$id_kelas = $this->uri->segment(4);
		$peserta = $this->uri->segment(5);


		$qia = $this->db
			->join("kelas_qia","kelas_qia.id_kelas = trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan")
			->where(array('trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan'=>$id_kelas))
			->get('trm_pembukaankelas_n_angkatan');

		if($qia->num_rows()>0){
			$peserta = $this->db
			->join("kelas_qia","kelas_qia.id_kelas = trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan")
			->join("mst_peserta","mst_peserta.Id_Peserta = kelas_qia.id_peserta")
			->where(array('trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan'=>$id_kelas,'mst_peserta.Id_Peserta'=>$peserta))
			->get('trm_pembukaankelas_n_angkatan');
		}else{
			$peserta = $this->db
			->join("kelas_nonqia","kelas_nonqia.id_kelas = trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan")
			->join("mst_peserta","mst_peserta.Id_Peserta = kelas_nonqia.id_peserta")
			->where(array('trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan'=>$id_kelas,'mst_peserta.Id_Peserta'=>$peserta))
			->get('trm_pembukaankelas_n_angkatan');
		}

		$data = array(
			'kelas'=>$this->db
                        ->where("Id_Kelas_n_Angkatan",$id_kelas)
                        ->get("trm_pembukaankelas_n_angkatan")->row(),
            	'hasil'=> $peserta,
		);

		$this->load->view('pages/modul/pelatihan/pbt/pengumuman-hasil/print_hasil',$data);
	}

	
}
