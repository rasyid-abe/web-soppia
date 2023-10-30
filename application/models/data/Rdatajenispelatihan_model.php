<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Rdatajenispelatihan_model extends CI_Model {
 
    var $table = 'mst_jenispelatihan'; //nama tabel dari database
    var $column_order = array(null, 'mst_jenispelatihan.Desc_JenisPelatihan','mst_jenispelatihan.status_pel','ref_kelompokpelatihan.Desc_KelompokPelatihan','mst_jenispelatihan.Flag_IHT','mst_jenispelatihan.Flag_QIA','mst_jenispelatihan.Flag_DefaultAwalQIA','ref_jenispelatihan1.Desc_JnsPelatihan1','ref_jenispelatihan2.Desc_JnsPelatihan2','ref_jenispelatihan3.Desc_JnsPelatihan3','mst_jenispelatihan.KODE_Singkatan','mst_jenispelatihan.Keterangan'); //field yang ada di table user
    var $column_search = array(  'mst_jenispelatihan.Desc_JenisPelatihan','ref_kelompokpelatihan.Desc_KelompokPelatihan','mst_jenispelatihan.Flag_IHT','mst_jenispelatihan.Flag_QIA','mst_jenispelatihan.Flag_DefaultAwalQIA','ref_jenispelatihan1.Desc_JnsPelatihan1','ref_jenispelatihan2.Desc_JnsPelatihan2','ref_jenispelatihan3.Desc_JnsPelatihan3','mst_jenispelatihan.KODE_Singkatan','mst_jenispelatihan.Keterangan'); //field yang diizin untuk pencarian 
    var $order = array('mst_jenispelatihan.Id_JenisPelatihan' => 'asc'); // default order 
 
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
                        'ref_kelompokpelatihan',
                        'ref_jenispelatihan1',
                        'ref_jenispelatihan2',
                        'ref_jenispelatihan3',
                        )
                )
            );


        $this->db
        ->select($this->table.'.*,'.$__selectstr)
        ->join("ref_kelompokpelatihan","ref_kelompokpelatihan.Kd_KelompokPelatihan=mst_jenispelatihan.FKd_KelompokPelatihan","left")
        ->join("ref_jenispelatihan1","ref_jenispelatihan1.Kd_JnsPelatihan1=mst_jenispelatihan.FKd_JnsPelatihan1","left")
        ->join("ref_jenispelatihan2","ref_jenispelatihan2.Kd_JnsPelatihan2=mst_jenispelatihan.FKd_JnsPelatihan2","left")
        ->join("ref_jenispelatihan3","ref_jenispelatihan3.Kd_JnsPelatihan3=mst_jenispelatihan.FKd_JnsPelatihan3","left")
        ->from($this->table);
     
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
        $this->db->where(array('Id_JenisPelatihan'=>$id));
        return $this->db->get()->row();        
    }
    public function getrecordjoin($id){
        $this->db->from($this->table);
        $this->db->join("ref_kelompokpelatihan","ref_kelompokpelatihan.Kd_KelompokPelatihan=mst_jenispelatihan.FKd_KelompokPelatihan","left");
        $this->db->join("ref_jenispelatihan1","ref_jenispelatihan1.Kd_JnsPelatihan1=mst_jenispelatihan.FKd_JnsPelatihan1","left");
        $this->db->join("ref_jenispelatihan2","ref_jenispelatihan2.Kd_JnsPelatihan2=mst_jenispelatihan.FKd_JnsPelatihan2","left");
        $this->db->join("ref_jenispelatihan3","ref_jenispelatihan3.Kd_JnsPelatihan3=mst_jenispelatihan.FKd_JnsPelatihan3","left");
        $this->db->where(array('Id_JenisPelatihan'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->set('Id_JenisPelatihan', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("Id_JenisPelatihan",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("Id_JenisPelatihan",$id)->delete($this->table);      
    }
 
}