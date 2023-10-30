<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Permission_model extends CI_Model {
 
    var $table = 'permission'; //nama tabel dari database
    var $column_order = array(null, 'name','description','label','menuname'); //field yang ada di table user
    var $column_search = array( 'permission.name','permission.description','permission.label','menu.name'); //field yang diizin untuk pencarian 
    var $order = array('permission.name' => 'ASC'); // default order 
 
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
                        'menu',
                        )
                )
            );
         
        $datadd = $this->db
        ->select($this->table.'.*,'.$__selectstr)
        ->join("menu",'menu.idmenu=permission.idmenu',"left")
        ->from($this->table);
 
        $column_search_new = explode(',', $__selectstr);
     
        foreach ($this->column_search as $item) // looping awal
        {
            //var_dump($item);
            //die();
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
            
            $arr = array('','permission.name','permission.description','menu.name');
            $this->db->order_by($arr[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
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
        $this->db->where(array('idpermission'=>$id));
        return $this->db->get()->row();        
    }
    public function insertdt($data){
        $this->db->set('idpermission', 'UUID()', FALSE);
        $this->db->insert($this->table,$data);      
    }
    public function updatedt($data,$id){
        $this->db->where("idpermission",$id)->update($this->table,$data);      
    }
    public function deletedt($id){
        $this->db->where("idpermission",$id)->delete($this->table);      
    }
 
}