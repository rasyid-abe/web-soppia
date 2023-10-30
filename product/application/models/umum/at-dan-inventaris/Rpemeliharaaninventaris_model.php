<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rpemeliharaaninventaris_model extends CI_Model {
    var $table = 'trm_kartueksploit_atninvent';
    var $column_order = array(null,'Tgl_TransaksiAwal','Tgl_TransaksiAkhir','Id_AT_n_Invent','Desc_AT_n_Invent','no_at_inv','Flag_JnsTransaksi','FId_ATnInvent','Desc_Transaksi','Nilai_Rp','PenanggungJwb');
    var $column_search = array('Tgl_TransaksiAwal','Tgl_TransaksiAkhir','Id_AT_n_Invent','Desc_AT_n_Invent','no_at_inv','Flag_JnsTransaksi','FId_ATnInvent','Desc_Transaksi','Nilai_Rp','PenanggungJwb'); 
    var $order = array('Id_TransEksploit_ATnInven_t' => 'asc'); 
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
         
        $this->db
        ->select("trm_kartueksploit_atninvent.*,mst_at_n_invent.Id_AT_n_Invent,mst_at_n_invent.Desc_AT_n_Invent,mst_at_n_invent.no_at_inv")
        ->join("mst_at_n_invent","mst_at_n_invent.Id_AT_n_Invent = trm_kartueksploit_atninvent.FId_ATnInvent")
        ->where(array('trm_kartueksploit_atninvent.Flag_JnsTransaksi'=>'P'))
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
        $this->db->where(array('Id_TransEksploit_ATnInven_t'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->select("trm_kartueksploit_atninvent.*,mst_at_n_invent.Id_AT_n_Invent,mst_at_n_invent.Desc_AT_n_Invent,mst_at_n_invent.no_at_inv,mst_at_n_invent.Flag_AT_or_Inv");
        $this->db->join("mst_at_n_invent","mst_at_n_invent.Id_AT_n_Invent = trm_kartueksploit_atninvent.FId_ATnInvent");
        $this->db->where(array('trm_kartueksploit_atninvent.Flag_JnsTransaksi'=>'P'));
        $this->db->where(array('Id_TransEksploit_ATnInven_t'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->set('Id_TransEksploit_ATnInven_t', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("Id_TransEksploit_ATnInven_t",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("Id_TransEksploit_ATnInven_t",$id)->delete($this->table);      
    }
    
}