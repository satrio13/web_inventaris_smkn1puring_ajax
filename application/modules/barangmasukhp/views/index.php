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
                            <button onclick="add_barangmasukhp()" class="btn bg-primary btn-sm"><i class="fa fa-plus"></i> TAMBAH DATA</button>
                            <a href="<?= base_url('backend/export-barangmasukhp'); ?>" class="btn bg-navy btn-sm"><i class="fa fa-file-excel"></i> EXPORT DATA EXCEL</a>
                            <a href="<?= base_url("backend/cetak-barangmasukhp-pdf"); ?>" target="_blank" class="btn bg-info btn-sm"><i class="fa fa-print"></i> CETAK PDF</a>
                            <a href="<?= base_url("backend/cetak-barangmasukhp"); ?>" target="_blank" class="btn bg-purple btn-sm"><i class="fa fa-print"></i> CETAK</a>
                            <button onclick="reload_table()" class="btn bg-maroon btn-sm"><i class="fas fa-sync-alt"></i> REFRESH</button>
                            <br><br>
                            <h3 class="text-center"><?= strtoupper($title); ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-striped table-sm" id="table-barangmasukhp">
                                    <thead class="bg-secondary text-center">
                                        <tr>
                                            <th width="5%" nowrap>NO</th>
                                            <th nowrap>KODE BARANG</th>
                                            <th nowrap>NAMA BARANG</th>
                                            <th nowrap>KATEGORI</th>
                                            <th nowrap>TGL MASUK</th>
                                            <th nowrap>JML MASUK</th>
                                            <th nowrap>SATUAN</th>
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
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id_masukhp"/> 
                    <div class="form-body">
                        <div class="form-group row">
                            <label for="id_baranghp" class="col-md-3 col-form-label">NAMA BARANG <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="id_baranghp" id="id_baranghp" class="form-control required">
                                <?php foreach($baranghp as $r): ?>
                                    <option value="<?= $r->id_baranghp; ?>" ><?= $r->barang; ?></option>
                                <?php endforeach; ?>
                                </select>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl_masuk" class="col-md-3 col-form-label">TGL MASUK <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control required" placeholder="TGL MASUK">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jml_masuk" class="col-md-3 col-form-label">JML MASUK <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="number" name="jml_masuk" id="jml_masuk" min="0" class="form-control required" placeholder="JML MASUK">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-3 col-md-9">
                                <span class="text-danger"><b>*</b></span>) Field Wajib Diisi
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_barangmasukhp()" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->