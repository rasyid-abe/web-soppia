<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller { 
    protected  $name = 'Role'; 
    protected  $model = 'Role_model'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-role');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Manage '.$this->name,
		);
		recordlog("mengakses halaman role");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/index',$data);
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
            $row[] = $field->name;
            $row[] = $field->description;
            $row[] = $this->actionsetting($field->idrole);
            $row[] = $this->actiontime($field->idrole);
            $row[] = $this->actiontable($field->idrole);
 
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
		if(accessperm('melihat-data-role')){
			$btn = "<a href='".base_url(strtolower($this->name)."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-role')){
			$btn .= "<a href='".base_url(strtolower($this->name)."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-role')){
			$btn .= "<a href='".base_url(strtolower($this->name)."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}
	
	public function actionsetting($id){
		if(accessperm('melihat-set-permission')){
			$btn = "<a href='".base_url(strtolower($this->name)."/permissionview/".$id)."' class='btn btn-xs btn-default' data-toggle='tooltip' title='Melihat Set Permission'> <i class='fa fa-ticket'></i> Melihat Set Permission </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-ticket'></i> No Access </a>";
        }	
		if(accessperm('melihat-set-permission-menu')){
			$btn .= "<a href='".base_url(strtolower($this->name)."/permissionviewmenu/".$id)."' class='btn btn-xs btn-default' data-toggle='tooltip' title='Melihat Set Permission role on menu'> <i class='fa fa-ticket'></i> Melihat Set Permission on Menu </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-ticket'></i> No Access </a>";
        }
		if(accessperm('mengatur-set-permission-role')){
			$btn .= "<a href='".base_url(strtolower($this->name)."/permission/".$id)."' class='btn btn-xs btn-default sett-data' data-toggle='tooltip' title='Set Permission'> <i class='fa fa-ticket'></i> Set Permission </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-ticket'></i> No Access </a>";
        }
		if(accessperm('mengatur-set-permission-menu-role')){
			$btn .= "<a href='".base_url(strtolower($this->name)."/permmenu/".$id)."' class='btn btn-xs btn-default sett-data' data-toggle='tooltip' title='Set Permission role on menu'> <i class='fa fa-ticket'></i> Set Permission On Menu </a>";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-ticket'></i> No Access </a>";
        }	
        return $btn;
	}
	
	public function actiontime($id){
		if(accessperm('mengeset-waktu-login-role')){
			if(is_adminadmin()){
				$check = $this->db->where(array('idrole'=>$id))->get('role');
				if($check->num_rows()>0){
					if($check->row()->is_khusus == 1){
						$btn = '';
					}else{
						$btn = "<a href='".base_url(strtolower($this->name)."/settimelogin/".$id)."' class='btn btn-xs btn-success' data-toggle='tooltip' title='Mengeset izin waktu access'> <i class='fa  fa-calendar-check-o'></i> Set Time </a>";
					}
				}else{					
					$btn =  '';
				}
				
			}else{

			$btn = "<a href='".base_url(strtolower($this->name)."/settimelogin/".$id)."' class='btn btn-xs btn-success' data-toggle='tooltip'
                title='Mengeset izin waktu access'> <i class='fa  fa-calendar-check-o'></i> Set Time </a>";
			}
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-calendar-check-o'></i> No Access </a>";
        }
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-role');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Add '.$this->name,
		);
		recordlog("mengakses halaman add role");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/add',$data);
	}

	public function store(){	
		permissions('menambahkan-data-role');	

		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$description = $this->security->xss_clean(html_escape($this->input->post("description")));

		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[role.name]|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url(strtolower($this->name).'/add'));
		}else{
			$data = array(
				'name'=>$name,
				'description'=>$description,
				'created_at'=>date ("Y-m-d H:i:s"),
				'created_by'=>$this->session->userdata("username"),
			);
			$this->thismodel->insertdt($data);
			recordlog("Menambahkan data role");
			$this->session->set_flashdata('success', 'data berhasil  di simpan');
			redirect(base_url(strtolower($this->name).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-role');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Edit '.$this->name,
			'role'=>$this->thismodel->getrecord($id)
		);
		recordlog("Mengakses Halaman Edit Role");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-role');	

		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$description = $this->security->xss_clean(html_escape($this->input->post("description")));

		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url(strtolower($this->name).'/edit/'.$id));
		}else{
			$data = array(
				'name'=>$name,
				'description'=>$description,
				'updated_at'=>date ("Y-m-d H:i:s"),
				'updated_by'=>$this->session->userdata("username"),
			);
			$this->thismodel->updatedt($data,$id);
			recordlog("Merubah data Role ");
			$this->session->set_flashdata('success', 'data berhasil di perbaharui');
			redirect(base_url(strtolower($this->name).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-role');
		$data = array(
			'dt'=>$this->thismodel->getrecord($id),
			'timelog'=>$this->db->where("idrole",$id)->get("timelog")
		);
		recordlog("Melihat data Role");
		$this->load->view("pages/modul/".strtolower($this->name)."/view",$data);
	}

	public function delete($id){
		permissions('menghapus-data-role');
		echo "Anda yakin bermaksud menghapus data ini ? <br/><hr/>";
		echo '<div class="container-fluid" style="margin:0;padding:0">'; 
			echo '<div class="col-sm-12"> 
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <a href="'.base_url(strtolower($this->name)."/delete_exec/".$id).'" class="btn btn-default btn-block btn-flat">Ya</a>
	          </div>
	          <div class="col-sm-6" style="margin:0;padding:0">
	            <button class="btn btn-danger btn-block btn-flat" data-dismiss="modal" >Batal</button>
	          </div>
	        </div>';
		echo '</div>';
	}

	public function delete_exec($id){
		permissions('menghapus-data-role');
		recordlog("Menghapus data Role ");
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'data berhasil di perbaharui');
		redirect(base_url(strtolower($this->name)));
	}

	
	public function permission($id){
		permissions('mengatur-set-permission-role');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Set Permission '.$this->name,
			'role'=>$this->thismodel->getrecord($id),
			'menu'=>$this->db->order_by("urutan")->get("menu"),
		);
		recordlog("Mengakses Halaman Set Permission Role ");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/setperm',$data);
	}	
	
	public function permissionview($id){
		permissions('melihat-set-permission');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Melihat Set Permission '.$this->name,
			'role'=>$this->thismodel->getrecord($id),
			'menu'=>$this->db->order_by("urutan")->get("menu"),
		);
		recordlog("Mengakses Halaman Set Permission Role ");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/viewsetperm',$data);
	}

	public function permrole($role,$perm){
		permissions('mengatur-set-permission-role');
		$cek = $this->db->where(array(
			'idrole'=>$role,
			'idpermission'=>$perm,
		))->get("permissionrole");

		if($cek->num_rows()>0){
			$this->db->where(array(
				'idrole'=>$role,
				'idpermission'=>$perm,
			))->delete("permissionrole");
		}else{
			$this->db->set('id', 'UUID()', FALSE);
			$this->db->insert("permissionrole",array(
				'idrole'=>$role,
				'idpermission'=>$perm,
			));
		}

		recordlog("Merubah Set Permission Role ");

		echo "sukses";
	}

	public function permmenu($id){
		permissions('mengatur-set-permission-menu-role');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Set Permission Menu '.$this->name,
			'role'=>$this->thismodel->getrecord($id),
			'menu'=>$this->db->where(array('active'=>'1'))->order_by("urutan")->get("menu"),
		);
		recordlog("Mengakses Halaman Set Permission Menu Role ");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/setpermmenu',$data);
	}
	
	public function permissionviewmenu($id){
		permissions('melihat-set-permission-menu');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Melihat Set Permission Menu '.$this->name,
			'role'=>$this->thismodel->getrecord($id),
			'menu'=>$this->db->where(array('active'=>'1'))->order_by("urutan")->get("menu"),
		);
		recordlog("Mengakses Halaman Set Permission Menu Role ");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/viewsetpermmenu',$data);
	}


	public function permmenurole($role,$perm){
		permissions('mengatur-set-permission-menu-role');
		$cek = $this->db->where(array(
			'idrole'=>$role,
			'idmenu'=>$perm,
		))->get("menurole");

		if($cek->num_rows()>0){
			$this->db->where(array(
				'idrole'=>$role,
				'idmenu'=>$perm,
			))->delete("menurole");
		}else{
			$this->db->set('id', 'UUID()', FALSE);
			$this->db->insert("menurole",array(
				'idrole'=>$role,
				'idmenu'=>$perm,
			));
		}

		recordlog("Merubah data Set Permission Menu Role ");

		echo "sukses";
	}
	
	public function settimelogin($id){
		permissions('mengeset-waktu-login-role');
		$role = $this->thismodel->getrecord($id);
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Set Time Access '.$this->name.' <b>'.$role->name.'</b>',
			'dt'=>$this->thismodel->getrecord($id),
			'ceklogtime'=>$this->db->where("idrole",$id)->get("timelog"),
		);
		recordlog("Mengakses Halaman Set Waktu Access pada data role");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/settimelog',$data);
		
	}
	
	public function settimeaccessproseshw(){
		permissions('mengeset-waktu-login-role');
	    $count = count($this->input->post("centang"));
        $day = array();
	    $time = array();
	    for($i=0;$i<$count;$i++){
	        array_push($day,$this->input->post('centang')[$i]);
	        array_push($time,array( 
	            'timestart'=>array(
	                $this->input->post('centang')[$i] => $this->input->post('timestart')[$this->input->post('centang')[$i]]
	                ),
	            'timeend'=>array(
	                $this->input->post('centang')[$i] => $this->input->post('timeend')[$this->input->post('centang')[$i]]
	                ),
	        ));
	    }
	    $cek = $this->db->where("idrole",$this->input->post("idrole"))->get("timelog");
	    if($cek->num_rows()>0){
    	    $data = array(
    	        'day'=>serialize($day),
    	        'time'=>serialize($time),
    	        'status'=> 'HW',
    	        );
    	    $this->db->where("idrole",$this->input->post("idrole"))->update("timelog",$data);
	    }else{
    	    $data = array(
    	        'idrole'=>$this->input->post('idrole'),
    	        'day'=>serialize($day),
    	        'time'=>serialize($time),
    	        'status'=> 'HW',
    	        );
    	    $this->db->insert("timelog",$data);
	    }
	    recordlog("Mengeset/Mengatur waktu login role");
		$this->session->set_flashdata('success', 'data berhasil di perbaharui');
		redirect(base_url(strtolower($this->name).'/settimelogin/'.$this->input->post('idrole')));
	}
	
	public function settimeaccessprosestw(){
		permissions('mengeset-waktu-login-role');
		$range = explode("-",$this->input->post("range"));
		
		$datestart = str_replace(" ","",$range[0]);
		$dateend = str_replace(" ","",$range[1]);
		
		$datestart = str_replace('/', '-', $datestart);
		$dateend = str_replace('/', '-', $dateend);
		
		$datestart = date("Y-m-d",strtotime($datestart));
		$dateend = date("Y-m-d",strtotime($dateend));
		$time = array();
		array_push($time,
		    array(
		        'timestart'=>$this->input->post("timestart"),
		        'timeend'=>$this->input->post("timeend"),
		    )
		);
		$cek = $this->db->where("idrole",$this->input->post("idrole"))->get("timelog");
	    if($cek->num_rows()>0){
	         $data = array(
    	        'datestart'=>$datestart,
    	        'dateend'=>$dateend,
    	        'day'=>null,
    	        'time'=>serialize($time),
    	        'status'=> 'TW',
    	        );
    	    $this->db->where("idrole",$this->input->post("idrole"))->update("timelog",$data);
	    }else{
	        $data = array(
    	        'idrole'=>$this->input->post('idrole'),
    	        'datestart'=>$datestart,
    	        'dateend'=>$dateend,
    	        'day'=>null,
    	        'time'=>serialize($time),
    	        'status'=> 'Y',
    	        );
    	    $this->db->insert("timelog",$data);
	    }
		
	    recordlog("Mengeset waktu login role");
		$this->session->set_flashdata('success', 'data berhasil di perbaharui');
		redirect(base_url(strtolower($this->name).'/settimelogin/'.$this->input->post('idrole')));
	}
	
	public function settimeaccessprosesya(){
		permissions('mengeset-waktu-login-role');
		$cek = $this->db->where("idrole",$this->input->post("idrole"))->get("timelog");
	    if($cek->num_rows() > 0){
	        $data = array(
    	        'datestart'=>null,
    	        'dateend'=>null,
    	        'day'=>null,
    	        'time'=>null,
    	        'status'=> 'Y',
    	        );
    	    $this->db->where("idrole",$this->input->post('idrole'))->update("timelog",$data);
	    }else{
	        $data = array(
    	        'idrole'=>$this->input->post('idrole'),
    	        'datestart'=>null,
    	        'dateend'=>null,
    	        'day'=>null,
    	        'time'=>null,
    	        'status'=> 'Y',
    	        );
    	    $this->db->insert("timelog",$data);
	    }
	    
	    recordlog("Mengeset waktu login role");
		$this->session->set_flashdata('success', 'data berhasil di perbaharui');
		redirect(base_url(strtolower($this->name).'/settimelogin/'.$this->input->post('idrole')));
	}

	
}