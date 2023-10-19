<div class="container">
    <div class="content-wrapper bg-white">
        <div class="content-header">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="text-dark"><?= $title; ?></h1>
                </div>
            </div>
        </div>
        <section class="content bg-white">
            <div class="row">
                <div class="col-md-12">
                    <a href="" target="_self" class="btn bg-maroon btn-sm"><i class="fas fa-sync-alt"></i> REFRESH HALAMAN</a>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="card border border-secondary">
                        <div class="card-header bg-info">
                            <h5><i class='fa fa-list'></i> Daftar Barang</h5>
                        </div>
                        <div class="card-body">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-striped table-sm" id="table-pengambilan">
                                    <thead class="bg-secondary text-center">
                                        <tr>
                                            <th width="5%" nowrap>No</th>
                                            <th nowrap>Kode Barang</th>
                                            <th nowrap>Barang</th>
                                            <th nowrap>Stok</th>
                                            <th nowrap>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>  
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border border-secondary">
                        <div class="card-header bg-info">
                            <h5><i class='fa fa-cart-plus'></i> Keranjang Pengambilan</h5>
                        </div>
                        <div class="card-body">
                            <div class="table table-responsive">
                                <form action="#" id="form_cart" class="form-horizontal">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="bg-secondary text-center">
                                            <tr>
                                                <th width="5%" nowrap>No</th>
                                                <th nowrap>Kode Barang</th>
                                                <th nowrap>Barang</th>
                                                <th nowrap>Jumlah</th>
                                                <th nowrap>#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="show_cart">
                                            <div id="load_add" class="text-center"></div>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div> 
                    </div>
                </div>        
            </div>
        </section>
        <section class="content bg-white">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border border-secondary">
                        <div class="card-header">
                            <h5 class="text-center">Riwayat Pengambilan Barang</h5>
                            <br><div class="alert alert-info"><a href="<?= base_url('backend/laporan-pengambilan'); ?>" class="btn btn-danger btn-sm text-decoration-none"><b>Klik Disini</b></a> Untuk Melihat Laporan Pengambilan Barang</div>
                            <div id="load_edit" class="text-center"></div>
                        </div>
                        <div class="card-body">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-striped table-sm" id="table-ambil">
                                    <thead class="bg-secondary text-center">
                                        <tr>
                                            <th width="5%" nowrap>No</th>
                                            <th nowrap>KODE AMBIL</th>
                                            <th nowrap>LOGIN PENGAMBIL</th>
                                            <th nowrap>NAMA PENGAMBIL</th>
                                            <th nowrap>TGL AMBIL</th>
                                            <th nowrap>WAKTU AMBIL</th>
                                            <th nowrap>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>  
                                   
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </section>
    </div>
    
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_detail" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Detail Pengambilan Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mt-2">
                        <div class="col-md-2 text-bold">KODE AMBIL</div>
                        <div class="col-md-4" id="kode_trans_detail"></div>
                        <div class="col-md-2 text-bold">NAMA PENGAMBIL</div>
                        <div class="col-md-4" id="nama_pengambil_detail"></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2 text-bold">TGL AMBIL</div>
                        <div class="col-md-4" id="tgl_keluar_detail"></div>
                        <div class="col-md-2 text-bold">JAM AMBIL</div>
                        <div class="col-md-4" id="jam_keluar_detail"></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2 text-bold">LOGIN PENGAMBIL</div>
                        <div class="col-md-10" id="login_pengambil_detail"></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12 text-right" id="link_cetak">
                           
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead class="bg-secondary text-center">
                                        <tr>
                                            <th width="5%" nowrap>NO</th>
                                            <th nowrap>KODE BARANG</th>
                                            <th nowrap>NAMA BARANG</th>
                                            <th nowrap>JUMLAH</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_detail">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->