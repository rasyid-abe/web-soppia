<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_jadwal extends CI_Controller {
 	protected  $name = 'Data jadwal';
    protected  $model = 'umum/jadwal-kerja/Rjadwal_kerja_model';
 	protected  $breadcrumb1 = 'Dashboard';
 	protected  $breadcrumb2 = 'Jadwal Jam Kerja';
 	protected  $breadcrumb3 = 'Data Jadwal';

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model($this->model,'thismodel');
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}

    public function index(){
		permissions('melihat-data-jadwal-kerja');
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
		$this->templatecus->dashboard('pages/modul/umum/jadwal-kerja/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = $field->shift_jadwal;
            $row[] = $field->jam_mulai_jadwal;
            $row[] = $field->jam_akhir_jadwal;
            $row[] = $field->ket_jadwal;
            $row[] = $this->actiontable($field->id_jadwal);
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
		if(accessperm('melihat-data-jadwal-kerja')){
			$btn = "";
        }else{
			$btn = "";
        }
		if(accessperm('merubah-data-jadwal-kerja')){
			$btn .= "<a href='".base_url('jadwal-kerja/data_jadwal/edit/'.$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-jadwal-kerja')){
			$btn .= "<a href='".base_url('jadwal-kerja/data_jadwal/delete/'.$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }
        return $btn;
	}

    public function add(){
		permissions('menambahkan-data-jadwal-kerja');
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
		$this->templatecus->dashboard('pages/modul/umum/jadwal-kerja/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){
		permissions('menambahkan-data-jadwal-kerja');

		$shift = $this->security->xss_clean(html_escape($this->input->post("shift")));
		$mulai = $this->security->xss_clean(html_escape($this->input->post("mulai")));
		$akhir = $this->security->xss_clean(html_escape($this->input->post("akhir")));
		$ket = $this->security->xss_clean(html_escape($this->input->post("ket")));

        $this->form_validation->set_rules('shift','Shift','trim|required|xss_clean');
		$this->form_validation->set_rules('mulai','Jam Mulai Kerja','trim|required|xss_clean');
		$this->form_validation->set_rules('akhir','Jam Akhir Kerja','trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('jadwal-kerja/data_jadwal/add'));
		} else {

			$data = array(
				'shift_jadwal'=>$shift,
				'jam_mulai_jadwal'=>$mulai,
				'jam_akhir_jadwal'=>$akhir,
				'ket_jadwal'=>$ket,
				'date_input_jadwal'=>date('Y-m-d H:i:s'),
			);
			recordlog("Menyimpan ".$this->name);
			$this->thismodel->insertdt($data);
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
			redirect(base_url('jadwal-kerja/data_jadwal/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-jadwal-kerja');
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
		$this->templatecus->dashboard('pages/modul/umum/jadwal-kerja/'.url_title(strtolower($this->name)).'/edit',$data);
	}

	public function update($id){
		permissions('merubah-data-jadwal-kerja');

		$shift = $this->security->xss_clean(html_escape($this->input->post("shift")));
		$mulai = $this->security->xss_clean(html_escape($this->input->post("mulai")));
		$akhir = $this->security->xss_clean(html_escape($this->input->post("akhir")));
		$ket = $this->security->xss_clean(html_escape($this->input->post("ket")));

        $this->form_validation->set_rules('shift','Shift','trim|required|xss_clean');
		$this->form_validation->set_rules('mulai','Jam Mulai Kerja','trim|required|xss_clean');
		$this->form_validation->set_rules('akhir','Jam Akhir Kerja','trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url('jadwal-kerja/data_jadwal/edit/'.$id));
		}else{
            $data = array(
				'shift_jadwal'=>$shift,
				'jam_mulai_jadwal'=>$mulai,
				'jam_akhir_jadwal'=>$akhir,
				'ket_jadwal'=>$ket,
			);

            recordlog("Merubah ".$this->name);
			$this->thismodel->updatedt($data,$id);
			$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
			redirect(base_url('jadwal-kerja/data_jadwal/edit/'.$id));
		}
	}

	public function delete($id){
		permissions('menghapus-data-jadwal-kerja');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">';
			echo '<div class="col-sm-i2">
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('jadwal-kerja/data_jadwal/delete_exec/'.$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-jadwal-kerja');
		recordlog("Menghapus ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'jadwal-kerja/data_jadwal' ) );
	}

}
