<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('checkEmail'))
{
	function checkEmail($email) {
	   if ( strpos($email, '@') !== false ) {
	      $split = explode('@', $email);
	      return (strpos($split['1'], '.') !== false ? true : false);
	   }
	   else {
	      return false;
	   }
	}
}

if (!function_exists('randStrGen')){
	function randStrGen($len){
	    $result = "";
	    $chars = "abcdefghijklmnopqrstuvwxyz0123456789$11";
	    $charArray = str_split($chars);
	    for($i = 0; $i < $len; $i++){
		    $randItem = array_rand($charArray);
		    $result .= "".$charArray[$randItem];
	    }
	    return $result;
	}
}

if (!function_exists('fullname')){
	function fullname(){
		/* start catatan log */
		$ci =& get_instance();
		$username = $ci->session->userdata("username");
		if(checkEmail($username)){
			$cekwhere  = array(
				'email' => $username,
			);
		}else{
			$cekwhere  = array(
				'username' => $username,
			);
		}
		$cek = $ci->db->where($cekwhere)->get("user");
		if($cek->num_rows()>0){
		    $user = $ci->db->where(array('iduser'=>$cek->row()->iduser))->get("detailuser");
		    $name = $user->row()->fullname;
		}else{
		    $name = $ci->session->userdata("username"); 
		}
		return $name;
	}
}


if (!function_exists('gettimefile')){
	function gettimefile($namefile){
		/* start catatan log */
		$ci =& get_instance();
	    $find = $ci->db->where(array('namefile'=>$namefile))->get('meta_file');
	    if($find->num_rows()>0){
	        echo "<small>".$find->row()->datefile."</small>";
	    }else{
	        echo "";
	    }
	}
}



if (!function_exists('recordlog')){
	function recordlog($alasan){
		/* start catatan log */
			$ci =& get_instance();
			/*$username = $ci->session->userdata("username");
			if(checkEmail($username)){
				$cekwhere  = array(
					'email' => $username,
				);
			}else{
				$cekwhere  = array(
					'username' => $username,
				);
			}
			$cek = $ci->db->where($cekwhere)->get("user");
			if($cek->num_rows()>0){
			    $user = $ci->db->where(array('iduser'=>$cek->row()->iduser))->get("detailuser");
			    $name = $user->row()->fullname;
			}else{
			    $name = $ci->session->userdata("username"); 
			}*/
			$name = $ci->session->userdata("username");
			$logdata = array(
				'name'=>$name,
				'Keterangan'=>$alasan,
				'ontime'=> date ("Y-m-d H:i:s"),
			);
    		$ci->db->set('idlog', 'UUID()', FALSE);
			$ci->db->insert("loguser",$logdata);
		/* end catatan log */
	}
}


if (!function_exists('getrolename'))
{
	function getrolename($id) {
		$ci =& get_instance();
		$rs = (object) $ci->db
		->select('role.name as rolename,user.iduser')
		->join('roleuser','user.iduser = roleuser.iduser','left')
		->join('role','role.idrole = roleuser.idrole','left')
		->where('user.iduser',$id)->get('user')->row_array();
		return ($rs->rolename <> null)? ucwords(strtolower($rs->rolename)) : 'N/A';
	}
}


if (!function_exists('getmenuname'))
{
	function getmenuname($id) {
		$ci =& get_instance();
		if($id!= null || $id != ''){
			$rs = (object) $ci->db->where('idmenu',$id)->get("menu")->row_array();
			return ($rs->name <> null)? ucwords(strtolower($rs->name)) : 'N/A';
		}else{
			return 'N/A';
		}
	}
}

if (!function_exists('getlabelname'))
{
	function getlabelname($id) {
		$ci =& get_instance();
		if($id!= null || $id != ''){
			$rs = (object) $ci->db->where('idlabelmenu',$id)->get("labelmenu")->row_array();

			return ($rs->name <> null)? ucwords(strtolower($rs->name)) : 'N/A';
		}else{
			return 'N/A';
		}
	}
}

