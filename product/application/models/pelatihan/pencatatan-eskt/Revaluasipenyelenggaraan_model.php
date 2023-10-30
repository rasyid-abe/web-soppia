<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Revaluasipenyelenggaraan_model extends CI_Model {
    var $table = 'tre_pembukaankelas_n_angkatan_peserta_n_evalnya'; 
    var $column_order = array(null, 'FId_Kelas_n_Angkatan','nomor_kelas','DescBebas_Kelas_n_Angkatan','KODE_Singkatan','LokasiPenyelenggaraan','FId_Peserta','NamaLengkap_DgnGelar','NamaLengkap_TanpaGelar','Jwb_Eval1','Jwb_Eval2','Jwb_Eval3','Jwb_Eval4','Saran'); 
    var $column_search = array('FId_Kelas_n_Angkatan','nomor_kelas','DescBebas_Kelas_n_Angkatan','KODE_Singkatan','LokasiPenyelenggaraan','FId_Peserta','NamaLengkap_DgnGelar','NamaLengkap_TanpaGelar','Jwb_Eval1','Jwb_Eval2','Jwb_Eval3','Jwb_Eval4','Saran'); 
    var $order = array('FId_Kelas_n_Angkatan' => 'desc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {         
        $this->db
        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan = tre_pembukaankelas_n_angkatan_peserta_n_evalnya.FId_Kelas_n_Angkatan",'left') 
        ->join("mst_peserta","mst_peserta.Id_Peserta = tre_pembukaankelas_n_angkatan_peserta_n_evalnya.FId_Peserta",'left') 
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
        $this->db->where(array('FId_Kelas_n_Angkatan'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan = tre_pembukaankelas_n_angkatan_peserta_n_evalnya.FId_Kelas_n_Angkatan",'left');
        $this->db->join("mst_peserta","mst_peserta.Id_Peserta = tre_pembukaankelas_n_angkatan_peserta_n_evalnya.FId_Peserta",'left');
        $this->db->where(array('FId_Kelas_n_Angkatan'=>$id));
        return $this->db->get();        
    }
    public function insertdt($data){
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("FId_Kelas_n_Angkatan",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("FId_Kelas_n_Angkatan",$id)->delete($this->table);      
    }
}

