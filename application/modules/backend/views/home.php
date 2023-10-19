<div class="container">
    <div class="content-wrapper bg-white">
        <div class="content-header">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb ml-2">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="text-dark ml-2"><?= $title; ?></h1>
                </div>
            </div>
        </div>
        <section class="content bg-white">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-bold">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="10%">Nama</td>
                                <td>: <?= nama_user($this->session->userdata('id_user')); ?></td>
                            </tr>
                            <tr>
                                <td>Level</td>
                                <td>: <?= level_user($this->session->userdata('id_user')); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box border border-secondary">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cubes"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold"><a href="<?= base_url('backend/baranghp'); ?>">BARANG HABIS PAKAI</a></span>
                                <span class="info-box-number"><?= $jml_baranghp; ?> data</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box border border-secondary">
                            <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-cubes"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold"><a href="<?= base_url('backend/baranginv'); ?>">BARANG INVENTARIS</a></span>
                                <span class="info-box-number"><?= $jml_baranginv; ?> data</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box border border-secondary">
                            <span class="info-box-icon bg-orange elevation-1"><i class="fas fa-tags text-white"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold"><a href="<?= base_url('backend/kategori'); ?>">KATEGORI BARANG</a></span>
                                <span class="info-box-number"><?= $jml_kategori; ?> data</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card border border-secondary">
                            <div class="card-header">
                                <h3 class="card-title text-bold">10 PENGAMBILAN TERAKHIR</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>                  
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Kode Ambil</th>
                                            <th>Nama Pengambil</th>
                                            <th>Tgl Ambil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $no = 1; 
                                    if($pengambilan->num_rows() > 0)
                                    {
                                        foreach($pengambilan->result() as $r): 
                                            echo'<tr>
                                                    <td>'.$no++.'</td>
                                                    <td>
                                                        <a href="javascript:void(0)" data="'.$r->kode_trans.'" class="text-bold item_detail_pengambilan" title="LIHAT DETAIL">'.$r->kode_trans.'</a>
                                                    </td>
                                                    <td>'.$r->nama_pengambil.'</td>
                                                    <td>'.date('d-m-Y', strtotime($r->tgl_keluar)).'</td>
                                                </tr>';
                                        endforeach;
                                    }else
                                    {
                                        echo'<tr>
                                                <td class="text-center" colspan="4">data kosong</td>
                                            </tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border border-secondary">
                            <div class="card-header">
                                <h3 class="card-title text-bold">10 PEMINDAHAN TERAKHIR</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>                  
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Kode Pindah</th>
                                            <th>Tgl Pindah</th>
                                            <th>Ke Ruang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $no = 1; 
                                    if($pemindahan->num_rows() > 0)
                                    {
                                        foreach($pemindahan->result() as $r): 
                                            echo'<tr>
                                                    <td>'.$no++.'</td>
                                                    <td>
                                                        <a href="javascript:void(0)" data="'.$r->kode_pindah.'" class="text-bold item_detail_pemindahan" title="LIHAT DETAIL">'.$r->kode_pindah.'</a>
                                                    </td>
                                                    <td>'.date('d-m-Y', strtotime($r->tgl_pindah)).'</td>
                                                    <td>'.$r->ruang.'</td>
                                                </tr>';
                                        endforeach;
                                    }else
                                    {
                                        echo'<tr>
                                                <td class="text-center" colspan="4">data kosong</td>
                                            </tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="modal fade" id="modal_detail_pengambilan" role="dialog">
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
                        <div class="col-md-12 text-right" id="link_cetak_pengambilan">
                           
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
                                    <tbody id="show_detail_pengambilan">
                                        
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

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_detail_pemindahan" role="dialog">
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
                        <div class="col-md-12 text-right" id="link_cetak_pemindahan">
                           
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
                                    <tbody id="show_detail_pemindahan">

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