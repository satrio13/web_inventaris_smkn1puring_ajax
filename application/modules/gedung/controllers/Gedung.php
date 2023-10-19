<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gedung extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}

		$this->load->model('gedung_model');
    } 

    function index()
	{	
		$data['title'] = 'Gedung';
		//layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('gedung/index', $data);
		$this->load->view('backend/template/js');
		$this->load->view('gedung/script');
    }

    function get_data_gedung()
	{
		$list = $this->gedung_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{	
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $r->nama_gedung;
            $row[] = $r->luas;
            $row[] = $r->tahun_p;
            $row[] = $r->sumberdana;
            $action = '<div class="text-center">
						<a href="javascript:void(0)" class="btn btn-info btn-xs" title="EDIT DATA" onclick="edit_gedung('.$r->id_gedung.')"><i class="fa fa-edit"></i> EDIT</a>
						<a href="javascript:void(0)" class="btn btn-danger btn-xs" title="HAPUS DATA" onclick="delete_gedung('.$r->id_gedung.')"><i class="fa fa-trash"></i> HAPUS</a>
                    </div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->gedung_model->count_all(),
			"recordsFiltered" => $this->gedung_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    }

	function tambah_gedung()
	{ 
		$this->_validate();  
        $q = $this->gedung_model->tambah_gedung();
        echo json_encode($q);	
    }

	function get_gedung_by_id($id_gedung)
	{ 
        $data = $this->gedung_model->get_gedung_by_id($id_gedung);
        echo json_encode($data);
    }

    function edit_gedung()
	{ 
		$this->_validate(); 
		$id_gedung = $this->input->post('id_gedung',TRUE); 
		$q = $this->gedung_model->edit_gedung($id_gedung);
		echo json_encode($q);	
    }

    function hapus_gedung($id_gedung)
	{ 
        $cek = $this->gedung_model->cek_gedung($id_gedung);
        if(!$cek)
        {
            show_404();
        }else
        {
            $q = $this->gedung_model->hapus_gedung($id_gedung);
            echo json_encode($q);   
        }  
    }

	function cetak_gedung_pdf()
	{	
		$data['data'] = $this->gedung_model->tampil_gedung();
		$this->load->library('pdfgenerator');
		$html = $this->load->view('gedung/cetak_gedung_pdf', $data, true);
		$filename = 'Gedung - Aplikasi Manajemen Barang SMK N 1 Puring';
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
	}

	function cetak_gedung()
	{	
		$data['data'] = $this->gedung_model->tampil_gedung();
		$this->load->view('gedung/cetak_gedung', $data);
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nama_gedung') == '')
		{
			$data['inputerror'][] = 'nama_gedung';
			$data['error_string'][] = 'Nama Gedung wajib diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
 
}