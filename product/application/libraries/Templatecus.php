<?php
class Templatecus{
    protected $_ci;
    
    function __construct(){
        $this->_ci = &get_instance();
    }
    
    function dashboard($content, $data = NULL){
        if( checktimeloginrole($this->_ci->session->userdata("username")) ){
            $data['label'] = $this->_ci->db
            ->select("any_value(menu.idmenu)as idmenu,any_value(menu.parent)as parent,any_value(menu.urutan)as urutan,any_value(menu.name)as name,any_value(menu.description)as description,any_value(menu.url)as url,any_value(menu.icon)as icon,any_value(menu.labelmenu)as labelmenu,any_value(menu.active)as active,any_value(menu.kategori)as kategori,any_value(menu.core)as core,any_value(menu.created_at)as created_at,any_value(menu.created_by)as created_by,any_value(menu.updated_at)as updated_at,any_value(menu.updated_by)as updated_by")
            ->where(array('active'=>'1','parent'=>null))->order_by("urutan","ASC")->group_by("labelmenu")->get("menu");
    
            $data['header'] = $this->_ci->load->view('template/dashboard/header', $data, TRUE);
            $data['asidebar'] = $this->_ci->load->view('template/dashboard/asidebar', $data, TRUE);
            $data['content'] = $this->_ci->load->view($content, $data, TRUE);
            $data['footer'] = $this->_ci->load->view('template/dashboard/footer', $data, TRUE);
            $this->_ci->load->view('template/dashboard/main', $data);
        }else{
            recordlog("Logout");
    		$this->_ci->session->sess_destroy();
			$this->_ci->session->set_flashdata('error','Maaf, Waktu login(akses) anda sudah abis!<br/> Silahkan hubungi administrator untuk merubah waktu akses(login) akun anda!');
    		redirect(base_url('login'));
        }
    }
    
    function login($content, $data = NULL){
        $data['header'] = $this->_ci->load->view('template/login/header', $data, TRUE);
        $data['content'] = $this->_ci->load->view($content, $data, TRUE);
        $data['footer'] = $this->_ci->load->view('template/login/footer', $data, TRUE);
        $this->_ci->load->view('template/login/main', $data);
    }
}