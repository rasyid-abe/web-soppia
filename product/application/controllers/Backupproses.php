<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Backupproses extends CI_Controller
{
  public function __construct(){
    parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); 
    if($this->session->userdata('status') != "login-soppia" && !$this->session->userdata('logged')){
      redirect(base_url('login'));
    }
  }
  // backup files in directory
  function files()
  {
     $opt = array(
       'src' => '../www', // dir name to backup
       'dst' => 'uploads/fileapps/backup' // dir name backup output destination
     );
     
     // Codeigniter v3x
     $this->load->library('recurseZip_lib', $opt);
     $download = $this->recursezip_lib->compress();
     
     /* Codeigniter v2x
     $zip    = $this->load->library('recurseZip_lib', $opt);     
     $download = $zip->compress();
     */
     
     recordlog("Backup Files");
     redirect(base_url($download));
     
     /*if(file_exists('./uploads/fileapps/backup/www.zip')){
        unlink('./uploads/fileapps/backup/www.zip');
      }*/
  }
   
  // backup database.sql
  public function db()
  {
    $this->load->dbutil();

    $prefs = array(     
        'format'      => 'zip',             
        'filename'    => 'my_db_backup.sql'
        );
    
    
    //$backup =& $this->dbutil->backup($prefs); 
    $backup = $this->dbutil->backup();
    
    $db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
    /*$save = 'uploads/fileapps/backup/'.$db_name;
    
    write_file($save, $backup);*/
    
    $this->load->helper('download');
     recordlog("Backup Database");
    //$data = file_get_contents(base_url()."uploads/fileapps/backup/".$db_name);
    force_download($db_name, $backup);
    
     /*if(file_exists('./uploads/fileapps/backup/'.$db_name)){
        unlink('./uploads/fileapps/backup/'.$db_name);
      }*/
  }
   
}