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
                                <table class="table table-bordered table-striped table-sm" id="table-pemindahan">
                                    <thead class="bg-secondary text-center">
                                        <tr>
                                            <th width="5%" nowrap>No</th>
                                            <th nowrap>Kode Barang</th>
                                            <th nowrap>Nama Barang</th>
                                            <th nowrap>Posisi</th>
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
                    <div class="card">
                        <div class="card-header bg-info border border-secondary">
                            <h5><i class='fa fa-cart-plus'></i> Keranjang Pemindahan</h5>
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
                                                <th nowrap>Kondisi</th>
                                                <th nowrap>#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="show_cart_pemindahan">
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
                            <h5 class="text-center">Riwayat Pemindahan Barang</h5>
                            <br><div class="alert alert-info"><a href="<?= base_url('backend/laporan-pemindahan'); ?>" class="btn btn-danger btn-sm text-decoration-none"><b>Klik Disini</b></a> Untuk Melihat Laporan Pemindahan Barang</div>
                            <div id="load_edit" class="text-center"></div>
                        </div>
                        <div class="card-body">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-striped table-sm" id="table-pindah">
                                    <thead class="bg-secondary text-center">
                                        <tr>
                                            <th width="5%" nowrap>No</th>
                                            <th nowrap>KODE PINDAH</th>
                                            <th nowrap>TGL PINDAH</th>
                                            <th nowrap>KE RUANG</th>
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
                <h5 class="modal-title">Detail Pemindahan Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mt-2">
                        <div class="col-md-2 text-bold">KODE PINDAH</div>
                        <div class="col-md-4" id="kode_pindah_detail"></div>
                        <div class="col-md-2 text-bold">TGL PINDAH</div>
                        <div class="col-md-4" id="tgl_pindah_detail"></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2 text-bold">KE RUANG</div>
                        <div class="col-md-10" id="ruang_detail"></div>
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
                                            <th nowrap>KONDISI BARANG</th>
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