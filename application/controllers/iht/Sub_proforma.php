<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_proforma extends CI_Controller {
 	protected  $name = 'Sub Proforma'; 

 	protected  $breadcrumb1 = 'Dashboard'; 
 	protected  $breadcrumb2 = 'IHT'; 

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
		if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
			redirect(base_url('login'));
		}
	}

	/* new */
	public function indexnew($proforma){
		$data2 = array(
			'breadcrumb1'=>$this->breadcrumb1,
			'breadcrumb2'=>$this->breadcrumb2,
			'breadcrumb3'=>$this->name,
			'titlepage'=>$this->name,
			'subtitlepage'=>'Data '.$this->name,
			'titlebox'=>'Manage '.$this->name,
			'proforma'=> $this->db
			->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_proformakontrak.FId_PershInstansi",'left')
			->where("Id_ProformaKontrak",$proforma)
			->get("mst_proformakontrak"),			
			"addendum"=>$this->db->where("FId_ProformaKontrak",$proforma)->order_by('No_Urut_Add', 'ASC')->get("mst_addendumkontrak")
		);
		recordlog("Melihat Data ".$this->name);
		$this->templatecus->dashboard('pages/modul/pelatihan/iht/sub-proforma/index',$data2);
	}
	
}
