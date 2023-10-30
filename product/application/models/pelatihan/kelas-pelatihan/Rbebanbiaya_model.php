<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rbebanbiaya_model extends CI_Model {
	var $table = 'trm_sub_journal_soppia'; 
    var $column_order = array(null,'Tgl_Transaksi','Desc_Transaksi','Desc_Account','Flag_D_or_K','Nilai_Rp','Flag_Proforma_or_Kelas','Desc_ProformaKontrak','DescBaku_Kelas_n_Angkatan','Desc_PershInstansi','Keterangan'); 
    var $column_search = array('Tgl_Transaksi','Desc_Transaksi','Desc_Account','Flag_D_or_K','Nilai_Rp','Flag_Proforma_or_Kelas','Desc_ProformaKontrak','DescBaku_Kelas_n_Angkatan','Desc_PershInstansi','Keterangan'); 
    var $order = array('Id_Voucher_Journal' => 'asc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {         
        $this->db
        ->select("trm_sub_journal_soppia.*,mst_subaccount_soppia.Desc_Account,mst_proformakontrak.Desc_ProformaKontrak,trm_pembukaankelas_n_angkatan.*,mst_pershinstansi.Desc_PershInstansi")
        ->join("mst_subaccount_soppia","mst_subaccount_soppia.Kd_SubAccount=trm_sub_journal_soppia.Fkd_SubAccount",'left') 
        ->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_sub_journal_soppia.FId_Proforma",'left')
        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=trm_sub_journal_soppia.FId_Kelas_n_Angkatan",'left')
        ->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_sub_journal_soppia.FId_PershInstansi",'left')
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
        $this->db->where(array('Id_Voucher_Journal'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->select("trm_sub_journal_soppia.*,mst_subaccount_soppia.Desc_Account,mst_proformakontrak.Desc_ProformaKontrak,trm_pembukaankelas_n_angkatan.*,mst_pershinstansi.Desc_PershInstansi");
        $this->db->join("mst_subaccount_soppia","mst_subaccount_soppia.Kd_SubAccount=trm_sub_journal_soppia.Fkd_SubAccount",'left');
        $this->db->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_sub_journal_soppia.FId_Proforma",'left');
        $this->db->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=trm_sub_journal_soppia.FId_Kelas_n_Angkatan",'left');
        $this->db->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=trm_sub_journal_soppia.FId_PershInstansi",'left');
        $this->db->where(array('Id_Voucher_Journal'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
    	$this->db->set('Id_Voucher_Journal', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("Id_Voucher_Journal",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("Id_Voucher_Journal",$id)->delete($this->table);      
    }
}

