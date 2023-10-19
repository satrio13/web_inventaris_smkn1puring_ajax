<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    function login()
    {
        if($this->input->post('submit') == 'Submit')
        { 
            $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');
            $this->form_validation->set_rules('username', 'Username', 'alpha_numeric|required|trim');
            $this->form_validation->set_rules('password', 'Password', 'alpha_numeric|required|trim');

            if($this->form_validation->run() == TRUE)
            {
                $user = $this->input->post('username', TRUE);
                $pass = $this->input->post('password', TRUE);

                $cek = $this->db->get_where('tb_user', array('username' => $user));
                if($cek->num_rows() > 0)
                {
                    $data = $cek->row();
                    if(password_verify($pass, $data->password))
                    {
                        if($data->is_active == 1)
                        { 
                            $datauser = array (
                                'id_user' => $data->id_user,
                                'nama' => $data->nama,
                                'level' => $data->level,
                                'login' => TRUE
                            );
                            $this->session->set_userdata($datauser); 
                            redirect('backend');
                        }else{
                            $this->session->set_flashdata('msg-lg', "Akun anda tidak aktif!");    
                        }
                    }else{
                        $this->session->set_flashdata('msg-lg', "Password yang anda masukkan salah!");
                    }
                }else{
                    $this->session->set_flashdata('msg-lg', "Username belum terdaftar!");
                }
            }
        }
        
        if($this->session->userdata('login') == TRUE)
        {
            redirect('backend');
        }
    }

    function cek_login()
    { 
        if(!$this->session->userdata('id_user'))
        { 
            redirect('auth/login');
        }
    }

    function logout()
    {   
        $this->cek_login();
        $this->session->unset_userdata('id_user');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('level');
        $this->session->unset_userdata('login');
        redirect('auth/login');
    }
        
}