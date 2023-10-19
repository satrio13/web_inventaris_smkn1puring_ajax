<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Baranghp_model extends CI_Model
{
    private $table = 'tb_baranghp b'; //nama tabel dari database
    private $column_order = array(null,'b.kode_hp','b.barang','k.kategori','b.stok','b.satuan','b.harga','b.kode_hp');
    private $column_search = array('b.kode_hp','b.barang','k.kategori','b.stok','b.satuan','b.harga');
    private $order = array('b.id_baranghp' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {   
        $this->db->select('b.*,k.kategori');
        $this->db->from($this->table);
        $this->db->join('tb_kategori k','b.id_kategori=k.id_kategori');
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

    function tampil_baranghp()
    {
        return $this->db->select('b.*,k.kategori')->from('tb_baranghp b')->join('tb_kategori k','b.id_kategori=k.id_kategori')->order_by('kode_hp','asc')->get()->result();
    }

    function tambah_baranghp()
    {
        $data = [
            'kode_hp' => strip_tags($this->input->post('kode_hp',TRUE)),
            'barang' => strip_tags($this->input->post('barang',TRUE)),
            'id_kategori' => strip_tags($this->input->post('id_kategori',TRUE)),
            'satuan' => strip_tags($this->input->post('satuan',TRUE)),
            'harga' => strip_tags($this->input->post('harga',TRUE))
        ];

        $this->db->insert('tb_baranghp',$data);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Disimpan'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Disimpan!'];
        }
    }

    function cek_baranghp($id_baranghp)
    {
        return $this->db->select('id_baranghp')->from('tb_baranghp')->where('id_baranghp',$id_baranghp)->get()->row();
    }

    function get_baranghp_by_id($id_baranghp)
    {
        return $this->db->get_where('tb_baranghp', ['id_baranghp' => $id_baranghp])->row();
    }

    function cek_kode_hp($kode_hp)
    {
        return $this->db->select('kode_hp')->from('tb_baranghp')->where('kode_hp',$kode_hp)->get()->row();
    }

    function cek_id_kategori($id_kategori)
    {
        return $this->db->select('id_kategori')->from('tb_kategori')->where('id_kategori',$id_kategori)->get()->row();
    }

    function edit_baranghp($id_baranghp)
    {
        $data = [
            'kode_hp' => strip_tags($this->input->post('kode_hp',TRUE)),
            'barang' => strip_tags($this->input->post('barang',TRUE)),
            'id_kategori' => strip_tags($this->input->post('id_kategori',TRUE)),
            'satuan' => strip_tags($this->input->post('satuan',TRUE)),
            'harga' => strip_tags($this->input->post('harga',TRUE))
        ];

        $this->db->update('tb_baranghp',$data,['id_baranghp'=>$id_baranghp]);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Diupdate'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Diupdate!'];
        }
    }
    
    function hapus_baranghp($id_baranghp)
    {   
        $cek_keluarhp = $this->db->select('id_baranghp')->from('tb_keluarhp')->where('id_baranghp',$id_baranghp)->get()->num_rows();
        $cek_keluarhptemp = $this->db->select('id_baranghp')->from('tb_keluarhptemp')->where('id_baranghp',$id_baranghp)->get()->num_rows();
        $cek_masukhp = $this->db->select('id_baranghp')->from('tb_masukhp')->where('id_baranghp',$id_baranghp)->get()->num_rows();
        if($cek_keluarhp > 0 OR $cek_keluarhptemp > 0 OR $cek_masukhp > 0)
        {
            return ['status' => false, 'message' => 'Data gagal dihapus, karena sudah berelasi!'];
        }else
        {
            $this->db->delete('tb_baranghp', ['id_baranghp'=>$id_baranghp]);
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