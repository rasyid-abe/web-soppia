<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rpresensi_model extends CI_Model {
 var $table = 'mst_pegawai';
	public function getrecord($id){
		$this->db->from($this->table);
		$this->db->where(array('id_pegawai'=>$id));
		return $this->db->get()->row();  
 }
}