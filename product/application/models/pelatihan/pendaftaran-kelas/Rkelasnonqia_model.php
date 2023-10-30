<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rkelasnonqia_model extends CI_Model {
    var $table = 'kelas_nonqia'; 
    var $column_order = array(null,'mst_peserta.NIK','ABS(mst_peserta.NIPP)','mst_peserta.NamaLengkap_DgnGelar','mst_peserta.NamaPershInstansi'); 
    var $column_search = array('mst_peserta.NIK','ABS(mst_peserta.NIPP)','mst_peserta.NamaLengkap_DgnGelar','mst_peserta.NamaPershInstansi'); 
    var $order = array('id_nonqia' => 'desc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query($idkelasnonqia)
    {         
        $this->db
        ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_nonqia.id_peserta",'left')
        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=kelas_nonqia.id_kelas",'left')
        ->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
        ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
        ->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
        ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_pembukaankelas_n_angkatan.idproforma",'left')
        ->where("kelas_nonqia.kelulusan",0)  
        ->where("kelas_nonqia.id_kelas",$idkelasnonqia)  
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
 
    function get_datatables($idkelasnonqia)
    {
        $this->_get_datatables_query($idkelasnonqia);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($idkelasnonqia)
    {
        $this->_get_datatables_query($idkelasnonqia);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($idkelasnonqia)
    {
        $this->db->from($this->table);
        $this->db->where("kelas_nonqia.id_kelas",$idkelasnonqia);
        return $this->db->count_all_results();
    }

    /* crud proccesing */
    public function getrecord($id){
        $this->db->from($this->table);
        $this->db->where(array('id_nonqia'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->insert($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("id_nonqia",$id)->delete($this->table);      
    }
}

