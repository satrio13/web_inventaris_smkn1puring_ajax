<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function laporan_stok()
    {
        return $this->db->select('b.*,k.kategori')->from('tb_baranghp b')->join('tb_kategori k','b.id_kategori=k.id_kategori')->order_by('kode_hp','asc')->get();
    }

    function laporan_pembelian($tgl_awal,$tgl_akhir)
    {
        return $this->db->select('d.*,b.*,k.kategori')->from('tb_masukhp d')->join('tb_baranghp b','d.id_baranghp=b.id_baranghp')->join('tb_kategori k','b.id_kategori=k.id_kategori')->where('d.tgl_masuk >= ',$tgl_awal)->where('d.tgl_masuk <= ',$tgl_akhir)->order_by('d.id_masukhp','desc')->get();
    }

    function laporan_pengambilan($tgl_awal,$tgl_akhir)
    {
        return $this->db->select('*')->from('tb_detailkeluarhp')->where('tgl_keluar >= ',$tgl_awal)->where('tgl_keluar <= ',$tgl_akhir)->order_by('kode_trans','desc')->get();
    }

    function laporan_pemindahan($tgl_awal,$tgl_akhir)
    {
        return $this->db->select('p.*,r.ruang')->from('tb_pindah p')->join('tb_ruang r','p.id_ruang=r.id_ruang')
        ->where('p.tgl_pindah >= ',$tgl_awal)->where('p.tgl_pindah <= ',$tgl_akhir)->order_by('p.kode_pindah','desc')->group_by('p.kode_pindah')->get();
    }

    function daftar_barang_per_ruang($id_ruang)
    {
        return $this->db->select('p.id_pindah,p.id_baranginv,p.status,p.id_ruang,b.kode_inv,b.barang,b.merk,b.th_beli,b.id_kondisi,b.keterangan,r.*')->from('tb_pindah p')->join('tb_baranginv b','p.id_baranginv=b.id_baranginv')->join('tb_ruang r','p.id_ruang=r.id_ruang')->where('p.status',1)->where('p.id_ruang',$id_ruang)->group_by('b.id_baranginv')->order_by('b.kode_inv','asc')->get();
    }

    function rekap_barang_per_ruang($id_ruang)
    {
        return $this->db->select('p.id_baranginv,p.status,p.id_ruang,b.id_kategori,b.satuan,k.kategori,COUNT(b.id_kategori) AS jml')->from('tb_pindah p')->join('tb_baranginv b','p.id_baranginv=b.id_baranginv')->join('tb_kategori k','b.id_kategori=k.id_kategori')->where('p.status',1)->where('p.id_ruang',$id_ruang)->group_by('b.id_kategori')->order_by('k.kategori','asc')->get();
    }
    
}