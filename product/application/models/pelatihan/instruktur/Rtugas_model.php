<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rtugas_model extends CI_Model {
	var $table = 'trm_instrukturngajar_dikelas'; 
    var $column_order = array(null,'trm_instrukturngajar_dikelas.Tgl_Mengajar','tre_pembukaankelas_n_angkatan_sesi.No_Urut_Sesi','mst_instruktur.NamaLengkap_DgnGelar','trm_pembukaankelas_n_angkatan.DescBebas_Kelas_n_Angkatan','mst_materi_n_aktifitas.Desc_Materi_n_Aktifitas'); 
    var $column_search = array('trm_instrukturngajar_dikelas.Tgl_Mengajar','tre_pembukaankelas_n_angkatan_sesi.No_Urut_Sesi','mst_instruktur.NamaLengkap_DgnGelar','trm_pembukaankelas_n_angkatan.DescBebas_Kelas_n_Angkatan','mst_materi_n_aktifitas.Desc_Materi_n_Aktifitas'); 
    var $order = array('NamaLengkap_DgnGelar' => 'asc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {         
        $this->db->select('
        	trm_instrukturngajar_dikelas.*,mst_instruktur.NamaLengkap_DgnGelar,
        	trm_pembukaankelas_n_angkatan.DescBaku_Kelas_n_Angkatan,
        	trm_pembukaankelas_n_angkatan.DescBebas_Kelas_n_Angkatan,
        	tre_pembukaankelas_n_angkatan_sesi.*,
        	mst_materi_n_aktifitas.*')
        ->join("mst_instruktur","mst_instruktur.Id_Instruktur=trm_instrukturngajar_dikelas.FId_Instruktur",'left')
        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=trm_instrukturngajar_dikelas.FId_Kelas_n_Angkatan",'left')
        ->join("tre_pembukaankelas_n_angkatan_sesi","tre_pembukaankelas_n_angkatan_sesi.idpembukaankelasangkatan=trm_instrukturngajar_dikelas.idpembukaankelasangkatan",'left')
        ->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=trm_instrukturngajar_dikelas.FKd_Materi",'left')

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
        $this->db->where(array('Id_InstrukturNgajar_diKelas'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->select('
        	trm_instrukturngajar_dikelas.*,mst_instruktur.NamaLengkap_DgnGelar,
        	trm_pembukaankelas_n_angkatan.DescBaku_Kelas_n_Angkatan,
        	trm_pembukaankelas_n_angkatan.DescBebas_Kelas_n_Angkatan,
        	mst_materi_n_aktifitas.*');
        $this->db->join("mst_instruktur","mst_instruktur.Id_Instruktur=trm_instrukturngajar_dikelas.FId_Instruktur",'left');
        $this->db->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=trm_instrukturngajar_dikelas.FId_Kelas_n_Angkatan",'left');
        $this->db->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=trm_instrukturngajar_dikelas.FKd_Materi",'left');
        $this->db->where(array('Id_InstrukturNgajar_diKelas'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->set('Id_InstrukturNgajar_diKelas', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("Id_InstrukturNgajar_diKelas",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("Id_InstrukturNgajar_diKelas",$id)->delete($this->table);      
    }
}