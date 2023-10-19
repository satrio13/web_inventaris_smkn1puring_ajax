<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ruang_model extends CI_Model
{
    private $table = 'tb_ruang'; //nama tabel dari database
    private $column_order = array(null,'ruang','nomor','nama_pj','nip_pj','id_ruang');
    private $column_search = array('ruang','nomor','nama_pj','nip_pj');
    private $order = array('id_ruang' => 'desc'); // default order 
 
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

    function tampil_ruang()
    {
        return $this->db->select('*')->from('tb_ruang')->order_by('id_ruang','desc')->get()->result();
    }

    function tambah_ruang()
    {
        $data = [
            'ruang' => strip_tags($this->input->post('ruang',TRUE)),
            'nomor' => strip_tags($this->input->post('nomor',TRUE)),
            'nama_pj' => strip_tags($this->input->post('nama_pj',TRUE)),
            'nip_pj' => strip_tags($this->input->post('nip_pj',TRUE))
        ];

        $this->db->insert('tb_ruang',$data);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Disimpan'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Disimpan!'];
        }
    }

    function cek_ruang($id_ruang)
    {
        return $this->db->select('id_ruang')->from('tb_ruang')->where('id_ruang',$id_ruang)->get()->row();
    }

    function get_ruang_by_id($id_ruang)
    {
        return $this->db->get_where('tb_ruang', ['id_ruang' => $id_ruang])->row();
    }

    function edit_ruang($id_ruang)
    {
        $data = [
            'ruang' => strip_tags($this->input->post('ruang',TRUE)),
            'nomor' => strip_tags($this->input->post('nomor',TRUE)),
            'nama_pj' => strip_tags($this->input->post('nama_pj',TRUE)),
            'nip_pj' => strip_tags($this->input->post('nip_pj',TRUE))
        ];

        $this->db->update('tb_ruang',$data,['id_ruang'=>$id_ruang]);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Diupdate'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Diupdate!'];
        }
    }

    function hapus_ruang($id_ruang)
    {   
        $cek_pindah = $this->db->select('id_ruang')->from('tb_pindah')->where('id_ruang',$id_ruang)->get()->num_rows();
        $cek_pindah_temp = $this->db->select('id_ruang')->from('tb_pindahtemp')->where('id_ruang',$id_ruang)->get()->num_rows();
        if($cek_pindah > 0 OR $cek_pindah_temp > 0)
        {
            return ['status' => false, 'message' => 'Data gagal dihapus, karena sudah berelasi!'];
        }else
        {
            $this->db->delete('tb_ruang', ['id_ruang'=>$id_ruang]);
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