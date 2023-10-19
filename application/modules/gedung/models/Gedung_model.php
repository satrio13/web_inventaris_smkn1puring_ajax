<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gedung_model extends CI_Model
{
    private $table = 'tb_gedung'; //nama tabel dari database
    private $column_order = array(null,'nama_gedung','luas','tahun_p','sumberdana','id_gedung');
    private $column_search = array('nama_gedung','luas','tahun_p','sumberdana');
    private $order = array('id_gedung' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {   
        $this->db->from($this->table);
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

    function tampil_gedung()
    {
        return $this->db->select('*')->from('tb_gedung')->order_by('id_gedung','desc')->get()->result();
    }

    function tambah_gedung()
    {
        $data = [
            'nama_gedung' => strip_tags($this->input->post('nama_gedung',TRUE)),
            'luas' => strip_tags($this->input->post('luas',TRUE)),
            'tahun_p' => strip_tags($this->input->post('tahun_p',TRUE)),
            'sumberdana' => strip_tags($this->input->post('sumberdana',TRUE))
        ];

        $this->db->insert('tb_gedung',$data);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Disimpan'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Disimpan!'];
        }
    }

    function cek_gedung($id_gedung)
    {
        return $this->db->select('id_gedung')->from('tb_gedung')->where('id_gedung',$id_gedung)->get()->row();
    }

    function get_gedung_by_id($id_gedung)
    {
        return $this->db->get_where('tb_gedung', ['id_gedung' => $id_gedung])->row();
    }

    function edit_gedung($id_gedung)
    {
        $data = [
            'nama_gedung' => strip_tags($this->input->post('nama_gedung',TRUE)),
            'luas' => strip_tags($this->input->post('luas',TRUE)),
            'tahun_p' => strip_tags($this->input->post('tahun_p',TRUE)),
            'sumberdana' => strip_tags($this->input->post('sumberdana',TRUE))
        ];

        $this->db->update('tb_gedung',$data,['id_gedung'=>$id_gedung]);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Diupdate'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Diupdate!'];
        }
    }

    function hapus_gedung($id_gedung)
    {   
        $this->db->delete('tb_gedung', ['id_gedung'=>$id_gedung]);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Dihapus'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Dihapus!'];
        }
    }

}