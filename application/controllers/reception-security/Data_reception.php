<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_reception extends CI_Controller {
 	protected  $name = 'Data reception';
    protected  $model = 'umum/reception-security/Rreception_model';
 	protected  $breadcrumb1 = 'Dashboard';
 	protected  $breadcrumb2 = 'Reception dan Security';
 	protected  $breadcrumb3 = 'Reception';

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model($this->model,'thismodel');
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}

    public function index(){
		permissions('melihat-data-data-reception');
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
		$this->templatecus->dashboard('pages/modul/umum/reception-security/'.url_title(strtolower($this->name)).'/index',$data);
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
            $row[] = ($field->foto!= null)? '<img src="'.base_url("uploads/photo/pegawai/".$field->foto).'" width="50px" height="50px"></img>' : '<code>N/A</code>';
            $row[] = $field->nama_pegawai;
            $row[] = $field->email;
            $row[] = $field->kota_lahir;
            $row[] = $this->actiontable($field->id_pegawai);
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
		if(accessperm('melihat-data-data-reception')){
			$btn = "<a href='".base_url('reception-security/data_reception/view/'.$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Jadwal'> <i class='fa fa-search-plus'></i> Lihat Jadwal</a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-data-reception')){
			$btn .= "<a href='".base_url('reception-security/data_reception/edit/'.$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Atur Jadwal </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
        return $btn;
	}

    public function add($id_pegawai){
		permissions('menambahkan-data-data-reception');
		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
		$data = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->breadcrumb3,
			'titlepage'=>$this->breadcrumb3,
			'subtitlepage'=>'Data '.$this->breadcrumb3,
			'titlebox'=>'Add '.$this->breadcrumb3,
			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
            'id_pegawai'=>$id_pegawai,
            'shifting'=>$this->thismodel->get_shifting()->result()
		);
		recordlog("Mengakses Halaman Add ".$this->name);
		$this->templatecus->dashboard('pages/modul/umum/reception-security/'.url_title(strtolower($this->name)).'/add',$data);
	}


	public function store(){
		permissions('menambahkan-data-data-reception');

        $id_pegawai = $this->security->xss_clean(html_escape($this->input->post("id_pegawai")));
        $senin = $this->security->xss_clean(html_escape($this->input->post("senin")));
        $selasa = $this->security->xss_clean(html_escape($this->input->post("selasa")));
        $rabu = $this->security->xss_clean(html_escape($this->input->post("rabu")));
        $kamis = $this->security->xss_clean(html_escape($this->input->post("kamis")));
        $jumat = $this->security->xss_clean(html_escape($this->input->post("jumat")));
        $sabtu = $this->security->xss_clean(html_escape($this->input->post("sabtu")));
        $minggu = $this->security->xss_clean(html_escape($this->input->post("minggu")));

		$data = array(
            'id_jadwal_pegawai_reception'=>$id_pegawai,
            'jadwal_senin_reception'=>$senin,
            'jadwal_selasa_reception'=>$selasa,
            'jadwal_rabu_reception'=>$rabu,
            'jadwal_kamis_reception'=>$kamis,
            'jadwal_jumat_reception'=>$jumat,
            'jadwal_sabtu_reception'=>$sabtu,
            'jadwal_minggu_reception'=>$minggu,
            'tanggal_input_jadwal_reception'=>date('Y-m-d H:i:s'),
		);
		recordlog("Menyimpan ".$this->name);
		$this->thismodel->insertdt($data);
		$this->session->set_flashdata('success', 'Data berhasil di simpan');
		redirect(base_url('reception-security/data_reception/edit/'.$id_pegawai));

	}

	public function edit($id){
        $check = $this->thismodel->getrecord($id);
        if($check->num_rows() > 0) {
    		permissions('merubah-data-data-reception');
    		$urlnow = $this->uri->segment(1).'/'.$this->uri->segment(2);
    		$data = array(
    			'breadcrumb1'=>$this->breadcrumb1,
    			'breadcrumb2'=>$this->breadcrumb2,
    			'breadcrumb3'=>$this->breadcrumb3,
    			'titlepage'=>$this->breadcrumb3,
    			'subtitlepage'=>'Data '.$this->breadcrumb3,
    			'titlebox'=>'Edit '.$this->breadcrumb3,
    			'dtdefault'=>$this->thismodel->getrecord($id)->row(),
    			'urlback'=>$this->db->where("url",$urlnow)->get("menu"),
                'shifting'=>$this->thismodel->get_shifting()->result()
    		);
    		recordlog("Mengakses Halaman Edit ".$this->name);
    		$this->templatecus->dashboard('pages/modul/umum/reception-security/'.url_title(strtolower($this->name)).'/edit',$data);
        } else {
            // echo "string";
            $this->add($id);
        }
	}

	public function update($id){
		permissions('merubah-data-data-reception');

        $senin = $this->security->xss_clean(html_escape($this->input->post("senin")));
        $selasa = $this->security->xss_clean(html_escape($this->input->post("selasa")));
        $rabu = $this->security->xss_clean(html_escape($this->input->post("rabu")));
        $kamis = $this->security->xss_clean(html_escape($this->input->post("kamis")));
        $jumat = $this->security->xss_clean(html_escape($this->input->post("jumat")));
        $sabtu = $this->security->xss_clean(html_escape($this->input->post("sabtu")));
        $minggu = $this->security->xss_clean(html_escape($this->input->post("minggu")));

        $data = array(
            'jadwal_senin_reception'=>$senin,
            'jadwal_selasa_reception'=>$selasa,
            'jadwal_rabu_reception'=>$rabu,
            'jadwal_kamis_reception'=>$kamis,
            'jadwal_jumat_reception'=>$jumat,
            'jadwal_sabtu_reception'=>$sabtu,
            'jadwal_minggu_reception'=>$minggu,
            'tanggal_update_jadwal_reception'=>date('Y-m-d H:i:s'),
		);

        recordlog("Merubah ".$this->name);
		$this->thismodel->updatedt($data,$id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url('reception-security/data_reception/edit/'.$id));
	}

	public function view($id){
            permissions('melihat-data-data-reception');
            $data = array(
                'dtdefault'=>$this->thismodel->getrecord($id)
            );
            recordlog("Mengakses Halaman Detail ".$this->name);
            $this->load->view("pages/modul/umum/reception-security/".url_title(strtolower($this->name))."/view",$data);

	}

	public function delete($id){
		permissions('menghapus-data-data-reception');

		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">';
			echo '<div class="col-sm-i2">
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url('reception-security/data_reception/delete_exec/'.$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-data-reception');
		recordlog("Menghapus ".$this->name);
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'Data berhasil di perbaharui');
		redirect(base_url( 'reception-security/data_reception' ) );
	}

}
