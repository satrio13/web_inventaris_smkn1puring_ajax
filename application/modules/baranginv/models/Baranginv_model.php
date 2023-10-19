<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Baranginv_model extends CI_Model
{
    private $table = 'tb_baranginv b'; //nama tabel dari database
    private $column_order = array(null,'b.kode_inv','b.barang','b.merk','b.satuan','k.kategori','b.th_beli','n.kondisi','b.keterangan','b.kode_inv');
    private $column_search = array('b.kode_inv','b.barang','b.merk','b.satuan','k.kategori','b.th_beli','n.kondisi','b.keterangan');
    private $order = array('b.id_baranginv' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {   
        $this->db->select('b.*,k.kategori,n.kondisi');
        $this->db->from($this->table);
        $this->db->join('tb_kategori k','b.id_kategori=k.id_kategori');
        $this->db->join('tb_kondisi n','b.id_kondisi=n.id_kondisi');
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

    function tampil_baranginv()
    {
        return $this->db->select('b.*,k.kategori,n.kondisi')->from('tb_baranginv b')->join('tb_kategori k','b.id_kategori=k.id_kategori')->join('tb_kondisi n','b.id_kondisi=n.id_kondisi')->order_by('b.kode_inv','asc')->get()->result();
    }

    function tambah_baranginv()
    {
        $data = [
            'kode_inv' => strip_tags($this->input->post('kode_inv',TRUE)),
            'barang' => strip_tags($this->input->post('barang',TRUE)),
            'merk' => strip_tags($this->input->post('merk',TRUE)),
            'satuan' => strip_tags($this->input->post('satuan',TRUE)),
            'id_kategori' => strip_tags($this->input->post('id_kategori',TRUE)),
            'th_beli' => strip_tags($this->input->post('th_beli',TRUE)),
            'id_kondisi' => strip_tags($this->input->post('id_kondisi',TRUE)),
            'keterangan' => strip_tags($this->input->post('keterangan',TRUE))
        ];

        $this->db->insert('tb_baranginv',$data);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Disimpan'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Disimpan!'];
        }
    }

    function cek_baranginv($id_baranginv)
    {
        return $this->db->select('id_baranginv')->from('tb_baranginv')->where('id_baranginv',$id_baranginv)->get()->row();
    }

    function get_baranginv_by_id($id_baranginv)
    {
        return $this->db->get_where('tb_baranginv', ['id_baranginv' => $id_baranginv])->row();
    }

    function cek_kode_inv($kode_inv)
    {
        return $this->db->select('kode_inv')->from('tb_baranginv')->where('kode_inv',$kode_inv)->get()->row();
    }

    function cek_id_kategori($id_kategori)
    {
        return $this->db->select('id_kategori')->from('tb_kategori')->where('id_kategori',$id_kategori)->get()->row();
    }

    function cek_id_kondisi($id_kondisi)
    {
        return $this->db->select('id_kondisi')->from('tb_kondisi')->where('id_kondisi',$id_kondisi)->get()->row();
    }

    function edit_baranginv($id_baranginv)
    {
        $data = [
            'kode_inv' => strip_tags($this->input->post('kode_inv',TRUE)),
            'barang' => strip_tags($this->input->post('barang',TRUE)),
            'merk' => strip_tags($this->input->post('merk',TRUE)),
            'satuan' => strip_tags($this->input->post('satuan',TRUE)),
            'id_kategori' => strip_tags($this->input->post('id_kategori',TRUE)),
            'th_beli' => strip_tags($this->input->post('th_beli',TRUE)),
            'id_kondisi' => strip_tags($this->input->post('id_kondisi',TRUE)),
            'keterangan' => strip_tags($this->input->post('keterangan',TRUE))
        ];

        $this->db->update('tb_baranginv',$data,['id_baranginv'=>$id_baranginv]);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Diupdate'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Diupdate!'];
        }
    }

    function hapus_baranginv($id_baranginv)
    {   
        $cek_pindah = $this->db->select('id_baranginv')->from('tb_pindah')->where('id_baranginv',$id_baranginv)->get()->num_rows();
        $cek_pindahtemp = $this->db->select('id_baranginv')->from('tb_pindahtemp')->where('id_baranginv',$id_baranginv)->get()->num_rows();
        if($cek_pindah > 0 OR $cek_pindahtemp > 0)
        {
            return ['status' => false, 'message' => 'Data gagal dihapus, karena sudah berelasi!'];
        }else
        {
            $this->db->delete('tb_baranginv', ['id_baranginv'=>$id_baranginv]);
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