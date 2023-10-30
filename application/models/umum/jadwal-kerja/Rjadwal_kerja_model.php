<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rjadwal_kerja_model extends CI_Model {

    var $table = 'data_jam_kerja';
    var $column_order = array(null, 'shift_jadwal','jam_mulai_jadwal','jam_akhir_jadwal','ket_jadwal');
    var $column_search = array('shift_jadwal','jam_mulai_jadwal','jam_akhir_jadwal','ket_jadwal');
    var $order = array('id_jadwal' => 'asc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {

        $this->db->from($this->table);

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
        $this->db->where(array('id_jadwal'=>$id));
        return $this->db->get()->row();
    }
    public function insertdt($data){
        $this->db->insert($this->table,$data);
    }
    public function updatedt($data,$id){
        $this->db->where("id_jadwal",$id)->update($this->table,$data);
    }
    public function deletedt($id){
        $this->db->where("id_jadwal",$id)->delete($this->table);
    }
}
