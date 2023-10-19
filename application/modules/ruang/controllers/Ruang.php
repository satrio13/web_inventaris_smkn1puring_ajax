<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ruang extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}

		$this->load->model('ruang_model');
    } 

    function index()
	{	
		$data['title'] = 'Ruang';
		//layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('ruang/index', $data);
		$this->load->view('backend/template/js');
		$this->load->view('ruang/script');
    }
    
    function get_data_ruang()
	{
		$list = $this->ruang_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{	
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $r->ruang;
            $row[] = $r->nomor;
            $row[] = $r->nama_pj;
            $row[] = $r->nip_pj;
            $action = '<div class="text-center">
						<a href="javascript:void(0)" class="btn btn-info btn-xs" title="EDIT DATA" onclick="edit_ruang('.$r->id_ruang.')"><i class="fa fa-edit"></i> EDIT</a>
						<a href="javascript:void(0)" class="btn btn-danger btn-xs" title="HAPUS DATA" onclick="delete_ruang('.$r->id_ruang.')"><i class="fa fa-trash"></i> HAPUS</a>
                    </div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->ruang_model->count_all(),
			"recordsFiltered" => $this->ruang_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    } 
    
    function tambah_ruang()
	{ 
		$this->_validate();  
        $q = $this->ruang_model->tambah_ruang();
        echo json_encode($q);	
    }
    
    function get_ruang_by_id($id_ruang)
	{ 
        $data = $this->ruang_model->get_ruang_by_id($id_ruang);
        echo json_encode($data);
    }

    function edit_ruang()
	{ 
		$this->_validate(); 
		$id_ruang = $this->input->post('id_ruang',TRUE); 
		$q = $this->ruang_model->edit_ruang($id_ruang);
		echo json_encode($q);	
    }

    function hapus_ruang($id_ruang)
	{ 
        $cek = $this->ruang_model->cek_ruang($id_ruang);
        if(!$cek)
        {
            show_404();
        }else
        {
            $q = $this->ruang_model->hapus_ruang($id_ruang);
            echo json_encode($q);   
        }  
    }

	function cetak_ruang_pdf()
	{	
		$data['data'] = $this->ruang_model->tampil_ruang();
		$this->load->library('pdfgenerator');
		$html = $this->load->view('ruang/cetak_ruang_pdf', $data, true);
		$filename = 'Ruang - Aplikasi Manajemen Barang SMK N 1 Puring';
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
	}

	function cetak_ruang()
	{	
		$data['data'] = $this->ruang_model->tampil_ruang();
		$this->load->view('ruang/cetak_ruang', $data);
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('ruang') == '')
		{
			$data['inputerror'][] = 'ruang';
			$data['error_string'][] = 'Ruang wajib diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
    
}