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
                <div class="card-header bg-info">
                    <?php echo form_open('backend/rekap-barang-per-ruang'); ?>
                        <div class="row">
                          <div class="col-md-3 text-bold p-1">
                            <select name="id_ruang" class="form-control-sm col-md-12">
                              <?php foreach($ruang as $r): ?>
                                <option value="<?= $r->id_ruang; ?>" <?= set_select('id_ruang',$r->id_ruang); ?> ><?= $r->ruang; ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          <div class="col-md-3 p-1">
                            <button type="submit" name="submit" value="Submit" class="btn bg-danger btn-sm border border-white"><i class="fa fa-search"></i> Cari Data</button>
                          </div>
                        </div>
                    <?php echo form_close(); ?>
                    </div>
                    <div class="card-body">
                      <h3 class="text-center"><?= strtoupper($title); ?></h3>
                      <div class="table table-responsive">
                        <?php if(isset($submit)){ ?>
                          <table class="table" width="100%">
                            <tr>
                              <td width="15%" class="text-bold">NOMOR RUANG</td>
                              <td width="2%" class="text-bold">:</td>
                              <td><?= nomor_ruang($id_ruang); ?></td>
                            </tr>
                            <tr>
                              <td width="15%" class="text-bold">RUANG</td>
                              <td width="2%" class="text-bold">:</td>
                              <td><?= ruang($id_ruang); ?></td>
                            </tr>
                          </table>
                          <a href="<?= base_url("backend/export-rekap-barang-per-ruang/$id_ruang"); ?>" target="_blank" class="btn bg-navy btn-sm mb-2"><i class="fa fa-file-excel"></i> EXPORT DATA EXCEL</a>
                          <a href="<?= base_url("backend/cetak-rekap-barang-per-ruang-pdf/$id_ruang"); ?>" target="_blank" class="btn bg-primary btn-sm mb-2"><i class="fa fa-print"></i> CETAK PDF</a>
                          <a href="<?= base_url("backend/cetak-rekap-barang-per-ruang/$id_ruang"); ?>" target="_blank" class="btn bg-purple btn-sm mb-2"><i class="fa fa-print"></i> CETAK</a>
                        <?php } ?>
                        <table class="table table-bordered table-striped table-sm">
                          <thead class="bg-secondary text-center">
                            <tr>
                                <th width="5%">NO</th>
                                <th nowrap>KATEGORI BARANG</th>
                                <th nowrap>JUMLAH</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php 
                          if(isset($submit))
                          {
                            if($data->num_rows() > 0)
                            {
                              $no = 1;
                              foreach($data->result() as $r):
                              echo'<tr>
                                    <td class="text-center">'.$no++.'</td>
                                    <td>'.$r->kategori.'</td>
                                    <td>'.$r->jml.' '.$r->satuan.'</td>
                                  </tr>';
                              endforeach;
                            }else
                            {
                              echo'<tr>
                                  <td colspan="3" class="text-center">DATA KOSONG</td>
                                </tr>';
                            }
                          }else
                          {
                            echo'<tr>
                                  <td colspan="3" class="text-center">ANDA BELUM MELAKUKAN PENCARIAN</td>
                                </tr>';
                          }
                          ?>
                          </tbody>
                        </table>
                    </div>
                </div>
              </div>
          </div>
        </section>
    </div>