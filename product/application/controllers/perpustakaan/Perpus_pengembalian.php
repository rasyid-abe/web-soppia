<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perpus_pengembalian extends CI_Controller {
 	protected  $name = 'Data pengembalian'; 
    protected  $model = 'umum/perpustakaan/Rperpuspengembalian_model';
 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Perpustakaan'; 
 	protected  $breadcrumb3 = 'Data Pengembalian'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-perpustakaan');
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
		$this->templatecus->dashboard('pages/modul/umum/perpustakaan/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->nama_anggota;
            $row[] = $field->judul_buku;
            $row[] = $field->jml_pinjam;
            $row[] = tgl_indo($field->tgl_pinjam);
            $row[] = tgl_indo($field->tgl_kembali);
            $row[] = tgl_indo($field->tanggal_kembali);
            $row[] = $this->actiontable($field->id_kembali);

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
		if(accessperm('melihat-data-perpustakaan')){
 			$btn = "<a href='".base_url('perpustakaan/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-perpustakaan')){
			$btn .= "<a href='".base_url('perpustakaan/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-perpustakaan');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'id_buku'=>$this->db->get("perpus_buku"),
			'id_anggota'=>$this->db->get("perpus_anggota"),
			'id_pinjam'=>$this->db
			    ->join("perpus_anggota","perpus_anggota.id_anggota=perpus_peminjaman.id_anggota","left")
			    ->where('status',0)
			    ->get("perpus_peminjaman"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/umum/perpustakaan/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-perpustakaan');	
		
		$pinjam = $this->security->xss_clean(html_escape($this->input->post("id_pinjam")));
		$tglk = $this->security->xss_clean(html_escape($this->input->post("tanggal_kembali")));
		
		$this->form_validation->set_rules('id_pinjam', 'Data Peminjaman', 'trim|required|xss_clean');
		$this->form_validation->set_rules('tgl_kembali', 'Tanggal Kembali', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('perpustakaan/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'id_pinjam'=>$pinjam,
				'tanggal_kembali'=>$tglk
			);
			
			$idbuku = $this->db->query("select id_buku from perpus_peminjaman where id_pinjam='$pinjam'")->row_array();
			$ids = $idbuku['id_buku'];
			$stokbuku = $this->db->query("select jumlah_buku from perpus_buku where id_buku='$ids'")->row_array();
			$jmlbuku  = $this->db->query("select jml_pinjam,id_buku from perpus_peminjaman where id_pinjam='$pinjam'")->row_array();
			
			$jumlah = $stokbuku['jumlah_buku'] + $jmlbuku['jml_pinjam'];
			
			$bukutambah = $jmlbuku['id_buku'];
			$stokupdate = $this->db->query("update perpus_buku set jumlah_buku='$jumlah' where id_buku='$bukutambah'");
			$this->db->query("update perpus_peminjaman set status=1 where id_pinjam='$pinjam'");
			
			recordlog("Menyimpan ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('perpustakaan/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function view($id){
		permissions('melihat-data-perpustakaan');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecordjoin($id)
		);
		recordlog("Mengakses Halaman Detail ".$this->name);
		$this->load->view("pages/modul/umum/perpustakaan/".url_title(strtolower($this->name))."/view",$data);
	}
	
	public function delete($id){
		permissions('menghapus-data-perpustakaan');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('perpustakaan/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-perpustakaan');
		recordlog("Menghapus ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'perpustakaan/'.url_title(strtolower($this->name)) ) );
	}

	
}
