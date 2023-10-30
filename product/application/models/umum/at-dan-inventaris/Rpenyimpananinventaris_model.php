<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rpenyimpananinventaris_model extends CI_Model {
 var $table = 'mst_at_n_invent';
 public function getrecord($id){
        $this->db->from($this->table);
        $this->db->where(array('Id_AT_n_Invent'=>$id));
        return $this->db->get()->row();        
}
}