<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rsertifikasi_model extends CI_Model {
 
    var $table = 'ref_sertifikasi'; //nama tabel dari database
    var $column_order = array(null, 'ref_sertifikasi.Desc_Sertifikasi','ref_sertifikasi.Kode_Singkatan','ref_jenis_sertifikasi1.Desc_Jns_Sertifikasi1','ref_jenis_sertifikasi2.Desc_Jns_Sertifikasi2','ref_sertifikasi.Keterangan'); //field yang ada di table 
    var $column_search = array('ref_sertifikasi.Desc_Sertifikasi','ref_sertifikasi.Kode_Singkatan','ref_jenis_sertifikasi1.Desc_Jns_Sertifikasi1','ref_jenis_sertifikasi2.Desc_Jns_Sertifikasi2','ref_sertifikasi.Keterangan'); //field yang diizin untuk pencarian 
    var $order = array('ref_sertifikasi.Desc_Sertifikasi' => 'asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function __selectstr($data){
        $master = $this->db->list_fields($data['master']);
        $mm = array();
        /*$mm = array();
        if(count($master)>0){
            foreach ($master as $value) {
                array_push($mm, $data['master'].'.'.$value);
            }
        }
        $master = $mm;*/
        //return $master;
        $countarr = count( $data['field'] );
        if($countarr > 0){
            foreach ($data['field'] as $value) {
                $arr = $this->db->list_fields($value);
                if( count($arr) >0 ){
                    foreach ($arr as $val) {
                        if (in_array($val, $mm)) {
                            
                        }else{
                            array_push($mm, '('.$value.'.'.$val.') as '.$value.$val);
                            //array_push($column_search, $value.'.'.$val);
                        }
                    }
                }else{
                    //return null;
                }
            }
        }else{
            return null;
        }
        return implode(",",$mm);

    }
 
    private function _get_datatables_query()
    {
        $i = 0;
        $__selectstr = $this->__selectstr ( 
                array(
                'master'=> $this->table,
                'field' => 
                    array(
                        'ref_jenis_sertifikasi1',
                        'ref_jenis_sertifikasi2'
                        )
                )
            );
         
        $this->db
        ->select($this->table.'.*,'.$__selectstr)
        ->join("ref_jenis_sertifikasi1","ref_jenis_sertifikasi1.Kd_Jns_Sertifikasi1=ref_sertifikasi.FKd_Jns_Sertifikasi1",'left')
        ->join("ref_jenis_sertifikasi2","ref_jenis_sertifikasi2.Kd_Jns_Sertifikasi2=ref_sertifikasi.FKd_Jns_Sertifikasi2",'left')
        ->from($this->table);
        $column_search_new = explode(',', $__selectstr);

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
        $this->db->where(array('Kd_Sertifikasi'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->join("ref_jenis_sertifikasi1","ref_jenis_sertifikasi1.Kd_Jns_Sertifikasi1=ref_sertifikasi.FKd_Jns_Sertifikasi1",'left');
        $this->db->join("ref_jenis_sertifikasi2","ref_jenis_sertifikasi2.Kd_Jns_Sertifikasi2=ref_sertifikasi.FKd_Jns_Sertifikasi2",'left');
        $this->db->where(array('Kd_Sertifikasi'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->set('Kd_Sertifikasi', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("Kd_Sertifikasi",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("Kd_Sertifikasi",$id)->delete($this->table);      
    }
 
}