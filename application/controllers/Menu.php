<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller { 
    protected  $name = 'Menu'; 
    protected  $model = 'Menu_model'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
        $this->load->model($this->model,'thismodel');        
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}
	
	public function index(){
		permissions('melihat-data-menu');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Manage '.$this->name,
		);
		recordlog("Mengakses Halaman Menu");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/index',$data);
	}

	public function namemenu($parent){
		$rs = $this->db->where(array("idmenu"=>$parent))->get("menu");
		if($rs->num_rows()>0){
			return $rs->row()->name;
		}else{			
			return '<code>N/A</code>';
		}
	}
	
	/*public function labelname($labelmenu){
	    $rs = $this->db->where(array('idlabelmenu'=>$labelmenu))->get('labelmenu');
	    if($rs->num_rows()>0){
	        return $rs->row()->name;
	    }else{
	        return '<code>N/A</code>';
	    }
	}*/

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
            $row[] = ($field->parent!=null)? $this->namemenu($field->parent):'<code>N/A</code>';
            $row[] = ($field->url!=null)?$field->url:'<code>N/A</code>';
            $row[] = ($field->labelnamae!=null)? $field->labelnamae:'<code>N/A</code>';
            $row[] = ($field->active=='1')? 'Ya':'Tidak';
            
            $row[] = $this->actiontable($field->idmenu,$field->core);
 
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

	public function actiontable($id,$core){
		if(accessperm('melihat-data-menu')){
			$btn = "<a href='".base_url(strtolower($this->name)."/view/".$id)."' class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'> <i class='fa fa-search-plus'></i> View </a> ";
        }else{
			$btn = "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-search-plus'></i> No Access </a>";
        }
		if(accessperm('merubah-data-menu')){
			$btn .= "<a href='".base_url(strtolower($this->name)."/edit/".$id)."' class='btn btn-xs btn-warning' data-toggle='tooltip'
                title='Edit Data'> <i class='fa fa-pencil-square'></i> Edit </a> ";
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-pencil-square'></i> No Access </a>";
        }
		if(accessperm('menghapus-data-menu')){
			if($core != '1' || $core !=1){
				$btn .= "<a href='".base_url(strtolower($this->name)."/delete/".$id)."' class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>";	
			}else{
				$btn .= "";
			}
				
        }else{
			$btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
        }	
        return $btn;
	}

	public function add(){
		permissions('menambahkan-data-menu');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Add '.$this->name,
			'parent'=>$this->db->where_in('kategori',array('induk','sub'))->get("menu"),
			'labelmenu'=>$this->db->get("labelmenu"),
		);
		recordlog("Mengakses Halaman Add Menu");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/add',$data);
	}

	public function addlabel($data=null){
		recordlog("Mengakses Modal Add Label");
		$this->load->view("pages/modul/".strtolower($this->name).'/label/add',array('data'=>$data));
	}

	public function loadicon(){
		recordlog("Mengakses Modal Icon");
		$this->load->view("pages/modul/".strtolower($this->name).'/icon/icon');
	}

	public function labelstore(){
		$name = $this->security->xss_clean(html_escape($this->input->post("data")));
		$cek = $this->db->where("name",$name)->get("labelmenu");
		if(!empty($name)){
			if($cek->num_rows()>0){
				recordlog("Gagal Menambahkan data label");
				echo "gagal";
			}else{
				$data = array(
					'name'=>strtoupper($name)
				);
	        	$this->db->set('idlabelmenu', 'UUID()', FALSE);
				$this->db->insert("labelmenu",$data);
				echo "sukses";
				recordlog("Menambahkan data label baru");
			}
		}else{
			recordlog("Gagal Menambahkan data label");
			echo "gagal";
		}
	}

	public function loadlabelmenu(){
		$data = array(
			'label'=>$this->db->get("labelmenu")
		);
		$this->load->view("pages/modul/".strtolower($this->name)."/label/loadselect",$data);

	}

	public function store(){	
		permissions('menambahkan-data-menu');	

		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$kategori = $this->security->xss_clean(html_escape($this->input->post("tipe")));
		$parent = $this->security->xss_clean(html_escape($this->input->post("parent")));

		$url = $this->security->xss_clean(html_escape($this->input->post("url")));
		$icon = $this->security->xss_clean(html_escape($this->input->post("icon")));
		$labelmenu = $this->security->xss_clean(html_escape($this->input->post("labelmenu")));
		$active = $this->security->xss_clean(html_escape($this->input->post("active")));
		$description = $this->security->xss_clean(html_escape($this->input->post("description")));

		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[menu.name]|xss_clean');
		$this->form_validation->set_rules('tipe', 'Tipe', 'trim|required|xss_clean');
		$this->form_validation->set_rules('parent', 'Parent', 'trim|xss_clean');
		$this->form_validation->set_rules('url', 'Url', 'trim|xss_clean');
		$this->form_validation->set_rules('icon', 'Icon', 'trim|xss_clean');
		$this->form_validation->set_rules('labelmenu', 'Label Menu', 'trim|xss_clean');
		$this->form_validation->set_rules('active', 'Active', 'trim|required|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url(strtolower($this->name).'/add'));
		}else{
			$urutan = $this->db->select("max(urutan)as urutan")->get("menu");
			$urutan = ($urutan->row()->urutan == null)? 1:((int)$urutan->row()->urutan+1);
			if($kategori== 'induk'){
				$data = array(
					'name'=>$name,
					'kategori'=>$kategori,
					'parent'=>null,
					'url'=>null,
					'icon'=>$icon,
					'labelmenu'=>$labelmenu,
					'active'=>$active,
					'urutan'=>$urutan,
					'description'=>$description,
					'created_at'=>date ("Y-m-d H:i:s"),
					'created_by'=>$this->session->userdata("username"),
				);
			}else if($kategori == 'tunggal'){
				$data = array(
					'name'=>$name,
					'kategori'=>$kategori,
					'parent'=>$parent,
					'url'=>$url,
					'icon'=>$icon,
					'labelmenu'=>$labelmenu,
					'active'=>$active,
					'urutan'=>$urutan,
					'description'=>$description,
					'created_at'=>date ("Y-m-d H:i:s"),
					'created_by'=>$this->session->userdata("username"),
				);
			}else{				
				$data = array(
					'name'=>$name,
					'kategori'=>$kategori,
					'parent'=>$parent,
					'icon'=>$icon,
					'url'=>null,
					'labelmenu'=>$labelmenu,
					'active'=>$active,
					'urutan'=>$urutan,
					'description'=>$description,
					'created_at'=>date ("Y-m-d H:i:s"),
					'created_by'=>$this->session->userdata("username"),
				);
			}
			$this->thismodel->insertdt($data);
			recordlog("Menambahkan data Menu");
			$this->session->set_flashdata('success', 'data berhasil  di simpan');
			redirect(base_url(strtolower($this->name).'/add'));
		}
	}

	public function edit($id){
		permissions('merubah-data-menu');
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Edit '.$this->name,
			'menu'=>$this->thismodel->getrecord($id),
			'parent'=>$this->db->where_in('kategori',array('induk','sub'))->get("menu"),
			'labelmenu'=>$this->db->get("labelmenu"),
		);
		recordlog("Mengakses Halaman Edit Menu");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/edit',$data);
	}

	public function update($id){	
		permissions('merubah-data-menu');	


		$name = $this->security->xss_clean(html_escape($this->input->post("name")));
		$kategori = $this->security->xss_clean(html_escape($this->input->post("tipe")));
		$parent = $this->security->xss_clean(html_escape($this->input->post("parent")));
		$url = $this->security->xss_clean(html_escape($this->input->post("url")));
		$icon = $this->security->xss_clean(html_escape($this->input->post("icon")));
		$labelmenu = $this->security->xss_clean(html_escape($this->input->post("labelmenu")));
		$active = $this->security->xss_clean(html_escape($this->input->post("active")));
		$description = $this->security->xss_clean(html_escape($this->input->post("description")));

		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('tipe', 'Tipe', 'trim|required|xss_clean');
		$this->form_validation->set_rules('parent', 'Parent', 'trim|xss_clean');
		$this->form_validation->set_rules('url', 'Url', 'trim|xss_clean');
		$this->form_validation->set_rules('icon', 'Icon', 'trim|xss_clean');
		$this->form_validation->set_rules('labelmenu', 'Label Menu', 'trim|xss_clean');
		$this->form_validation->set_rules('active', 'Active', 'trim|required|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(array( 'error'=>validation_errors(),'oldinput'=> $this->security->xss_clean(html_escape($this->input->post())) ));
			redirect(base_url(strtolower($this->name).'/edit/'.$id));
		}else{
			if($kategori== 'induk'){
				$data = array(
					'name'=>$name,
					'kategori'=>$kategori,
					'parent'=>null,
					'url'=>null,
					'icon'=>$icon,
					'labelmenu'=>$labelmenu,
					'active'=>$active,
					'description'=>$description,
					'updated_at'=>date ("Y-m-d H:i:s"),
					'updated_by'=>$this->session->userdata("username"),
				);
			}else if($kategori == 'tunggal'){
				$data = array(
					'name'=>$name,
					'kategori'=>$kategori,
					'parent'=>$parent,
					'url'=>$url,
					'icon'=>$icon,
					'labelmenu'=>$labelmenu,
					'active'=>$active,
					'description'=>$description,
					'updated_at'=>date ("Y-m-d H:i:s"),
					'updated_by'=>$this->session->userdata("username"),
				);
			}else{				
				$data = array(
					'name'=>$name,
					'kategori'=>$kategori,
					'parent'=>$parent,
					'icon'=>$icon,
					'url'=>null,
					'labelmenu'=>$labelmenu,
					'active'=>$active,
					'description'=>$description,
					'updated_at'=>date ("Y-m-d H:i:s"),
					'updated_by'=>$this->session->userdata("username"),
				);
			}
			$this->thismodel->updatedt($data,$id);
			recordlog("Merubah data Menu");
			$this->session->set_flashdata('success', 'data berhasil di perbaharui');
			redirect(base_url(strtolower($this->name).'/edit/'.$id));
		}
	}

	public function view($id){
		permissions('melihat-data-menu');
		$data = array(
			'dt'=>$this->thismodel->getrecord($id)
		);
		recordlog("Melihat data Menu");
		$this->load->view("pages/modul/".strtolower($this->name)."/view",$data);
	}

	public function delete($id){
		permissions('menghapus-data-menu');
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
		permissions('menghapus-data-menu');
		recordlog("Menghapus data Menu");
		$this->thismodel->deletedt($id);
		$this->session->set_flashdata('success', 'data berhasil di perbaharui');
		redirect(base_url(strtolower($this->name)));
	}

	public function set_position_menu(){
		$data = array(
			'breadcrumb1'=>'Dashboard',
			'breadcrumb2'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Set Position '.$this->name,
			'menu'=>$this->db->get("menu"),
		);
		recordlog("Mengakses Halaman Set Position Menu");
		$this->templatecus->dashboard('pages/modul/'.strtolower($this->name).'/setpositionmenu',$data);
	}

	public function save_position_menu(){
		$data = $this->input->post('list');
		/*var_dump($data);
		die();*/
		$count = count($data);
		for($i=0;$i<$count;$i++){
			$no = $i+1;
			$arr = $data[$i];
			if (array_key_exists('id', $arr)) {
			//echo 'urutan '.$no." parent null pada id ini ".$data[$i]['id'].'<br/>';	
				/* start update position menu induk and tunggal */	
					$this->db->where(array('idmenu'=>$data[$i]['id']))->update('menu',array('parent'=>null,'urutan'=>$no));
					$label = $this->db->where(array('idmenu'=>$data[$i]['id']))->get("menu")->row();
				/* end update position menu induk and tunggal */
				if (array_key_exists('children', $arr)) {
				    $countchildlvl1 = count( $data[$i]['children'] );
					for($i1=0;$i1<$countchildlvl1;$i1++){
						$no1 = $i1+1;
						$arr1 = $data[$i]['children'][$i1];
						if (array_key_exists('id', $arr1)) {	
							//echo 'urutan '.$no1." id ini ".$data[$i]['children'][$i1]['id'].' anak dari '.$data[$i]['id'].'<br/>';	
							/* start update position child menu tunggal  */	
								$this->db->where(array('idmenu'=>$data[$i]['children'][$i1]['id']))->update('menu',array('parent'=>$data[$i]['id'],'urutan'=>$no1,'labelmenu'=>$label->labelmenu));
								$label1 = $this->db->where(array('idmenu'=>$data[$i]['children'][$i1]['id']))->get("menu")->row();
								/* end update position child menu tunggal */	
							if (array_key_exists('children', $arr1)) {
				    			$countchildlvl2 = count( $data[$i]['children'][$i1]['children'] );
				    			for($i2=0;$i2<$countchildlvl2;$i2++){				    				
									$no2 = $i2+1;
									$arr2 = $data[$i]['children'][$i1]['children'][$i2];
									if (array_key_exists('id', $arr2)) {
										$this->db->where(array('idmenu'=>$data[$i]['children'][$i1]['children'][$i2]['id']))->update('menu',array('parent'=>$data[$i]['children'][$i1]['id'],'urutan'=>$no2,'labelmenu'=>$label1->labelmenu));
									}
				    			}
							}
						}
					}
				}
			}
		}

		recordlog("Mengeset/Merubah position Menu");
	}

}