<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggunaan_inventaris extends CI_Controller {
 	protected  $name = 'Penggunaan inventaris'; 
    protected  $model = 'umum/at-dan-inventaris/Rpenggunaaninventaris_model';
 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'At Dan Inventaris'; 
 	protected  $breadcrumb3 = 'Penggunaan Inventaris'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-penggunaan-inventaris');
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
		$this->templatecus->dashboard('pages/modul/umum/at-dan-inventaris/'.url_title(strtolower($this->name)).'/index',$data);
	}
	
	public function getno($data){
	    $rs = '' ;
	    if($data != null || $data != ''){
	        $rs = $this->db->where(array("Id_AT_n_Invent"=>$data))->get("mst_at_n_invent");
	        $rs = $rs->row()->no_at_inv;
	    }else{
	        $rs = "<code>N/A</code>";
	    }
	    return $rs;
	}
	
	public function getflag($data){
	    $rs = '' ;
	    if($data != null || $data != ''){
	        $rs = $this->db->where(array("Id_AT_n_Invent"=>$data))->get("mst_at_n_invent");
	        $rs = $rs->row()->Flag_AT_or_Inv;
	        if($rs == "INV"){
	            $rs = "INVENTARIS";
	        }else{
	            $rs = "AKTIVA TETAP";
	        }
	    }else{
	        $rs = "<code>N/A</code>";
	    }
	    return $rs;
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
            $row[] = $this->getno($field->FId_ATnInvent);
            $row[] = $this->getflag($field->FId_ATnInvent);
            $row[] = $field->Desc_Transaksi;
            $row[] = tgl_indo($field->Tgl_TransaksiAwal);
            $row[] = tgl_indo($field->Tgl_TransaksiAkhir); 
            $row[] = $this->actiontable($field->Id_TransEksploit_ATnInven_t);

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

	public function actiontable($id){
		if(accessperm('melihat-data-penggunaan-inventaris')){
			$btn = "<a href='".base_url('at-dan-inventaris/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-penggunaan-inventaris')){
			$btn .= "<a href='".base_url('at-dan-inventaris/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-penggunaan-inventaris')){
			$btn .= "<a href='".base_url('at-dan-inventaris/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-penggunaan-inventaris');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'at_inv' => $this->db->get("mst_at_n_invent"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
     	recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/umum/at-dan-inventaris/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-penggunaan-inventaris');
		
		$no_at_n_invetaris = $this->security->xss_clean(html_escape($this->input->post("no_at_n_invetaris")));
		$desc_transaksi = $this->security->xss_clean(html_escape($this->input->post("desc_transaksi")));
		$penggung_jawab = $this->security->xss_clean(html_escape($this->input->post("penggung_jawab")));
		$tgl_pinjam = $this->security->xss_clean(html_escape($this->input->post("tgl_pinjam")));
		$tgl_kembali = $this->security->xss_clean(html_escape($this->input->post("tgl_kembali")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("keterangan")));
		
		$this->form_validation->set_rules('no_at_n_invetaris', 'No AT dan Inventaris', 'trim|required|xss_clean');
		$this->form_validation->set_rules('desc_transaksi', 'Deskripsi Penggunaan', 'trim|xss_clean');
		$this->form_validation->set_rules('penggung_jawab', 'Penanggung Jawab', 'trim|xss_clean');
		$this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'trim|xss_clean');
		$this->form_validation->set_rules('tgl_kembali', 'Tanggal Kembali', 'trim|xss_clean');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'FId_ATnInvent'=>$no_at_n_invetaris,
				'Desc_Transaksi'=>$desc_transaksi,
				'Flag_JnsTransaksi'=>'G',
				'PenanggungJwb'=>$penggung_jawab,
				'Nilai_Rp'=>null,
				'Tgl_TransaksiAwal'=>($tgl_pinjam!="")?$tgl_pinjam:null,
				'Tgl_TransaksiAkhir'=>($tgl_kembali!="")?$tgl_kembali:null,
				'Keterangan'=>$keterangan,
			);
			
			$this->thismodel->insertdt($data);
     	    recordlog("Menambahkan data ".$this->name);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-penggunaan-inventaris');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'at_inv' => $this->db->get("mst_at_n_invent"),
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
     	recordlog("Mengakses Halaman Edit ".$this->name);
		$this->templatecus->dashboard('pages/modul/umum/at-dan-inventaris/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-penggunaan-inventaris');
        
        $no_at_n_invetaris = $this->security->xss_clean(html_escape($this->input->post("no_at_n_invetaris")));
		$desc_transaksi = $this->security->xss_clean(html_escape($this->input->post("desc_transaksi")));
		$penggung_jawab = $this->security->xss_clean(html_escape($this->input->post("penggung_jawab")));
		$tgl_pinjam = $this->security->xss_clean(html_escape($this->input->post("tgl_pinjam")));
		$tgl_kembali = $this->security->xss_clean(html_escape($this->input->post("tgl_kembali")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("keterangan")));
		
		$this->form_validation->set_rules('no_at_n_invetaris', 'No AT dan Inventaris', 'trim|xss_clean');
		$this->form_validation->set_rules('desc_transaksi', 'Deskripsi Penggunaan', 'trim|xss_clean');
		$this->form_validation->set_rules('penggung_jawab', 'Penanggung Jawab', 'trim|xss_clean');
		$this->form_validation->set_rules('tgl_pinjam', 'Tanggal Pinjam', 'trim|xss_clean');
		$this->form_validation->set_rules('tgl_kembali', 'Tanggal Kembali', 'trim|xss_clean');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'FId_ATnInvent'=>$no_at_n_invetaris,
				'Desc_Transaksi'=>$desc_transaksi,
				'PenanggungJwb'=>$penggung_jawab,
				'Tgl_TransaksiAwal'=>($tgl_pinjam!="")?$tgl_pinjam:null,
				'Tgl_TransaksiAkhir'=>($tgl_kembali!="")?$tgl_kembali:null,
				'Keterangan'=>$keterangan,
			);
			$this->thismodel->updatedt($data,$id);
     	    recordlog("Merubah data ".$this->name);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-penggunaan-inventaris');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
     	recordlog("Mengakses Halaman Lihat data ".$this->name);
		$this->load->view("pages/modul/umum/at-dan-inventaris/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-penggunaan-inventaris');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('at-dan-inventaris/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-penggunaan-inventaris');
		$this->thismodel->deletedt($id);
     	recordlog("Menghapus data ".$this->name);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'at-dan-inventaris/'.url_title(strtolower($this->name)) ) );
	}

	
}
