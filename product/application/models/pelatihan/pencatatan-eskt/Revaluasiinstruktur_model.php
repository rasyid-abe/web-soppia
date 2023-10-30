<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Revaluasiinstruktur_model extends CI_Model {
	var $table = 'tre_instrukturngajar_dikelas_evaluasi'; 
    var $column_order = array(null,'NamaLengkap_DgnGelar','NamaLengkap_TanpaGelar','Jwb_Eval1','Jwb_Eval2','Jwb_Eval3','Jwb_Eval3','Jwb_Eval5','Jwb_Eval6','Jwb_Eval7','Jwb_Eval8','Jwb_Eval9','Saran_Eval'); 
    var $column_search = array('NamaLengkap_DgnGelar','NamaLengkap_TanpaGelar','Jwb_Eval1','Jwb_Eval2','Jwb_Eval3','Jwb_Eval3','Jwb_Eval5','Jwb_Eval6','Jwb_Eval7','Jwb_Eval8','Jwb_Eval9','Saran_Eval'); 
    var $order = array('FId_InstrukturNgajar_diKelas' => 'asc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {         
        $this->db
        ->select("tre_instrukturngajar_dikelas_evaluasi.*,mst_instruktur.NamaLengkap_DgnGelar,mst_instruktur.Id_Instruktur,mst_peserta.NamaLengkap_TanpaGelar,mst_peserta.Id_Peserta")
        ->join("trm_instrukturngajar_dikelas","trm_instrukturngajar_dikelas.Id_InstrukturNgajar_diKelas = tre_instrukturngajar_dikelas_evaluasi.FId_InstrukturNgajar_diKelas",'left') 
        ->join("mst_instruktur","mst_instruktur.Id_Instruktur = trm_instrukturngajar_dikelas.FId_Instruktur",'left') 
        ->join("mst_peserta","mst_peserta.Id_Peserta = tre_instrukturngajar_dikelas_evaluasi.FId_Peserta",'left') 
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
        $this->db->where(array('FId_InstrukturNgajar_diKelas'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->select("tre_instrukturngajar_dikelas_evaluasi.*,mst_instruktur.NamaLengkap_DgnGelar,mst_instruktur.Id_Instruktur,mst_peserta.NamaLengkap_TanpaGelar,mst_peserta.Id_Peserta");
        $this->db->join("trm_instrukturngajar_dikelas","trm_instrukturngajar_dikelas.Id_InstrukturNgajar_diKelas=tre_instrukturngajar_dikelas_evaluasi.FId_InstrukturNgajar_diKelas",'left');
        $this->db->join("mst_instruktur","mst_instruktur.Id_Instruktur=trm_instrukturngajar_dikelas.FId_Instruktur",'left');
        $this->db->join("mst_peserta","mst_peserta.Id_Peserta=tre_instrukturngajar_dikelas_evaluasi.FId_Peserta",'left');
        $this->db->where(array('FId_InstrukturNgajar_diKelas'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("FId_InstrukturNgajar_diKelas",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("FId_InstrukturNgajar_diKelas",$id)->delete($this->table);      
    }
}

