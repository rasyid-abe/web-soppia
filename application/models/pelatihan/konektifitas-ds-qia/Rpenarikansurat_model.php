<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rpenarikansurat_model extends CI_Model {
	var $table = 'mst_peserta_dgn_ds_qia'; 
    var $column_order = array(null,'ABS(mst_peserta.NIPP)','mst_peserta.NamaLengkap_TanpaGelar','mst_peserta.NamaPershInstansi','mst_peserta_dgn_ds_qia.Tgl_SuratPlacement'); 
    var $column_search = array('ABS(mst_peserta.NIPP)','mst_peserta.NamaLengkap_TanpaGelar','mst_peserta.NamaPershInstansi','mst_peserta_dgn_ds_qia.Tgl_SuratPlacement'); 
    var $order = array('FId_Peserta' => 'asc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {         
        $this->db
        ->join("mst_peserta","mst_peserta.Id_Peserta=mst_peserta_dgn_ds_qia.FId_Peserta",'left')
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
        $this->db->where(array('FId_Peserta'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->join("mst_peserta","mst_peserta.Id_Peserta=mst_peserta_dgn_ds_qia.FId_Peserta",'left');        
        $this->db->where(array('FId_Peserta'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("FId_Peserta",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("FId_Peserta",$id)->delete($this->table);      
    }
}

