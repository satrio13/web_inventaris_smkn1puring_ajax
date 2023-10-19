<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tahun extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}

		$this->load->model('tahun_model');
    } 

    function index()
	{	
		$data['title'] = 'Tahun';
		//layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('tahun/index', $data);
		$this->load->view('backend/template/js');
		$this->load->view('tahun/script');
	}
	
	function get_data_tahun()
	{
		$list = $this->tahun_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
        foreach($list as $r)
        {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $r->tahun;
			$action = '<div class="text-center">
						<a href="javascript:void(0)" class="btn btn-info btn-xs" title="EDIT DATA" onclick="edit_tahun('.$r->id_tahun.')"><i class="fa fa-edit"></i> EDIT</a>
						<a href="javascript:void(0)" class="btn btn-danger btn-xs" title="HAPUS DATA" onclick="delete_tahun('.$r->id_tahun.')"><i class="fa fa-trash"></i> HAPUS</a>
					  </div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->tahun_model->count_all(),
			"recordsFiltered" => $this->tahun_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    }

	function tambah_tahun()
	{ 
		$this->_validate();  
        $q = $this->tahun_model->tambah_tahun();
        echo json_encode($q);	
    }

	function get_tahun_by_id($id_tahun)
	{ 
        $data = $this->tahun_model->get_tahun_by_id($id_tahun);
        echo json_encode($data);
    }

    function edit_tahun()
	{ 
		$this->_validate(); 
		$id_tahun = $this->input->post('id_tahun',TRUE); 
		$q = $this->tahun_model->edit_tahun($id_tahun);
		echo json_encode($q);	
    }

    function hapus_tahun($id_tahun)
	{ 
        $cek = $this->tahun_model->cek_tahun($id_tahun);
        if(!$cek)
        {
            show_404();
        }else
        {
            $q = $this->tahun_model->hapus_tahun($id_tahun);
            echo json_encode($q);   
        }  
    }

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('tahun') == '')
		{
			$data['inputerror'][] = 'tahun';
			$data['error_string'][] = 'Tahun wajib diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
}