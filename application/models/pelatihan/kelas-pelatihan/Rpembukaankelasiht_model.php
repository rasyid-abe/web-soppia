<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rpembukaankelasiht_model extends CI_Model {
	var $table = 'trm_pembukaankelas_n_angkatan'; 
    var $column_order = array(null,'trm_pembukaankelas_n_angkatan.DescBebas_Kelas_n_Angkatan','trm_pembukaankelas_n_angkatan.nomor_kelas','trm_pembukaankelas_n_angkatan.No_Urut_Angkatan','mst_jenispelatihan.Desc_JenisPelatihan','trm_pembukaankelas_n_angkatan.Tgl_Mulai_Aktual'); 
    var $column_search = array('trm_pembukaankelas_n_angkatan.DescBebas_Kelas_n_Angkatan','trm_pembukaankelas_n_angkatan.nomor_kelas','trm_pembukaankelas_n_angkatan.No_Urut_Angkatan','mst_jenispelatihan.Desc_JenisPelatihan','trm_pembukaankelas_n_angkatan.Tgl_Mulai_Aktual'); 
    var $order = array('nomor_kelas' => 'desc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {         
        $this->db
        ->select("trm_pembukaankelas_n_angkatan.*,mst_jenispelatihan.Desc_JenisPelatihan,mst_pershinstansi.Desc_PershInstansi,ref_kotatraining.Desc_KotaTraining,
        mst_formatpiagamsertifikat.Desc_Piagam_Sertifikat,mst_proformakontrak.No_ProformaKontrak,mst_proformakontrak.Desc_ProformaKontrak,
        mst_dokbukaklsreguler.Desc_DokBukaKlsReguler,mst_dokbukaklsreguler.No_Klsreguler")
        ->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
        ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
        ->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
        ->join("mst_formatpiagamsertifikat","mst_formatpiagamsertifikat.Id_FormatPiagamSertifikat=trm_pembukaankelas_n_angkatan.FId_FormatSertifikat",'left')
        ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_pembukaankelas_n_angkatan.idproforma",'left')
        ->join("mst_dokbukaklsreguler","mst_dokbukaklsreguler.Id_DokBukaKlsReguler=trm_pembukaankelas_n_angkatan.idskreguler",'left')
        ->where('trm_pembukaankelas_n_angkatan.idproforma !=',"")
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
        $this->db->where(array('Id_Kelas_n_Angkatan'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->select("trm_pembukaankelas_n_angkatan.*,mst_jenispelatihan.Desc_JenisPelatihan,mst_pershinstansi.Desc_PershInstansi,ref_kotatraining.Desc_KotaTraining,
        mst_formatpiagamsertifikat.Desc_Piagam_Sertifikat,mst_proformakontrak.No_ProformaKontrak,mst_proformakontrak.Desc_ProformaKontrak,
        mst_dokbukaklsreguler.Desc_DokBukaKlsReguler,mst_dokbukaklsreguler.No_Klsreguler");
        $this->db->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left');
        $this->db->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left');
        $this->db->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left');
        $this->db->join("mst_formatpiagamsertifikat","mst_formatpiagamsertifikat.Id_FormatPiagamSertifikat=trm_pembukaankelas_n_angkatan.FId_FormatSertifikat",'left');        
        $this->db->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_pembukaankelas_n_angkatan.idproforma",'left');        
        $this->db->join("mst_dokbukaklsreguler","mst_dokbukaklsreguler.Id_DokBukaKlsReguler=trm_pembukaankelas_n_angkatan.idskreguler",'left');        
        $this->db->where('trm_pembukaankelas_n_angkatan.idproforma !=',"");
        $this->db->where(array('Id_Kelas_n_Angkatan'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->set('Id_Kelas_n_Angkatan', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("Id_Kelas_n_Angkatan",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("Id_Kelas_n_Angkatan",$id)->delete($this->table);      
    }
}

