<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Menu_model extends CI_Model {
 
    protected $table = 'menu'; //nama tabel dari database
    protected $column_order = array(null, 'menu.name','menu.description','menu.url','menu.icon','labelmenu.name'); //field yang ada di table user
    protected $column_search = array( 'menu.name','menu.description','menu.url','menu.icon','labelmenu.name'); //field yang diizin untuk pencarian 
    protected $order = array('menu.name' => 'asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
         
        $this->db
        ->select("{$this->table}.*,labelmenu.idlabelmenu,(labelmenu.name) as labelnamae")
        ->join("labelmenu","labelmenu.idlabelmenu={$this->table}.labelmenu","left")
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
           /* $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);*/

            $arr = array('','menu.name','','menu.url','labelmenu.name');
            $this->db->order_by($arr[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
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
        $this->db->where(array('idmenu'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->set('idmenu', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("idmenu",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("idmenu",$id)->delete($this->table);      
    }
 
}