<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kategori_model extends CI_Model
{
    private $table = 'tb_kategori'; //nama tabel dari database
    private $column_order = array(null,'kategori','id_kategori','kategori');
    private $column_search = array('kategori','id_kategori');
    private $order = array('id_kategori' => 'desc'); // default order 
 
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

    function tampil_kategori()
    {
        return $this->db->select('*')->from('tb_kategori')->order_by('id_kategori','desc')->get()->result();
    }

    function tambah_kategori()
    {
        $data = [
            'kategori' => strip_tags($this->input->post('kategori',TRUE))
        ];

        $this->db->insert('tb_kategori',$data);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Disimpan'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Disimpan!'];
        }
    }

    function cek_kategori($id_kategori)
    {
        return $this->db->select('id_kategori')->from('tb_kategori')->where('id_kategori',$id_kategori)->get()->row();
    }

    function get_kategori_by_id($id_kategori)
    {
        return $this->db->get_where('tb_kategori', ['id_kategori' => $id_kategori])->row();
    }

    function edit_kategori($id_kategori)
    {
        $data = [
            'kategori' => strip_tags($this->input->post('kategori',TRUE))
        ];

        $this->db->update('tb_kategori',$data,['id_kategori'=>$id_kategori]);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Diupdate'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Diupdate!'];
        }
    }

    function hapus_kategori($id_kategori)
    {   
        $cek_baranghp = $this->db->select('id_kategori')->from('tb_baranghp')->where('id_kategori',$id_kategori)->get()->num_rows();
        $cek_baranginv = $this->db->select('id_kategori')->from('tb_baranginv')->where('id_kategori',$id_kategori)->get()->num_rows();
        if($cek_baranghp > 0 OR $cek_baranginv > 0)
        {
            return ['status' => false, 'message' => 'Data gagal dihapus, karena sudah berelasi!'];
        }else
        {
            $this->db->delete('tb_kategori', ['id_kategori'=>$id_kategori]);
            if($this->db->affected_rows() > 0)
            {
                return ['status' => true, 'message' => 'Data Berhasil Dihapus'];
            }else
            {
                return ['status' => false, 'message' => 'Data Gagal Dihapus!'];
            } 
        }       
    }

}