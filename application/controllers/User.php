<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller { 
    protected  $name = 'User'; 
    protected  $model = 'User_model'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');
        $this->load->model('Detail_model','thismodeldetail');  
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-user');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Manage '.$this->name,
		);
		recordlog("Mengakses Halaman Data User");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/index',$data);
	}

	public function getdata(){

		$csrf_name = $this->security->get_csrf_token_name();
		$csrf_hash = $this->security->get_csrf_hash(); 
		
		$list = $this->thismodel->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {

            $getusername = $this->db->where(array('username'=>$this->session->userdata('username')))->get("user");
            $getrole = $this->db->where(array('iduser'=>$getusername->row()->iduser))->get("roleuser");
            $getkhusus = $this->db->where(array('idrole'=>$getrole->row()->idrole))->get("role");
            $no++;
            $row = array();
            $row[] = $no;


			$getrole1 = $this->db->where(array('iduser'=>$field->iduser))->get("roleuser");
	        $getusername1 = $this->db->where(array('iduser'=>$field->iduser))->get("user");
	        $getkhusus1 = $this->db->where(array('idrole'=>$getrole1->row()->idrole))->get("role");

	        if($getkhusus->row()->is_khusus != 1){
		    	// data role nya apa 
		        if($getkhusus1->row()->is_khusus ==1){
                	$row[] = "*********";
		        }else{
            		$row[] = $field->username;

		        }
		    }else{
            	$row[] = $field->username;

		    }

            $passd = "";
            if($this->encryption->decrypt($field->password) == false){
                $passd = $field->password;
            } else {
                $passd = $this->encryption->decrypt($field->password);    
            }
            if($getkhusus->row()->is_khusus ==1){
                $passd = $passd;
            }else{
                $passd = "*********";
            }
            $row[] = $passd;

            if($getkhusus->row()->is_khusus != 1){
		    	// data role nya apa 
		        if($getkhusus1->row()->is_khusus ==1){
                	$row[] = "*********";
		        }else{
            		$row[] = $field->email;
		        }
		    }else{
            	$row[] = $field->email;
		    }

            $row[] = getrolename($field->iduser);
            $row[] = $this->actiontable($field->iduser);
 
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
        $getusername1 = $this->db->where(array('username'=>$this->session->userdata('username')))->get("user");
        $getrole1 = $this->db->where(array('iduser'=>$getusername1->row()->iduser))->get("roleuser");
        $getkhusus1 = $this->db->where(array('idrole'=>$getrole1->row()->idrole))->get("role");
		
		$getrole = $this->db->where(array('iduser'=>$id))->get("roleuser");
        $getusername = $this->db->where(array('iduser'=>$id))->get("user");
        $getkhusus = $this->db->where(array('idrole'=>$getrole->row()->idrole))->get("role");
            
		if(accessperm('melihat-data-user')){

		    if($getkhusus1->row()->is_khusus != 1){
		    	// data role nya apa 
		        if($getkhusus->row()->is_khusus ==1){
		        	$btn ='';
		        }else{
					$btn = "<a href='".base_url(strtolower($this->name)."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
				}

		    }else{
					$btn = "<a href='".base_url(strtolower($this->name)."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";		    	
		    }
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-user')){
			// yang login tidak sama dengan 1
		    if($getkhusus1->row()->is_khusus != 1){
		    	// data role nya apa 
		        if($getkhusus->row()->is_khusus ==1){
		        }else{
		        	/*if( $getkhusus->row()->is_khusus == 3 ){
		        		if($getusername->row()->username == $this->session->userdata('username')){
		        			$btn .= "<a href='".base_url(strtolower($this->name)."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
		        		}
		        	}else{*/

	    			    $btn .= "<a href='".base_url(strtolower($this->name)."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
		        	/*}*/

		        }
		    }else{

		       /* if($getkhusus->row()->is_khusus ==1){
		        	if($getusername->row()->username == $this->session->userdata('username')){
			    		$btn .= "<a href='".base_url(strtolower($this->name)."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
		        	}
		        }else{*/

				    $btn .= "<a href='".base_url(strtolower($this->name)."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";

		        /*}*/
		    }
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-user')){

			// yang login tidak sama dengan 1
		    if($getkhusus1->row()->is_khusus != 1){
		    	// data role nya apa 
		        if($getkhusus->row()->is_khusus ==1){
		        }else{
		        	/*if( $getkhusus->row()->is_khusus == 3 ){
		        		if($getusername->row()->username == $this->session->userdata('username')){
		        			$btn .= "<a href='".base_url(strtolower($this->name)."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";
		        		}
		        	}else{*/

	    			    $btn .= "<a href='".base_url(strtolower($this->name)."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";
		        	/*}*/

		        }
		    }else{

		        /*if($getkhusus->row()->is_khusus ==1){
		        	if($getusername->row()->username == $this->session->userdata('username')){
			    		$btn .= "<a href='".base_url(strtolower($this->name)."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";
		        	}
		        }else{*/

				    $btn .= "<a href='".base_url(strtolower($this->name)."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";

		        /*}*/
		    }

		    
		    /*if($getkhusus1->row()->is_khusus != 1){
		        if($getkhusus->row()->is_khusus ==1){
		        }else{
			        $btn .= "<a href='".base_url(strtolower($this->name)."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";
		        }
		    }else{
			        $btn .= "<a href='".base_url(strtolower($this->name)."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";
		    }*/
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-user');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Add '.$this->name,
			'role'=>$this->db->get("role")
		);
		recordlog("Mengakses Halaman Add User");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/add',$data);
	}


	public function store(){	
		permissions('menambahkan-data-user');	

		$name = $this->security->xss_clean(html_escape($this->input->post("fullname")));
		$email = $this->security->xss_clean(html_escape($this->input->post("email")));
		$username = $this->security->xss_clean(html_escape($this->input->post("username")));
		$passe = $this->security->xss_clean(html_escape($this->input->post("password")));
		$password = $this->encryption->encrypt($passe);
		$role = $this->security->xss_clean(html_escape($this->input->post("role")));

		$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[user.email]|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[user.username]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('role', 'Role/Peran', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url(strtolower($this->name).'/add'));
		}else{
			/* insert data user */
			$datauser = array(
				'email'=>$email,
				'username'=>$username,
				'password'=>$password,
				'is_active'=>'1',
				'created_at'=>date ("Y-m-d H:i:s"),
				'created_by'=>$this->session->userdata("username"),
			);
			$this->thismodel->insertdt($datauser);
			$iduser = $this->thismodel->getdtwhereid($datauser);

			/* insert to details*/
			$datadetail = array(
				'iduser'=>$iduser,
				'fullname'=>$name,
			);
			$this->thismodeldetail->insertdt($datadetail);
			/* insert role */
			$datarole = array(
				'iduser'=>$iduser,
				'idrole'=>$role,
			);
			$this->thismodel->insertroleuser($datarole,'roleuser');
			
			recordlog("Menambahakan Data User");

			$this->session->set_flashdata('success', 'data berhasil  di simpan');
			redirect(base_url(strtolower($this->name).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-user');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Edit '.$this->name,
			'user'=>$this->thismodel->getrecord($id),
			'role'=>$this->db->get("role"),
			'roleuser'=>$this->thismodel->getrecordwhere($id,'roleuser'),
			'detailuser'=>$this->thismodel->getrecordwhere($id,'detailuser')
		);
			
		recordlog("Mengakses Halaman Edit User");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/edit',$data);
	}

	public function update($id){
		permissions('merubah-data-user');

		$name = $this->security->xss_clean(html_escape($this->input->post("fullname")));
		$email = $this->security->xss_clean(html_escape($this->input->post("email")));
		$username = $this->security->xss_clean(html_escape($this->input->post("username")));
		$passe = $this->security->xss_clean(html_escape($this->input->post("password")));
		$password = $this->encryption->encrypt($passe);
		$role = $this->security->xss_clean(html_escape($this->input->post("role")));
		$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean');
		$this->form_validation->set_rules('role', 'Role/Peran', 'trim|required|xss_clean');

		$checkuser = $this->db->where(array("username"=>$this->session->userdata("username")))->get("user");

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata( array( 'error'=>validation_errors() ) );
			redirect(base_url(strtolower($this->name).'/edit/'.$id));
		}else{
			/* update data user */
			if(!empty($this->input->post("password"))){
				$datauser = array(
					'email'=>$email,
					'username'=>$username,
					'password'=>$password,
					'updated_at'=>date ("Y-m-d H:i:s"),
					'updated_by'=>$this->session->userdata("username"),
				);
				recordlog("Merubah Data User");
			}else{
				$datauser = array(
					'email'=>$email,
					'username'=>$username,
					'updated_at'=>date ("Y-m-d H:i:s"),
					'updated_by'=>$this->session->userdata("username"),
				);
				recordlog("Merubah Data User");
			}
			$this->thismodel->updatedt($datauser,$id);

			/* update to details*/
			$datadetail = array(
				'fullname'=>$name,
			);

			$iddetail = $this->thismodel->getrecordwhere($id,'detailuser');

			$this->thismodeldetail->updatedt($datadetail,$iddetail->iddetail);
			/* update role */
			$datarole = array(
				'iduser'=>$id,
				'idrole'=>$role,
			);
			$where = array(
				'iduser'=>$id
			);

			$checkexits = $this->db->where($datarole)->get("roleuser");
			if($checkexits->num_rows()>0){
				$this->thismodel->updateroleuser($datarole,'roleuser',$where);
			}else{
				$this->thismodel->insertroleuser($datarole,'roleuser');
			}

			if($checkuser->row()->iduser == $id){
				if($username != $checkuser->row()->username){
					redirect(base_url("logout"));
				}else{						
					$this->session->set_flashdata('success', 'data berhasil  di perbaharui');
					redirect(base_url(strtolower($this->name).'/edit/'.$id));
				}
			}else{
				$this->session->set_flashdata('success', 'data berhasil  di perbaharui');
				redirect(base_url(strtolower($this->name).'/edit/'.$id));
			}
		}
	}

	public function view($id){
		permissions('melihat-data-user');
		$data = array(
			'dt'=>$this->thismodel->getrecord($id),
			'dt1'=>$this->thismodel->getrecordwhere($id,'detailuser'),
		);
		recordlog("Melihat Data User");
		$this->load->view("pages/modul/".strtolower($this->name)."/view",$data);
	}

	public function delete($id){
		permissions('menghapus-data-user');
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
		permissions('menghapus-data-user');
		recordlog("Menghapus Data User");
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'data berhasil di perbaharui');
		redirect(base_url(strtolower($this->name)));
	}
	
}