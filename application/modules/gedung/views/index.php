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
                            <button onclick="add_gedung()" class="btn bg-primary btn-sm"><i class="fa fa-plus"></i> TAMBAH GEDUNG</button>
                            <a href="<?= base_url("backend/cetak-gedung-pdf"); ?>" target="_blank" class="btn bg-info btn-sm"><i class="fa fa-print"></i> CETAK PDF</a>
                            <a href="<?= base_url("backend/cetak-gedung"); ?>" target="_blank" class="btn bg-purple btn-sm"><i class="fa fa-print"></i> CETAK</a>
                            <button onclick="reload_table()" class="btn bg-maroon btn-sm"><i class="fas fa-sync-alt"></i> REFRESH</button>
                            <br><br>
                            <h3 class="text-center"><?= strtoupper($title); ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-striped table-sm" id="table-gedung">
                                    <thead class="bg-secondary text-center">
                                        <tr>
                                            <th width="5%" nowrap>NO</th>
                                            <th nowrap>NAMA GEDUNG</th>
                                            <th nowrap>LUAS</th>
                                            <th nowrap>TAHUN</th>
                                            <th nowrap>SUMBERDANA</th>
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
                    <input type="hidden" value="" name="id_gedung"/> 
                    <div class="form-body">
                        <div class="form-group row">
                            <label for="nama_gedung" class="col-md-3 col-form-label">NAMA GEDUNG <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="nama_gedung" id="nama_gedung" maxlength="100" class="form-control required" placeholder="NAMA GEDUNG">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="luas" class="col-md-3 col-form-label">LUAS</label>
                            <div class="col-md-9">
                                <input type="text" name="luas" id="luas" maxlength="50" class="form-control" placeholder="LUAS">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tahun_p" class="col-md-3 col-form-label">TAHUN</label>
                            <div class="col-md-9">
                                <input type="text" name="tahun_p" id="tahun_p" maxlength="4" class="form-control" placeholder="TAHUN" onkeypress="return hanyaAngka(event)">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sumberdana" class="col-md-3 col-form-label">SUMBERDANA</label>
                            <div class="col-md-9">
                                <input type="text" name="sumberdana" id="sumberdana" maxlength="80" class="form-control" placeholder="SUMBERDANA">
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
                <button type="button" id="btnSave" onclick="save_gedung()" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->