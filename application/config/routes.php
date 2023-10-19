<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route = array(
    'default_controller' => 'backend',
    'backend/pengurusbarang' => 'pengurusbarang', // start pengurusbarang
    'backend/get_data_pengurusbarang' => 'pengurusbarang/get_data_pengurusbarang',
    'backend/get_pengurusbarang_by_id' => 'pengurusbarang/get_pengurusbarang_by_id',
    'backend/edit-pengurusbarang' => 'pengurusbarang/edit-pengurusbarang', // end pengurusbarang
    'backend/tahun' => 'tahun', // start tahun
    'backend/get_data_tahun' => 'tahun/get_data_tahun',
    'backend/get_tahun_by_id/(:num)' => 'tahun/get_tahun_by_id/$1',
    'backend/tambah-tahun' => 'tahun/tambah-tahun',
    'backend/edit-tahun' => 'tahun/edit-tahun',
    'backend/hapus-tahun/(:num)' => 'tahun/hapus-tahun/$1', // end tahun
    'backend/ruang' => 'ruang', // start ruang
    'backend/get_data_ruang' => 'ruang/get_data_ruang',
    'backend/get_ruang_by_id/(:num)' => 'ruang/get_ruang_by_id/$1',
    'backend/cetak-ruang-pdf' => 'ruang/cetak-ruang-pdf',
    'backend/cetak-ruang' => 'ruang/cetak-ruang',
    'backend/tambah-ruang' => 'ruang/tambah-ruang',
    'backend/edit-ruang' => 'ruang/edit-ruang',
    'backend/hapus-ruang/(:num)' => 'ruang/hapus-ruang/$1', // end ruang
    'backend/tanah' => 'tanah', // start tanah
    'backend/get_data_tanah' => 'tanah/get_data_tanah',
    'backend/get_tanah_by_id/(:num)' => 'tanah/get_tanah_by_id/$1',
    'backend/cetak-tanah-pdf' => 'tanah/cetak-tanah-pdf',
    'backend/cetak-tanah' => 'tanah/cetak-tanah',
    'backend/tambah-tanah' => 'tanah/tambah-tanah',
    'backend/edit-tanah' => 'tanah/edit-tanah',
    'backend/hapus-tanah/(:num)' => 'tanah/hapus-tanah/$1', // end tanah
    'backend/gedung' => 'gedung', // start gedung
    'backend/get_data_gedung' => 'gedung/get_data_gedung',
    'backend/get_gedung_by_id/(:num)' => 'gedung/get_gedung_by_id/$1',
    'backend/cetak-gedung-pdf' => 'gedung/cetak-gedung-pdf',
    'backend/cetak-gedung' => 'gedung/cetak-gedung',
    'backend/tambah-gedung' => 'gedung/tambah-gedung',
    'backend/edit-gedung' => 'gedung/edit-gedung',
    'backend/hapus-gedung/(:num)' => 'gedung/hapus-gedung/$1', // end gedung
    'backend/kategori' => 'kategori', // start kategori
    'backend/get_data_kategori' => 'kategori/get_data_kategori',
    'backend/get_kategori_by_id/(:num)' => 'kategori/get_kategori_by_id/$1',
    'backend/cetak-kategori-pdf' => 'kategori/cetak-kategori-pdf',
    'backend/cetak-kategori' => 'kategori/cetak-kategori',
    'backend/tambah-kategori' => 'kategori/tambah-kategori',
    'backend/edit-kategori' => 'kategori/edit-kategori',
    'backend/hapus-kategori/(:num)' => 'kategori/hapus-kategori/$1', // end kategori
    //'backend/kondisi' => 'kondisi', // start kondisi
    //'backend/tambah-kondisi' => 'kondisi/tambah-kondisi',
    //'backend/edit-kondisi/(:num)' => 'kondisi/edit-kondisi/$1',
    //'backend/hapus-kondisi/(:num)' => 'kondisi/hapus-kondisi/$1', // end kondisi
    'backend/baranghp' => 'baranghp', // start baranghp
    'backend/get_data_baranghp' => 'baranghp/get_data_baranghp',
    'backend/get_baranghp_by_id/(:num)' => 'baranghp/get_baranghp_by_id/$1',
    'backend/cetak-baranghp-pdf' => 'baranghp/cetak-baranghp-pdf',
    'backend/cetak-baranghp' => 'baranghp/cetak-baranghp',
    'backend/tambah-baranghp' => 'baranghp/tambah-baranghp',
    'backend/form-baranghp' => 'baranghp/form-baranghp',
    'backend/import-baranghp' => 'baranghp/import-baranghp',
    'backend/export-baranghp' => 'baranghp/export-baranghp',
    'backend/edit-baranghp' => 'baranghp/edit-baranghp',
    'backend/hapus-baranghp/(:num)' => 'baranghp/hapus-baranghp/$1', // end baranghp
    'backend/baranginv' => 'baranginv', // start baranginv
    'backend/get_data_baranginv' => 'baranginv/get_data_baranginv',
    'backend/get_baranginv_by_id/(:num)' => 'baranginv/get_baranginv_by_id/$1',
    'backend/cetak-baranginv-pdf' => 'baranginv/cetak-baranginv-pdf',
    'backend/cetak-baranginv' => 'baranginv/cetak-baranginv',
    'backend/tambah-baranginv' => 'baranginv/tambah-baranginv',
    'backend/form-baranginv' => 'baranginv/form-baranginv',
    'backend/import-baranginv' => 'baranginv/import-baranginv',
    'backend/export-baranginv' => 'baranginv/export-baranginv',
    'backend/edit-baranginv' => 'baranginv/edit-baranginv',
    'backend/hapus-baranginv/(:num)' => 'baranginv/hapus-baranginv/$1', // end baranginv
    'backend/barangmasukhp' => 'barangmasukhp', // start barangmasukhp
    'backend/get_data_barangmasukhp' => 'barangmasukhp/get_data_barangmasukhp',
    'backend/cetak-barangmasukhp-pdf' => 'barangmasukhp/cetak-barangmasukhp-pdf',
    'backend/cetak-barangmasukhp' => 'barangmasukhp/cetak-barangmasukhp',
    'backend/export-barangmasukhp' => 'barangmasukhp/export-barangmasukhp',
    'backend/tambah-barangmasukhp' => 'barangmasukhp/tambah-barangmasukhp',
    'backend/hapus-barangmasukhp/(:num)' => 'barangmasukhp/hapus-barangmasukhp/$1', // end barangmasukhp
    'backend/pengambilan' => 'pengambilan', // start pengambilan
    'backend/data_cart' => 'pengambilan/data_cart',
    'backend/get_data_pengambilan' => 'pengambilan/get_data_pengambilan',
    'backend/get_data_riwayat_pengambilan' => 'pengambilan/get_data_riwayat_pengambilan',
    'backend/get_pengambilan' => 'pengambilan/get_pengambilan',
    'backend/get_data_ambil' => 'pengambilan/get_data_ambil',
    'backend/get_terambil' => 'pengambilan/get_terambil',
    'backend/simpan_pengambilan' => 'pengambilan/simpan_pengambilan',
    'backend/hapus_cart/(:num)' => 'pengambilan/hapus_cart/$1',
    'backend/hapus_batal' => 'pengambilan/hapus_batal',
    'backend/hapus-pengambilan/(:any)' => 'pengambilan/hapus-pengambilan/$1',
    'backend/detail-pengambilan' => 'pengambilan/detail-pengambilan',
    'backend/rincian-pengambilan/(:any)' => 'pengambilan/rincian-pengambilan/$1',
    'backend/cetak-pengambilan-pdf/(:any)' => 'pengambilan/cetak-pengambilan-pdf/$1',
    'backend/cetak-pengambilan/(:any)' => 'pengambilan/cetak-pengambilan/$1', // end pengambilan
    'backend/pemindahan' => 'pemindahan', // start pemindahan
    'backend/data_cart_pemindahan' => 'pemindahan/data_cart_pemindahan',
    'backend/get_data_pemindahan' => 'pemindahan/get_data_pemindahan',
    'backend/get_data_pindah' => 'pemindahan/get_data_pindah',
    'backend/get_pemindahan' => 'pemindahan/get_pemindahan',
    'backend/get_terpindah' => 'pemindahan/get_terpindah',
    'backend/hapus_cart_pemindahan/(:num)' => 'pemindahan/hapus_cart_pemindahan/$1',
    'backend/hapus_batal_pemindahan' => 'pemindahan/hapus_batal_pemindahan',
    'backend/simpan_pemindahan' => 'pemindahan/simpan_pemindahan',
    'backend/hapus-pemindahan/(:any)' => 'pemindahan/hapus-pemindahan/$1',
    'backend/detail-pemindahan' => 'pemindahan/detail-pemindahan',
    'backend/rincian-pemindahan/(:any)' => 'pemindahan/rincian-pemindahan/$1',
    'backend/cetak-pemindahan-pdf/(:any)' => 'pemindahan/cetak-pemindahan-pdf/$1',
    'backend/cetak-pemindahan/(:any)' => 'pemindahan/cetak-pemindahan/$1', // end pemindahan
    'backend/laporan-stok' => 'laporan/laporan-stok', // start laporan
    'backend/cetak-laporan-stok-pdf' => 'laporan/cetak-laporan-stok-pdf',
    'backend/cetak-laporan-stok' => 'laporan/cetak-laporan-stok',
    'backend/export-laporan-stok' => 'laporan/export-laporan-stok',
    'backend/laporan-pembelian' => 'laporan/laporan-pembelian',
    'backend/cetak-laporan-pembelian-pdf/(:any)/(:any)' => 'laporan/cetak-laporan-pembelian-pdf/$1/$2',
    'backend/cetak-laporan-pembelian/(:any)/(:any)' => 'laporan/cetak-laporan-pembelian/$1/$2',
    'backend/export-laporan-pembelian/(:any)/(:any)' => 'laporan/export-laporan-pembelian/$1/$2',
    'backend/laporan-pengambilan' => 'laporan/laporan-pengambilan',
    'backend/cetak-laporan-pengambilan-pdf/(:any)/(:any)' => 'laporan/cetak-laporan-pengambilan-pdf/$1/$2',
    'backend/cetak-laporan-pengambilan/(:any)/(:any)' => 'laporan/cetak-laporan-pengambilan/$1/$2',
    'backend/export-laporan-pengambilan/(:any)/(:any)' => 'laporan/export-laporan-pengambilan/$1/$2',
    'backend/laporan-pemindahan' => 'laporan/laporan-pemindahan',
    'backend/cetak-laporan-pemindahan-pdf/(:any)/(:any)' => 'laporan/cetak-laporan-pemindahan-pdf/$1/$2',
    'backend/cetak-laporan-pemindahan/(:any)/(:any)' => 'laporan/cetak-laporan-pemindahan/$1/$2',
    'backend/export-laporan-pemindahan/(:any)/(:any)' => 'laporan/export-laporan-pemindahan/$1/$2',
    'backend/daftar-barang-per-ruang' => 'laporan/daftar-barang-per-ruang',
    'backend/cetak-daftar-barang-per-ruang-pdf/(:num)' => 'laporan/cetak-daftar-barang-per-ruang-pdf/$1',
    'backend/cetak-daftar-barang-per-ruang/(:num)' => 'laporan/cetak-daftar-barang-per-ruang/$1',
    'backend/export-daftar-barang-per-ruang/(:num)' => 'laporan/export-daftar-barang-per-ruang/$1',
    'backend/rekap-barang-per-ruang' => 'laporan/rekap-barang-per-ruang',
    'backend/cetak-rekap-barang-per-ruang-pdf/(:num)' => 'laporan/cetak-rekap-barang-per-ruang-pdf/$1',
    'backend/cetak-rekap-barang-per-ruang/(:num)' => 'laporan/cetak-rekap-barang-per-ruang/$1',
    'backend/export-rekap-barang-per-ruang/(:num)' => 'laporan/export-rekap-barang-per-ruang/$1', // end laporan
    'backend/perbaikan' => 'perbaikan', // start perbaikan
    'backend/get_data_perbaikan' => 'perbaikan/get_data_perbaikan',
    'backend/get_perbaikan_by_id/(:num)' => 'perbaikan/get_perbaikan_by_id/$1',
    'backend/cetak-perbaikan-pdf' => 'perbaikan/cetak-perbaikan-pdf',
    'backend/cetak-perbaikan' => 'perbaikan/cetak-perbaikan',
    'backend/tambah-perbaikan' => 'perbaikan/tambah-perbaikan',
    'backend/export-perbaikan' => 'perbaikan/export-perbaikan',
    'backend/edit-perbaikan' => 'perbaikan/edit-perbaikan',
    'backend/hapus-perbaikan/(:num)' => 'perbaikan/hapus-perbaikan/$1', // end perbaikan
    'backend/user' => 'user', //start user
    'backend/get_data_users' => 'user/get_data_users',
    'backend/get_user_by_id/(:num)' => 'user/get_user_by_id/$1',
    'backend/tambah-user' => 'user/tambah-user',
    'backend/edit-user' => 'user/edit-user',
    'backend/hapus-user/(:any)' => 'user/hapus-user/$1',
    'backend/edit-profil/(:num)' => 'user/edit-profil/$1',
    'backend/ganti-password/(:num)' => 'user/ganti-password/$1', //end user
    'backend/backup' => 'backup'
);
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
