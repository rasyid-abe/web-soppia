<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Detail_model extends CI_Model {
 
    var $table = 'detailuser'; //nama tabel dari database
     
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /* crud prosesing */
    public function getrecord($id){
        $this->db->from($this->table);
        $this->db->where(array('iddetail'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->set('iddetail', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("iddetail",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("iddetail",$id)->delete($this->table);      
    }
 
 
}