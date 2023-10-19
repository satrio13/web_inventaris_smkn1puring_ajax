<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pemindahan extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
		
		$this->load->model(array('pemindahan_model','pindah_model'));
    } 

    function index()
	{	
        $data['title'] = 'Transaksi Pemindahan Barang';
		//layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('pemindahan/index', $data);
		$this->load->view('backend/template/js');
		$this->load->view('pemindahan/script');
	}
	
	function get_data_pemindahan()
	{
		$list = $this->pemindahan_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{	
			$get = $this->db->select('p.id_baranginv,p.id_ruang,p.status,r.ruang')->from('tb_pindah p')->join('tb_ruang r','p.id_ruang=r.id_ruang','left')->where('p.id_baranginv',$r->id_baranginv)->where('p.status',1)->get()->row();
			if($get)
			{
				$ruang = $get->ruang;
			}else
			{
				$ruang = '';
			}
			
			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = $r->kode_inv;
			$row[] = $r->barang;
			$row[] = $ruang;
			$action = '<div class="text-center"><a href="javascript:void(0)" class="btn btn-danger btn-xs item_addinv" data="'.$r->id_baranginv.'"><i class="fa fa-cart-plus"></i> PINDAH</a></div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pemindahan_model->count_all(),
			"recordsFiltered" => $this->pemindahan_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	function get_data_pindah()
	{
		$list = $this->pindah_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $r)
		{	
			if($r->id_user == $this->session->userdata('id_user'))
			{
				$aksi = '<a href="javascript:void(0)" data="'.$r->kode_pindah.'" class="btn bg-info btn-xs item_edit_pemindahan" title="EDIT DATA"><i class="fa fa-edit"></i> EDIT</a>
				<a href="javascript:void(0)" data="'.$r->kode_pindah.'" class="btn bg-danger btn-xs item_hapus_pemindahan" title="HAPUS DATA"><i class="fa fa-trash"></i> HAPUS</a>';
			}else
			{
				$aksi = '';
			} 

			$no++;
			$row = array();
			$row[] = '<div class="text-center">'.$no.'</div>';
			$row[] = '<a href="javascript:void(0)" data="'.$r->kode_pindah.'" class="text-bold item_detail" title="LIHAT DETAIL">'.$r->kode_pindah.'</a>';
			$row[] = date('d-m-Y', strtotime($r->tgl_pindah));
			$row[] = $r->ruang;
			$action = '<div class="text-center"><a href="javascript:void(0)" data="'.$r->kode_pindah.'" class="btn btn-primary btn-xs mr-1 item_detail" title="LIHAT DETAIL"><i class="fa fa-eye"></i> DETAIL</a>'.$aksi.'</div>';
			$row[] = $action;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->pindah_model->count_all(),
			"recordsFiltered" => $this->pindah_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}

	function data_ruang()
	{
		$data = $this->pemindahan_model->ruang_list();
		echo json_encode($data);
	}

	function data_cart_pemindahan()
	{
		$data['q'] = $this->db->select('b.id_baranginv,b.kode_inv,b.barang,d.kode_pindah,b.id_kondisi,d.id_baranginv,d.id_user,d.id_ruang,p.tgl_pindah,p.id_kondisi as kondisi_pindah')->from('tb_pindahtemp d')->join('tb_baranginv b','d.id_baranginv=b.id_baranginv','left')->join('tb_pindah p','d.kode_pindah=p.kode_pindah','left')->where('d.id_user',$this->session->userdata('id_user'))->group_by('d.id_baranginv')->order_by('b.kode_inv','asc')->get();
		$this->load->view('pemindahan/data_cart', $data);
	}

	function get_pemindahan()
	{
		$id_baranginv = $this->input->get('id');
		$data = $this->pemindahan_model->get_pemindahan_by_kode($id_baranginv);
		echo json_encode($data);
	}

	function get_terpindah()
    {
      $kode_pindah = $this->input->get('id');
      $data = $this->pemindahan_model->get_terpindah_by_kode($kode_pindah);
      echo json_encode($data);
	}
	
	function simpan_pemindahan()
	{
		$this->_validate();
		$notrans = $this->pemindahan_model->kode_pemindahan();
		$kode_pindah = $this->input->post('kode_pindah',TRUE);
		$tgl_pindah = $this->input->post('tgl_pindah',TRUE);
		$id_ruang = $this->input->post('id_ruang',TRUE);
		$id_kondisi = $this->input->post('id_kondisi',TRUE);
		$id_baranginv = $this->input->post('id_baranginv',TRUE);
		$data = $this->pemindahan_model->simpan_pemindahan($notrans,$kode_pindah,$tgl_pindah,$id_ruang,$id_kondisi,$id_baranginv);
		echo json_encode($data);
	}

	function hapus_cart_pemindahan($id_baranginv)
	{
		$data = $this->pemindahan_model->hapus_cart_pemindahan($id_baranginv);
		echo json_encode($data);
	}

	function hapus_batal_pemindahan()
    {
		$data = $this->pemindahan_model->hapus_batal_pemindahan();
		echo json_encode($data);
	}

    function detail_pemindahan()
	{	
		$kode_pindah = $this->input->get('kode_pindah');
		$data = $this->pemindahan_model->rincian_pemindahan($kode_pindah);
		echo json_encode($data);
    }

	/*
	function rincian_pemindahan($kode_pindah)
	{	
		$data['data'] = $this->pemindahan_model->rincian_pemindahan($kode_pindah);
		$this->load->view('pemindahan/rincian_pemindahan', $data);
	}
	*/
	
	function cetak_pemindahan_pdf($kode_pindah)
    {	
		$cek = $this->pemindahan_model->cek_detail($kode_pindah); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$data['data'] = $this->pemindahan_model->rincian_pemindahan($kode_pindah);
			$this->load->library('pdfgenerator');
			$html = $this->load->view('pemindahan/cetak_pemindahan_pdf', $data, true);
			$filename = 'Detail Pemindahan Barang - Aplikasi Manajemen Barang SMK N 1 Puring';
			$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
		}
	}

	function cetak_pemindahan($kode_pindah)
    {	
		$cek = $this->pemindahan_model->cek_detail($kode_pindah); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$data['data'] = $this->pemindahan_model->rincian_pemindahan($kode_pindah);
			$this->load->view('pemindahan/cetak_pemindahan', $data);
		}
	}

	function hapus_pemindahan($kode_pindah)
	{ 	
		$cek = $this->pemindahan_model->cek_edit_hapus($kode_pindah); 
		if(!$cek)
		{ 
			show_404(); 
		}else
		{
			$q = $this->pemindahan_model->hapus_pemindahan($kode_pindah);
			echo json_encode($q);  
		}
	}

	private function _validate()
    {
      $data = array();
      $data['error_string'] = array();
      $data['inputerror'] = array();
      $data['status'] = TRUE;

      if($this->input->post('id_ruang') == '')
      {
        $data['inputerror'][] = 'id_ruang';
        $data['error_string'][] = 'Ruang wajib diisi';
        $data['status'] = FALSE;
      }

      if($this->input->post('tgl_pindah') == '')
      {
        $data['inputerror'][] = 'tgl_pindah';
        $data['error_string'][] = 'Tgl Pemindahan wajib diisi';
        $data['status'] = FALSE;
      }

      if($data['status'] === FALSE)
      {
        echo json_encode($data);
        exit();
      }
    }

}