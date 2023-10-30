<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengunaan_habis_pakai extends CI_Controller {
 	protected  $name = 'Pengunaan habis pakai'; 
    protected  $model = 'umum/persediaan-habis-pakai/Rpengunaanhabispakai_model';
 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Persediaan Habis Pakai'; 
 	protected  $breadcrumb3 = 'Pengunaan Habis Pakai'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-pengunaan-habis-pakai');
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
		recordlog("Mengakses Halaman Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/umum/persediaan-habis-pakai/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = tgl_indo($field->Tgl_PengadaanPertama);
            $row[] = $field->Desc_Consumables;
            $row[] = $field->Desc_Lokasi_Simpan;
            $row[] = number_format($field->Saldo);
            $row[] = $this->actiontable($field->Id_Consumables);

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
		if(accessperm('melihat-data-pengunaan-habis-pakai')){
			$btn = "<a href='".base_url('persediaan-habis-pakai/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-pengunaan-habis-pakai')){
			$btn .= "<a href='".base_url('persediaan-habis-pakai/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-pengunaan-habis-pakai')){
			$btn .= "<a href='".base_url('persediaan-habis-pakai/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-pengunaan-habis-pakai');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'FKd_Lokasi_Simpan'=>$this->db->get("ref_lokasi_simpan"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/umum/persediaan-habis-pakai/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-pengunaan-habis-pakai');	
		
		$descons = $this->security->xss_clean(html_escape($this->input->post("Desc_Consumables")));
		$tgl = $this->security->xss_clean(html_escape($this->input->post("Tgl_PengadaanPertama")));
		$lokasi = $this->security->xss_clean(html_escape($this->input->post("FKd_Lokasi_Simpan")));
		$nilaiadatitik = $this->security->xss_clean(html_escape($this->input->post("Saldo")));

        $saldo = str_replace(".", "", $nilaiadatitik);
		if($saldo == ""){
			$saldo = 0;
		}else{
			$saldo = $saldo;
		}
		
		$this->form_validation->set_rules('Desc_Consumables', 'Deskripsi Habis Pakai', 'trim|xss_clean');
		$this->form_validation->set_rules('Tgl_PengadaanPertama', 'Tanggal Pengadaan', 'trim|xss_clean');
		$this->form_validation->set_rules('FKd_Lokasi_Simpan', 'Lokasi Simpan', 'trim|xss_clean');
		$this->form_validation->set_rules('Saldo', 'Saldo', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('persediaan-habis-pakai/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'Desc_Consumables'=>$descons,
				'Tgl_PengadaanPertama'=>$tgl,
				'FKd_Lokasi_Simpan'=>$lokasi,
				'Saldo'=>$saldo
			);
			recordlog("Menyimpan Data ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('persediaan-habis-pakai/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-pengunaan-habis-pakai');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'FKd_Lokasi_Simpan'=>$this->db->get("ref_lokasi_simpan"),
			'dtdefault'=>$this->thismodel->getrecordjoin($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Edit ".$this->name);
		$this->templatecus->dashboard('pages/modul/umum/persediaan-habis-pakai/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-pengunaan-habis-pakai');
		
		$descons = $this->security->xss_clean(html_escape($this->input->post("Desc_Consumables")));
		$tgl = $this->security->xss_clean(html_escape($this->input->post("Tgl_PengadaanPertama")));
		$lokasi = $this->security->xss_clean(html_escape($this->input->post("FKd_Lokasi_Simpan")));
		$nilaiadatitik = $this->security->xss_clean(html_escape($this->input->post("Saldo")));

        $saldo = str_replace(str_split(",."),"", $nilaiadatitik);

		$this->form_validation->set_rules('Desc_Consumables', 'Deskripsi Habis Pakai', 'trim|xss_clean');
		$this->form_validation->set_rules('Tgl_PengadaanPertama', 'Tanggal Pengadaan', 'trim|xss_clean');
		$this->form_validation->set_rules('FKd_Lokasi_Simpan', 'Lokasi Simpan', 'trim|xss_clean');
		$this->form_validation->set_rules('Saldo', 'Saldo', 'trim|required|xss_clean');


		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('persediaan-habis-pakai/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
			    'Desc_Consumables'=>$descons,
				'Tgl_PengadaanPertama'=>$tgl,
				'FKd_Lokasi_Simpan'=>$lokasi,
				'Saldo'=>$saldo
			);
			recordlog("Merubah Data ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('persediaan-habis-pakai/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-pengunaan-habis-pakai');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Mengakses Halaman Detail ".$this->name);
		$this->load->view("pages/modul/umum/persediaan-habis-pakai/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-pengunaan-habis-pakai');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('persediaan-habis-pakai/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-pengunaan-habis-pakai');
		recordlog("Menghapus Data ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'persediaan-habis-pakai/'.url_title(strtolower($this->name)) ) );
	}

	
}
