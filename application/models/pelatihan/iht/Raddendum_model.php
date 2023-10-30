<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Raddendum_model extends CI_Model {
 
    var $table = 'mst_addendumkontrak'; //nama tabel dari database
    var $column_order = array(null, 'Desc_AddKontrak', 'No_Urut_Add', 'Desc_ProformaKontrak', 'Desc_PershInstansi', 'Nilai_Rp', 'Rencana_JmlPeserta','Rencana_TempatSelenggara','File_Lampiran'); //field yang ada di table
    var $column_search = array( 'Desc_AddKontrak', 'No_Urut_Add', 'FId_ProformaKontrak', 'FId_PershInstansi', 'Nilai_Rp', 'Rencana_JmlPeserta','Rencana_TempatSelenggara','File_Lampiran'); //field yang diizin untuk pencarian 
    var $order = array('Id_AddKontrak' => 'asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
         
        $this->db->select('mst_addendumkontrak.Id_AddKontrak,mst_addendumkontrak.No_Urut_Add,mst_addendumkontrak.Desc_AddKontrak, mst_proformakontrak.Desc_ProformaKontrak , mst_pershinstansi.Desc_PershInstansi , mst_addendumkontrak.Nilai_Rp , mst_addendumkontrak.Rencana_JmlPeserta , mst_addendumkontrak.Rencana_TempatSelenggara , mst_addendumkontrak.File_Lampiran')
        ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_addendumkontrak.FId_PershInstansi",'left')
        ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=mst_addendumkontrak.FId_ProformaKontrak",'left')
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
 
    function get_datatables()
    {
        $this->_get_datatables_query();
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
        $this->db->where(array('Id_AddKontrak'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->select('mst_addendumkontrak.Id_AddKontrak,mst_addendumkontrak.No_Urut_Add,mst_addendumkontrak.Desc_AddKontrak, mst_proformakontrak.Desc_ProformaKontrak , mst_pershinstansi.Desc_PershInstansi , mst_addendumkontrak.Nilai_Rp , mst_addendumkontrak.Rencana_JmlPeserta , mst_addendumkontrak.Rencana_TempatSelenggara , mst_addendumkontrak.File_Lampiran');
        $this->db->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_addendumkontrak.FId_PershInstansi",'left');
        $this->db->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=mst_addendumkontrak.FId_ProformaKontrak",'left');
        $this->db->where(array('Id_AddKontrak'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->set('Id_AddKontrak', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("Id_AddKontrak",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("Id_AddKontrak",$id)->delete($this->table);      
    }
 
}