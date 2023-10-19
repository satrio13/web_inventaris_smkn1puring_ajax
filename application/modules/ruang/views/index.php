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
                            <button onclick="add_ruang()" class="btn bg-primary btn-sm"><i class="fa fa-plus"></i> TAMBAH RUANG</button>
                            <a href="<?= base_url("backend/cetak-ruang-pdf"); ?>" target="_blank" class="btn bg-info btn-sm"><i class="fa fa-print"></i> CETAK PDF</a>
                            <a href="<?= base_url("backend/cetak-ruang"); ?>" target="_blank" class="btn bg-purple btn-sm"><i class="fa fa-print"></i> CETAK</a>
                            <button onclick="reload_table()" class="btn bg-maroon btn-sm"><i class="fas fa-sync-alt"></i> REFRESH</button>
                            <br><br>
                            <h3 class="text-center"><?= strtoupper($title); ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-striped table-sm" id="table-ruang">
                                    <thead class="bg-secondary text-center">
                                        <tr>
                                            <th width="5%" nowrap>NO</th>
                                            <th nowrap>RUANG</th>
                                            <th nowrap>NOMOR</th>
                                            <th nowrap>NAMA PENANGGUNG JAWAB</th>
                                            <th nowrap>NIP PENANGGUNG JAWAB</th>
                                            <th width="15%" nowrap>AKSI</th>
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
                    <input type="hidden" value="" name="id_ruang"/> 
                    <div class="form-body">
                        <div class="form-group row">
                            <label for="ruang" class="col-md-4 col-form-label">RUANG <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="ruang" id="ruang" maxlength="50" class="form-control required" placeholder="RUANG">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nomor" class="col-md-4 col-form-label">NOMOR</label>
                            <div class="col-md-8">
                                <input type="text" name="nomor" id="nomor" maxlength="5" class="form-control" placeholder="NOMOR">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama_pj" class="col-md-4 col-form-label">NAMA PENANGGUNG JAWAB</label>
                            <div class="col-md-8">
                                <input type="text" name="nama_pj" id="nama_pj" maxlength="50" class="form-control" placeholder="NAMA PENANGGUNG JAWAB">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nip_pj" class="col-md-4 col-form-label">NIP PENANGGUNG JAWAB</label>
                            <div class="col-md-8">
                                <input type="text" name="nip_pj" id="nip_pj" maxlength="50" class="form-control" placeholder="NIP PENANGGUNG JAWAB">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-4 col-md-8">
                                <span class="text-danger"><b>*</b></span>) Field Wajib Diisi
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_ruang()" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->