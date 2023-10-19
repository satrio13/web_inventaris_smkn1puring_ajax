<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pengurusbarang extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}

		$this->load->model('pengurusbarang_model');
    } 

    function index()
	{	
		$data['title'] = 'Pengurus Barang';
        $data['pengurus'] =  $this->db->select('*')->from('tb_user')->order_by('nama','asc')->get()->result();
		//layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('pengurusbarang/index', $data);
		$this->load->view('backend/template/js');
		$this->load->view('pengurusbarang/script');
    }

	function get_data_pengurusbarang()
	{
		$list = $this->pengurusbarang_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
        foreach($list as $r)
        {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $r->nama;
			$action = '<div class="text-center">
						<a href="javascript:void(0)" class="btn btn-info btn-xs" title="EDIT DATA" onclick="edit_pengurusbarang()"><i class="fa fa-edit"></i> EDIT</a>
					  </div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pengurusbarang_model->count_all(),
			"recordsFiltered" => $this->pengurusbarang_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    }

	function get_pengurusbarang_by_id()
	{ 
        $data = $this->pengurusbarang_model->get_pengurusbarang_by_id();
        echo json_encode($data);
    }

    function edit_pengurusbarang()
	{ 
		$this->_validate();  
		$q = $this->pengurusbarang_model->edit_pengurusbarang();
		echo json_encode($q);	
    }

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('id_user') == '')
		{
			$data['inputerror'][] = 'id_user';
			$data['error_string'][] = 'Pengurus Barang wajib diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}