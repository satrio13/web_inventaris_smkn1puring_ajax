<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kategori extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}

		$this->load->model('kategori_model');
    } 

    function index()
	{	
		$data['title'] = 'Kategori Barang';
        //layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('kategori/index', $data);
		$this->load->view('backend/template/js');
		$this->load->view('kategori/script');
    }

    function get_data_kategori()
	{
		$list = $this->kategori_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{	
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $r->kategori;
			$row[] = $r->id_kategori;
            $action = '<div class="text-center">
						<a href="javascript:void(0)" class="btn btn-info btn-xs" title="EDIT DATA" onclick="edit_kategori('.$r->id_kategori.')"><i class="fa fa-edit"></i> EDIT</a>
						<a href="javascript:void(0)" class="btn btn-danger btn-xs" title="HAPUS DATA" onclick="delete_kategori('.$r->id_kategori.')"><i class="fa fa-trash"></i> HAPUS</a>
                    </div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->kategori_model->count_all(),
			"recordsFiltered" => $this->kategori_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
    } 

	function tambah_kategori()
	{ 
		$this->_validate();  
        $q = $this->kategori_model->tambah_kategori();
        echo json_encode($q);	
    }

	function get_kategori_by_id($id_kategori)
	{ 
        $data = $this->kategori_model->get_kategori_by_id($id_kategori);
        echo json_encode($data);
    }

    function edit_kategori()
	{ 
		$this->_validate(); 
		$id_kategori = $this->input->post('id_kategori',TRUE); 
		$q = $this->kategori_model->edit_kategori($id_kategori);
		echo json_encode($q);	
    }

    function hapus_kategori($id_kategori)
	{ 
        $cek = $this->kategori_model->cek_kategori($id_kategori);
        if(!$cek)
        {
            show_404();
        }else
        {
            $q = $this->kategori_model->hapus_kategori($id_kategori);
            echo json_encode($q);   
        }  
    }

	function cetak_kategori_pdf()
	{	
		$data['data'] = $this->kategori_model->tampil_kategori();
		$this->load->library('pdfgenerator');
		$html = $this->load->view('kategori/cetak_kategori_pdf', $data, true);
		$filename = 'Kategori Barang - Aplikasi Manajemen Barang SMK N 1 Puring';
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'portrait');	
	}

	function cetak_kategori()
	{	
		$data['data'] = $this->kategori_model->tampil_kategori();
		$this->load->view('kategori/cetak_kategori', $data);	
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('kategori') == '')
		{
			$data['inputerror'][] = 'kategori';
			$data['error_string'][] = 'Kategori Barang wajib diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}