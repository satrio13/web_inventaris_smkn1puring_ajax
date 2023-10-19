<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Perbaikan_model extends CI_Model
{
    private $table = 'tb_perbaikan p'; //nama tabel dari database
    private $column_order = array(null,'b.kode_inv','b.barang','t.tgl','t.siapa','t.no_hp','k.kondisi','p.id');
    private $column_search = array('b.kode_inv','b.barang','t.tgl','t.siapa','t.no_hp','k.kondisi');
    private $order = array('p.id' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {   
        $this->db->select('p.*,b.kode_inv,b.barang,b.id_kondisi,k.kondisi');
        $this->db->from($this->table);
        $this->db->join('tb_baranginv b','p.id_baranginv=b.id_baranginv');
        $this->db->join('tb_kondisi k','b.id_kondisi=k.id_kondisi');

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

    function tampil_data()
    {
        return $this->db->select('p.*,b.kode_inv,b.barang,b.id_kondisi,k.kondisi')->from('tb_perbaikan p')->join('tb_baranginv b','p.id_baranginv=b.id_baranginv')->join('tb_kondisi k','b.id_kondisi=k.id_kondisi')->order_by('p.id','desc')->get()->result();
    }

    function tambah_perbaikan()
    {
        $this->db->trans_start();
            $data_insert = [
                'id_baranginv' => $this->input->post('id_baranginv', TRUE),
                'tgl' => $this->input->post('tgl', TRUE),
                'siapa' => $this->input->post('siapa', TRUE),
                'no_hp' => $this->input->post('no_hp', TRUE)
            ]; 

            $this->db->insert('tb_perbaikan', $data_insert);

            $data_update = [
                'id_kondisi' => $this->input->post('id_kondisi', TRUE)
            ]; 

            $this->db->update('tb_baranginv', $data_update, ['id_baranginv' => $this->input->post('id_baranginv', TRUE)]);
        $this->db->trans_complete();
        if($this->db->trans_status() == TRUE)
        {
            return ['status' => true, 'message' => 'Data Berhasil Disimpan'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Disimpan!'];
        }
    }

    function edit_perbaikan($id)
    {
        $this->db->trans_start();
            $data_update_perbaikan = [
                'tgl' => $this->input->post('tgl', TRUE),
                'siapa' => $this->input->post('siapa', TRUE),
                'no_hp' => $this->input->post('no_hp', TRUE)
            ]; 

            $this->db->update('tb_perbaikan', $data_update_perbaikan, ['id' => $id]);

            $data_update_kondisi = [
                'id_kondisi' => $this->input->post('id_kondisi', TRUE)
            ]; 

            $id_baranginv = $this->id_baranginv($id);

            $this->db->update('tb_baranginv', $data_update_kondisi, ['id_baranginv' => $id_baranginv]);
        $this->db->trans_complete();
        if($this->db->trans_status() == TRUE)
        {
            return ['status' => true, 'message' => 'Data Berhasil Diupdate'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Diupdate!'];
        }
    }

    function hapus_perbaikan($id)
    {   
        $this->db->delete('tb_perbaikan', ['id'=>$id]);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Dihapus'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Dihapus!'];
        }
    }

    function cek_perbaikan($id)
    {
        return $this->db->select('id')->from('tb_perbaikan')->where('id', $id)->get()->row();
    }
    
    function get_perbaikan_by_id($id)
    {
        return $this->db->select('p.*,b.kode_inv,b.barang,b.id_kondisi')->from('tb_perbaikan p')->join('tb_baranginv b','p.id_baranginv=b.id_baranginv')->where('p.id', $id)->get()->row();
    }

    function id_baranginv($id)
    {
        $q = $this->db->select('id_baranginv')->from('tb_perbaikan')->where('id', $id)->get()->row();
        return $q->id_baranginv;
    }

}