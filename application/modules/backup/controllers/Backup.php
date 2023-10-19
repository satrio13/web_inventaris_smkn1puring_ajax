<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backup extends CI_Controller
{
  public function index()
  {
    $this->load->dbutil();

    $prefs = array(
    'format' => 'zip',
    'filename' => 'my_db_backup.sql'
    );
   
    $backup =& $this->dbutil->backup($prefs);
    date_default_timezone_set('Asia/Jakarta');
    $db_name = 'backup-on-' . date("d-m-Y_H-i-s") . '.zip'; // file name
    //$save  = 'backup/db/' . $db_name; // dir name backup output destination
   
    $this->load->helper('file');
    write_file($save, $backup);
   
    $this->load->helper('download');
    force_download($db_name, $backup); 
  }
     
}