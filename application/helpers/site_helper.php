<?php 
function pesan_sukses($str)
{
   return "<script type='text/javascript'>
               setTimeout(function () { 
                  swal({
                     position: 'top-end',
                     icon: 'success',
                     title: '$str',
                     timer: 1500
                  });
               },2000); 
            </script>";
}

function pesan_gagal($str)
{
   return "<script type='text/javascript'>
               setTimeout(function () { 
                  swal({
                     position: 'top-end',
                     icon: 'error',
                     title: '$str',
                     timer: 5000
                  });
               },2000); 
            </script>";
}

function tgl_simpan_sekarang()
{
   date_default_timezone_set('Asia/Jakarta');
   return date('Y-m-d');
}

function tgl_jam_simpan_sekarang()
{
   date_default_timezone_set('Asia/Jakarta');
   return date('Y-m-d H:i:s');
}

function is_email($str)
{
   return filter_var($str, FILTER_VALIDATE_EMAIL);
}

function is_url($str)
{
   return preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$str);
}
   
function cetak($str)
{
   return strip_tags(htmlentities($str, ENT_QUOTES, 'UTF-8'));
}
   
function nama_user($id_user)
{
   $ci = & get_instance();
   $q = $ci->db->select('id_user,nama')->from('tb_user')->where('id_user',$id_user)->get()->row_array();
   return $q['nama'];
}

function level_user($id_user)
{
   $ci = & get_instance();
   $q = $ci->db->select('id_user,level')->from('tb_user')->where('id_user',$id_user)->get()->row_array();
   return $q['level'];
}

function nip($id_user)
{
   $ci = & get_instance();
   $q = $ci->db->select('id_user,nip')->from('tb_user')->where('id_user',$id_user)->get()->row_array();
   return $q['nip'];
}

function nip_pengurus_barang()
{
   $ci = & get_instance();
   $q = $ci->db->select('p.*,u.nip,u.nama')->from('tb_pengurusbarang p')->join('tb_user u','p.id_user=u.id_user')->where('p.id',1)->get()->row_array();
   return $q['nip'];
}

function nama_pengurus_barang()
{
   $ci = & get_instance();
   $q = $ci->db->select('p.*,u.nip,u.nama')->from('tb_pengurusbarang p')->join('tb_user u','p.id_user=u.id_user')->where('p.id',1)->get()->row_array();
   return $q['nama'];
}

function nama_ks()
{
   $ci = & get_instance();
   $q = $ci->db->select('nama,level,is_active')->from('tb_user')->where('level','ks')->where('is_active',1)->get()->row_array();
   return $q['nama'];
}

function nip_ks()
{
   $ci = & get_instance();
   $q = $ci->db->select('nip,level,is_active')->from('tb_user')->where('level','ks')->where('is_active',1)->get()->row_array();
   return $q['nip'];
}

function kategori($id_kategori)
{
   $ci = & get_instance();
   $q = $ci->db->select('*')->from('tb_kategori')->where('id_kategori',$id_kategori)->get()->row_array();
   return $q['kategori'];
}

function kondisi($id_kondisi)
{
   $ci = & get_instance();
   $q = $ci->db->select('*')->from('tb_kondisi')->where('id_kondisi',$id_kondisi)->get()->row_array();
   return $q['kondisi'];
}

function nomor_ruang($id_ruang)
{
   $ci = & get_instance();
   $q = $ci->db->select('id_ruang,nomor')->from('tb_ruang')->where('id_ruang',$id_ruang)->get()->row_array();
   return $q['nomor'];
}

function ruang($id_ruang)
{
   $ci = & get_instance();
   $q = $ci->db->select('id_ruang,ruang')->from('tb_ruang')->where('id_ruang',$id_ruang)->get()->row_array();
   return $q['ruang'];
}

function tgl_indo($tgl)
{
   $tanggal = substr($tgl,8,2);
   $bulan = getBulan(substr($tgl,5,2));
   $tahun = substr($tgl,0,4);
   return $tanggal.' '.$bulan.' '.$tahun;       
} 

function tgl_simpan($tgl)
{  
   $tanggal = substr($tgl,0,2);
   $bulan = substr($tgl,3,2);
   $tahun = substr($tgl,6,4);
   return $tahun.'-'.$bulan.'-'.$tanggal;     
}

