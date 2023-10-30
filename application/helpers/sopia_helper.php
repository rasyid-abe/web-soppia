<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('checknullpost'))
{
	function checknullpost($data) {
	   	if($data != '' || $data != "" || $data != null){
	   	    return $data;
	   	}else{
	   	    return null;
	   	}
	}
}

if (!function_exists('countnotif'))
{
	function countnotif($data,$jenis) {
	   	$ci =& get_instance();
	   	$getuser = $ci->db->where(array('username'=>$data))->get("user");
	   	if($getuser->num_rows()>0){
	   	    $getrole = $ci->db->where(array('iduser'=>$getuser->row()->iduser))->get("roleuser");
	   	    if($getrole->num_rows()>0){
                $getnotif = $ci->db->where(array('idrole'=>$getrole->row()->idrole,'is_khusus'=>'2'))->get("role");
                if($getnotif->num_rows()>0){
                    $chekpeserta = $ci->db->where(array('Flag_SebabTerkunci'=>'D'))->get("mst_peserta");
                        if($chekpeserta->num_rows()>0){
                            $count = 0;
                            if(accessperm('membuka-form-data-kuncian-entry-pejabat-1')){
                                $i =0;
                                foreach($chekpeserta->result() as $chekpst){
                                    $where = array(
                                    'Id_Peserta'=>$chekpst->Id_Peserta,
                                    'Flag_DaftarData_or_DaftarKelas'=>'D',
                                    'Pejabat_Pembuka_Kunci1'=>$getuser->row()->username,
                                    'Tgl_Pejabat1_BukaKunci !='=>null,
                                    );
                                    
                                    $checkkunci = $ci->db->where($where)->get("mst_peserta_logbukakuncian");
                                    if($checkkunci->num_rows()>0){
                                        $i = $i+0;
                                    }else{
                                        $i = $i+1;
                                    }
                                }
                                $count = $i;
                            }
                            if(accessperm('membuka-form-data-kuncian-entry-pejabat-2')){
                                $i =0;
                                foreach($chekpeserta->result() as $chekpst){
                                    $where = array(
                                    'Id_Peserta'=>$chekpst->Id_Peserta,
                                    'Flag_DaftarData_or_DaftarKelas'=>'D',
                                    'Pejabat_Pembuka_Kunci2'=>$getuser->row()->username,
                                    'Tgl_Pejabat2_BukaKunci !='=>null,
                                    );
                                    $checkkunci = $ci->db->where($where)->get("mst_peserta_logbukakuncian");
                                    if($checkkunci->num_rows()>0){
                                        $i = $i+0;
                                    }else{
                                        $i = $i+1;
                                    }
                                }
                               
                                $count = $i;
                            }
                            return $count;
                        }else{
                            return 0;
                        }
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
	   	}else{
	   	    return 0;
	   	}
	}
}


if (!function_exists('getnamegelar'))
{
	function getnamegelar($id) {
	   	$ci =& get_instance();
		$rs =  $ci->db->where('Kd_JnsGelar',$id)->get('ref_gelar');
		if($rs->num_rows()>0){
		    $rs = $rs->row();
		    return ($id <> null || $id <> '' )? ucwords(strtolower($rs->Desc_JnsGelar)) : '<code>N/A</code>';
		}else{
		    return '';
		}
	}
}

if (!function_exists('getnamesertifikasi'))
{
	function getnamesertifikasi($id) {
	   	$ci =& get_instance();
		$rs =  $ci->db->where('Kd_Sertifikasi',$id)->get('ref_sertifikasi');
		if($rs->num_rows()>0){
		    $rs = $rs->row();
		    return ($id <> null || $id <> '' )? ucwords(strtolower($rs->Desc_Sertifikasi)) : '<code>N/A</code>';
		}else{
		    return '';
		}
	}
}
if (!function_exists('getjeniskelamin'))
{
	function getjeniskelamin($id) {
	   	$ci =& get_instance();
		$rs =  $ci->db->where('Kd_JnsKelamin',$id)->get('ref_jeniskelamin');
		if($rs->num_rows()>0){
		    $rs = $rs->row();
		    return ($id <> null || $id <> '' )? ucwords(strtolower($rs->Desc_JnsKelamin)) : '<code>N/A</code>';
		}else{
		    return '';
		}
	}
}
if (!function_exists('getagama'))
{
	function getagama($id) {
	   	$ci =& get_instance();
		$rs =  $ci->db->where('Kd_Agama',$id)->get('ref_agama');
		if($rs->num_rows()>0){
		    $rs = $rs->row();
		    return ($id <> null || $id <> '' )? ucwords(strtolower($rs->Desc_Agama)) : '<code>N/A</code>';
		}else{
		    return '';
		}
	}
}
if (!function_exists('getstratapendidikan'))
{
	function getstratapendidikan($id) {
	   	$ci =& get_instance();
		$rs =  $ci->db->where('Kd_StrataPendidikan',$id)->get('ref_stratapendidikan');
		if($rs->num_rows()>0){
		    $rs = $rs->row();
		    return ($id <> null || $id <> '' )? ucwords(strtolower($rs->Desc_StrataPendidikan)) : '<code>N/A</code>';
		}else{
		    return '';
		}
	}
}
if (!function_exists('getbidangpendidikan'))
{
	function getbidangpendidikan($id) {
	   	$ci =& get_instance();
		$rs =  $ci->db->where('Kd_BidangPendidikan',$id)->get('ref_bidangpendidikan');
		if($rs->num_rows()>0){
		    $rs = $rs->row();
		    return ($id <> null || $id <> '' )? ucwords(strtolower($rs->Desc_BidangPendidikan)) : '<code>N/A</code>';
		}else{
		    return '';
		}
	}
}
if (!function_exists('getpersinstansi'))
{
	function getpersinstansi($id) {
	   	$ci =& get_instance();
		$rs =  $ci->db->where('Id_PershInstansi',$id)->get('mst_pershinstansi');
		if($rs->num_rows()>0){
		    $rs = $rs->row();
		    return ($id <> null || $id <> '' )? $rs->Desc_PershInstansi : '<code>N/A</code>';
		}else{
		    return '';
		}
	}
}
if (!function_exists('getbidangunitorganisasi'))
{
	function getbidangunitorganisasi($id) {
	   	$ci =& get_instance();
		$rs =  $ci->db->where('Kd_BidangUnitOrganisasi',$id)->get('ref_bidang_of_unitorganisasi');
		if($rs->num_rows()>0){
		    $rs = $rs->row();
		    return ($id <> null || $id <> '' )? $rs->Desc_BidangUnitOrganisasi : '<code>N/A</code>';
		}else{
		    return '';
		}
	}
}
if (!function_exists('getnamapeserta'))
{
	function getnamapeserta($id) {
	   	$ci =& get_instance();
		$rs =  $ci->db->where('Id_Peserta',$id)->get('mst_peserta');
		if($rs->num_rows()>0){
		    $rs = $rs->row();
		    return ($id <> null || $id <> '' )? 'Nama : '.$rs->NamaLengkap_TanpaGelar.' | '.'NIPP : '.$rs->NIPP.' | '.'NIK : '.$rs->NIK : '<code>N/A</code>';
		}else{
		    return '';
		}
	}
}
if (!function_exists('getnamainstruktur'))
{
	function getnamainstruktur($id) {
	   	$ci =& get_instance();
		$rs =  $ci->db->where('Id_Instruktur',$id)->get('mst_instruktur');
		if($rs->num_rows()>0){
		    $rs = $rs->row();
		    return ($id <> null || $id <> '' )? 'Nama : '.$rs->NamaLengkap_TanpaGelar.' | '.'NIIS : '.$rs->NIIS.' | '.'NIK : '.$rs->NIK : '<code>N/A</code>';
		}else{
		    return '';
		}
	}
}
if (!function_exists('getjwbeval'))
{
	function getjwbeval($id) {
	   	$ci =& get_instance();
	   	if($id== "5"){
			echo "Sangat Baik";
		}else if($id == "4"){
			echo "Baik";
		}else if($id == "3"){
			echo "Cukup";
		}else if($id == "2"){
			echo "Kurang";
		}else if($id == "1"){
			echo "Kurang Sekali";
		}else{
			echo "<code>N/A</code>";
		}
	}
}

if (!function_exists('tgl_indo'))
{
	function tgl_indo($date) {
		if($date != null || $date != ''){				
			$bulan = array (
				1 => 'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
			$pecahkan = explode('-', $date);
			// variabel pecahkan 0 = tanggal
			// variabel pecahkan 1 = bulan
			// variabel pecahkan 2 = tahun 
			$data =  $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
			return ($date <> null)? $data : '<code>N/A</code>';
		}else{
			return '<code>N/A</code>';
		}
	}
}
