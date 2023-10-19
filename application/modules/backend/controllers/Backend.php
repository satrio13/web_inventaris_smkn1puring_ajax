<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Backend extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}
	} 

	function index()
	{	
		$data['title'] = 'Dashboard';
		$data['jml_baranghp'] = $this->db->select('id_baranghp')->from('tb_baranghp')->get()->num_rows();
		$data['jml_baranginv'] = $this->db->select('id_baranginv')->from('tb_baranginv')->get()->num_rows();
		$data['jml_kategori'] = $this->db->select('id_kategori')->from('tb_kategori')->get()->num_rows();
		$data['pengambilan'] = $this->db->select('*')->from('tb_detailkeluarhp')->order_by('kode_trans','desc')->limit(10,0)->get();
		$data['pemindahan'] = $this->db->select('p.*,r.ruang')->from('tb_pindah p')->join('tb_ruang r','p.id_ruang=r.id_ruang')->order_by('p.kode_pindah','desc')->group_by('p.kode_pindah')->limit(10,0)->get();
		
		//layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('backend/home', $data);
		$this->load->view('backend/template/js');
		$this->load->view('backend/script');
	} 
	
}