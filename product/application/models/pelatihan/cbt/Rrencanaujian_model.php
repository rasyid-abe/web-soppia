<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rrencanaujian_model extends CI_Model {
    var $table = 'trm_settingrencanaujian'; 
    var $column_order = array(null,'Desc_Materi_n_Aktifitas','Tgl_Ujian','UserNama_Pembuka','Password_Pembuka','Skor_Benar','Skor_Salah','Skor_Default',
                                'Flag_HasilTayangLangsung','Flag_BisaMundur','Flag_JmlSoalTakTerbatas','Lama_WaktuUjian','Jml_SoalUjian','Flag_BedaPersentaseAntarBab',
                                'CatatanPelaksanaanUjian','Flag_TelahDiumumkan','Tgl_pengumuman','Desc_JenisPelatihan','nomor_kelas','Flag_QIA','Desc_PershInstansi',
                                'Desc_KotaTraining','Desc_Piagam_Sertifikat','DescBaku_Kelas_n_Angkatan','DescBebas_Kelas_n_Angkatan','LokasiPenyelenggaraan',
                                'No_ProformaKontrak','Desc_ProformaKontrak','Desc_DokBukaKlsReguler','No_Klsreguler'); 
    var $column_search = array('Desc_Materi_n_Aktifitas','Tgl_Ujian','UserNama_Pembuka','Password_Pembuka','Skor_Benar','Skor_Salah','Skor_Default',
                                'Flag_HasilTayangLangsung','Flag_BisaMundur','Flag_JmlSoalTakTerbatas','Lama_WaktuUjian','Jml_SoalUjian','Flag_BedaPersentaseAntarBab',
                                'CatatanPelaksanaanUjian','Flag_TelahDiumumkan','Tgl_pengumuman','Desc_JenisPelatihan','nomor_kelas','Flag_QIA','Desc_PershInstansi',
                                'Desc_KotaTraining','Desc_Piagam_Sertifikat','DescBaku_Kelas_n_Angkatan','DescBebas_Kelas_n_Angkatan','LokasiPenyelenggaraan',
                                'No_ProformaKontrak','Desc_ProformaKontrak','Desc_DokBukaKlsReguler','No_Klsreguler'); 
    var $order = array('Kd_SettingRencanaUjian' => 'desc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {         
        $this->db
        ->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=trm_settingrencanaujian.FKd_Materi_n_Aktifitas",'left')
        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=trm_settingrencanaujian.FId_Kelas_n_Angkatan",'left')
        ->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left')
        ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left')
        ->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left')
        ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_pembukaankelas_n_angkatan.idproforma",'left')
        ->join("mst_dokbukaklsreguler","mst_dokbukaklsreguler.Id_DokBukaKlsReguler=trm_pembukaankelas_n_angkatan.idskreguler",'left')
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
        $this->db->where(array('Kd_SettingRencanaUjian'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=trm_settingrencanaujian.FKd_Materi_n_Aktifitas",'left'); 
        $this->db->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=trm_settingrencanaujian.FId_Kelas_n_Angkatan",'left');     
        $this->db->join("mst_jenispelatihan","mst_jenispelatihan.Id_JenisPelatihan=trm_pembukaankelas_n_angkatan.FId_JenisPelatihan",'left');     
        $this->db->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_pembukaankelas_n_angkatan.FId_PershInstansi",'left');     
        $this->db->join("ref_kotatraining","ref_kotatraining.Kd_KotaTraining=trm_pembukaankelas_n_angkatan.FKd_KotaTraining",'left');  
        $this->db->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_pembukaankelas_n_angkatan.idproforma",'left');
        $this->db->join("mst_dokbukaklsreguler","mst_dokbukaklsreguler.Id_DokBukaKlsReguler=trm_pembukaankelas_n_angkatan.idskreguler",'left');
        $this->db->where(array('Kd_SettingRencanaUjian'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->set('Kd_SettingRencanaUjian', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("Kd_SettingRencanaUjian",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("Kd_SettingRencanaUjian",$id)->delete($this->table);      
    }
}

