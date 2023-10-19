<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model
{
    private $table = 'tb_user'; //nama tabel dari database
    private $column_order = array(null,'nama','nip','username','email','level','is_active','id_user');
    private $column_search = array('nama','nip','username','email','level');
    private $order = array('id_user' => 'desc'); // default order 
 
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

    function tambah_user()
    {
        $level = strip_tags($this->input->post('level',TRUE));
        $aktif = strip_tags($this->input->post('is_active',TRUE));
        $this->db->trans_start();
            if($level == 'ks')
            {
                $cek = $this->db->select('level')->from('tb_user')->where('level','ks')->get()->num_rows();
                if($cek > 0)
                {   
                    $data_insert = [
                        'nama' => strip_tags($this->input->post('nama',TRUE)),
                        'nip' => strip_tags($this->input->post('nip',TRUE)),
                        'username' => strip_tags(trim($this->input->post('username',TRUE))),
                        'password' => password_hash(trim($this->input->post('password1')), PASSWORD_DEFAULT),
                        'email' => strip_tags($this->input->post('email',TRUE)),
                        'level' => $level,
                        'is_active' => $aktif
                    ];
                    $this->db->insert('tb_user',$data_insert);

                    $id_user = $this->db->insert_id();
                    if($aktif == 1)
                    {
                        $is_active = 0;
                    }else
                    {
                        $is_active = 1;
                    }
                    $data_update = [
                        'is_active' => $is_active
                    ];
                    $this->db->update('tb_user',$data_update,['id_user != '=>$id_user,'level'=>'ks']);
                }else
                {
                    $data_insert = [
                        'nama' => strip_tags($this->input->post('nama',TRUE)),
                        'nip' => strip_tags($this->input->post('nip',TRUE)),
                        'username' => strip_tags(trim($this->input->post('username',TRUE))),
                        'password' => password_hash(trim($this->input->post('password1')), PASSWORD_DEFAULT),
                        'email' => strip_tags($this->input->post('email',TRUE)),
                        'level' => $level,
                        'is_active' => $aktif
                    ];
                    $this->db->insert('tb_user',$data_insert);
                }
            }else
            {   
                $data_insert = [
                    'nama' => strip_tags($this->input->post('nama',TRUE)),
                    'nip' => strip_tags($this->input->post('nip',TRUE)),
                    'username' => strip_tags(trim($this->input->post('username',TRUE))),
                    'password' => password_hash(trim($this->input->post('password1')), PASSWORD_DEFAULT),
                    'email' => strip_tags($this->input->post('email',TRUE)),
                    'level' => $level,
                    'is_active' => $aktif
                ];
                $this->db->insert('tb_user',$data_insert);
            }
        $this->db->trans_complete();
        if($this->db->trans_status() == TRUE)
        {
            return ['status' => true, 'message' => 'Data Berhasil Disimpan'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Disimpan!'];
        }
    }

    function cek_user($id_user)
    {   
        return $this->db->select('id_user')->from('tb_user')->where('id_user',$id_user)->get()->row();
    }

    function get_user_by_id($id_user)
    {
        return $this->db->get_where('tb_user', ['id_user' => $id_user])->row();
    }

    function edit_user($id_user)
    {
        $level = strip_tags($this->input->post('level',TRUE));
        $aktif = strip_tags($this->input->post('is_active',TRUE));
        $password = trim($this->input->post('password'));
        $this->db->trans_start();
            if($level == 'ks')
            {
                $cek = $this->db->select('level')->from('tb_user')->where('level','ks')->get()->num_rows();
                if($cek > 0)
                {   
                    if(empty($password))
                    {   
                        $data = [
                            'nama' => strip_tags($this->input->post('nama',TRUE)),
                            'nip' => strip_tags($this->input->post('nip',TRUE)),
                            'username' => strip_tags(trim($this->input->post('username',TRUE))),
                            'email' => strip_tags($this->input->post('email',TRUE)),
                            'level' => $level,
                            'is_active' => $aktif
                        ];
                    }else
                    {
                        $data = [
                            'nama' => strip_tags($this->input->post('nama',TRUE)),
                            'nip' => strip_tags($this->input->post('nip',TRUE)),
                            'username' => strip_tags(trim($this->input->post('username',TRUE))),
                            'password' => password_hash($password, PASSWORD_DEFAULT),
                            'email' => strip_tags($this->input->post('email',TRUE)),
                            'level' => $level,
                            'is_active' => $aktif
                        ];
                    }  
                    $this->db->update('tb_user', $data, ['id_user'=>$id_user]);

                    if($aktif == 1)
                    {
                        $is_active = 0;
                    }else
                    {
                        $is_active = 1;
                    }
                    $data_update = [
                        'is_active' => $is_active
                    ];
                    $this->db->update('tb_user',$data_update,['id_user != '=>$id_user,'level'=>'ks']);
                }else
                {
                    if(empty($password))
                    {
                        $data = [
                            'nama' => strip_tags($this->input->post('nama',TRUE)),
                            'nip' => strip_tags($this->input->post('nip',TRUE)),
                            'username' => strip_tags(trim($this->input->post('username',TRUE))),
                            'email' => strip_tags($this->input->post('email',TRUE)),
                            'level' => $level,
                            'is_active' => $aktif
                        ];
                    }else
                    {
                        $data = [
                            'nama' => strip_tags($this->input->post('nama',TRUE)),
                            'nip' => strip_tags($this->input->post('nip',TRUE)),
                            'username' => strip_tags(trim($this->input->post('username',TRUE))),
                            'password' => password_hash($password, PASSWORD_DEFAULT),
                            'email' => strip_tags($this->input->post('email',TRUE)),
                            'level' => $level,
                            'is_active' => $aktif
                        ];
                    }
                    $this->db->update('tb_user', $data, ['id_user'=>$id_user]);
                }
            }else
            {   
                if(empty($password))
                {
                    $data = [
                        'nama' => strip_tags($this->input->post('nama',TRUE)),
                        'nip' => strip_tags($this->input->post('nip',TRUE)),
                        'username' => strip_tags(trim($this->input->post('username',TRUE))),
                        'email' => strip_tags($this->input->post('email',TRUE)),
                        'level' => $level,
                        'is_active' => $aktif
                    ];
                }else
                {
                    $data = [
                        'nama' => strip_tags($this->input->post('nama',TRUE)),
                        'nip' => strip_tags($this->input->post('nip',TRUE)),
                        'username' => strip_tags(trim($this->input->post('username',TRUE))),
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'email' => strip_tags($this->input->post('email',TRUE)),
                        'level' => $level,
                        'is_active' => $aktif
                    ];
                }
                $this->db->update('tb_user', $data, ['id_user'=>$id_user]);
            }
        $this->db->trans_complete();
        if($this->db->trans_status() == TRUE)
        {
            return ['status' => true, 'message' => 'Data Berhasil Diupdate'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Diupdate!'];
        }
    }

    function edit_profil($id_user)
    {
        $data_update = array(
            'nama' => strip_tags($this->input->post('nama',TRUE)),
            'nip' => strip_tags($this->input->post('nip',TRUE)),
            'username' => strip_tags(trim($this->input->post('username',TRUE))),
            'email' => strip_tags($this->input->post('email',TRUE))
        );

        $this->db->update('tb_user',$data_update, ['id_user'=>$id_user]);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Data Berhasil Diupdate'];
        }else
        {
            return ['status' => false, 'message' => 'Data Gagal Diupdate!'];
        }
    }

    function ganti_password($id_user)
    {
        $data = [
            'password' => password_hash(trim($this->input->post('pass1')), PASSWORD_DEFAULT)
        ];
        
        $this->db->update('tb_user',$data,['id_user'=>$id_user]);
        if($this->db->affected_rows() > 0)
        {
            return ['status' => true, 'message' => 'Password Berhasil Diupdate'];
        }else
        {
            return ['status' => false, 'message' => 'Password Gagal Diupdate!'];
        }
    }

    function hapus_user($id_user)
    {   
        $cek_dkeluarhp = $this->db->select('id_user')->from('tb_detailkeluarhp')->where('id_user',$id_user)->get()->num_rows();
        $cek_keluarhptemp = $this->db->select('id_user')->from('tb_keluarhptemp')->where('id_user',$id_user)->get()->num_rows();
        $cek_pindah = $this->db->select('id_user')->from('tb_pindah')->where('id_user',$id_user)->get()->num_rows();
        $cek_pindahtemp = $this->db->select('id_user')->from('tb_pindahtemp')->where('id_user',$id_user)->get()->num_rows();
        if($id_user == 1)
        {
            $hasil = ['status' => false, 'message' => 'Akun admin tidak dapat dihapus!'];
        }else
        {
            if( ($cek_dkeluarhp > 0) OR ($cek_keluarhptemp > 0) OR ($cek_pindah > 0) OR ($cek_pindahtemp > 0) )
            {
                $hasil = 0;
            }else
            {
                $this->db->where('id_user',$id_user)->delete('tb_user');
                if($this->db->affected_rows() > 0)
                {
                    $hasil = ['status' => true, 'message' => 'Data Berhasil Dihapus'];
                }else
                {
                    $hasil = ['status' => false, 'message' => 'Data gagal dihapus, karena sudah berelasi!'];
                }
            }
        }
        return $hasil;
    }  

}