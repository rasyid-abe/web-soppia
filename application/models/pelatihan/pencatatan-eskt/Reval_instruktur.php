<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Reval_instruktur extends CI_Model {
	var $table = 'tre_pembukaankelas_n_angkatan_sesi'; 
    var $column_order = array(null,'mst_instruktur.NamaLengkap_DgnGelar','mst_materi_n_aktifitas.Desc_Materi_n_Aktifitas','mst_materi_n_aktifitas.Singkatan','mst_materi_n_aktifitas.Skor','mst_materi_n_aktifitas.Flag_Daftar_Nilai','mst_materi_n_aktifitas.Menit_per_Sesi'); 
    var $column_search = array('mst_instruktur.NamaLengkap_DgnGelar','mst_materi_n_aktifitas.Desc_Materi_n_Aktifitas','mst_materi_n_aktifitas.Singkatan','mst_materi_n_aktifitas.Skor','mst_materi_n_aktifitas.Flag_Daftar_Nilai','mst_materi_n_aktifitas.Menit_per_Sesi'); 
    var $order = array('idpembukaankelasangkatan' => 'desc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query($id)
    {         
        $this->db
        ->select("any_value(tre_pembukaankelas_n_angkatan_sesi.FId_Kelas_n_Angkatan) as FId_Kelas_n_Angkatan, 
                  any_value(tre_pembukaankelas_n_angkatan_sesi.idpembukaankelasangkatan) as idpembukaankelasangkatan, 
                  any_value(tre_pembukaankelas_n_angkatan_sesi.FId_Instruktur) as FId_Instruktur, 
                  any_value(mst_instruktur.NamaLengkap_DgnGelar) as NamaLengkap_DgnGelar, 
                  any_value(mst_materi_n_aktifitas.Desc_Materi_n_Aktifitas) as Desc_Materi_n_Aktifitas, 
                  any_value(mst_materi_n_aktifitas.Singkatan) as Singkatan, 
                  any_value(mst_materi_n_aktifitas.Skor) as Skor, 
                  any_value(mst_materi_n_aktifitas.Flag_Daftar_Nilai) as Flag_Daftar_Nilai, 
                  any_value(mst_materi_n_aktifitas.Menit_per_Sesi) as Menit_per_Sesi")
        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=tre_pembukaankelas_n_angkatan_sesi.FId_Kelas_n_Angkatan",'left')
        ->join("ref_sesi_satuan","ref_sesi_satuan.Kd_Sesi_Satuan=tre_pembukaankelas_n_angkatan_sesi.FKd_Sesi_Satuan",'left')
        ->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas",'left')
        ->join("mst_instruktur","mst_instruktur.Id_Instruktur=tre_pembukaankelas_n_angkatan_sesi.FId_Instruktur",'left')
        ->where("tre_pembukaankelas_n_angkatan_sesi.FId_Kelas_n_Angkatan",$id)
        //->where("mst_materi_n_aktifitas.Skor !=",0)
        ->where("tre_pembukaankelas_n_angkatan_sesi.FId_Instruktur !=","")
        ->group_by("tre_pembukaankelas_n_angkatan_sesi.FId_Instruktur")
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
 
    function get_datatables($id)
    {
        $this->_get_datatables_query($id);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($id)
    {
        $this->_get_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($id)
    {
        $this->db->from($this->table);
        $this->db->where("tre_pembukaankelas_n_angkatan_sesi.FId_Kelas_n_Angkatan",$id);
        return $this->db->count_all_results();
    }

    /* crud proccesing */
    public function getrecord($id){
        $this->db->from($this->table);
        $this->db->where(array('FId_Kelas_n_Angkatan'=>$id));
        return $this->db->get()->row();        
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

