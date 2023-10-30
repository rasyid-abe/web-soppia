<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_soal extends CI_Controller {
 	protected  $name = 'Bank soal'; 
    protected  $model = 'pelatihan/cbt/Rbanksoal_model'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'CBT'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-bank-soal');
		$urlnow = uri_string();
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Bank Soal',
			'titlepage'=>'Bank Soal',
			'subtitlepage'=>'Data Bank Soal',
			'titlebox'=>'Manage Bank Soal',
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/cbt/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = ($field->NamaLengkap_DgnGelar!= null)? $field->NamaLengkap_DgnGelar : '<code>N/A</code>';
            $row[] = ($field->Desc_Materi_n_Aktifitas!= null)? $field->Desc_Materi_n_Aktifitas : '<code>N/A</code>';
            $row[] = ($field->Desc_SubBab!= null)? $field->Desc_SubBab : '<code>N/A</code>';
            $row[] = $this->actiontable($field->Id_Soal);

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
		if(accessperm('melihat-data-bank-soal')){
			$btn = "<a href='".base_url('cbt/'.url_title(strtolower($this->name))."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-bank-soal')){
			$btn .= "<a href='".base_url('cbt/'.url_title(strtolower($this->name))."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-bank-soal')){
			$btn .= "<a href='".base_url('cbt/'.url_title(strtolower($this->name))."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-bank-soal');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Bank Soal',
			'titlepage'=>'Bank Soal',
			'subtitlepage'=>'Data Bank Soal',
			'titlebox'=>'Add Bank Soal',
			'materi'=>$this->db->get("mst_materi_n_aktifitas"),
			'subbab'=>$this->db
			                ->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=mst_materi_subbab.FKd_Materi_n_Aktifitas",'left')
			                ->get("mst_materi_subbab"),
			'instruktur'=>$this->db->get("mst_instruktur"),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/cbt/'.url_title(strtolower($this->name)).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-bank-soal');
		
		$instruktur = $this->security->xss_clean(html_escape($this->input->post("instruktur")));
		$materipel = $this->security->xss_clean(html_escape($this->input->post("materipel")));
		$subbabm = $this->security->xss_clean(html_escape($this->input->post("subbabm")));
		$pertanyaan = $this->security->xss_clean(html_escape($this->input->post("Isi_PertanyaanSoal")));
		$tingkat = $this->security->xss_clean(html_escape($this->input->post("Tingkat_Kesulitan")));
		$benar = $this->security->xss_clean(html_escape($this->input->post("Jawab_yg_Benar")));
		$penjelasan = $this->security->xss_clean(html_escape($this->input->post("Penjelasan_Jawaban")));
		$point = $this->security->xss_clean(html_escape($this->input->post("Flag_4PointJwb")));
		$pointa = $this->security->xss_clean(html_escape($this->input->post("Jawab_Point_a")));
		$pointb = $this->security->xss_clean(html_escape($this->input->post("Jawab_Point_b")));
		$pointc = $this->security->xss_clean(html_escape($this->input->post("Jawab_Point_c")));
		$pointd = $this->security->xss_clean(html_escape($this->input->post("Jawab_Point_d")));
		$pointe = $this->security->xss_clean(html_escape($this->input->post("Jawab_Point_e")));
		
		$this->form_validation->set_rules('instruktur', 'instruktur', 'trim|xss_clean');
		$this->form_validation->set_rules('materipel', 'materipel', 'trim|xss_clean');
		$this->form_validation->set_rules('subbabm', 'subbabm', 'trim|xss_clean');
		$this->form_validation->set_rules('Isi_PertanyaanSoal', 'Isi_PertanyaanSoal', 'trim|xss_clean');
		$this->form_validation->set_rules('Tingkat_Kesulitan', 'Tingkat_Kesulitan', 'trim|xss_clean');
		$this->form_validation->set_rules('Jawab_yg_Benar', 'Jawab_yg_Benar', 'trim|xss_clean');
		$this->form_validation->set_rules('Penjelasan_Jawaban', 'Penjelasan_Jawaban', 'trim|xss_clean');
		$this->form_validation->set_rules('Flag_4PointJwb', 'Flag_4PointJwb', 'trim|xss_clean');
		$this->form_validation->set_rules('Jawab_Point_a', 'Jawab_Point_a', 'trim|xss_clean');
		$this->form_validation->set_rules('Jawab_Point_b', 'Jawab_Point_b', 'trim|xss_clean');
		$this->form_validation->set_rules('Jawab_Point_c', 'Jawab_Point_c', 'trim|xss_clean');
		$this->form_validation->set_rules('Jawab_Point_d', 'Jawab_Point_d', 'trim|xss_clean');
		$this->form_validation->set_rules('Jawab_Point_e', 'Jawab_Point_e', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/add'));
		}else{
		    
		    $this->load->library('upload');

			if( !empty($_FILES['Path_FileLampiran']['name']) ){
				$config = array(
					'upload_path'=> './uploads/soal/',
					'allowed_types'=>'png|gif|jpeg|jpg',
					'max_size'=>3000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('Path_FileLampiran') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData = $this->upload->data();
					$filephoto = $uploadData['file_name'];
				}
			}else{
				$filephoto = null;
			}	
			
			$data = array(
				'FKd_Materi_n_Aktifitas'=>$materipel,
				'FKd_SubBab'=>$subbabm,
				'Isi_PertanyaanSoal'=>$pertanyaan,
				'Flag_4PointJwb'=>$point,
				'Jawab_Point_a'=>$pointa,
				'Jawab_Point_b'=>$pointb,
				'Jawab_Point_c'=>$pointc,
				'Jawab_Point_d'=>$pointd,
				'Jawab_Point_e'=>$pointe,
				'Jawab_yg_Benar'=>$benar,
				'Tingkat_Kesulitan'=>$tingkat,
				'Penjelasan_Jawaban'=>$penjelasan,
				'FId_Instruktur'=>$instruktur,
				'Path_FileLampiran'=>$filephoto
			);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data Berhasil Disimpan');
			redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-bank-soal');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>'Bank Soal',
			'titlepage'=>'Bank Soal',
			'subtitlepage'=>'Data Bank Soal',
			'titlebox'=>'Edit Bank Soal',			
			'materi'=>$this->db->get("mst_materi_n_aktifitas"),
			'subbab'=>$this->db
			                ->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=mst_materi_subbab.FKd_Materi_n_Aktifitas",'left')
			                ->get("mst_materi_subbab"),
			'instruktur'=>$this->db->get("mst_instruktur"),
			'dtdefault'=>$this->thismodel->getrecord($id),
			'urlback'=>$this->db->where("url",$urlnow)->get("menu")
		);
		$this->templatecus->dashboard('pages/modul/pelatihan/cbt/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-bank-soal');
		
		$instruktur = $this->security->xss_clean(html_escape($this->input->post("instruktur")));
		$materipel = $this->security->xss_clean(html_escape($this->input->post("materipel")));
		$subbabm = $this->security->xss_clean(html_escape($this->input->post("subbabm")));
		$pertanyaan = $this->security->xss_clean(html_escape($this->input->post("Isi_PertanyaanSoal")));
		$tingkat = $this->security->xss_clean(html_escape($this->input->post("Tingkat_Kesulitan")));
		$benar = $this->security->xss_clean(html_escape($this->input->post("Jawab_yg_Benar")));
		$penjelasan = $this->security->xss_clean(html_escape($this->input->post("Penjelasan_Jawaban")));
		$point = $this->security->xss_clean(html_escape($this->input->post("Flag_4PointJwb")));
		$pointa = $this->security->xss_clean(html_escape($this->input->post("Jawab_Point_a")));
		$pointb = $this->security->xss_clean(html_escape($this->input->post("Jawab_Point_b")));
		$pointc = $this->security->xss_clean(html_escape($this->input->post("Jawab_Point_c")));
		$pointd = $this->security->xss_clean(html_escape($this->input->post("Jawab_Point_d")));
		$pointe = $this->security->xss_clean(html_escape($this->input->post("Jawab_Point_e")));
		
		$this->form_validation->set_rules('instruktur', 'instruktur', 'trim|xss_clean');
		$this->form_validation->set_rules('materipel', 'materipel', 'trim|xss_clean');
		$this->form_validation->set_rules('subbabm', 'subbabm', 'trim|xss_clean');
		$this->form_validation->set_rules('Isi_PertanyaanSoal', 'Isi_PertanyaanSoal', 'trim|xss_clean');
		$this->form_validation->set_rules('Tingkat_Kesulitan', 'Tingkat_Kesulitan', 'trim|xss_clean');
		$this->form_validation->set_rules('Jawab_yg_Benar', 'Jawab_yg_Benar', 'trim|xss_clean');
		$this->form_validation->set_rules('Penjelasan_Jawaban', 'Penjelasan_Jawaban', 'trim|xss_clean');
		$this->form_validation->set_rules('Flag_4PointJwb', 'Flag_4PointJwb', 'trim|xss_clean');
		$this->form_validation->set_rules('Jawab_Point_a', 'Jawab_Point_a', 'trim|xss_clean');
		$this->form_validation->set_rules('Jawab_Point_b', 'Jawab_Point_b', 'trim|xss_clean');
		$this->form_validation->set_rules('Jawab_Point_c', 'Jawab_Point_c', 'trim|xss_clean');
		$this->form_validation->set_rules('Jawab_Point_d', 'Jawab_Point_d', 'trim|xss_clean');
		$this->form_validation->set_rules('Jawab_Point_e', 'Jawab_Point_e', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/add'));
		}else{
		    
		    $this->load->library('upload');

			if( !empty($_FILES['Path_FileLampiran']['name']) ){
				$config = array(
					'upload_path'=> './uploads/soal/',
					'allowed_types'=>'png|gif|jpeg|jpg',
					'max_size'=>3000000,
					'encrypt_name'=>true
				);
				$this->upload->initialize($config);
				if( !$this->upload->do_upload('Path_FileLampiran') ){
					$this->session->set_flashdata('error',$this->upload->display_errors());
					redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/add'));
				}else{
					$uploadData = $this->upload->data();
					$filephoto = $uploadData['file_name'];
				}
			}else{
				$dtdefault = $this->thismodel->getrecord($id);
				$filephoto = $dtdefault->Path_FileLampiran;
			}	
			
			$data = array(
				'FKd_Materi_n_Aktifitas'=>$materipel,
				'FKd_SubBab'=>$subbabm,
				'Isi_PertanyaanSoal'=>$pertanyaan,
				'Flag_4PointJwb'=>$point,
				'Jawab_Point_a'=>$pointa,
				'Jawab_Point_b'=>$pointb,
				'Jawab_Point_c'=>$pointc,
				'Jawab_Point_d'=>$pointd,
				'Jawab_Point_e'=>$pointe,
				'Jawab_yg_Benar'=>$benar,
				'Tingkat_Kesulitan'=>$tingkat,
				'Penjelasan_Jawaban'=>$penjelasan,
				'FId_Instruktur'=>$instruktur,
				'Path_FileLampiran'=>$filephoto
			);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data Berhasil Diperbaharui');
			redirect(base_url('cbt/'.url_title(strtolower($this->name)).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-bank-soal');
		$data = array(
			'dtdefault'=>$this->thismodel->getrecord($id)
		);
		$this->load->view("pages/modul/pelatihan/cbt/".url_title(strtolower($this->name))."/view",$data);
	}
	
	public function delete($id){
		permissions('menghapus-data-bank-soal');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-i2"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('cbt/'.url_title(strtolower($this->name))."/delete-exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-bank-soal');
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'cbt/'.url_title(strtolower($this->name)) ) );
	}
}