function tgl_view($tgl)
{
   $tanggal = substr($tgl,8,2);
   $bulan = substr($tgl,5,2);
   $tahun = substr($tgl,0,4);
   return $tanggal.'-'.$bulan.'-'.$tahun;       
}

function tgl_view_excel($tgl)
{
   $tanggal = substr($tgl,3,2);
   $bulan = substr($tgl,0,2);
   $tahun = substr($tgl,6,4);
   return $tanggal.'-'.$bulan.'-'.$tahun;       
}

function getTanggal($tgl)
{
   switch ($tgl)
   {
      case '01':
         $tanggal = 'Satu';
         break;
      case '02':
         $tanggal = 'Dua';
         break;
      case '03':
         $tanggal = 'Tiga';
         break;
      case '04':
         $tanggal = 'Empat';
         break;
      case '05':
         $tanggal = 'Lima';
         break;
      case '06':
         $tanggal = 'Enam';
         break;
      case '07':
         $tanggal = 'Tujuh';
         break;
      case '08':
         $tanggal = 'Delapan';
         break;
      case '09':
         $tanggal = 'Sembilan';
         break;
      case '10':
         $tanggal = 'Sepuluh';
         break;
      case '11':
         $tanggal = 'Sebelas';
         break;
      case '12':
         $tanggal = 'Dua Belas';
         break;
      case '13':
         $tanggal = 'Tiga Belas';
         break;
      case '14':
         $tanggal = 'Empat Belas';
         break;
      case '15':
         $tanggal = 'Lima Belas';
         break;
      case '16':
         $tanggal = 'Enam Belas';
         break;
      case '17':
         $tanggal = 'Tujuh Belas';
         break;
      case '18':
         $tanggal = 'Delapan Belas';
         break;
      case '19':
         $tanggal = 'Sembilan Belas';
         break;
      case '20':
         $tanggal = 'Dua Puluh';
         break;
      case '21':
         $tanggal = 'Dua Puluh Satu';
         break;
      case '22':
         $tanggal = 'Dua Puluh Dua';
         break;
      case '23':
         $tanggal = 'Dua Puluh Tiga';
         break;
      case '24':
         $tanggal = 'Dua Puluh Empat';
         break;
      case '25':
         $tanggal = 'Dua Puluh Lima';
         break;
      case '26':
         $tanggal = 'Dua Puluh Enam';
         break;
      case '27':
         $tanggal = 'Dua Puluh Tujuh';
         break;
      case '28':
         $tanggal = 'Dua Puluh Delapan';
         break;
      case '29':
         $tanggal = 'Dua Puluh Sembilan';
         break;
      case '30':
         $tanggal = 'Tiga Puluh';
         break;
      case '31':
         $tanggal = 'Tiga Puluh Satu';
         break;
      } 
      return $tanggal;
}

function getBulan($bln)
{
   switch ($bln) 
   {
      case '01':
         $bulan = 'Januari';
         break;
      case '02':
         $bulan = 'Februari';
         break;
      case '03':
         $bulan = 'Maret';
         break;
      case '04':
         $bulan = 'April';
         break;
      case '05':
         $bulan = 'Mei';
         break;
      case '06':
         $bulan = 'Juni';
         break;
      case '07':
         $bulan = 'Juli';
         break;
      case '08':
         $bulan = 'Agustus';
         break;
      case '09':
         $bulan = 'September';
         break;
      case '10':
         $bulan = 'Oktober';
         break;
      case '11':
         $bulan = 'November';
         break;
      case '12':
         $bulan = 'Desember';
         break;
   } 
   return $bulan;
}
   
function getTahun($thn)
{
   switch ($thn) 
   {
      case '2018':
         $tahun = 'Dua Ribu Delapan Belas';
         break;
      case '2019':
         $tahun = 'Dua Ribu Sembilan Belas';
         break;
      case '2020':
         $tahun = 'Dua Ribu Dua Puluh';
         break;
      case '2021':
         $tahun = 'Dua Ribu Dua Puluh Satu';
         break;
      case '2022':
         $tahun = 'Dua Ribu Dua Puluh Dua';
         break;
      case '2023':
         $tahun = 'Dua Ribu Dua Puluh Tiga';
         break;
      case '2024':
         $tahun = 'Dua Ribu Dua Puluh Empat';
         break;
      case '2025':
         $tahun = 'Dua Ribu Dua Puluh Lima';
         break;
   }
   return $tahun;
}