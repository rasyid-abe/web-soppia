<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rkelasqia_model extends CI_Model {
    var $table = 'kelas_qia'; 
    var $column_order = array(null,'mst_peserta.NIK','ABS(mst_peserta.NIPP)','mst_peserta.NamaLengkap_DgnGelar','mst_peserta.NamaPershInstansi'); 
    var $column_search = array('NamaLengkap_DgnGelar','NIK','Flag_QIA','Desc_JenisPelatihan','Desc_PershInstansi','Desc_KotaTraining','Desc_Piagam_Sertifikat','DescBaku_Kelas_n_Angkatan',
            'DescBebas_Kelas_n_Angkatan','LokasiPenyelenggaraan','No_ProformaKontrak','Desc_ProformaKontrak'); 
    var $order = array('id_qia' => 'desc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query($idkelasqia)
    {         
        $this->db
        ->join("mst_peserta","mst_peserta.Id_Peserta=kelas_qia.id_peserta",'left')
        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=kelas_qia.id_kelas",'left')
        ->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
        ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
        ->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
        ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_pembukaankelas_n_angkatan.idproforma",'left')
        ->where("kelas_qia.kelulusan",0)        
        ->where("kelas_qia.id_kelas",$idkelasqia)        
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
 
    function get_datatables($idkelasqia)
    {
        $this->_get_datatables_query($idkelasqia);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($idkelasqia)
    {
        $this->_get_datatables_query($idkelasqia);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($idkelasqia)
    {
        $this->db->from($this->table);
        $this->db->where("kelas_qia.id_kelas",$idkelasqia);
        return $this->db->count_all_results();
    }

    /* crud proccesing */
    public function getrecord($id){
        $this->db->from($this->table);
        $this->db->where(array('id_qia'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->insert($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("id_qia",$id)->delete($this->table);      
    }
}

