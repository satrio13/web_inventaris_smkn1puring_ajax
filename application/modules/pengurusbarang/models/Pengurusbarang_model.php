<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pengurusbarang_model extends CI_Model {
 
    private $table = 'tb_pengurusbarang p'; //nama tabel dari database
    private $column_order = array(null, 'u.nama','p.id'); //field yang ada di table
    private $column_search = array('u.nama'); //field yang diizin untuk pencarian 
    private $order = array('p.id' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        $this->db->select('p.*,u.nama')->from($this->table)->join('tb_user u','p.id_user=u.id_user')->where('p.id',1);
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

    function get_pengurusbarang_by_id()
    {
        return $this->db->get_where('tb_pengurusbarang', ['id'=>1])->row();
    }

    function edit_pengurusbarang()
	{
        $data = [
            'id_user' => $this->input->post('id_user',TRUE)			
        ];
       
        $this->db->update('tb_pengurusbarang', $data, ['id'=>1]);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Disimpan'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Disimpan!'];
        }
    }
    
}