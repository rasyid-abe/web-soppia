<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengadaan_inventaris extends CI_Controller {
 	protected  $name = 'Pengadaan inventaris'; 
    protected  $model = 'umum/at-dan-inventaris/Rpengadaaninventaris_model';
 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'At Dan Inventaris'; 
 	protected  $breadcrumb3 = 'Pengadaan Inventaris'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-pengadaan-inventaris');
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

	public function getdata(){
		$csrf_name = $this->security->get_csrf_token_name();
		$csrf_hash = $this->security->get_csrf_hash(); 
		
		$list = $this->thismodel->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            if($field->Flag_AT_or_Inv != null){
                if($field->Flag_AT_or_Inv == "AT"){
                   $Flag_AT_or_Inv  = "Aktiva Tetap";
                }else{
                   $Flag_AT_or_Inv = "Inventory";
                }
            }else{
                $Flag_AT_or_Inv = "";
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->no_at_inv;
            $row[] = $Flag_AT_or_Inv;
            $row[] = $field->Desc_AT_n_Invent;
            $row[] = tgl_indo($field->Tgl_Pengadaan);
            $row[] = $this->actiontable($field->Id_AT_n_Invent);

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
		if(accessperm('melihat-data-pengadaan-inventaris')){
			$btn = "<a href='".base_url('at-dan-inventaris/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-pengadaan-inventaris')){
			$btn .= "<a href='".base_url('at-dan-inventaris/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-pengadaan-inventaris')){
			$btn .= "<a href='".base_url('at-dan-inventaris/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-pengadaan-inventaris');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
     	recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/umum/at-dan-inventaris/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-pengadaan-inventaris');	

		$kat_at_inv = $this->security->xss_clean(html_escape($this->input->post("kat_at_inv")));
		$no_at_inv = $this->security->xss_clean(html_escape($this->input->post("no_at_inv")));
		$nama = $this->security->xss_clean(html_escape($this->input->post("nama")));
		$tgl_pembelian = $this->security->xss_clean(html_escape($this->input->post("tgl_pembelian")));
		$penanggung_jawab = $this->security->xss_clean(html_escape($this->input->post("penanggung_jawab")));
		$kontak_penanggung_jawab = $this->security->xss_clean(html_escape($this->input->post("kontak_penanggung_jawab")));
		$harga_barang = $this->security->xss_clean(html_escape($this->input->post("harga_barang")));
		$nilai = str_replace(".", "", $harga_barang);
		if($nilai == ""){
			$nilai = 0;
		}else{
			$nilai = $nilai;
		}
		$bukti = $this->security->xss_clean(html_escape($this->input->post("bukti")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("keterangan")));

		$this->form_validation->set_rules('kat_at_inv', 'kategori AT/Inventaris', 'trim|xss_clean');
		$this->form_validation->set_rules('no_at_inv', 'No AT atau Inventaris', 'trim|xss_clean');
		$this->form_validation->set_rules('tgl_pembelian', 'Tanggal pembelian', 'trim|xss_clean');
		$this->form_validation->set_rules('penanggung_jawab', 'penanggung jawab', 'trim|xss_clean');
		$this->form_validation->set_rules('kontak_penanggung_jawab', 'kontak penanggung jawab', 'trim|xss_clean');
		$this->form_validation->set_rules('harga_barang', 'harga barang', 'trim|xss_clean');
		$this->form_validation->set_rules('bukti', 'Bukti', 'trim|xss_clean');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/add'));
		}else{
		    $this->load->library('upload');

			if( !empty($_FILES['bukti']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/',
					'allowed_types'=>'jpeg|jpg|png',
					'max_size'=>1000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('bukti') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
			        redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData = $this->upload->data();
					$filedocument = $uploadData['file_name'];
                	$filedocument = $filedocument;
				}
			}else{
				$filedocument = null;
			}	
			
			$data = array(
                'Desc_AT_n_Invent'=>$nama,
                'Tgl_Pengadaan'=>$tgl_pembelian,
                'Flag_AT_or_Inv'=>$kat_at_inv,
                'no_at_inv'=>$no_at_inv,
                'penanggung_jawab'=>$penanggung_jawab,
                'kontak_penanggung_jawab'=>$kontak_penanggung_jawab,
                'bukti'=>$filedocument,
                'Keterangan'=>$keterangan,
                'Harga_Perolehan_Rp'=>$nilai,
			);
			
			$this->thismodel->insertdt($data);
        	recordlog("Menambahkan data ".$this->name);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-pengadaan-inventaris');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Edit '.$this->breadcrumb3,
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
     	recordlog("Mengakses Halaman Edit ".$this->name);
		$this->templatecus->dashboard('pages/modul/umum/at-dan-inventaris/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-pengadaan-inventaris');

		$kat_at_inv = $this->security->xss_clean(html_escape($this->input->post("kat_at_inv")));
		$no_at_inv = $this->security->xss_clean(html_escape($this->input->post("no_at_inv")));
		$nama = $this->security->xss_clean(html_escape($this->input->post("nama")));
		$tgl_pembelian = $this->security->xss_clean(html_escape($this->input->post("tgl_pembelian")));
		$penanggung_jawab = $this->security->xss_clean(html_escape($this->input->post("penanggung_jawab")));
		$kontak_penanggung_jawab = $this->security->xss_clean(html_escape($this->input->post("kontak_penanggung_jawab")));
		$harga_barang = $this->security->xss_clean(html_escape($this->input->post("harga_barang")));
		$nilai = str_replace(".", "", $harga_barang);
		if($nilai == ""){
			$nilai = 0;
		}else{
			$nilai = $nilai;
		}
		$bukti = $this->security->xss_clean(html_escape($this->input->post("bukti")));
		$keterangan = $this->security->xss_clean(html_escape($this->input->post("keterangan")));

		$this->form_validation->set_rules('kat_at_inv', 'kategori AT/Inventaris', 'trim|xss_clean');
		$this->form_validation->set_rules('no_at_inv', 'No AT atau Inventaris', 'trim|xss_clean');
		$this->form_validation->set_rules('tgl_pembelian', 'Tanggal pembelian', 'trim|xss_clean');
		$this->form_validation->set_rules('penanggung_jawab', 'penanggung jawab', 'trim|xss_clean');
		$this->form_validation->set_rules('kontak_penanggung_jawab', 'kontak penanggung jawab', 'trim|xss_clean');
		$this->form_validation->set_rules('harga_barang', 'harga barang', 'trim|xss_clean');
		$this->form_validation->set_rules('bukti', 'Bukti', 'trim|xss_clean');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
		    $this->load->library('upload');
			$getfile = $this->thismodel->getrecord($id);
			
			if( !empty($_FILES['bukti']['name']) ){
				$config = array(
					'upload_path'=> './uploads/fileapps/',
					'allowed_types'=>'jpeg|jpg|png',
					'max_size'=>1000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('bukti') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/edit/'.$id));
				}else{
                	
					if($getfile->bukti != null || $getfile->bukti <> null || $getfile->bukti != '' || $getfile->bukti <> ''){
						if(file_exists('./uploads/fileapps/'.$getfile->bukti)){
							unlink('./uploads/fileapps/'.$getfile->bukti);
						}
					}

					$uploadData = $this->upload->data();
					$filedocument = $uploadData['file_name'];
                	$filedocument = $filedocument;
				}
			}else{
				$filedocument = $getfile->bukti;
			}	
			
			$data = array(
			    'Desc_AT_n_Invent'=>$nama,
                'Tgl_Pengadaan'=>$tgl_pembelian,
                'Flag_AT_or_Inv'=>$kat_at_inv,
                'no_at_inv'=>$no_at_inv,
                'penanggung_jawab'=>$penanggung_jawab,
                'kontak_penanggung_jawab'=>$kontak_penanggung_jawab,
                'bukti'=>$filedocument,
                'Keterangan'=>$keterangan,
                'Harga_Perolehan_Rp'=>$nilai,
			);
			
			$this->thismodel->updatedt($data,$id);
     	    recordlog("Merubah Data ".$this->name);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('at-dan-inventaris/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-pengadaan-inventaris');
		$data = array(
			'dt'=>$this->thismodel->getrecord($id)
		);
     	recordlog("Melihat ada ".$this->name);
		$this->load->view("pages/modul/umum/at-dan-inventaris/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-pengadaan-inventaris');

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
		permissions('menghapus-data-pengadaan-inventaris');	
		$getfile = $this->thismodel->getrecord($id);
		
		if($getfile->bukti != null || $getfile->bukti <> null || $getfile->bukti != '' || $getfile->bukti <> ''){
			if(file_exists('./uploads/fileapps/'.$getfile->bukti)){
				unlink('./uploads/fileapps/'.$getfile->bukti);
			}
		}
		
		$this->thismodel->deletedt($id);
     	recordlog("Menghapus Data ".$this->name);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'at-dan-inventaris/'.url_title(strtolower($this->name)) ) );
	}

	
}
