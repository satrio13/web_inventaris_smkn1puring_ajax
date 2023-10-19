<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporan extends CI_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id_user'))
		{ 
			redirect('auth/login');
		}

		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('laporan_model');
    } 

    function laporan_stok()
	{	
        $data['title'] = 'Laporan Stok Barang Habis Pakai';
        $data['data'] = $this->laporan_model->laporan_stok();
        //layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('laporan/laporan_stok', $data);
		$this->load->view('backend/template/js');
		$this->load->view('laporan/script');
    }

    function cetak_laporan_stok_pdf()
	{	
		$data['data'] = $this->laporan_model->laporan_stok();
		$this->load->library('pdfgenerator');
		$html = $this->load->view('laporan/cetak_laporan_stok_pdf', $data, true);
		$filename = 'Laporan Stok Barang Habis Pakai - Aplikasi Manajemen Barang SMK N 1 Puring';
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
    }

    function cetak_laporan_stok()
	{	
		$data['data'] = $this->laporan_model->laporan_stok();
		$html = $this->load->view('laporan/cetak_laporan_stok', $data);
    }

	function export_laporan_stok()
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator("SMK N 1 PURING")
            ->setLastModifiedBy("SMK N 1 PURING")
            ->setTitle("Laporan Stok Barang Habis Pakai")
            ->setSubject("Laporan Stok Barang Habis Pakai")
            ->setDescription("Laporan Stok Barang Habis Pakai")
            ->setKeywords("Laporan Stok Barang Habis Pakai");

		$style_col = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FFFFFF')
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '6495ED')
			)
		);

		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_isi_tengah = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_isi_kiri = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
	
        $data = $this->laporan_model->laporan_stok();
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath('assets/img/logo_smkn1puring.png');
		$objDrawing->setOffsetY(9);
		//$objDrawing->setOffsetX(4.1);
		$objDrawing->setCoordinates('B1');
		$objDrawing->setHeight(80);
		$objDrawing->setWorksheet($excel->getActiveSheet());

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "DINAS PENDIDIKAN KABUPATEN KEBUMEN");
		$excel->getActiveSheet()->mergeCells('A2:E2');
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "SEKOLAH MENENGAH KEJURUAN NEGERI 1 PURING");
		$excel->getActiveSheet()->mergeCells('A3:D3');
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A4', "Jl. Selatan-Selatan Kilometer 04 Puring - Kebumen, Kode Pos 54383");
		$excel->getActiveSheet()->mergeCells('A4:E4');
		$excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A5', "Email : smknegeri1puring@gmail.com - Telp : 0811-2635-864");
		$excel->getActiveSheet()->mergeCells('A5:D5');
		$excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('A6:D6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
       
		$excel->setActiveSheetIndex(0)->setCellValue('A7', "LAPORAN STOK BARANG HABIS PAKAI");
        $excel->getActiveSheet()->mergeCells('A7:D7');
        $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

        $excel->setActiveSheetIndex(0)->setCellValue('A9', "NO"); 
        $excel->setActiveSheetIndex(0)->setCellValue('B9', "KODE BARANG"); 
        $excel->setActiveSheetIndex(0)->setCellValue('C9', "NAMA BARANG"); 
        $excel->setActiveSheetIndex(0)->setCellValue('D9', "JUMLAH STOK");
		
        $excel->getActiveSheet()->getStyle('A9')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B9')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C9')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D9')->applyFromArray($style_col);
        
        $no = 1; 
        $numrow = 10; 
        foreach($data->result() as $r):
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $r->kode_hp);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $r->barang);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $r->stok);
        
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_isi_tengah);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
        	
            $no++;
            $numrow++;
        endforeach;

		$row_puring = $numrow + 1;
		$row_pengurus = $numrow + 2;
		$row_nama_pengurus = $numrow + 6;
		$row_nip_pengurus = $numrow + 7;
		$excel->getActiveSheet()->setCellValue('D'.$row_puring, 'Puring, '.tgl_indo(date('Y-m-d')));
		$excel->getActiveSheet()->setCellValue('D'.$row_pengurus, 'Pengurus Barang');
		$excel->getActiveSheet()->setCellValue('D'.$row_nama_pengurus, nama_pengurus_barang());
		$excel->getActiveSheet()->setCellValue('D'.$row_nip_pengurus, 'NIP. '.nip_pengurus_barang());

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->getActiveSheet(0)->setTitle("Stok Barang Habis Pakai");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="laporan-stok-barang-habis-pakai.xlsx"'); 
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');  
	}

    function laporan_pembelian()
	{	
        if($this->input->post('submit', TRUE) == 'Submit')
        {  
            $tgl_awal = $this->input->post('tgl_awal',TRUE);
            $tgl_akhir = $this->input->post('tgl_akhir',TRUE);
            $data['submit'] = $this->input->post('submit',TRUE);
            $data['tgl_awal'] = $tgl_awal;
            $data['tgl_akhir'] = $tgl_akhir;
            $data['data'] = $this->laporan_model->laporan_pembelian($tgl_awal,$tgl_akhir);
        }
        $data['title'] = 'Laporan Pembelian Barang Habis Pakai';
        //layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('laporan/laporan_pembelian', $data);
		$this->load->view('backend/template/js');
		$this->load->view('laporan/script');
    }

    function cetak_laporan_pembelian_pdf($tgl_awal,$tgl_akhir)
	{	
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['data'] = $this->laporan_model->laporan_pembelian($tgl_awal,$tgl_akhir);
		$this->load->library('pdfgenerator');
		$html = $this->load->view('laporan/cetak_laporan_pembelian_pdf', $data, true);
		$filename = 'Laporan Pembelian Barang Habis Pakai - Aplikasi Manajemen Barang SMK N 1 Puring';
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
    }
   
    function cetak_laporan_pembelian($tgl_awal,$tgl_akhir)
	{	
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['data'] = $this->laporan_model->laporan_pembelian($tgl_awal,$tgl_akhir);
		$this->load->view('laporan/cetak_laporan_pembelian', $data);
    }
   
	function export_laporan_pembelian($tgl_awal,$tgl_akhir)
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator("SMK N 1 PURING")
            ->setLastModifiedBy("SMK N 1 PURING")
            ->setTitle("Laporan Pembelian Barang Habis Pakai")
            ->setSubject("Laporan Pembelian Barang Habis Pakai")
            ->setDescription("Laporan Pembelian Barang Habis Pakai")
            ->setKeywords("Laporan Pembelian Barang Habis Pakai");

		$style_col = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FFFFFF')
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '6495ED')
			)
		);

		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_isi_tengah = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_isi_kiri = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
	
        $data = $this->laporan_model->laporan_pembelian($tgl_awal,$tgl_akhir);
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath('assets/img/logo_smkn1puring.png');
		$objDrawing->setOffsetY(9);
		//$objDrawing->setOffsetX(4.1);
		$objDrawing->setCoordinates('B1');
		$objDrawing->setHeight(80);
		$objDrawing->setWorksheet($excel->getActiveSheet());

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "DINAS PENDIDIKAN KABUPATEN KEBUMEN");
		$excel->getActiveSheet()->mergeCells('A2:F2');
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "SEKOLAH MENENGAH KEJURUAN NEGERI 1 PURING");
		$excel->getActiveSheet()->mergeCells('A3:F3');
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A4', "Jl. Selatan-Selatan Kilometer 04 Puring - Kebumen, Kode Pos 54383");
		$excel->getActiveSheet()->mergeCells('A4:F4');
		$excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A5', "Email : smknegeri1puring@gmail.com - Telp : 0811-2635-864");
		$excel->getActiveSheet()->mergeCells('A5:F5');
		$excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('A6:F6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
       
		$excel->setActiveSheetIndex(0)->setCellValue('A7', "LAPORAN PEMBELIAN BARANG HABIS PAKAI");
        $excel->getActiveSheet()->mergeCells('A7:F7');
        $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$tgl_awal = $this->uri->segment('3');
		$tgl_akhir = $this->uri->segment('4');
		if($tgl_awal != $tgl_akhir)
		{ 
			$periode_tgl = tgl_indo($tgl_awal).' s.d. '.tgl_indo($tgl_akhir);
		}else
		{
			$periode_tgl = tgl_indo($tgl_awal);
		} 

		$excel->setActiveSheetIndex(0)->setCellValue('A8', "Tanggal ".$periode_tgl);
        $excel->getActiveSheet()->mergeCells('A8:F8');
        $excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(TRUE); 		
        $excel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$excel->setActiveSheetIndex(0)->setCellValue('A10', "NO"); 
        $excel->setActiveSheetIndex(0)->setCellValue('B10', "KODE BARANG"); 
        $excel->setActiveSheetIndex(0)->setCellValue('C10', "NAMA BARANG"); 
        $excel->setActiveSheetIndex(0)->setCellValue('D10', "KATEGORI");
		$excel->setActiveSheetIndex(0)->setCellValue('E10', "TGL MASUK");
		$excel->setActiveSheetIndex(0)->setCellValue('F10', "JML MASUK");

        $excel->getActiveSheet()->getStyle('A10')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B10')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C10')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D10')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E10')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F10')->applyFromArray($style_col);

        $no = 1; 
        $numrow = 11; 
        foreach($data->result() as $r):
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $r->kode_hp);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $r->barang);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $r->kategori);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, date('d-m-Y', strtotime($r->tgl_masuk)));
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $r->jml_masuk.' '.$r->satuan);

            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_isi_tengah);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
            $no++;
            $numrow++;
        endforeach;

		$row_puring = $numrow + 1;
		$row_pengurus = $numrow + 2;
		$row_nama_pengurus = $numrow + 6;
		$row_nip_pengurus = $numrow + 7;
		$excel->getActiveSheet()->setCellValue('E'.$row_puring, 'Puring, '.tgl_indo(date('Y-m-d')));
		$excel->getActiveSheet()->setCellValue('E'.$row_pengurus, 'Pengurus Barang');
		$excel->getActiveSheet()->setCellValue('E'.$row_nama_pengurus, nama_pengurus_barang());
		$excel->getActiveSheet()->setCellValue('E'.$row_nip_pengurus, 'NIP. '.nip_pengurus_barang());

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(40); 
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->getActiveSheet(0)->setTitle("Pembelian Barang Habis Pakai");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="laporan-pembelian-barang-habis-pakai.xlsx"'); 
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');  
	}

    function laporan_pengambilan()
	{	
        if($this->input->post('submit', TRUE) == 'Submit')
        {  
            $tgl_awal = $this->input->post('tgl_awal',TRUE);
            $tgl_akhir = $this->input->post('tgl_akhir',TRUE);
            $data['submit'] = $this->input->post('submit',TRUE);
            $data['tgl_awal'] = $tgl_awal;
            $data['tgl_akhir'] = $tgl_akhir;
            $data['data'] = $this->laporan_model->laporan_pengambilan($tgl_awal,$tgl_akhir);
        }
        $data['title'] = 'Laporan Pengambilan Barang Habis Pakai';
        //layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('laporan/laporan_pengambilan', $data);
		$this->load->view('backend/template/js');
		$this->load->view('laporan/script');
        
    }

    function cetak_laporan_pengambilan_pdf($tgl_awal,$tgl_akhir)
	{	
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['data'] = $this->laporan_model->laporan_pengambilan($tgl_awal,$tgl_akhir);
		$this->load->library('pdfgenerator');
		$html = $this->load->view('laporan/cetak_laporan_pengambilan_pdf', $data, true);
		$filename = 'Laporan Pengambilan Barang Habis Pakai - Aplikasi Manajemen Barang SMK N 1 Puring';
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
    }

    function cetak_laporan_pengambilan($tgl_awal,$tgl_akhir)
	{	
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['data'] = $this->laporan_model->laporan_pengambilan($tgl_awal,$tgl_akhir);
		$this->load->view('laporan/cetak_laporan_pengambilan', $data);	
    }

	function export_laporan_pengambilan($tgl_awal,$tgl_akhir)
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator("SMK N 1 PURING")
            ->setLastModifiedBy("SMK N 1 PURING")
            ->setTitle("Laporan Pengambilan Barang Habis Pakai")
            ->setSubject("Laporan Pengambilan Barang Habis Pakai")
            ->setDescription("Laporan Pengambilan Barang Habis Pakai")
            ->setKeywords("Laporan Pengambilan Barang Habis Pakai");

		$style_col = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FFFFFF')
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '6495ED')
			)
		);

		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_isi_tengah = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_isi_kiri = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
	
        $data = $this->laporan_model->laporan_pengambilan($tgl_awal,$tgl_akhir);
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath('assets/img/logo_smkn1puring.png');
		$objDrawing->setOffsetY(9);
		//$objDrawing->setOffsetX(4.1);
		$objDrawing->setCoordinates('B1');
		$objDrawing->setHeight(80);
		$objDrawing->setWorksheet($excel->getActiveSheet());

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "DINAS PENDIDIKAN KABUPATEN KEBUMEN");
		$excel->getActiveSheet()->mergeCells('A2:E2');
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "SEKOLAH MENENGAH KEJURUAN NEGERI 1 PURING");
		$excel->getActiveSheet()->mergeCells('A3:E3');
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A4', "Jl. Selatan-Selatan Kilometer 04 Puring - Kebumen, Kode Pos 54383");
		$excel->getActiveSheet()->mergeCells('A4:E4');
		$excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A5', "Email : smknegeri1puring@gmail.com - Telp : 0811-2635-864");
		$excel->getActiveSheet()->mergeCells('A5:E5');
		$excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('A6:E6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
       
		$excel->setActiveSheetIndex(0)->setCellValue('A7', "LAPORAN PENGAMBILAN BARANG HABIS PAKAI");
        $excel->getActiveSheet()->mergeCells('A7:E7');
        $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$tgl_awal = $this->uri->segment('3');
		$tgl_akhir = $this->uri->segment('4');
		if($tgl_awal != $tgl_akhir)
		{ 
			$periode_tgl = tgl_indo($tgl_awal).' s.d. '.tgl_indo($tgl_akhir);
		}else
		{
			$periode_tgl = tgl_indo($tgl_awal);
		} 

		$excel->setActiveSheetIndex(0)->setCellValue('A8', "Tanggal ".$periode_tgl);
        $excel->getActiveSheet()->mergeCells('A8:E8');
        $excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(TRUE); 		
        $excel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A10', "NO"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B10', "KODE AMBIL"); 
		$excel->setActiveSheetIndex(0)->setCellValue('C10', "NAMA PENGAMBIL"); 
		$excel->setActiveSheetIndex(0)->setCellValue('D10', "TGL AMBIL");
		$excel->setActiveSheetIndex(0)->setCellValue('E10', "WAKTU AMBIL");
		
		$excel->getActiveSheet()->getStyle('A10')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B10')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C10')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D10')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E10')->applyFromArray($style_col);

        $no = 1; 
        $numrow = 11; 
        foreach($data->result() as $r):
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $r->kode_trans);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $r->nama_pengambil);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, date('d-m-Y', strtotime($r->tgl_keluar)));
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $r->jam_keluar);

            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_isi_tengah);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $no++;
            $numrow++;
        endforeach;

		$row_puring = $numrow + 1;
		$row_pengurus = $numrow + 2;
		$row_nama_pengurus = $numrow + 6;
		$row_nip_pengurus = $numrow + 7;
		$excel->getActiveSheet()->setCellValue('D'.$row_puring, 'Puring, '.tgl_indo(date('Y-m-d')));
		$excel->getActiveSheet()->setCellValue('D'.$row_pengurus, 'Pengurus Barang');
		$excel->getActiveSheet()->setCellValue('D'.$row_nama_pengurus, nama_pengurus_barang());
		$excel->getActiveSheet()->setCellValue('D'.$row_nip_pengurus, 'NIP. '.nip_pengurus_barang());

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); 
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->getActiveSheet(0)->setTitle("Pengambilan Barang Habis Pakai");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="laporan-pengambilan-barang-habis-pakai.xlsx"'); 
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');  
	}

    function laporan_pemindahan()
	{	
        if($this->input->post('submit', TRUE) == 'Submit')
        {  
            $tgl_awal = $this->input->post('tgl_awal',TRUE);
            $tgl_akhir = $this->input->post('tgl_akhir',TRUE);
            $data['submit'] = $this->input->post('submit',TRUE);
            $data['tgl_awal'] = $tgl_awal;
            $data['tgl_akhir'] = $tgl_akhir;
            $data['data'] = $this->laporan_model->laporan_pemindahan($tgl_awal,$tgl_akhir);
        }
        $data['title'] = 'Laporan Pemindahan Barang Inventaris';
        //layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('laporan/laporan_pemindahan', $data);
		$this->load->view('backend/template/js');
		$this->load->view('laporan/script');
    }

    function cetak_laporan_pemindahan_pdf($tgl_awal,$tgl_akhir)
	{	
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['data'] = $this->laporan_model->laporan_pemindahan($tgl_awal,$tgl_akhir);
		$this->load->library('pdfgenerator');
		$html = $this->load->view('laporan/cetak_laporan_pemindahan_pdf', $data, true);
		$filename = 'Laporan Pemindahan Barang Inventaris - Aplikasi Manajemen Barang SMK N 1 Puring';
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
    }

    function cetak_laporan_pemindahan($tgl_awal,$tgl_akhir)
	{	
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['data'] = $this->laporan_model->laporan_pemindahan($tgl_awal,$tgl_akhir);
		$this->load->view('laporan/cetak_laporan_pemindahan', $data);
    }

	function export_laporan_pemindahan($tgl_awal,$tgl_akhir)
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator("SMK N 1 PURING")
            ->setLastModifiedBy("SMK N 1 PURING")
            ->setTitle("Laporan Pemindahan Barang Inventaris")
            ->setSubject("Laporan Pemindahan Barang Inventaris")
            ->setDescription("Laporan Pemindahan Barang Inventaris")
            ->setKeywords("Laporan Pemindahan Barang Inventaris");

		$style_col = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FFFFFF')
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '6495ED')
			)
		);

		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_isi_tengah = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_isi_kiri = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
	
        $data = $this->laporan_model->laporan_pemindahan($tgl_awal,$tgl_akhir);
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath('assets/img/logo_smkn1puring.png');
		$objDrawing->setOffsetY(9);
		//$objDrawing->setOffsetX(4.1);
		$objDrawing->setCoordinates('B1');
		$objDrawing->setHeight(80);
		$objDrawing->setWorksheet($excel->getActiveSheet());

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "DINAS PENDIDIKAN KABUPATEN KEBUMEN");
		$excel->getActiveSheet()->mergeCells('A2:D2');
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "SEKOLAH MENENGAH KEJURUAN NEGERI 1 PURING");
		$excel->getActiveSheet()->mergeCells('A3:D3');
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A4', "Jl. Selatan-Selatan Kilometer 04 Puring - Kebumen, Kode Pos 54383");
		$excel->getActiveSheet()->mergeCells('A4:D4');
		$excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A5', "Email : smknegeri1puring@gmail.com - Telp : 0811-2635-864");
		$excel->getActiveSheet()->mergeCells('A5:D5');
		$excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('A6:D6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
       
		$excel->setActiveSheetIndex(0)->setCellValue('A7', "LAPORAN PEMINDAHAN BARANG INVENTARIS");
        $excel->getActiveSheet()->mergeCells('A7:D7');
        $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$tgl_awal = $this->uri->segment('3');
		$tgl_akhir = $this->uri->segment('4');
		if($tgl_awal != $tgl_akhir)
		{ 
			$periode_tgl = tgl_indo($tgl_awal).' s.d. '.tgl_indo($tgl_akhir);
		}else
		{
			$periode_tgl = tgl_indo($tgl_awal);
		} 

		$excel->setActiveSheetIndex(0)->setCellValue('A8', "Tanggal ".$periode_tgl);
        $excel->getActiveSheet()->mergeCells('A8:D8');
        $excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(TRUE); 		
        $excel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A10', "NO"); 
        $excel->setActiveSheetIndex(0)->setCellValue('B10', "KODE PINDAH"); 
        $excel->setActiveSheetIndex(0)->setCellValue('C10', "TGL PINDAH");
		$excel->setActiveSheetIndex(0)->setCellValue('D10', "KE RUANG");

        $excel->getActiveSheet()->getStyle('A10')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B10')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C10')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D10')->applyFromArray($style_col);

        $no = 1; 
        $numrow = 11; 
        foreach($data->result() as $r):
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $r->kode_pindah);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, date('d-m-Y', strtotime($r->tgl_pindah)));
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $r->ruang);

            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_isi_tengah);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $no++;
            $numrow++;
        endforeach;

		$row_puring = $numrow + 1;
		$row_pengurus = $numrow + 2;
		$row_nama_pengurus = $numrow + 6;
		$row_nip_pengurus = $numrow + 7;
		$excel->getActiveSheet()->setCellValue('D'.$row_puring, 'Puring, '.tgl_indo(date('Y-m-d')));
		$excel->getActiveSheet()->setCellValue('D'.$row_pengurus, 'Pengurus Barang');
		$excel->getActiveSheet()->setCellValue('D'.$row_nama_pengurus, nama_pengurus_barang());
		$excel->getActiveSheet()->setCellValue('D'.$row_nip_pengurus, 'NIP. '.nip_pengurus_barang());

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(60); 
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->getActiveSheet(0)->setTitle("Pemindahan Barang Inventaris");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="laporan-pemindahan-barang-inventaris.xlsx"'); 
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');  
	}

    function daftar_barang_per_ruang()
	{	
        if($this->input->post('submit', TRUE) == 'Submit')
        {  
            $id_ruang = $this->input->post('id_ruang',TRUE);
            $data['id_ruang'] = $id_ruang;
            $data['submit'] = $this->input->post('submit',TRUE);
            $data['data'] = $this->laporan_model->daftar_barang_per_ruang($id_ruang);
        }
        $data['title'] = 'Daftar Barang Inventaris Per Ruang';
        $data['ruang'] = $this->db->select('id_ruang,ruang')->from('tb_ruang')->order_by('ruang','asc')->get()->result();
        //layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('laporan/daftar_barang', $data);
		$this->load->view('backend/template/js');
		$this->load->view('laporan/script');
    }

    function cetak_daftar_barang_per_ruang_pdf($id_ruang)
	{	
        $data['data'] = $this->laporan_model->daftar_barang_per_ruang($id_ruang);
        $data['ruang'] = $this->db->get_where('tb_ruang', ['id_ruang' => $id_ruang])->row();
		$this->load->library('pdfgenerator');
		$html = $this->load->view('laporan/cetak_daftar_barang_pdf', $data, true);
		$filename = 'Laporan Daftar Barang Inventaris Ruang - Aplikasi Manajemen Barang SMK N 1 Puring';
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
    }

    function cetak_daftar_barang_per_ruang($id_ruang)
	{	
        $data['data'] = $this->laporan_model->daftar_barang_per_ruang($id_ruang);
        $data['ruang'] = $this->db->get_where('tb_ruang', ['id_ruang' => $id_ruang])->row();
		$this->load->view('laporan/cetak_daftar_barang', $data);	
    }

	function export_daftar_barang_per_ruang($id_ruang)
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator("SMK N 1 PURING")
            ->setLastModifiedBy("SMK N 1 PURING")
            ->setTitle("Daftar Barang Inventaris Per Ruang")
            ->setSubject("Daftar Barang Inventaris Per Ruang")
            ->setDescription("Daftar Barang Inventaris Per Ruang")
            ->setKeywords("Daftar Barang Inventaris Per Ruang");

		$style_col = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FFFFFF')
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '6495ED')
			)
		);

		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_isi_tengah = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_isi_kiri = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
	
        $data = $this->laporan_model->daftar_barang_per_ruang($id_ruang);
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath('assets/img/logo_smkn1puring.png');
		$objDrawing->setOffsetY(9);
		//$objDrawing->setOffsetX(4.1);
		$objDrawing->setCoordinates('B1');
		$objDrawing->setHeight(80);
		$objDrawing->setWorksheet($excel->getActiveSheet());

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "DINAS PENDIDIKAN KABUPATEN KEBUMEN");
		$excel->getActiveSheet()->mergeCells('A2:F2');
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "SEKOLAH MENENGAH KEJURUAN NEGERI 1 PURING");
		$excel->getActiveSheet()->mergeCells('A3:F3');
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A4', "Jl. Selatan-Selatan Kilometer 04 Puring - Kebumen, Kode Pos 54383");
		$excel->getActiveSheet()->mergeCells('A4:F4');
		$excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A5', "Email : smknegeri1puring@gmail.com - Telp : 0811-2635-864");
		$excel->getActiveSheet()->mergeCells('A5:F5');
		$excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('A6:F6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
       
		$excel->setActiveSheetIndex(0)->setCellValue('A7', "DAFTAR BARANG INVENTARIS PER RUANG");
        $excel->getActiveSheet()->mergeCells('A7:F7');
        $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		
		$excel->setActiveSheetIndex(0)->setCellValue('A9', "NOMOR RUANG");
        $excel->getActiveSheet()->mergeCells('A9:B9');
        $excel->getActiveSheet()->getStyle('A9')->getFont()->setBold(TRUE); 
        $excel->setActiveSheetIndex(0)->setCellValue('C9', ": ".nomor_ruang($id_ruang));

		$excel->setActiveSheetIndex(0)->setCellValue('A10', "RUANG");
        $excel->getActiveSheet()->mergeCells('A10:B10');
        $excel->getActiveSheet()->getStyle('A10')->getFont()->setBold(TRUE); 
        $excel->setActiveSheetIndex(0)->setCellValue('C10', ": ".ruang($id_ruang));

		$excel->setActiveSheetIndex(0)->setCellValue('A12', "NO"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B12', "KODE BARANG"); 
		$excel->setActiveSheetIndex(0)->setCellValue('C12', "NAMA BARANG");
		$excel->setActiveSheetIndex(0)->setCellValue('D12', "MERK");
		$excel->setActiveSheetIndex(0)->setCellValue('E12', "TAHUN BELI");
		$excel->setActiveSheetIndex(0)->setCellValue('F12', "KONDISI");
		$excel->setActiveSheetIndex(0)->setCellValue('G12', "KETERANGAN");

		$excel->getActiveSheet()->getStyle('A12')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B12')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C12')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D12')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E12')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F12')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G12')->applyFromArray($style_col);

        $no = 1; 
        $numrow = 13; 
        foreach($data->result() as $r):
			if($r->id_kondisi == 1)
			{
				$kondisi = 'Baik';
			}elseif($r->id_kondisi == 2)
			{
				$kondisi = 'Rusak Ringan';
			}elseif($r->id_kondisi == 3)
			{
				$kondisi = 'Rusak Sedang';
			}elseif($r->id_kondisi == 4)
			{
				$kondisi = 'Rusak Berat';
			}elseif($r->id_kondisi == 5)
			{
				$kondisi = 'Hilang';
			}elseif($r->id_kondisi == 6)
			{
				$kondisi = 'Dihapus';
			}else
			{
				$kondisi = '';
			}

			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $r->kode_inv);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $r->barang);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $r->merk);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $r->th_beli);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $kondisi);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $r->keterangan);

            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_isi_tengah);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $no++;
            $numrow++;
        endforeach;

		$row_puring = $numrow + 1;
		$row_pengurus = $numrow + 2;
		$row_nama_pengurus = $numrow + 6;
		$row_nip_pengurus = $numrow + 7;
		$excel->getActiveSheet()->setCellValue('F'.$row_puring, 'Puring, '.tgl_indo(date('Y-m-d')));
		$excel->getActiveSheet()->setCellValue('F'.$row_pengurus, 'Pengurus Barang');
		$excel->getActiveSheet()->setCellValue('F'.$row_nama_pengurus, nama_pengurus_barang());
		$excel->getActiveSheet()->setCellValue('F'.$row_nip_pengurus, 'NIP. '.nip_pengurus_barang());

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(40); 
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->getActiveSheet(0)->setTitle("Daftar Barang Inventaris Ruang");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="daftar-barang-inventaris-ruang.xlsx"'); 
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');  
	}

    function rekap_barang_per_ruang()
	{	
        if($this->input->post('submit', TRUE) == 'Submit')
        {  
            $id_ruang = $this->input->post('id_ruang',TRUE);
            $data['id_ruang'] = $id_ruang;
            $data['submit'] = $this->input->post('submit',TRUE);
            $data['data'] = $this->laporan_model->rekap_barang_per_ruang($id_ruang);
        }
        $data['title'] = 'Rekap Barang Inventaris Per Ruang';
        $data['ruang'] = $this->db->select('id_ruang,ruang')->from('tb_ruang')->order_by('ruang','asc')->get()->result();
        //layout
		$this->load->view('backend/template/head');
		$this->load->view('backend/template/topbar');
		$this->load->view('backend/template/nav');
		$this->load->view('laporan/rekap_barang', $data);
		$this->load->view('backend/template/js');
		$this->load->view('laporan/script');
    }

    function cetak_rekap_barang_per_ruang_pdf($id_ruang)
	{	
        $data['data'] = $this->laporan_model->rekap_barang_per_ruang($id_ruang);
        $data['ruang'] = $this->db->select('*')->from('tb_ruang')->where('id_ruang',$id_ruang)->get()->row();
		$this->load->library('pdfgenerator');
		$html = $this->load->view('laporan/cetak_rekap_barang_pdf', $data, true);
		$filename = 'Laporan Rekap Barang Inventaris Ruang - Aplikasi Manajemen Barang SMK N 1 Puring';
		$this->pdfgenerator->generate($html, $filename, TRUE, 'A4', 'landscape');	
    }

    function cetak_rekap_barang_per_ruang($id_ruang)
	{	
        $data['data'] = $this->laporan_model->rekap_barang_per_ruang($id_ruang);
        $data['ruang'] = $this->db->select('*')->from('tb_ruang')->where('id_ruang',$id_ruang)->get()->row();
		$this->load->view('laporan/cetak_rekap_barang', $data);	
    }

	function export_rekap_barang_per_ruang($id_ruang)
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();

        $excel->getProperties()->setCreator("SMK N 1 PURING")
            ->setLastModifiedBy("SMK N 1 PURING")
            ->setTitle("Rekap Barang Inventaris Per Ruang")
            ->setSubject("Rekap Barang Inventaris Per Ruang")
            ->setDescription("Rekap Barang Inventaris Per Ruang")
            ->setKeywords("Rekap Barang Inventaris Per Ruang");

		$style_col = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => 'FFFFFF')
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '6495ED')
			)
		);

		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_isi_tengah = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_isi_kiri = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
	
        $data = $this->laporan_model->rekap_barang_per_ruang($id_ruang);
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setPath('assets/img/logo_smkn1puring.png');
		$objDrawing->setOffsetY(9);
		//$objDrawing->setOffsetX(4.1);
		$objDrawing->setCoordinates('B1');
		$objDrawing->setHeight(80);
		$objDrawing->setWorksheet($excel->getActiveSheet());

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "DINAS PENDIDIKAN KABUPATEN KEBUMEN");
		$excel->getActiveSheet()->mergeCells('A2:F2');
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "SEKOLAH MENENGAH KEJURUAN NEGERI 1 PURING");
		$excel->getActiveSheet()->mergeCells('A3:F3');
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A4', "Jl. Selatan-Selatan Kilometer 04 Puring - Kebumen, Kode Pos 54383");
		$excel->getActiveSheet()->mergeCells('A4:F4');
		$excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A5', "Email : smknegeri1puring@gmail.com - Telp : 0811-2635-864");
		$excel->getActiveSheet()->mergeCells('A5:F5');
		$excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->getActiveSheet()->getStyle('A6:F6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
       
		$excel->setActiveSheetIndex(0)->setCellValue('A7', "REKAP BARANG INVENTARIS PER RUANG");
        $excel->getActiveSheet()->mergeCells('A7:F7');
        $excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		
		$excel->setActiveSheetIndex(0)->setCellValue('A9', "NOMOR RUANG");
        $excel->getActiveSheet()->mergeCells('A9:B9');
        $excel->getActiveSheet()->getStyle('A9')->getFont()->setBold(TRUE); 
        $excel->setActiveSheetIndex(0)->setCellValue('C9', ": ".nomor_ruang($id_ruang));

		$excel->setActiveSheetIndex(0)->setCellValue('A10', "RUANG");
        $excel->getActiveSheet()->mergeCells('A10:B10');
        $excel->getActiveSheet()->getStyle('A10')->getFont()->setBold(TRUE); 
        $excel->setActiveSheetIndex(0)->setCellValue('C10', ": ".ruang($id_ruang));

		$excel->setActiveSheetIndex(0)->setCellValue('A12', "NO"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B12', "JUMLAH"); 
		$excel->setActiveSheetIndex(0)->setCellValue('C12', "KATEGORI BARANG");

		$excel->getActiveSheet()->getStyle('A12')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B12')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C12')->applyFromArray($style_col);

        $no = 1; 
        $numrow = 13; 
        foreach($data->result() as $r):
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $r->jml.' '.$r->satuan);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $r->kategori);

            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_isi_tengah);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $no++;
            $numrow++;
        endforeach;

		$row_puring = $numrow + 1;
		$row_pengurus = $numrow + 2;
		$row_nama_pengurus = $numrow + 6;
		$row_nip_pengurus = $numrow + 7;
		$excel->getActiveSheet()->setCellValue('C'.$row_puring, 'Puring, '.tgl_indo(date('Y-m-d')));
		$excel->getActiveSheet()->setCellValue('C'.$row_pengurus, 'Pengurus Barang');
		$excel->getActiveSheet()->setCellValue('C'.$row_nama_pengurus, nama_pengurus_barang());
		$excel->getActiveSheet()->setCellValue('C'.$row_nip_pengurus, 'NIP. '.nip_pengurus_barang());

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->getActiveSheet(0)->setTitle("Rekap Barang Inventaris Ruang");
        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="rekap-barang-inventaris-ruang.xlsx"'); 
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');  
	}

}