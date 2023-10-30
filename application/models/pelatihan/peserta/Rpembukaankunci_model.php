<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rpembukaankunci_model extends CI_Model {
 
    var $table = 'mst_peserta'; //nama tabel dari database
    var $column_order = array(null,'','ABS(NIPP)','NamaPershInstansi','NIK','NamaLengkap_TanpaGelar','NamaLengkap_DgnGelar','NamaPanggilan'); 
    var $column_search = array('NIPP','NamaPershInstansi','NIK','NamaLengkap_TanpaGelar','NamaLengkap_DgnGelar','NamaPanggilan');  
    var $order = array('Last_Posting_Date' => 'DESC','NamaLengkap_TanpaGelar'=>'ASC'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
         
        $this->db->where_in("Flag_SebabTerkunci",array("D"))
        ->where("Flag_Deleted","N")
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
        $this->db->where(array('Id_Peserta'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->where(array('Id_Peserta'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->set('Id_Peserta', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("Id_Peserta",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("Id_Peserta",$id)->delete($this->table);      
    }
 
}