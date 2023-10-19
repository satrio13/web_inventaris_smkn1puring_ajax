<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pemindahan_model extends CI_Model
{
    private $table = 'tb_baranginv'; //nama tabel dari database
    private $column_order = array(null,'kode_inv','barang','kode_inv','kode_inv');
    private $column_search = array('kode_inv','barang');
    private $order = array('kode_inv' => 'asc'); // default order 

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

    function kode_pemindahan()
    {
        $this->db->select('Right(tb_pindah.kode_pindah,5) as kode ',false);
        $this->db->order_by('kode_pindah', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('tb_pindah');
        if($query->num_rows() <> 0)
        {
            $data = $query->row();
            $kode = intval($data->kode)+1;
        }else
        {
            $kode = 1;
        }
        $kodemax = str_pad($kode,5,"0",STR_PAD_LEFT);
        $kodejadi  = "PD".$kodemax;
        return $kodejadi;
    }

    function pemindahan_list()
    {
        $hsl = $this->db->select('*')->from('tb_baranginv')->order_by('kode_inv','asc')->get();
        if($hsl->num_rows() > 0)
        {
            foreach($hsl->result() as $data)
            {
                $q = $this->db->select('b.id_baranginv,b.kode_inv,b.barang,b.satuan,k.id_kategori,k.kategori,p.kode_pindah,p.id_ruang,r.ruang')
                    ->from('tb_baranginv b')
                    ->join('tb_kategori k','b.id_kategori=k.id_kategori')
                    ->join('tb_pindah p','b.id_baranginv=p.id_baranginv')
                    ->join('tb_ruang r','p.id_ruang=r.id_ruang')
                    ->where('b.id_baranginv',$data->id_baranginv)
                    ->order_by('p.kode_pindah','desc')
                    ->limit(1,0)->get();
                $r = $q->row();
                if(empty($r->ruang))
                {
                    $ruang = '';
                }else
                {
                    $ruang = $r->ruang;
                }
                $hasil[] = [
                    'id_baranginv' => $data->id_baranginv,
                    'kode_inv' => $data->kode_inv,
                    'barang' => $data->barang,
                    'ruang' => $ruang
                ];
            }
            return $hasil;
        }else
        {
            return $hsl->result();
        }
    }

    function get_pemindahan_by_kode($id_baranginv)
    {   
        $get = $this->db->select('id_baranginv')->from('tb_baranginv')->where('id_baranginv',$id_baranginv)->get()->row();
        if($get)
        {
            $cek = $this->db->select('id_baranginv,id_user')->from('tb_pindahtemp')->where('id_baranginv',$get->id_baranginv)->where('id_user',$this->session->userdata('id_user'))->get()->num_rows();
            if($cek > 0)
            {
                return ['status' => false, 'message' => 'Barang sudah berada di keranjang!'];
            }else
            {            
                $data = [
                    'id_baranginv' => $get->id_baranginv,
                    'id_user' => $this->session->userdata('id_user')
                ];

                $this->db->insert('tb_pindahtemp', $data);
                return ['status' => true, 'message' => 'Barang berhasil dimasukan keranjang'];
            }
        }
    }

    function get_terpindah_by_kode($kode_pindah)
    {
        $cek = $this->db->select('kode_pindah')->from('tb_pindahtemp')->where('kode_pindah',$kode_pindah)->get()->num_rows();
        if($cek > 0)
        {
            $hasil = ['status' => false, 'message' => 'Gagal memasukan barang ke keranjang!'];
        }else
        {
            $q_select = $this->db->select('*')->from('tb_pindahtemp')->where('kode_pindah != ',$kode_pindah)->where('id_user',$this->session->userdata('id_user'))->get();
            $jml = $q_select->num_rows();
            if($jml > 0)
            {
                $hasil = ['status' => false, 'message' => 'Gagal memasukan barang ke keranjang!'];
            }else
            {
                $hsl = $this->db->select('b.id_baranginv,b.kode_inv,b.barang,b.satuan,p.kode_pindah,p.id_user,p.id_ruang')->from('tb_baranginv b')->join('tb_pindah p','p.id_baranginv=b.id_baranginv')->where('p.kode_pindah',$kode_pindah)->where('p.id_user',$this->session->userdata('id_user'))->get();
                $jml2 = $hsl->num_rows();
                if($jml2 > 0)
                {
                    foreach($hsl->result() as $r)
                    {   
                        $data_insert = [
                            'id_baranginv' => $r->id_baranginv,
                            'id_ruang' => $r->id_ruang,
                            'kode_pindah' => $r->kode_pindah,
                            'id_user' => $this->session->userdata('id_user')
                        ];
                        $this->db->insert('tb_pindahtemp',$data_insert);
                    }   
                    $hasil = ['status' => true, 'message' => 'Barang berhasil dimasukan keranjang']; 
                }else
                {
                    $hasil = ['status' => false, 'message' => 'Gagal memasukan barang ke keranjang!'];
                }    
            } 

            return $hasil;
        }
    }
    
    function hapus_cart_pemindahan($id_baranginv)
    {
        $this->db->where('id_baranginv',$id_baranginv)->delete('tb_pindahtemp');
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Dihapus'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Dihapus!'];
        } 
    }
    
    function hapus_batal_pemindahan()
    {
        $this->db->where('id_user',$this->session->userdata('id_user'))->delete('tb_pindahtemp');   
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Dihapus'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Dihapus!'];
        }
    }
    
    function simpan_pemindahan($notrans,$kode_pindah,$tgl_pindah,$id_ruang,$id_kondisi,$id_baranginv)
    {   
        $kode_alert = $kode_pindah;
        if(empty($kode_pindah))
        {
            $kode_pindah = $notrans;
        }else
        {
            $kode_pindah = $kode_pindah;
            $this->db->where('kode_pindah',$kode_pindah)->delete('tb_pindah');
        }

        if($id_baranginv > 0)
        {
            $this->db->trans_start();
                // insert tb_pindah
                $data_insert = [];
                foreach($id_baranginv AS $key => $val)
                {
                    $id_baranginv = $this->input->post("id_baranginv[$key]",TRUE);
                    $id_kondisi= $this->input->post("id_kondisi[$key]",TRUE);

                    $data_insert[] = [
                        'kode_pindah' => $kode_pindah,
                        'id_baranginv' => $id_baranginv,
                        'status' => 1,
                        'id_ruang' => $id_ruang,
                        'id_kondisi' => $id_kondisi,
                        'tgl_pindah' => $tgl_pindah,
                        'id_user' => $this->session->userdata('id_user')
                    ];

                    $data_update = [
                        'status' => 2
                    ];

                    $data_update_kondisi = [
                        'id_kondisi' => $id_kondisi,
                    ];
                    
                    $this->db->update('tb_pindah', $data_update, ['id_baranginv'=>$id_baranginv, 'kode_pindah !='=> $kode_pindah]);
                    $this->db->update('tb_baranginv', $data_update_kondisi, ['id_baranginv'=>$id_baranginv]);
                }      
                $this->db->insert_batch('tb_pindah', $data_insert);
                $this->db->where('id_user',$this->session->userdata('id_user'))->delete('tb_pindahtemp');
            $this->db->trans_complete();
            if($this->db->trans_status() == TRUE)
            {
                if(empty($kode_alert))
                {
                    $hasil = ['status' => true, 'message' => 'Data Berhasil Disimpan'];
                }else
                {
                    $hasil = ['status' => true, 'message' => 'Data Berhasil Disimpan'];
                }
            }else
            {
                if(empty($kode_alert))
                {
                    $hasil = ['status' => false, 'message' => 'Data Gagal Diupdate!'];
                }else
                {
                    $hasil = ['status' => false, 'message' => 'Data Gagal Diupdate!'];
                }
            }
        }else
        {
            $hasil = ['status' => false, 'message' => 'Keranjang Kosong, Data Gagal Disimpan!'];
        }

        return $hasil;
    }

    function riwayat()
    {
        return $this->db->select('p.*,r.ruang')->from('tb_pindah p')->join('tb_ruang r','p.id_ruang=r.id_ruang')->order_by('p.kode_pindah','desc')->group_by('p.kode_pindah')->limit('10')->get();
    }

    function cek_detail($kode_pindah)
    {
        return $this->db->select('kode_pindah')->from('tb_pindah')->where('kode_pindah',$kode_pindah)->get()->row();
    }

    function cek_kondisi_pindah($id_baranginv, $kode_pindah)
    {
        return $this->db->select('id_baranginv,id_kondisi,kode_pindah')->from('tb_pindah')->where('id_baranginv',$id_baranginv)->where('kode_pindah',$kode_pindah)->get()->row_array();
    }

    function cek_ruang_pindah($id_baranginv, $kode_pindah)
    {
        return $this->db->select('id_baranginv,id_ruang,kode_pindah')->from('tb_pindah')->where('id_baranginv',$id_baranginv)->where('kode_pindah',$kode_pindah)->get()->row_array();
    }

    function cek_edit_hapus($kode_pindah)
    {
        return $this->db->select('kode_pindah,id_user')->from('tb_pindah')->where('kode_pindah',$kode_pindah)->where('id_user',$this->session->userdata('id_user'))->get()->row();
    }

    /*
    function detail_pemindahan($kode_pindah)
    {
        return $this->db->select('p.*,r.ruang')->from('tb_pindah p')->join('tb_ruang r','p.id_ruang=r.id_ruang')->where('p.kode_pindah',$kode_pindah)->get()->row();
    }
    */

    function rincian_pemindahan($kode_pindah)
    {
        return $this->db->select('p.*,r.ruang,b.kode_inv,b.barang,b.id_kondisi,k.kondisi')->from('tb_pindah p')->join('tb_ruang r','p.id_ruang=r.id_ruang')->join('tb_baranginv b','p.id_baranginv=b.id_baranginv')->join('tb_kondisi k','b.id_kondisi=k.id_kondisi')->where('p.kode_pindah',$kode_pindah)->order_by('b.kode_inv','asc')->get()->result_array();
    }

    function hapus_pemindahan($kode_pindah)
    {   
        $cek = $this->db->select('kode_pindah')->from('tb_pindahtemp')->where('kode_pindah',$kode_pindah)->get()->num_rows();
        if($cek > 0)
        {
            $hasil = ['status' => false, 'message' => 'Data Gagal Dihapus!'];
        }else
        {
            $this->db->where('kode_pindah',$kode_pindah)->delete('tb_pindah');
            if($this->db->affected_rows() > 0)
            {
                $hasil = ['status' => true, 'message' => 'Data Berhasil Dihapus'];
            }else
            {
                $hasil = ['status' => false, 'message' => 'Data Gagal Dihapus!'];
            }
        }
        return $hasil;
    }

}