<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rkontrakresmi_model extends CI_Model {
 
    var $table = 'mst_kontrakresmi'; //nama tabel dari database
    var $column_order = array(null, 'mst_kontrakresmi.Desc_KontrakResmi','Desc_ProformaKontrak','Desc_PershInstansi','mst_kontrakresmi.Nilai_Rp','mst_kontrakresmi.Rencana_JmlPeserta','mst_kontrakresmi.Rencana_TempatSelenggara','mst_kontrakresmi.File_Lampiran'); //field yang ada di table user
    var $column_search = array( 'mst_kontrakresmi.Desc_KontrakResmi','Desc_ProformaKontrak','Desc_PershInstansi','mst_kontrakresmi.Nilai_Rp','mst_kontrakresmi.Rencana_JmlPeserta','mst_kontrakresmi.Rencana_TempatSelenggara','mst_kontrakresmi.File_Lampiran'); //field yang diizin untuk pencarian 
    var $order = array('Id_KontrakResmi' => 'asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query($proforma = null)
    {
         
        $this->db
        ->select('mst_kontrakresmi.Id_KontrakResmi,mst_kontrakresmi.Desc_KontrakResmi, mst_proformakontrak.Desc_ProformaKontrak , mst_pershinstansi.Desc_PershInstansi , mst_kontrakresmi.Nilai_Rp , mst_kontrakresmi.Rencana_JmlPeserta , mst_kontrakresmi.Rencana_TempatSelenggara , mst_kontrakresmi.File_Lampiran')
        ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_kontrakresmi.FId_PershInstansi",'left')
        ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=mst_kontrakresmi.FId_ProformaKontrak",'left')
        ->where("FId_ProformaKontrak",$proforma)
        ->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables($proforma)
    {
        $this->_get_datatables_query($proforma);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /* crud proccesing */
    public function getrecord($id){
        $this->db->from($this->table);
        $this->db->where(array('Id_KontrakResmi'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->select('mst_kontrakresmi.Id_KontrakResmi,mst_kontrakresmi.Desc_KontrakResmi,mst_kontrakresmi.FId_PershInstansi,mst_kontrakresmi.FId_ProformaKontrak, mst_proformakontrak.Desc_ProformaKontrak , mst_pershinstansi.Desc_PershInstansi , mst_kontrakresmi.Nilai_Rp , mst_kontrakresmi.Rencana_JmlPeserta , mst_kontrakresmi.Rencana_TempatSelenggara , mst_kontrakresmi.File_Lampiran');
        $this->db->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_kontrakresmi.FId_PershInstansi",'left');
        $this->db->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=mst_kontrakresmi.FId_ProformaKontrak",'left');
        $this->db->where(array('Id_KontrakResmi'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->set('Id_KontrakResmi', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("Id_KontrakResmi",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("Id_KontrakResmi",$id)->delete($this->table);      
    }
 
}