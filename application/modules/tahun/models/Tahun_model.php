<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tahun_model extends CI_Model {
 
    private $table = 'tb_tahun'; //nama tabel dari database
    private $column_order = array(null, 'tahun','id_tahun'); //field yang ada di table
    private $column_search = array('tahun'); //field yang diizin untuk pencarian 
    private $order = array('id_tahun' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        $this->db->from($this->table);
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

    function tambah_tahun()
    {
        $data = [
            'tahun' => strip_tags($this->input->post('tahun',TRUE))
        ];

        $this->db->insert('tb_tahun', $data);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Disimpan'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Disimpan!'];
        }
    }

    function cek_tahun($id_tahun)
    {
        return $this->db->select('id_tahun')->from('tb_tahun')->where('id_tahun',$id_tahun)->get()->row();
    }

    function get_tahun_by_id($id_tahun)
    {
        return $this->db->get_where('tb_tahun', ['id_tahun' => $id_tahun])->row();
    }

    function edit_tahun($id_tahun)
    {
        $data = [
            'tahun' => strip_tags($this->input->post('tahun',TRUE))
        ];

        $this->db->update('tb_tahun',$data,['id_tahun'=>$id_tahun]);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Diupdate'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Diupdate!'];
        }
    }

    function hapus_tahun($id_tahun)
    {   
        $this->db->delete('tb_tahun', ['id_tahun'=>$id_tahun]);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Dihapus'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Dihapus!'];
        }
    }

}