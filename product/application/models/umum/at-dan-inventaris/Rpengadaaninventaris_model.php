<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rpengadaaninventaris_model extends CI_Model {
    
    var $table = 'mst_at_n_invent'; 
    var $column_order = array(null,'Desc_AT_n_Invent','no_at_inv','Tgl_Pengadaan','Flag_AT_or_Inv','Desc_Lokasi_Simpan','Harga_Perolehan_Rp','AccDepr_Rp','FKd_Lokasi_Simpan','Metode_Depresiasi','Th_UmurEkonomis');
    var $column_search = array('Desc_AT_n_Invent','no_at_inv','Tgl_Pengadaan','Flag_AT_or_Inv','Desc_Lokasi_Simpan','Harga_Perolehan_Rp','AccDepr_Rp','FKd_Lokasi_Simpan','Metode_Depresiasi','Th_UmurEkonomis'); 
    var $order = array('Id_AT_n_Invent' => 'asc'); 
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
         
        $this->db
        ->select("{$this->table}.*,ref_lokasi_simpan.Kd_Lokasi_Simpan,ref_lokasi_simpan.Desc_Lokasi_Simpan,(ref_lokasi_simpan.Keterangan) as ketlokasisimpan")
        ->join("ref_lokasi_simpan","ref_lokasi_simpan.Kd_Lokasi_Simpan={$this->table}.FKd_Lokasi_Simpan","left")
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
        $this->db->where(array('Id_AT_n_Invent'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->select("{$this->table}.*,ref_lokasi_simpan.Kd_Lokasi_Simpan,ref_lokasi_simpan.Desc_Lokasi_Simpan,(ref_lokasi_simpan.Keterangan) as ketlokasisimpan");
        $this->db->join("ref_lokasi_simpan","ref_lokasi_simpan.Kd_Lokasi_Simpan={$this->table}.FKd_Lokasi_Simpan","left");
        $this->db->from($this->table);
        $this->db->where(array('Id_AT_n_Invent'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->set('Id_AT_n_Invent', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("Id_AT_n_Invent",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("Id_AT_n_Invent",$id)->delete($this->table);      
    }
 
}