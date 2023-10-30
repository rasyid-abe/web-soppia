<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Raccountingjurnal_model extends CI_Model {
var $table = 'trm_sub_journal_soppia'; 
    var $column_order = array(null,'Kode_SubAccount','Desc_Account','Rencana_JmlPeserta','Tgl_Transaksi','Desc_Transaksi','Flag_D_or_K','Nilai_Rp','Nilai_Rps','Desc_ProformaKontrak','Desc_PershInstansi','Keterangan');
    var $column_search = array('Kode_SubAccount','Desc_Account','Tgl_Transaksi','Desc_Transaksi','Flag_D_or_K','Nilai_Rp','Nilai_Rps','Desc_ProformaKontrak','Desc_PershInstansi','Keterangan'); 
    var $order = array('Id_Voucher_Journal' => 'asc'); 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query($idpro)
    {         
        $this->db->from($this->table);
        $this->db->select("trm_sub_journal_soppia.*,mst_subaccount_soppia.Desc_Account,mst_subaccount_soppia.Kode_SubAccount,mst_proformakontrak.*,mst_pershinstansi.Desc_PershInstansi");
        $this->db->join("mst_subaccount_soppia","mst_subaccount_soppia.Kd_SubAccount=trm_sub_journal_soppia.Fkd_SubAccount",'left');
        $this->db->join("mst_proformakontrak","mst_proformakontrak.Id_ProformaKontrak=trm_sub_journal_soppia.FId_Proforma",'left');
        $this->db->join("mst_pershinstansi","mst_pershinstansi.Id_PershInstansi=mst_proformakontrak.FId_PershInstansi",'left');
        $this->db->where("trm_sub_journal_soppia.FId_Proforma",$idpro);

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
 
    function get_datatables($idpro)
    {
        $this->_get_datatables_query($idpro);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($idpro)
    {
        $this->_get_datatables_query($idpro);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($idpro)
    {
        $this->db->from($this->table);
        $this->db->where("FId_Proforma",$idpro);
        return $this->db->count_all_results();
    }
    
    public function insertdt($data){
        $this->db->set('Id_Voucher_Journal', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
}

