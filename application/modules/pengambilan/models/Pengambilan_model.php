<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pengambilan_model extends CI_Model
{   
    private $table = 'tb_baranghp'; //nama tabel dari database
    private $column_order = array(null,'kode_hp','barang','stok','kode_hp');
    private $column_search = array('kode_hp','barang','stok');
    private $order = array('kode_hp' => 'asc'); // default order 
    
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
    
    function get_pengambilan_by_kode($kobar)
    {
        $get = $this->db->select('id_baranghp')->from('tb_baranghp')->where('id_baranghp',$kobar)->get()->row();
        if($get)
        {   
            $cek = $this->db->select('id_baranghp,id_user')->from('tb_keluarhptemp')->where('id_baranghp',$get->id_baranghp)->where('id_user',$this->session->userdata('id_user'))->get()->num_rows();
            if($cek > 0)
            {
                return ['status' => false, 'message' => 'Barang sudah berada di keranjang!'];
            }else
            {
                $data = [
                    'id_baranghp' => $get->id_baranghp,
                    'qty' => 1,
                    'tgl' => tgl_jam_simpan_sekarang(),
                    'id_user' => $this->session->userdata('id_user')
                ];

                $this->db->insert('tb_keluarhptemp', $data); 
                return ['status' => true, 'message' => 'Barang berhasil dimasukan keranjang'];
            }
        }
	}

    function get_terambil_by_kode($kobar)
    {
        $cek = $this->db->select('kode_trans')->from('tb_keluarhptemp')->where('kode_trans',$kobar)->get()->num_rows();
        if($cek > 0)
        {
            return ['status' => false, 'message' => 'Gagal memasukan barang ke keranjang!'];
        }else
        {
            $q_select = $this->db->select('*')->from('tb_keluarhptemp')->where('kode_trans != ',$kobar)->where('id_user',$this->session->userdata('id_user'))->get();
            $jml = $q_select->num_rows();
            if($jml > 0)
            {
                return ['status' => false, 'message' => 'Gagal memasukan barang ke keranjang!'];
            }else
            {
                $hsl = $this->db->select('b.id_baranghp,b.kode_hp,b.barang,b.satuan,d.kode_trans,d.id_user,d.nama_pengambil,d.tgl_keluar,s.jml_keluar')
                                ->from('tb_baranghp b')
                                ->join('tb_keluarhp s','s.id_baranghp=b.id_baranghp')
                                ->join('tb_detailkeluarhp d','d.kode_trans=s.kode_trans')
                                ->where('d.kode_trans',$kobar)
                                ->where('d.id_user',$this->session->userdata('id_user'))->get();
                $jml2 = $hsl->num_rows();
                if($jml2 > 0)
                {
                    $this->db->where('id_user',$this->session->userdata('id_user'))->delete('tb_keluarhptemp');
                    foreach($hsl->result() as $r)
                    {   
                        $data_insert = [
                            'id_baranghp' => $r->id_baranghp,
                            'qty' => $r->jml_keluar,
                            'kode_trans' => $r->kode_trans,
                            'tgl' => tgl_jam_simpan_sekarang(),
                            'id_user' => $this->session->userdata('id_user')
                        ];

                        $this->db->insert('tb_keluarhptemp',$data_insert);
                    }   
                    return ['status' => true, 'message' => 'Barang berhasil dimasukan keranjang'];
                }else
                {
                    return ['status' => false, 'message' => 'Gagal memasukan barang ke keranjang!'];
                }    
            }     
        }
    }

    function kode_trans()
    {
        $this->db->select('Right(tb_detailkeluarhp.kode_trans,5) as kode ',false);
        $this->db->order_by('kode_trans', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('tb_detailkeluarhp');
        if($query->num_rows() <> 0)
        {
            $data = $query->row();
            $kode = intval($data->kode)+1;
        }else
        {
            $kode = 1;
        }
        $kodemax = str_pad($kode,5,"0",STR_PAD_LEFT);
        $kodejadi  = "TR".$kodemax;
        return $kodejadi;
    }

    function hapus_cart($kobar)
    {
		$this->db->where('id_baranghp',$kobar)->delete('tb_keluarhptemp');
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Dihapus'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Dihapus!'];
        }
    }

    function hapus_batal($kode_trans)
    {
        if(empty($kode_trans))
        {
            $this->db->where('id_user',$this->session->userdata('id_user'))->delete('tb_keluarhptemp');
        }else
        {
            $this->db->where('kode_trans',$kode_trans)->where('id_user',$this->session->userdata('id_user'))->delete('tb_keluarhptemp');
        }
    }
    
    function simpan_pengambilan($no_trans,$kode_trans,$tgl_keluar,$jam_keluar,$nama_pengambil,$id_user,$id_baranghp,$jml_keluar)
    {
        if($id_baranghp == 0)
        {
            $hasil = ['status' => false, 'message' => 'Keranjang Kosong, Data Gagal Disimpan!'];
        }else
        {
            if(empty($kode_trans))
            {
                $kode_trans = $no_trans;
                $this->db->trans_start();
                    $data = [
                        'kode_trans' => $kode_trans,
                        'nama_pengambil' => $nama_pengambil,
                        'tgl_keluar' => $tgl_keluar,
                        'jam_keluar' => $jam_keluar,
                        'id_user' => $id_user     
                    ];
                    $this->db->insert('tb_detailkeluarhp', $data);
                    
                    // insert tb_keluarhp
                    $result = [];
                    foreach($id_baranghp AS $key => $val)
                    {
                        $result[] = [
                            'kode_trans' => $kode_trans,
                            'id_baranghp' => $this->input->post("id_baranghp[$key]",TRUE),
                            'jml_keluar' => $this->input->post("qty[$key]",TRUE)
                        ];
                    }      
                    $this->db->insert_batch('tb_keluarhp', $result);

                    // update tb_baranghp
                    $update = [];
                    foreach($id_baranghp AS $key => $val)
                    {
                        // cek stok
                        $r = $this->db->select('id_baranghp,stok')->from('tb_baranghp')->where('id_baranghp', $this->input->post("id_baranghp[$key]",TRUE))->get()->row();
                    
                        $update[] = [
                            'id_baranghp' => $this->input->post("id_baranghp[$key]",TRUE),
                            'stok' => $r->stok - $this->input->post("qty[$key]",TRUE)
                        ];
                    }      
                    $this->db->update_batch('tb_baranghp', $update, 'id_baranghp');
                    $this->db->where('id_user',$this->session->userdata('id_user'))->delete('tb_keluarhptemp');
                $this->db->trans_complete();
                if($this->db->trans_status() == TRUE)
                {
                    $hasil = ['status' => true, 'message' => 'Data Berhasil Disimpan'];
                }else
                {
                    $hasil = ['status' => false, 'message' => 'Data Gagal Disimpan!'];
                }
            }else
            {
                $kode_trans = $kode_trans;
                $this->db->trans_start();
                    $data = [
                        'nama_pengambil' => $nama_pengambil,
                        'tgl_keluar' => $tgl_keluar,
                        'jam_keluar' => $jam_keluar  
                    ];
                    $this->db->update('tb_detailkeluarhp', $data, ['kode_trans'=>$kode_trans]); 
                    $this->hapus_from_cart($kode_trans);
                    // insert tb_keluarhp
                    $result = [];
                    foreach($id_baranghp AS $key => $val)
                    {
                        $result[] = [
                            'kode_trans' => $kode_trans,
                            'id_baranghp' => $this->input->post("id_baranghp[$key]",TRUE),
                            'jml_keluar' => $this->input->post("qty[$key]",TRUE)
                        ];
                    }      
                    $this->db->insert_batch('tb_keluarhp', $result);

                    // update tb_baranghp
                    $update = [];
                    foreach($id_baranghp AS $key => $val)
                    {
                        // cek stok
                        $r = $this->db->select('id_baranghp,stok')->from('tb_baranghp')->where('id_baranghp', $this->input->post("id_baranghp[$key]",TRUE))->get()->row();
                    
                        $update[] = [
                            'id_baranghp' => $this->input->post("id_baranghp[$key]",TRUE),
                            'stok' => $r->stok - $this->input->post("qty[$key]",TRUE)
                        ];
                    }      
                    $this->db->update_batch('tb_baranghp', $update, 'id_baranghp');
                    $this->db->where('id_user',$this->session->userdata('id_user'))->delete('tb_keluarhptemp');
                $this->db->trans_complete();
                if($this->db->trans_status() == TRUE)
                {
                    $hasil = ['status' => true, 'message' => 'Data Berhasil Disimpan'];
                }else
                {
                    $hasil = ['status' => false, 'message' => 'Data Gagal Disimpan!'];
                }            
            }    
        }
        
        return $hasil;
    }

    function riwayat()
    {
        return $this->db->select('*')->from('tb_detailkeluarhp')->order_by('kode_trans','desc')->limit('10')->get();
    }

    function cek_detail($kode_trans)
    {
        return $this->db->select('kode_trans')->from('tb_detailkeluarhp')->where('kode_trans',$kode_trans)->get()->row();
    }

    /*
    function detail_pengambilan($kode_trans)
    {
        return $this->db->select('d.*,u.nama')->from('tb_detailkeluarhp d')->join('tb_user u','d.id_user=u.id_user')->where('d.kode_trans',$kode_trans)->get()->row();
    }
    */

    function rincian_pengambilan($kode_trans)
    {
        return $this->db->select('d.*,k.*,b.kode_hp,b.barang,b.satuan,u.nama')->from('tb_detailkeluarhp d')->join('tb_keluarhp k','d.kode_trans=k.kode_trans')->join('tb_baranghp b','k.id_baranghp=b.id_baranghp')->join('tb_user u','d.id_user=u.id_user')->where('k.kode_trans',$kode_trans)->order_by('b.kode_hp','asc')->get()->result_array();
    }

    function cek_edit_hapus($kode_trans)
    {
        return $this->db->select('kode_trans,id_user')->from('tb_detailkeluarhp')->where('kode_trans',$kode_trans)->where('id_user',$this->session->userdata('id_user'))->get()->row();
    }
    
    function hapus_pengambilan($kode_trans)
    {   
        $cek = $this->db->select('kode_trans')->from('tb_keluarhptemp')->where('kode_trans',$kode_trans)->get()->num_rows();
        if($cek > 0)
        {
            $hasil = ['status' => false, 'message' => 'Data Gagal Dihapus!'];
        }else
        {
            $this->db->trans_start();
                $data = $this->db->select('*')->from('tb_keluarhp')->where('kode_trans',$kode_trans)->get();
                foreach($data->result() as $r):
                    // cek stok
                    $cek = $this->db->select('id_baranghp,stok')->from('tb_baranghp')->where('id_baranghp', $r->id_baranghp)->get()->row();
                    $stok = $cek->stok + $r->jml_keluar;
                    $data_update = [
                        'stok' => $stok 
                    ];
                    $this->db->update('tb_baranghp',$data_update,['id_baranghp'=>$r->id_baranghp]);
                endforeach;

                $this->db->where('kode_trans',$kode_trans)->delete('tb_detailkeluarhp');
                $this->db->where('kode_trans',$kode_trans)->delete('tb_keluarhp');
            $this->db->trans_complete();
            if($this->db->trans_status() == TRUE)
            {
                $hasil = ['status' => true, 'message' => 'Data Berhasil Dihapus'];
            }else
            {
                $hasil = ['status' => false, 'message' => 'Data Gagal Dihapus!'];
            }
        }
        return $hasil;
    }

    function hapus_from_cart($kode_trans)
    {   
        $this->db->trans_start();
            $data = $this->db->select('*')->from('tb_keluarhp')->where('kode_trans',$kode_trans)->get();
            foreach($data->result() as $r):
                // cek stok
                $cek = $this->db->select('id_baranghp,stok')->from('tb_baranghp')->where('id_baranghp', $r->id_baranghp)->get()->row();
                $stok = $cek->stok + $r->jml_keluar;
                $data_update = [
                    'stok' => $stok 
                ];
                $this->db->update('tb_baranghp',$data_update,['id_baranghp'=>$r->id_baranghp]);
            endforeach;

            $this->db->where('kode_trans',$kode_trans)->delete('tb_keluarhp');
        $this->db->trans_complete();
    }

}