<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rbanksoal_model extends CI_Model {
	var $table = 'mst_soal'; 
    var $column_order = array(null,'Desc_Materi_n_Aktifitas','Desc_SubBab','NamaLengkap_DgnGelar','NamaLengkap_TanpaGelar','Isi_PertanyaanSoal','Flag_4PointJwb','Jawab_Point_a',
                        'Jawab_Point_b','Jawab_Point_c','Jawab_Point_d','Jawab_Point_e','Jawab_yg_Benar','Tingkat_Kesulitan','Penjelasan_Jawaban','Path_FileLampiran'); 
    var $column_search = array('Desc_Materi_n_Aktifitas','Desc_SubBab','NamaLengkap_DgnGelar','NamaLengkap_TanpaGelar','Isi_PertanyaanSoal','Flag_4PointJwb','Jawab_Point_a',
                        'Jawab_Point_b','Jawab_Point_c','Jawab_Point_d','Jawab_Point_e','Jawab_yg_Benar','Tingkat_Kesulitan','Penjelasan_Jawaban','Path_FileLampiran'); 
    var $order = array('Id_Soal' => 'desc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {         
        $this->db
        ->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=mst_soal.FKd_Materi_n_Aktifitas",'left')
        ->join("mst_materi_subbab","mst_materi_subbab.Kd_SubBab=mst_soal.FKd_SubBab",'left')
        ->join("mst_instruktur","mst_instruktur.Id_Instruktur=mst_soal.FId_Instruktur",'left')
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
        $this->db->where(array('Id_Soal'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=mst_soal.FKd_Materi_n_Aktifitas",'left');     
        $this->db->join("mst_materi_subbab","mst_materi_subbab.Kd_SubBab=mst_soal.FKd_SubBab",'left');     
        $this->db->join("mst_instruktur","mst_instruktur.Id_Instruktur=mst_soal.FId_Instruktur",'left');     
        $this->db->where(array('Id_Soal'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("Id_Soal",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("Id_Soal",$id)->delete($this->table);      
    }
}

