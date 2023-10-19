<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}

		$this->load->model('user_model');
    } 
    
    public function index()
	{	
        if($this->session->userdata('level') == 'superadmin')
        {
			$data['title'] = 'Master Users';
			//layout
			$this->load->view('backend/template/head');
			$this->load->view('backend/template/topbar');
			$this->load->view('backend/template/nav');
			$this->load->view('user/index', $data);
			$this->load->view('backend/template/js');
			$this->load->view('user/script');
		}else
		{
			show_404();
		}
	}

	function get_data_users()
	{
		$list = $this->user_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{	
            if($r->is_active == 1)
            {
                $status = '<span class="badge badge-primary">Aktif</span>';
			}else
			{
                $status = '<span class="badge badge-danger">Non Aktif</span>';
            }
            
			if($r->id_user == 1)
			{
				$aksi = '<a href="javascript:void(0)" class="btn btn-info btn-xs disabled"><i class="fa fa-edit"></i> EDIT</a>
				<a href="javascript:void(0)" class="btn btn-danger btn-xs disabled"><i class="fa fa-trash"></i> HAPUS</a>';
			}else
			{
				$aksi = '<a href="javascript:void(0)" class="btn btn-info btn-xs" title="EDIT DATA" onclick="edit_user('.$r->id_user.')"><i class="fa fa-edit"></i> EDIT</a>
				<a href="javascript:void(0)" class="btn btn-danger btn-xs" title="HAPUS DATA" onclick="delete_user('.$r->id_user.')"><i class="fa fa-trash"></i> HAPUS</a>';
			}

            $no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $r->nama;
			$row[] = $r->nip;
			$row[] = $r->username;
			$row[] = $r->email;
			$row[] = $r->level;
			$row[] = '<div class="text-center">'.$status.'</div>';
			$action = '<div class="text-center">'.$aksi.'</div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->user_model->count_all(),
			"recordsFiltered" => $this->user_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    }
	 
    function tambah_user()
	{ 
		$this->_validate_tambah();  
        $q = $this->user_model->tambah_user();
        echo json_encode($q);	
    }
    
    function get_user_by_id($id_user)
	{ 
        $data = $this->user_model->get_user_by_id($id_user);
        echo json_encode($data);
    }

    function edit_user()
	{ 
		$id_user = $this->input->post('id_user',TRUE); 
		$username = $this->input->post('username',TRUE); 
		$email = $this->input->post('email',TRUE); 
		$this->_validate_edit($id_user, $username, $email); 
		$q = $this->user_model->edit_user($id_user); 
		echo json_encode($q);	
    }

    function hapus_user($id_user)
	{ 
		if($this->session->userdata('level') == 'superadmin')
        {
			$cek = $this->user_model->cek_user($id_user);
			if(!$cek)
			{
				show_404();
			}else
			{
				$q = $this->user_model->hapus_user($id_user);
				echo json_encode($q);   
			} 
		}else
		{
			show_404();
		} 
    }

	function edit_profil($id_user)
	{ 
		$username = $this->input->post('username',TRUE); 
		$email = $this->input->post('email',TRUE); 
		$this->_validate_profil($id_user, $username, $email); 
		$q = $this->user_model->edit_profil($id_user);
		echo json_encode($q);   
	}

	function ganti_password($id_user)
	{ 
		$pass1 = $this->input->post('pass1',TRUE); 
		$pass2 = $this->input->post('pass2',TRUE); 
		$pass3 = $this->input->post('pass3',TRUE); 
		$this->_validate_password($id_user, $pass1, $pass2, $pass3); 
		$q = $this->user_model->ganti_password($id_user);
		echo json_encode($q);   
	}
	
	private function _validate_tambah()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		$username = $this->input->post('username');
		$cek_username = $this->_cek_username_tambah($username);

		$email = $this->input->post('email');
		$cek_email = $this->_cek_email_tambah($email);

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama wajib diisi';
			$data['status'] = FALSE;
		}

		if($username == '')
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username wajib diisi';
			$data['status'] = FALSE;
		}elseif($cek_username == FALSE)
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username sudah digunakan!';
			$data['status'] = FALSE;
		}elseif(strlen($this->input->post('username')) < 5)
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username minimal 5 karakter';
			$data['status'] = FALSE;
		}elseif(strlen($this->input->post('username')) > 30)
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username maksimal 30 karakter';
			$data['status'] = FALSE;
		}

		if($this->input->post('password1') == '')
		{
			$data['inputerror'][] = 'password1';
			$data['error_string'][] = 'Password wajib diisi';
			$data['status'] = FALSE;
		}elseif(strlen($this->input->post('password1')) < 5)
		{
			$data['inputerror'][] = 'password1';
			$data['error_string'][] = 'Password minimal 5 karakter';
			$data['status'] = FALSE;
		}elseif(strlen($this->input->post('password1')) > 30)
		{
			$data['inputerror'][] = 'password1';
			$data['error_string'][] = 'Password maksimal 30 karakter';
			$data['status'] = FALSE;
		}

		if($this->input->post('password2') == '')
		{
			$data['inputerror'][] = 'password2';
			$data['error_string'][] = 'Ulang Password wajib diisi';
			$data['status'] = FALSE;
		}elseif(strlen($this->input->post('password2')) < 5)
		{
			$data['inputerror'][] = 'password2';
			$data['error_string'][] = 'Password minimal 5 karakter';
			$data['status'] = FALSE;
		}elseif(strlen($this->input->post('password2')) > 30)
		{
			$data['inputerror'][] = 'password2';
			$data['error_string'][] = 'Password maksimal 30 karakter';
			$data['status'] = FALSE;
		}

		if($this->input->post('password1') != $this->input->post('password2'))
		{
			$data['inputerror'][] = 'password2';
			$data['error_string'][] = 'Ulang Password harus sama';
			$data['status'] = FALSE;
		}

		if($email == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email wajib diisi';
			$data['status'] = FALSE;
		}elseif($cek_email == FALSE)
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email sudah digunakan!';
			$data['status'] = FALSE;
		}elseif(strlen($email) < 5)
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email minimal 5 karakter';
			$data['status'] = FALSE;
		}elseif(strlen($email) > 100)
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email maksimal 30 karakter';
			$data['status'] = FALSE;
		}

		if($this->input->post('level') == '')
		{
			$data['inputerror'][] = 'level';
			$data['error_string'][] = 'Level User wajib diisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('is_active') == '')
		{
			$data['inputerror'][] = 'is_active';
			$data['error_string'][] = 'Status Aktif wajib diisi';
			$data['status'] = FALSE;
		}
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function _cek_username_tambah($username = '')
    {
	    $cek = $this->db->select('username')->from('tb_user')->where('username',$username)->get()->num_rows();
        if($cek > 0)
        {
			return FALSE;
        }else
        {
			return TRUE;
		}
	}

	function _cek_email_tambah($email = '')
    {
	    $cek = $this->db->select('email')->from('tb_user')->where('email',$email)->get()->num_rows();
        if($cek > 0)
        {
			return FALSE;
        }else
        {
			return TRUE;
		}
	}

	private function _validate_edit($id_user, $username, $email)
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		$cek_username = $this->_cek_username_edit($username, $id_user);
		$cek_email = $this->_cek_email_edit($email, $id_user);

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama wajib diisi';
			$data['status'] = FALSE;
		}

		if($username == '')
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username wajib diisi';
			$data['status'] = FALSE;
		}elseif($cek_username == FALSE)
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username sudah digunakan!';
			$data['status'] = FALSE;
		}elseif(strlen($username) < 5)
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username minimal 5 karakter';
			$data['status'] = FALSE;
		}elseif(strlen($username) > 30)
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username maksimal 30 karakter';
			$data['status'] = FALSE;
		}

		if($email == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email wajib diisi';
			$data['status'] = FALSE;
		}elseif($cek_email == FALSE)
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email sudah digunakan!';
			$data['status'] = FALSE;
		}elseif(strlen($email) < 5)
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email minimal 5 karakter';
			$data['status'] = FALSE;
		}elseif(strlen($email) > 100)
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email maksimal 30 karakter';
			$data['status'] = FALSE;
		}

		if($this->input->post('level') == '')
		{
			$data['inputerror'][] = 'level';
			$data['error_string'][] = 'Level User wajib diisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('is_active') == '')
		{
			$data['inputerror'][] = 'is_active';
			$data['error_string'][] = 'Status Aktif wajib diisi';
			$data['status'] = FALSE;
		}
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	private function _validate_profil($id_user, $username, $email)
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		$cek_username = $this->_cek_username_edit($username, $id_user);
		$cek_email = $this->_cek_email_edit($email, $id_user);

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama wajib diisi';
			$data['status'] = FALSE;
		}

		if($username == '')
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username wajib diisi';
			$data['status'] = FALSE;
		}elseif($cek_username == FALSE)
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username sudah digunakan!';
			$data['status'] = FALSE;
		}elseif(strlen($username) < 5)
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username minimal 5 karakter';
			$data['status'] = FALSE;
		}elseif(strlen($username) > 30)
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username maksimal 30 karakter';
			$data['status'] = FALSE;
		}

		if($email == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email wajib diisi';
			$data['status'] = FALSE;
		}elseif($cek_email == FALSE)
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email sudah digunakan!';
			$data['status'] = FALSE;
		}elseif(strlen($email) < 5)
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email minimal 5 karakter';
			$data['status'] = FALSE;
		}elseif(strlen($email) > 100)
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email maksimal 30 karakter';
			$data['status'] = FALSE;
		}
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function _cek_username_edit($username = '', $id_user = '')
    {
		$cek = $this->db->select('username')->from('tb_user')->where('username',$username)->where('id_user != ',$id_user)->get()->num_rows();
		if($cek)
		{
			return FALSE;
		}else
		{
			return TRUE;
		}
    }

	function _cek_email_edit($email = '', $id_user = '')
    {
		$cek = $this->db->select('email')->from('tb_user')->where('email',$email)->where('id_user != ',$id_user)->get()->num_rows();
		if($cek)
		{
			return FALSE;
		}else
		{
			return TRUE;
		}
	}

	private function _validate_password($id_user, $pass1, $pass2, $pass3)
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		$cek_password_lama = $this->_cek_password_lama($pass3, $id_user);

		if($pass1 == '')
		{
			$data['inputerror'][] = 'pass1';
			$data['error_string'][] = 'Password Baru wajib diisi';
			$data['status'] = FALSE;
		}elseif(strlen($pass1) < 5)
		{
			$data['inputerror'][] = 'pass1';
			$data['error_string'][] = 'Password minimal 5 karakter';
			$data['status'] = FALSE;
		}elseif(strlen($pass1) > 30)
		{
			$data['inputerror'][] = 'pass1';
			$data['error_string'][] = 'Password maksimal 30 karakter';
			$data['status'] = FALSE;
		}

		if($pass2 == '')
		{
			$data['inputerror'][] = 'pass2';
			$data['error_string'][] = 'Ulang Password Baru wajib diisi';
			$data['status'] = FALSE;
		}elseif(strlen($pass2) < 5)
		{
			$data['inputerror'][] = 'pass2';
			$data['error_string'][] = 'Password minimal 5 karakter';
			$data['status'] = FALSE;
		}elseif(strlen($pass2) > 30)
		{
			$data['inputerror'][] = 'pass2';
			$data['error_string'][] = 'Password maksimal 30 karakter';
			$data['status'] = FALSE;
		}

		if($pass3 == '')
		{
			$data['inputerror'][] = 'pass3';
			$data['error_string'][] = 'Password Lama wajib diisi';
			$data['status'] = FALSE;
		}elseif(strlen($pass3) < 5)
		{
			$data['inputerror'][] = 'pass3';
			$data['error_string'][] = 'Password minimal 5 karakter';
			$data['status'] = FALSE;
		}elseif(strlen($pass3) > 30)
		{
			$data['inputerror'][] = 'pass3';
			$data['error_string'][] = 'Password maksimal 30 karakter';
			$data['status'] = FALSE;
		}elseif($cek_password_lama == FALSE)
		{
			$data['inputerror'][] = 'pass3';
			$data['error_string'][] = 'Password Lama salah!';
			$data['status'] = FALSE;
		}

		if($this->input->post('pass1') != $this->input->post('pass2'))
		{
			$data['inputerror'][] = 'pass2';
			$data['error_string'][] = 'Ulang Password harus sama';
			$data['status'] = FALSE;
		}
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function _cek_password_lama($pass3 = '', $id_user = '')
    {
		$cek = $this->db->get_where('tb_user', array('id_user' => $id_user))->row();
		if(password_verify($pass3, $cek->password))
		{
			return TRUE;
		}else
		{
			return FALSE;
		}
	}

}