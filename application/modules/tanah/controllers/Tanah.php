<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tanah extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}

		$this->load->model('tanah_model');
    } 

    function index()
	{	
		$data['title'] = 'Tanah';
		//layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('tanah/index', $data);
		$this->load->view('backend/template/js');
		$this->load->view('tanah/script');
    }

    function get_data_tanah()
	{
		$list = $this->tanah_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{	
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $r->tanah;
            $row[] = $r->luas;
            $row[] = $r->selatan;
            $row[] = $r->timur;
            $row[] = $r->barat;
            $row[] = $r->utara;
            $row[] = $r->tahun_p;
            $row[] = $r->sumberdana;
            $action = '<div class="text-center">
						<a href="javascript:void(0)" class="btn btn-info btn-xs" title="EDIT DATA" onclick="edit_tanah('.$r->id_tanah.')"><i class="fa fa-edit"></i> EDIT</a>
						<a href="javascript:void(0)" class="btn btn-danger btn-xs" title="HAPUS DATA" onclick="delete_tanah('.$r->id_tanah.')"><i class="fa fa-trash"></i> HAPUS</a>
                    </div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->tanah_model->count_all(),
			"recordsFiltered" => $this->tanah_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    } 
 
	function tambah_tanah()
	{ 
		$this->_validate();  
        $q = $this->tanah_model->tambah_tanah();
        echo json_encode($q);	
    }

	function get_tanah_by_id($id_tanah)
	{ 
        $data = $this->tanah_model->get_tanah_by_id($id_tanah);
        echo json_encode($data);
    }

    function edit_tanah()
	{ 
		$this->_validate(); 
		$id_tanah = $this->input->post('id_tanah',TRUE); 
		$q = $this->tanah_model->edit_tanah($id_tanah);
		echo json_encode($q);	
    }

    function hapus_tanah($id_tanah)
	{ 
        $cek = $this->tanah_model->cek_tanah($id_tanah);
        if(!$cek)
        {
            show_404();
        }else
        {
            $q = $this->tanah_model->hapus_tanah($id_tanah);
            echo json_encode($q);   
        }  
    }

	function cetak_tanah_pdf()
	{	
		$data['data'] = $this->tanah_model->tampil_tanah();
		$this->load->library('pdfgenerator');
		$html = $this->load->view('tanah/cetak_tanah_pdf', $data, true);
		$filename = 'Tanah - Aplikasi Manajemen Barang SMK N 1 Puring';
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
	}

	function cetak_tanah()
	{	
		$data['data'] = $this->tanah_model->tampil_tanah();
		$this->load->view('tanah/cetak_tanah', $data);	
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('tanah') == '')
		{
			$data['inputerror'][] = 'tanah';
			$data['error_string'][] = 'Tanah wajib diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}