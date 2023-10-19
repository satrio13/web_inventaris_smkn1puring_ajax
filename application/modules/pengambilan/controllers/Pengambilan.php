<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pengambilan extends CI_Controller {
	  function __construct(){
      parent::__construct();
      if(!$this->session->userdata('id_user'))
      { 
        redirect('auth/login');
      }

      $this->load->model(array('pengambilan_model','ambil_model'));
    } 

    function index()
	  {	
      $data['title'] = 'Transaksi Pengambilan Barang';
      //layout
      $this->load->view('backend/template/head');
      $this->load->view('backend/template/topbar');
      $this->load->view('backend/template/nav');
      $this->load->view('pengambilan/index', $data);
      $this->load->view('backend/template/js');
      $this->load->view('pengambilan/script');
    }

    function get_data_pengambilan()
	  {
      $list = $this->pengambilan_model->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $r)
      {	
        if($r->stok == 0)
        {
          $aksi = '<button class="btn btn-danger btn-xs item_add" data="'.$r->id_baranghp.'" disabled><i class="fa fa-cart-plus"></i> ADD</button>';
        }else
        {
          $aksi = '<button class="btn btn-danger btn-xs item_add" data="'.$r->id_baranghp.'"><i class="fa fa-cart-plus"></i> ADD</button>';
        }

        $no++;
        $row = array();
        $row[] = '<div class="text-center">'.$no.'</div>';
        $row[] = $r->kode_hp;
        $row[] = $r->barang;
        $row[] = $r->stok.' '.$r->satuan;
        $action = '<div class="text-center">'.$aksi.'</div>';
        $row[] = $action;
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->pengambilan_model->count_all(),
        "recordsFiltered" => $this->pengambilan_model->count_filtered(),
        "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    }
    
    function get_data_ambil()
	  {
      $list = $this->ambil_model->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $r)
      {	
        if($r->id_user == $this->session->userdata('id_user'))
        {
          $aksi = '<a href="javascript:void(0)" data="'.$r->kode_trans.'" class="btn bg-info btn-xs item_edit" title="EDIT DATA"><i class="fa fa-edit"></i> EDIT</a>
          <a href="javascript:void(0)" data="'.$r->kode_trans.'" class="btn bg-danger btn-xs item_hapus_pengambilan" title="HAPUS DATA"><i class="fa fa-trash"></i> HAPUS</a>';
        }else
        {
          $aksi = '';
        } 

        $no++;
        $row = array();
        $row[] = '<div class="text-center">'.$no.'</div>';
        $row[] = '<a href="javascript:void(0)" data="'.$r->kode_trans.'" class="text-bold item_detail" title="LIHAT DETAIL">'.$r->kode_trans.'</a>';
        $row[] = $r->nama;
        $row[] = $r->nama_pengambil;
        $row[] = date('d-m-Y', strtotime($r->tgl_keluar));
        $row[] = $r->jam_keluar;
        $action = '<div class="text-center"><a href="javascript:void(0)" data="'.$r->kode_trans.'" class="btn btn-primary btn-xs mr-1 item_detail" title="LIHAT DETAIL"><i class="fa fa-eye"></i> DETAIL</a>'.$aksi.'</div>';
        $row[] = $action;
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->ambil_model->count_all(),
        "recordsFiltered" => $this->ambil_model->count_filtered(),
        "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    }

    function data_cart()
    { 
      $data['data'] = $this->db->select('d.*,b.*')->from('tb_keluarhptemp d')->join('tb_baranghp b','d.id_baranghp=b.id_baranghp')->where('d.id_user',$this->session->userdata('id_user'))->order_by('b.kode_hp','asc')->get();  
		  $this->load->view('pengambilan/data_cart', $data);
    }
    
    function get_pengambilan()
    {
      $kobar = $this->input->get('id');
      $data = $this->pengambilan_model->get_pengambilan_by_kode($kobar);
      echo json_encode($data);
    }

    function get_terambil()
    {
      $kobar = $this->input->get('id');
      $data = $this->pengambilan_model->get_terambil_by_kode($kobar);
      echo json_encode($data);
    }

    function detail_pengambilan()
	  {	
      $kode_trans = $this->input->get('kode_trans');
      $data = $this->pengambilan_model->rincian_pengambilan($kode_trans);
      echo json_encode($data);
    }

    /*
    function rincian_pengambilan($kode_trans)
	  {	
      $data['data'] = $this->pengambilan_model->rincian_pengambilan($kode_trans);
      $this->load->view('pengambilan/rincian_pengambilan', $data);
    }
    */
    
    function simpan_pengambilan()
    {
      $this->_validate();
      $no_trans = $this->pengambilan_model->kode_trans();
      $kode_trans = $this->input->post('kode_trans',TRUE);
      $nama_pengambil = $this->input->post('nama_pengambil',TRUE);
      $tgl_keluar = $this->input->post('tgl_keluar',TRUE);
      $jam_keluar = $this->input->post('jam_keluar',TRUE);
      $id_user = $this->session->userdata('id_user');
      $id_baranghp = $this->input->post("id_baranghp",TRUE);
      $jml_keluar = $this->input->post('qty',TRUE);
      $data = $this->pengambilan_model->simpan_pengambilan($no_trans,$kode_trans,$tgl_keluar,$jam_keluar,$nama_pengambil,$id_user,$id_baranghp,$jml_keluar);
      echo json_encode($data);
    }

    function hapus_cart($id_baranghp)
    {
      $data = $this->pengambilan_model->hapus_cart($id_baranghp);
      echo json_encode($data);
    }

    function hapus_batal()
    {
      $kobar = $this->input->post('kode');
      $data = $this->pengambilan_model->hapus_batal($kobar);
      echo json_encode($data);
    }

    function cetak_pengambilan_pdf($kode_trans)
    {	
      $cek = $this->pengambilan_model->cek_detail($kode_trans); 
      if(!$cek)
      { 
        show_404(); 
      }else
      {
        $data['data'] = $this->pengambilan_model->rincian_pengambilan($kode_trans);
        $this->load->library('pdfgenerator');
        $html = $this->load->view('pengambilan/cetak_pengambilan_pdf', $data, true);
        $filename = 'Detail Pengambilan Barang - Aplikasi Manajemen Barang SMK N 1 Puring';
        $this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
      }
    }

    function cetak_pengambilan($kode_trans)
    {	
      $cek = $this->pengambilan_model->cek_detail($kode_trans); 
      if(!$cek)
      { 
        show_404(); 
      }else
      {
        $data['data'] = $this->pengambilan_model->rincian_pengambilan($kode_trans);
        $this->load->view('pengambilan/cetak_pengambilan', $data);
      }
    }

    function hapus_pengambilan($kode_trans)
	  { 	
		  $cek = $this->pengambilan_model->cek_edit_hapus($kode_trans); 
      if(!$cek)
      { 
        show_404(); 
      }else
      {
        $q = $this->pengambilan_model->hapus_pengambilan($kode_trans);
        echo json_encode($q);  
      }
    }

    private function _validate()
    {
      $data = array();
      $data['error_string'] = array();
      $data['inputerror'] = array();
      $data['status'] = TRUE;

      if($this->input->post('nama_pengambil') == '')
      {
        $data['inputerror'][] = 'nama_pengambil';
        $data['error_string'][] = 'Nama Pengambil wajib diisi';
        $data['status'] = FALSE;
      }

      if($this->input->post('tgl_keluar') == '')
      {
        $data['inputerror'][] = 'tgl_keluar';
        $data['error_string'][] = 'Tgl Pengambilan wajib diisi';
        $data['status'] = FALSE;
      }

      if($this->input->post('jam_keluar') == '')
      {
        $data['inputerror'][] = 'jam_keluar';
        $data['error_string'][] = 'Jam Pengambilan wajib diisi';
        $data['status'] = FALSE;
      }

      if($data['status'] === FALSE)
      {
        echo json_encode($data);
        exit();
      }
    }
}