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
            <div class="col-12">
                <div class="card border border-secondary">
                    <div class="card-header">
                        <a href="<?= base_url("backend/export-laporan-stok"); ?>" target="_blank" class="btn bg-navy btn-sm"><i class="fa fa-file-excel"></i> EXPORT DATA EXCEL</a>
                        <a href="<?= base_url("backend/cetak-laporan-stok-pdf"); ?>" target="_blank" class="btn bg-info btn-sm"><i class="fa fa-print"></i> CETAK PDF</a>
                        <a href="<?= base_url("backend/cetak-laporan-stok"); ?>" target="_blank" class="btn bg-purple btn-sm"><i class="fa fa-print"></i> CETAK</a>
                        <a href="" target="_self" class="btn bg-maroon btn-sm"><i class="fas fa-sync-alt"></i> REFRESH</a>
                        <br><br>
                        <h3 class="text-center"><?= strtoupper($title); ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead class="bg-secondary text-center">
                                  <tr>
                                      <th width="5%" nowrap>NO</th>
                                      <th nowrap>KODE BARANG</th>
                                      <th nowrap>NAMA BARANG</th>
                                      <th nowrap>JUMLAH STOK</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($data->num_rows() > 0)
                                {
                                    $no = 1;
                                    foreach($data->result() as $r):
                                        echo'<tr>
                                                <td class="text-center">'.$no++.'</td>
                                                <td>'.$r->kode_hp.'</td>
                                                <td>'.$r->barang.'</td>
                                                <td class="text-right">'.$r->stok.' '.$r->satuan.'</td>
                                            </tr>';
                                    endforeach;
                                }else
                                {   
                                    echo'<tr>
                                            <td class="text-center" colspan="4">DATA KOSONG</td>
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