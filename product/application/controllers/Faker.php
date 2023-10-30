<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faker extends CI_Controller {

	public function __construct(){
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
	}
	
	public function index(){
	    
	    for($oi=1;$oi<=20;$oi++){
	            
    	    $f_calon = "Y";
    	    $nipp = rand(1000000000000,9999999999999);
    	    $nik = rand(1000000000000,9999999999999);
    	    $nmlgkp_tg = $this->randomName();
    	    $nmlgkp_dg = $this->randomName();
    	    $nmp = $this->randomName();
    	    $foto = null;
    	    $kota_lahir = $this->kotalahir();
    	    $tgl_lahir = rand(1933,2016).'-'.rand(1,12).'-'.rand(1,28);
    	    $jk = rand(1,2);
    	    $agm = rand(1,5);
    	    $sttpddk = rand(1,9);
    	    $pershinst = $this->db->order_by('rand()')->limit(1)->get("mst_pershinstansi")->row()->Id_PershInstansi;
    	    $namapershinst = $this->db->where(array('Id_PershInstansi'=>$pershinst))->get("mst_pershinstansi")->row()->Desc_PershInstansi;
    	    $almkantor = $this->db->where(array('Id_PershInstansi'=>$pershinst))->get("mst_pershinstansi")->row()->Alamat_Utama_Kantor;
    	    $telpkantor = $this->db->where(array('Id_PershInstansi'=>$pershinst))->get("mst_pershinstansi")->row()->Telp;
    	    $emailkantor = $this->db->where(array('Id_PershInstansi'=>$pershinst))->get("mst_pershinstansi")->row()->email;
    	    $org =  $this->db->order_by('rand()')->limit(1)->get("ref_bidang_of_unitorganisasi")->row()->Kd_BidangUnitOrganisasi;
    	    $a = array('staff','direktur','manager');
    	    $jbt =  array_rand($a,1);
    	    $almt = $this->db->where(array('Id_PershInstansi'=>$pershinst))->get("mst_pershinstansi")->row()->Alamat_Utama_Kantor;
    	    $telp = rand(00000000,99999999);
    	    $hp = rand(000000000000,999999999999);
    	    $email = $this->generateRandomString().'@gmail.com';
    	    $ktrg = null;
    	    
        	$data = array(
    			'Flag_CalonPeserta' =>$f_calon,
    			'Flag_SebabTerkunci' =>"N",
    			'NIPP' => $nipp,
    			'NIK' => $nik,
    			'NamaLengkap_TanpaGelar' => $nmlgkp_tg,
    			'NamaLengkap_DgnGelar' => $nmlgkp_dg,
    			'NamaPanggilan' => $nmp,
    			'FilePhoto' => $foto,
    			'Kota_Lahir' => $kota_lahir,
    			'Tgl_Lahir' => $tgl_lahir,
    			'FKd_JnsKelamin' => $jk,
    			'FKd_Agama' => $agm,
    			'Fkd_StrataPendidikanTerakhir' => $sttpddk,
    			'FId_PershInstansi' => $pershinst,
    			'NamaPershInstansi' => $namapershinst,
    			'Alamat_Kantor' => $almkantor,
    			'Telp_Kantor' => $telpkantor,
    			'eMail_Kantor' => $emailkantor,
    			'FKd_BidangUnitOrganisasi' => $org,
    			'Jabatan_NamaUnitOrganisasi' => $jbt,
    			'Alamat_Rumah' => $almt,
    			'Telp_Rumah' => $telp,
    			'No_HP' => $hp,
    			'eMail_Pribadi' => $email,
    			'Keterangan' => $ktrg,
    			'Entry_Date'=>date("Y-m-d"),
    			'Entry_By'=>$this->session->userdata('username'),
    			'Flag_Deleted'=>'N',
    		);
    		
    		$countgelar = count(rand(1,5));
			for($i=0;$i<$countgelar;$i++){
				$no = $i+1;
				$str = "FKd_Gelar{$no}";
				$data[$str] =  $this->db->order_by('rand()')->limit(1)->get("ref_gelar")->row()->Kd_JnsGelar;
			}

			$countsertifikasi = count(rand(1,6));
			for($as=0;$as<$countsertifikasi;$as++){
				$no = $as+1;
				$str = "FKd_Sertifikasi{$no}";
				$data[$str] = $this->db->order_by('rand()')->limit(1)->get("ref_sertifikasi")->row()->Kd_Sertifikasi;
			}

			$countbidangpendidikan = count(rand(1,3));
			for($ass=0;$ass<$countbidangpendidikan;$ass++){
				$no = $ass+1;
				$str = "FKd_BidangPendidikan{$no}";
				$data[$str] = $this->db->order_by('rand()')->limit(1)->get("ref_bidangpendidikan")->row()->Kd_BidangPendidikan;
			}
			
            $this->db->set('Id_Peserta', 'UUID()', FALSE);
			$this->db->insert("mst_peserta",$data);
	    }
	}
	
	public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
	
	public function kotalahir() {
        $firstname = array(
            'Surabaya',
            'Jember',
            'Medan',
            'Yogyakarta',
            'Denpasar',
            'Mataram',
            'Pontianak',
            'Balikpapan',
            'Jakarta',
            'Bandung',
            'Pekanbaru',
            'Banda Aceh',
            'Samarinda',
            'Cilegon',
            'Ponorogo',
            'Solo',
            'Tegal',
            'Blitar',
            'Makassar',
            'Palu',
            'Palopo',
            'Jayapura',
            'Ternate',
            'Maluku'
        );
    
    
        $name = $firstname[rand ( 0 , count($firstname) -1)];
        return $name;
    }
	public function randomName() {
        $firstname = array(
            'Johnathon',
            'Anthony',
            'Erasmo',
            'Raleigh',
            'Nancie',
            'Tama',
            'Camellia',
            'Augustine',
            'Christeen',
            'Luz',
            'Diego',
            'Lyndia',
            'Thomas',
            'Georgianna',
            'Leigha',
            'Alejandro',
            'Marquis',
            'Joan',
            'Stephania',
            'Elroy',
            'Zonia',
            'Buffy',
            'Sharie',
            'Blythe',
            'Gaylene',
            'Elida',
            'Randy',
            'Margarete',
            'Margarett',
            'Dion',
            'Tomi',
            'Arden',
            'Clora',
            'Laine',
            'Becki',
            'Margherita',
            'Bong',
            'Jeanice',
            'Qiana',
            'Lawanda',
            'Rebecka',
            'Maribel',
            'Tami',
            'Yuri',
            'Michele',
            'Rubi',
            'Larisa',
            'Lloyd',
            'Tyisha',
            'Samatha',
        );
    
        $lastname = array(
            'Mischke',
            'Serna',
            'Pingree',
            'Mcnaught',
            'Pepper',
            'Schildgen',
            'Mongold',
            'Wrona',
            'Geddes',
            'Lanz',
            'Fetzer',
            'Schroeder',
            'Block',
            'Mayoral',
            'Fleishman',
            'Roberie',
            'Latson',
            'Lupo',
            'Motsinger',
            'Drews',
            'Coby',
            'Redner',
            'Culton',
            'Howe',
            'Stoval',
            'Michaud',
            'Mote',
            'Menjivar',
            'Wiers',
            'Paris',
            'Grisby',
            'Noren',
            'Damron',
            'Kazmierczak',
            'Haslett',
            'Guillemette',
            'Buresh',
            'Center',
            'Kucera',
            'Catt',
            'Badon',
            'Grumbles',
            'Antes',
            'Byron',
            'Volkman',
            'Klemp',
            'Pekar',
            'Pecora',
            'Schewe',
            'Ramage',
        );
    
        $name = $firstname[rand ( 0 , count($firstname) -1)];
        $name .= ' ';
        $name .= $lastname[rand ( 0 , count($lastname) -1)];
    
        return $name;
    }
	
	
}