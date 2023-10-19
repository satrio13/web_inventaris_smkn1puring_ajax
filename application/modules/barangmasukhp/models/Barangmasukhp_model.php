<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Barangmasukhp_model extends CI_Model
{
    private $table = 'tb_masukhp d'; //nama tabel dari database
    private $column_order = array(null,'b.kode_hp','b.barang','k.kategori','d.tgl_masuk','d.jml_masuk','b.satuan','d.id_masukhp');
    private $column_search = array('b.kode_hp','b.barang','k.kategori','d.tgl_masuk','d.jml_masuk','b.satuan');
    private $order = array('d.id_masukhp' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {   
        $this->db->select('d.*,b.*,k.kategori');
        $this->db->from($this->table);
        $this->db->join('tb_baranghp b','d.id_baranghp=b.id_baranghp');
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

    function tampil_barangmasukhp()
    {
        return $this->db->select('d.*,b.*,k.kategori')->from('tb_masukhp d')->join('tb_baranghp b','d.id_baranghp=b.id_baranghp')->join('tb_kategori k','b.id_kategori=k.id_kategori')->order_by('d.id_masukhp','desc')->get()->result();
    }

    function tambah_barangmasukhp()
    {
        $id_baranghp = strip_tags($this->input->post('id_baranghp',TRUE));
        $tgl_masuk = strip_tags($this->input->post('tgl_masuk',TRUE));
        $jml_masuk = strip_tags($this->input->post('jml_masuk',TRUE));
        $data_insert = [
            'id_baranghp' => $id_baranghp,
            'tgl_masuk' => $tgl_masuk,
            'jml_masuk' => $jml_masuk
        ];  

        $q = $this->db->select('id_baranghp,stok')->from('tb_baranghp')->where('id_baranghp',$id_baranghp)->get()->row();
        $stok = $q->stok + $jml_masuk;
        $data_update = [
            'stok' => $stok
        ];
        $this->db->trans_start();
        $this->db->insert('tb_masukhp',$data_insert);
        $this->db->update('tb_baranghp',$data_update,['id_baranghp'=>$id_baranghp]);
        $this->db->trans_complete();
        if($this->db->trans_status() == TRUE)
        {
            return ['status' => true, 'message' => 'Data Berhasil Disimpan'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Disimpan!'];
        }
    }

    function cek_barangmasukhp($id_masukhp)
    {
        return $this->db->select('id_masukhp')->from('tb_masukhp')->where('id_masukhp',$id_masukhp)->get()->row();
    }

    function hapus_barangmasukhp($id_masukhp)
    {   
        // ambil id_baranghp dan stok dari tb_masukhp
        $q1 = $this->db->select('id_masukhp,id_baranghp,jml_masuk')->from('tb_masukhp')->where('id_masukhp',$id_masukhp)->get()->row();
        $id_baranghp = $q1->id_baranghp;
        //ambil stok dari tb_baranghp
        $q2 = $this->db->select('id_baranghp,stok')->from('tb_baranghp')->where('id_baranghp',$id_baranghp)->get()->row();
        //set stok
        $stok = $q2->stok - $q1->jml_masuk;
        $data_update = [
            'stok' => $stok
        ];
        $this->db->trans_start();
        $this->db->update('tb_baranghp',$data_update,['id_baranghp'=>$id_baranghp]);
        $this->db->where('id_masukhp',$id_masukhp)->delete('tb_masukhp');
        $this->db->trans_complete();
        if($this->db->trans_status() == TRUE)
        {
            return ['status' => true, 'message' => 'Data Berhasil Dihapus'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Dihapus'];
        }
    }

}