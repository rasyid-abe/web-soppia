<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket_sesi_harian extends CI_Controller {
 	protected  $name = 'Paket sesi harian'; 
    protected  $model = 'referensi/data-sesi/Rpaketsesiharian_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'Data Sesi'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-paket-sesi-harian');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Paket Sesi Harian',
			'titlepage'=>'Paket Sesi Harian',
			'subtitlepage'=>'Data Paket Sesi Harian',
			'titlebox'=>'Manage Paket Sesi Harian',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses halaman data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/data-sesi/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->Desc_Paket_Sesi_Harian;
            $row[] = $this->actiontable($field->Kd_Paket_Sesi_Harian);

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
		if(accessperm('melihat-data-paket-sesi-harian')){
			$btn = "<a href='".base_url('data-sesi/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a> ";
        }
		if(accessperm('merubah-data-paket-sesi-harian')){
			$btn .= "<a href='".base_url('data-sesi/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-info' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a> ";
        }
		if(accessperm('pengaturan-sesi-paket')){
			$btn .= "<a href='".base_url('data-sesi/'.url_title(strtolower($this->name))."/pengaturansesipaket/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Pengaturan Sesi'> <i class='fa fa-cogs'></i> Pengaturan Sesi</a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a> ";
        }
		if(accessperm('menghapus-data-paket-sesi-harian')){
			$btn .= "<a href='".base_url('data-sesi/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a> ";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a> ";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-paket-sesi-harian');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Paket Sesi Harian',
			'titlepage'=>'Paket Sesi Harian',
			'subtitlepage'=>'Data Paket Sesi Harian',
			'titlebox'=>'Add Paket Sesi Harian',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses halaman Add data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/data-sesi/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-paket-sesi-harian');	

		$description = $this->security->xss_clean(html_escape($this->input->post("Desc_Paket_Sesi_Harian")));

		$this->form_validation->set_rules('Desc_Paket_Sesi_Harian', 'Description', 'trim|required|is_unique[ref_paket_sesi_harian.Desc_Paket_Sesi_Harian]|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('data-sesi/'.url_title(strtolower($this->name)).'/add'));
		}else{
			$data = array(
				'Desc_Paket_Sesi_Harian'=>$description
			);
			$this->thismodel->insertdt($data);
			recordlog("Menambahkan data ".$this->name);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('data-sesi/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-paket-sesi-harian');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Paket Sesi Harian',
			'titlepage'=>'Paket Sesi Harian',
			'subtitlepage'=>'Data Paket Sesi Harian',
			'titlebox'=>'Edit Paket Sesi Harian',
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses halaman Edit data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/data-sesi/'.url_title(strtolower($this->name)).'/edit',$data);
	}


	public function update($id){	
		permissions('merubah-data-paket-sesi-harian');	


		$description = $this->security->xss_clean(html_escape($this->input->post("Desc_Paket_Sesi_Harian")));

		$this->form_validation->set_rules('Desc_Paket_Sesi_Harian', 'Description', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('data-sesi/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}else{
			$data = array(
				'Desc_Paket_Sesi_Harian'=>$description
			);
			$this->thismodel->updatedt($data,$id);
			recordlog("Mengubah data ".$this->name);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('data-sesi/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-paket-sesi-harian');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id),
			'sesi'=>$this->db->where(array('FKd_Paket_Sesi_Harian'=>$id))->get("ref_detil_paket_sesi_harian"),
		);
		recordlog("Melihat data ".$this->name);
		$this->load->view("pages/modul/referensi/data-sesi/".url_title(strtolower($this->name))."/view",$data);
	}

	
	public function delete($id){
		permissions('menghapus-data-paket-sesi-harian');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('data-sesi/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-paket-sesi-harian');
		$this->thismodel->deletedt($id);
		recordlog("Menghapus data ".$this->name);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'data-sesi/'.url_title(strtolower($this->name)) ) );
	}
	
	public function pengaturansesipaket($id){
		permissions('pengaturan-sesi-paket');
		$pkaet = $this->db->where(array("Kd_Paket_Sesi_Harian"=>$id))->get("ref_paket_sesi_harian");
		if($pkaet->num_rows()>0){
		    $paket = $pkaet->row()->Desc_Paket_Sesi_Harian;
		}else{
		    $paket = '';
		}
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$paket,
			'titlepage'=>$paket,
			'subtitlepage'=>'Data Paket Sesi Harian',
			'titlebox'=>'Manage '.$paket,
			'id'=>$id,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		recordlog("Mengakses halaman data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/data-sesi/'.url_title(strtolower($this->name)).'/pengaturan/index',$data);
	}
	
	public function pengaturansesipaketadd($id){
		permissions('pengaturan-sesi-paket');
	    $pkaet = $this->db->where(array("Kd_Paket_Sesi_Harian"=>$id))->get("ref_paket_sesi_harian");
		if($pkaet->num_rows()>0){
		    $paket = $pkaet->row()->Desc_Paket_Sesi_Harian;
		}else{
		    $paket = '';
		}
	    $data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Paket '.$paket,
			'titlepage'=>'Paket '.$paket,
			'subtitlepage'=>'Data '.$paket,
			'idpaket'=>$id,
			'fkd_sesi_satuan'=>$this->db->get("ref_sesi_satuan"),
			'titlebox'=>'Add '.$paket,
		);
		recordlog("Mengakses halaman Add data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/data-sesi/'.url_title(strtolower($this->name)).'/pengaturan/add',$data);
	}
	
	public function pengaturansesipaketstore($id){
		permissions('pengaturan-sesi-paket');
	    $idpaket = $id;
	    $sesi = $this->input->post("FKd_Sesi_Satuan");
	    $data = array(
	        'FKd_Paket_Sesi_Harian'=>$idpaket,
	        'FKd_Sesi_Satuan'=>$sesi,
	        );
	    
        $this->db->set('Kd_detail', 'UUID()', FALSE);
	    $this->db->insert('ref_detil_paket_sesi_harian',$data);
	    
		recordlog("Menambahkan data ".$this->name);
		$this->session->set_flashdata('success', 'Data berhasil di simpan');
		redirect(base_url('data-sesi/paket-sesi-harian/pengaturansesipaketadd/'.$idpaket));
	}
	
	public function pengaturansesipaketview($id1,$id2){
		permissions('pengaturan-sesi-paket');
	    $pkaet = $this->db->where(array("Kd_Paket_Sesi_Harian"=>$id1))->get("ref_paket_sesi_harian");
		if($pkaet->num_rows()>0){
		    $paket = $pkaet->row()->Desc_Paket_Sesi_Harian;
		}else{
		    $paket = '';
		}
        $dtpktharian = $this->db->where(array("Kd_detail"=>$id2))->get("ref_detil_paket_sesi_harian");
        if($dtpktharian->num_rows()>0){
            $sesi = $dtpktharian->row()->FKd_Sesi_Satuan;
            $jamsesi = $this->db->where(array('Kd_Sesi_Satuan'=>$sesi))->get("ref_sesi_satuan");
            if($jamsesi->num_rows()>0){
                $sesi = $jamsesi->row()->Desc_Sesi	;
            }else{
                $sesi = '';
            }
        }else{
            $sesi = '';
        }
	    
	    echo "
	    <table class='table'>
	        <tr>
	            <td>Paket</td>
	            <td>:</td>
	            <td>".$paket."</td>
	        </tr>
	        <tr>
	            <td>Jam Sesi</td>
	            <td>:</td>
	            <td>".$sesi."</td>
	        </tr>
	    </table>
	    ";
	}
	
	public function pengaturansesipaketdelete($id1,$id2){
		permissions('pengaturan-sesi-paket');
		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('data-sesi/paket-sesi-harian/pengaturansesipaket/delete-exec/'.$id1.'/'.$id2).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}
	
	public function pengaturansesipaketdelete_exec($id1,$id2){
		permissions('pengaturan-sesi-paket');
	    $this->db->where(array('Kd_detail'=>$id2))->delete('ref_detil_paket_sesi_harian');
		recordlog("Menghapus data".$this->name);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'data-sesi/paket-sesi-harian/pengaturansesipaket/'.$id1) );
	}

    public function pengaturansesipaketedit($id1,$id2){
		permissions('pengaturan-sesi-paket');
        $pkaet = $this->db->where(array("Kd_Paket_Sesi_Harian"=>$id1))->get("ref_paket_sesi_harian");
		if($pkaet->num_rows()>0){
		    $paket = $pkaet->row()->Desc_Paket_Sesi_Harian;
		}else{
		    $paket = '';
		}
		$dtpktharian = $this->db->where(array("Kd_detail"=>$id2))->get("ref_detil_paket_sesi_harian");
        if($dtpktharian->num_rows()>0){
            $sesi = $dtpktharian->row()->FKd_Sesi_Satuan;
        }else{
            $sesi = '';
        }
	    $data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Paket '.$paket,
			'titlepage'=>'Paket '.$paket,
			'subtitlepage'=>'Data '.$paket,
			'idpaket'=>$id1,
			'idsesi'=>$sesi,
			'idsesireal'=>$id2,
			'fkd_sesi_satuan'=>$this->db->get("ref_sesi_satuan"),
			'titlebox'=>'Edit '.$paket,
		);
		recordlog("Mengakses halaman Edit data ".$this->name);
		$this->templatecus->dashboard('pages/modul/referensi/data-sesi/'.url_title(strtolower($this->name)).'/pengaturan/edit',$data);
    }
    
    public function pengaturansesipaketupdate($id1,$id2){
		permissions('pengaturan-sesi-paket');
        $idpaket = $id1;
	    $sesi = $this->input->post("FKd_Sesi_Satuan");
	    $data = array(
	        'FKd_Paket_Sesi_Harian'=>$idpaket,
	        'FKd_Sesi_Satuan'=>$sesi,
	        );
	    $this->db->where(array('Kd_detail'=>$id2))->update('ref_detil_paket_sesi_harian',$data);
	    
		recordlog("Menambahkan data ".$this->name);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url('data-sesi/paket-sesi-harian/pengaturansesipaketedit/'.$id1.'/'.$id2));
    }
	
}
