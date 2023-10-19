<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ambil_model extends CI_Model
{
    private $table = 'tb_detailkeluarhp d'; //nama tabel dari database
    private $column_order = array(null,'d.kode_trans','u.nama','d.nama_pengambil','d.tgl_keluar','d.jam_keluar','d.kode_trans');
    private $column_search = array('d.kode_trans','u.nama','d.nama_pengambil','d.tgl_keluar','d.jam_keluar');
    private $order = array('d.kode_trans' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {   
        $this->db->select('d.*,u.nama')->from('tb_detailkeluarhp d')->join('tb_user u','d.id_user=u.id_user');
        $i = 0;
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // cek kalo ada search data
			{				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open group like or like
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close group like or like
			}
			$i++;
		}		
		if(isset($_POST['order'])) // cek kalo click order
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
 
    function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

}