if (!function_exists('accessperm'))
{
	function accessperm($name) {
		$ci =& get_instance();
		$uname = $ci->session->userdata("username");
		if($uname != 'anonim'){
			$getuser = $ci->db->where(array('username'=>$uname))->get("user")->row();
			$getrole = $ci->db->where(array('iduser'=>$getuser->iduser))->get("roleuser")->row();
			$getperm = $ci->db->where(array('label'=>$name))->get("permission");
			if($getperm->num_rows() > 0){					
				$getpermrole = $ci->db->where(array('idrole'=>$getrole->idrole,'idpermission'=>$getperm->row()->idpermission))->get("permissionrole");
				if($getpermrole->num_rows()>0){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
}


if (!function_exists('permissions'))
{
	function permissions($name) {
		$ci =& get_instance();

		$uname = $ci->session->userdata("username");
		if($uname != 'anonim'){
			$getuser = $ci->db->where(array('username'=>$uname))->get("user")->row();
			$getrole = $ci->db->where(array('iduser'=>$getuser->iduser))->get("roleuser")->row();
			$getperm = $ci->db->where(array('label'=>$name))->get("permission");
			if($getperm->num_rows() > 0){					
				$getpermrole = $ci->db->where(array('idrole'=>$getrole->idrole,'idpermission'=>$getperm->row()->idpermission))->get("permissionrole");
				if($getpermrole->num_rows() > 0){
					return true;
				}else{
					$message = '<h1>4 0 3</h1><br/><br/>F O R B I D D E N <br/><br/><br/>You don\'t have permission to access the requested object. It is either read-protected or not readable by the server.<br/>If you think this is a server error, please contact the webmaster.' ;
					$heading = '';
					return show_error($message, $heading);
					die();
				}
			}else{
				$message = '<h1>4 0 3</h1><br/><br/>F O R B I D D E N <br/><br/><br/>You don\'t have permission to access the requested object. It is either read-protected or not readable by the server.<br/>If you think this is a server error, please contact the webmaster.' ;
				$heading = '';
				return show_error($message, $heading);
				die();
			}
		}else{
			return true;
		}		
	}
}

if (!function_exists('checkroleperm'))
{
	function checkroleperm($role,$perm) {
		$ci =& get_instance();
		$rs = $ci->db->where(
			array(
				'idrole'=>$role,
				'idpermission'=>$perm,
			)
		)->get("permissionrole")->num_rows();
		return ($rs > 0)? true : false;
	}
}

if (!function_exists('checkmenurole'))
{
	function checkmenurole($role,$perm) {
		$ci =& get_instance();
		$rs = $ci->db->where(
			array(
				'idrole'=>$role,
				'idmenu'=>$perm,
			)
		)->get("menurole")->num_rows();
		return ($rs > 0)? true : false;
	}
}

if (!function_exists('is_admin'))
{
	function is_admin() {
		$ci =& get_instance();
		$username  = $ci->session->userdata('username');
		/* --------------- */
		$user = $ci->db->where(
			array(
				'username'=>$username
			)
		)->get("user");
		/* --------------- */
		if($user->num_rows()>0){
			$getrole = $ci->db->where(array(
					'iduser'=>$user->row()->iduser
				))->get("roleuser");

			if($getrole->num_rows()>0){
				$role = $ci->db->where(array(
					'idrole'=>$getrole->row()->idrole
					))->get("role");
				if($role->num_rows()>0){
					if($role->row()->is_khusus == '1'){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}

if (!function_exists('is_adminadmin'))
{
	function is_adminadmin() {
		$ci =& get_instance();
		$username  = $ci->session->userdata('username');
		/* --------------- */
		$user = $ci->db->where(
			array(
				'username'=>$username
			)
		)->get("user");
		/* --------------- */
		if($user->num_rows()>0){
			$getrole = $ci->db->where(array(
					'iduser'=>$user->row()->iduser
				))->get("roleuser");

			if($getrole->num_rows()>0){
				$role = $ci->db->where(array(
					'idrole'=>$getrole->row()->idrole
					))->get("role");
				if($role->num_rows()>0){
					if($role->row()->is_khusus == '3'){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}

if (!function_exists('checkaccessmenu'))
{
	function checkaccessmenu($username,$idmenu) {
		$ci =& get_instance();
		if($username != 'anonim'){
			$getiduser = $ci->db->where(array('username'=>$username))->get("user")->row();
			$getrole = $ci->db->where(array('iduser'=>$getiduser->iduser))->get("roleuser")->row();
			$rs = $ci->db->where(
				array(
					'idrole'=>$getrole->idrole,
					'idmenu'=>$idmenu,
				)
			)->get("menurole")->num_rows();
			return ($rs > 0)? true : false;
		}else{
			return true;
		}
	}
}

if (!function_exists('parentactivemenu'))
{
	function parentactivemenu($idmenu,$segment) {
		$ci =& get_instance();
		$count=0;
		if($segment == 'submenu'){
			$nesg = $ci->uri->segment(3);			 
			$check = $ci->db->where("parent",$idmenu)->get("menu");
			foreach ($check->result() as $key) {
				if($key->idmenu == $nesg){
					$count = $count+1;
				}else{
					$count = $count+0;
				}
			}
		}else{			
			$check = $ci->db->where("parent",$idmenu)->get("menu");
			foreach ($check->result() as $key) {
				if (strpos($key->url, $segment) !== false) {
					$count = $count+1;
				}else{
					$count = $count+0;
				}
			}
			$check1 = $ci->db->where("idmenu",$idmenu)->get("menu");
			foreach ($check1->result() as $vl) {
				if (strpos($vl->url, $segment) !== false) {
					$count = $count+1;
				}else{
					$count = $count+0;
				}
			}
			$check2 = $ci->db->where("idmenu",$idmenu)->get("menu")->row();
			$check2child = $ci->db->where("parent",$check2->idmenu)->get("menu");
			foreach ($check2child->result() as $vlv) {
				$check2child2 = $ci->db->where("parent",$vlv->idmenu)->get("menu");
				foreach ($check2child2->result() as $vlvv) {
					if ( strpos( $vlvv->url ,uri_string()) !== false ) {
						$count = $count+1;
					}else{
						$count = $count+0;
					}
				}
			}

		}

		$count = $count;
		if($count>0){
			return true;
		}else{
			return false;
		}
	}
}

if (!function_exists('childactivemenu'))
{
	function childactivemenu($idmenu,$segment) {
		$ci =& get_instance();
		$count=0;
		/*$check = $ci->db->where("parent",$idmenu)->get("menu");
		foreach ($check->result() as $key) {
			if (strpos($key->url, $segment) !== false) {
				$count = $count+1;
			}else{
				$count = $count+0;
			}
		}*/
		if($segment == 'submenu'){
			$nesg = $ci->uri->segment(3);			 
			$check = $ci->db->where("idmenu",$idmenu)->get("menu");
			foreach ($check->result() as $key) {
				if($key->idmenu == $nesg){
					$count = $count+1;
				}else{
					$count = $count+0;
				}
			}
		}else{
			$check1 = $ci->db->where("idmenu",$idmenu)->get("menu");
			foreach ($check1->result() as $vl) {
				if (strpos($vl->url, $segment) !== false) {
					$count = $count+1;
				}else{
					$count = $count+0;
				}
			}

			$check2 = $ci->db->where("parent",$idmenu)->get("menu");
			foreach ($check2->result() as $vlv) {
				if ( strpos( $vlv->url ,uri_string()) !== false ) {
					$count = $count+1;
				}else{
					$count = $count+0;
				}
			}
		}
		$count = $count;
		if($count>0){
			return true;
		}else{
			return false;
		}
	}
}

if (!function_exists('checktimeloginrole')){
	function checktimeloginrole($username) {
	    $ci =& get_instance();
	    if($username == 'anonim'){
	        return true;
	    }else{
	        if(checkEmail($username)){
    	        $getuser = $ci->db->where("email",$username)->get("user");
    	    }else{
    	        $getuser = $ci->db->where("username",$username)->get("user");
    	    }
    	    if($getuser->num_rows() > 0){
    	        $getrole = $ci->db->where("iduser",$getuser->row()->iduser)->get("roleuser");
    	        if($getrole->num_rows() > 0){
    	            $gettimelog = $ci->db->where("idrole",$getrole->row()->idrole)->get("timelog");
    	            if($gettimelog->num_rows() > 0){
    	                if($gettimelog->row()->status == 'Y'){
    	                    return true;
    	                }else if($gettimelog->row()->status == 'HW'){
    	                    $thisday = date("D");
    	                    $thistime = time();
    	                    
    	                    $day = unserialize($gettimelog->row()->day);
    	                    $time = unserialize($gettimelog->row()->time);
    	                    
    	                    if( in_array($thisday,$day) ){
    	                    	$count = count($time);
    	                    	$starat = '';
    	                    	$endat = '';
    	                    	
    	                    	for($a=0;$a<$count;$a++){
    	                    	    $daytime = unserialize($gettimelog->row()->time)[$a]['timestart'];
    	                    	    if(array_key_exists($thisday,unserialize($gettimelog->row()->time)[$a]['timestart'])){
    	                    	        $starat = unserialize($gettimelog->row()->time)[$a]['timestart'][$thisday];
    	                    	    }
    	                    	    if(array_key_exists($thisday,unserialize($gettimelog->row()->time)[$a]['timeend'])){
    	                    	        $endat = unserialize($gettimelog->row()->time)[$a]['timeend'][$thisday];
    	                    	    }
    	                    	}
    	                    	
    	                        $starat = strtotime($starat);	
    	                        $endat = strtotime($endat);	
    	                        
    	                        if($thistime >= $starat && $thistime < $endat){
    	                            return true;
    	                        }else{
    	                            return false;
    	                        }
    	                    }else{
    	                        return false;
    	                    }
    	                    
    	                }else if($gettimelog->row()->status == 'TW'){
    	                    $datenow = strtotime(date("Y-m-d"));
    	                    $thistime = time();
    	                    
    	                    $datestart = strtotime($gettimelog->row()->datestart);
    	                    $dateend = strtotime($gettimelog->row()->dateend);
    	                   
    	                    $timestart = unserialize($gettimelog->row()->time)[0]['timestart'];
    	                    $timeend = unserialize($gettimelog->row()->time)[0]['timeend'];
                        
                            $timestart = strtotime($timestart);	
                            $timeend = strtotime($timeend);	
                            
    	                    if($datenow >= $datestart && $datenow <= $dateend){
    	                        if($thistime >= $timestart && $thistime < $timeend){
    	                            return true;
    	                        }else{
    	                            return false;
    	                        }
    	                    }else{
    	                        return false;
    	                    }
    	                    
    	                    
    	                }else{
    	                    return false;
    	                }
    	            }else{
                        return true;
                    }
    	        }else{
                    return 'gagallogin';
                }
    	    }else{
                return 'gagallogin';
            }
	    }
	    
	}
}



if (!function_exists('inserthistory_peserta'))
{
	function inserthistory_peserta($peserta,$kelas) {
		$ci =& get_instance();
		
		$dtwhere = array(
			'idpeserta'=>$peserta,
			'idkelas'=>$kelas,
			);	

		// get jenis kelas
		$jenis_kelas = $ci->db->where(
			array(
				'Id_Kelas_n_Angkatan'=>$kelas,
				)
			)
		->join('mst_jenispelatihan','mst_jenispelatihan.Id_JenisPelatihan = trm_pembukaankelas_n_angkatan.FId_JenisPelatihan','left')
		->get('trm_pembukaankelas_n_angkatan');
		if($jenis_kelas->num_rows()>0){
			$jenis_kelas = $jenis_kelas->row()->status_pel;
		}else{
			$jenis_kelas = 'tidak diketahui';
		}

		//#get count lulus
		// ambil materi
		$getm = $ci->db
                        ->select("any_value(tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas) as FKd_Materi_n_Aktifitas, 
                                  any_value(mst_materi_n_aktifitas.Desc_Materi_n_Aktifitas) as Desc_Materi_n_Aktifitas")
                        ->join("mst_materi_n_aktifitas","mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas=tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas",'left')
                        ->join("trm_pembukaankelas_n_angkatan","trm_pembukaankelas_n_angkatan.Id_Kelas_n_Angkatan=tre_pembukaankelas_n_angkatan_sesi.FId_Kelas_n_Angkatan",'left')
                        ->where("tre_pembukaankelas_n_angkatan_sesi.FId_Kelas_n_Angkatan",$kelas)
                        ->where("tre_pembukaankelas_n_angkatan_sesi.FId_Instruktur !=",'')
                        ->where('tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas !=','')
                        ->group_by("tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas")
                        ->get("tre_pembukaankelas_n_angkatan_sesi");
        $countlulus = 0;
        if($getm->num_rows()>0){
        	foreach ($getm->result() as $kk => $vv) {
        		$checkpermapel = $ci->db->where(
	        			array(
		        			'FId_Peserta'=>$peserta,
		        			'FId_Kelas_n_Angkatan'=>$kelas,
		        			'FKd_Materi_n_Aktifitas'=>$vv->FKd_Materi_n_Aktifitas,
	        			)
        			)
        		->get("tre_bukakelasangkatan_peserta_hasilujian");

        		if($checkpermapel->num_rows()>0){
        			$pointcount = 0;

        			$pointcount = ($checkpermapel->row()->Flag_LulusUjian1 == "Y")? $pointcount+1: $pointcount+0 ;
        			$pointcount = ($checkpermapel->row()->Flag_LulusHer1 == "Y")? $pointcount+1: $pointcount+0 ;
        			$pointcount = ($checkpermapel->row()->Flag_LulusHer2 == "Y")? $pointcount+1: $pointcount+0 ;
        			$pointcount = ($checkpermapel->row()->Flag_LulusExtraHer1 == "Y")? $pointcount+1: $pointcount+0 ;

        			if($pointcount > 0 ){
        				$countlulus = $countlulus+1; 
        			}else{
        				$countlulus = $countlulus+0;
        			}
        		}else{
        			$countlulus = $countlulus+0;
        		}
        	}
        	$countmateri = $getm->num_rows();
        }else{
        	$countmateri = 0;
        	$countlulus = $countlulus+0;
        }

        // data insert or update
		$data = array(
				'idpeserta'=>$peserta,
				'idkelas'=>$kelas,
				'count_mapel'=>$countmateri,
				'count_lulus'=>$countlulus,
				'jenis'=>$jenis_kelas,
			);

		$check = $ci->db->where($dtwhere)->get("tbhispeserta");
        if($check->num_rows()>0){
            /*
            $ci->db->where($dtwhere)->update("tbhispeserta",$data);
            */
            if($countmateri > 0){
                $ci->db->where($dtwhere)->update('tbhispeserta',$data);      
            }
            
        }else{
            if($countmateri > 0){
                $ci->db->insert('tbhispeserta',$data);      
            }
        }
		//Flag_SudahQIA
        //  jika jumlah mapel sama dengan jumlah lulus check kelas apakah sudah ditutup
        if($countmateri > 0){
            if($countmateri == $countlulus ){
        	$cekstatuskelas = $ci->db
        	->where(array(
        		'Id_Kelas_n_Angkatan'=>$kelas
        		))
        	->get("trm_pembukaankelas_n_angkatan");
        	if($cekstatuskelas->num_rows()>0){
        		if($cekstatuskelas->row()->Flag_Selesai == "C"){
			        // jika sudah ceck apakah peserta ini telah melewati macam2 kelas jika sudah ubah status menjadi alumni
			        $mcmwhere = array(
			        	'idpeserta'=>$peserta
			        	);
			        $checkmacm2kelas = $ci->db->where($mcmwhere)->get("tbhispeserta");
			        if($checkmacm2kelas->num_rows()>0){
			            //update keterangan surat
			            $ceksurat = $ci->db->query("select * from mst_peserta_dgn_ds_qia where FId_Peserta='$peserta'")->num_rows();
                		if($ceksurat > 0){
                		    $ci->db->query("update mst_peserta_dgn_ds_qia set Flag_Surat='Y' where FId_Peserta='$peserta'");
                		}
			        	foreach ($checkmacm2kelas->result() as $kv) {
			        		if($kv->jenis == 'mnj' || $kv->jenis == 'MNJT'){
			        			$pst = $ci->db->where(array(
			        				'Id_Peserta'=>$peserta
			        				))->get("mst_peserta");
			        			if($pst->num_rows()>0){
			        				$dtupatepst = array(
			        					'Flag_SudahQIA'=>'Y',
			        					);
			        				$pst = $ci->db->where(array(
			        				'Id_Peserta'=>$peserta
			        				))->update("mst_peserta",$dtupatepst);
			        			}
			        		}
			        	}
			        }
        		}else{
        		    // jika sudah ceck apakah peserta ini telah melewati macam2 kelas jika sudah ubah status menjadi alumni
			        $mcmwhere = array(
			        	'idpeserta'=>$peserta
			        	);
			        $checkmacm2kelas = $ci->db->where($mcmwhere)->get("tbhispeserta");
			        if($checkmacm2kelas->num_rows()>0){
			            //update keterangan surat
			            $ceksurat = $ci->db->query("select * from mst_peserta_dgn_ds_qia where FId_Peserta='$peserta'")->num_rows();
                		if($ceksurat > 0){
                		    $ci->db->query("update mst_peserta_dgn_ds_qia set Flag_Surat='Y' where FId_Peserta='$peserta'");
                		}
			        	foreach ($checkmacm2kelas->result() as $kv) {
			        		if($kv->jenis == 'mnj' || $kv->jenis == 'MNJT'){
			        			$pst = $ci->db->where(array(
			        				'Id_Peserta'=>$peserta
			        				))->get("mst_peserta");
			        			if($pst->num_rows()>0){
			        				$dtupatepst = array(
			        					'Flag_SudahQIA'=>'Y',
			        					);
			        				$pst = $ci->db->where(array(
			        				'Id_Peserta'=>$peserta
			        				))->update("mst_peserta",$dtupatepst);
			        			}
			        		}
			        	}
			        }
        		}
        	}
        }
        }

	}
}