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
                            <button onclick="add_perbaikan()" class="btn bg-primary btn-sm"><i class="fa fa-plus"></i> TAMBAH DATA</button>
                            <a href="<?= base_url('backend/export-perbaikan'); ?>" class="btn bg-navy btn-sm"><i class="fa fa-file-excel"></i> EXPORT DATA EXCEL</a>
                            <a href="<?= base_url("backend/cetak-perbaikan-pdf"); ?>" target="_blank" class="btn bg-info btn-sm"><i class="fa fa-print"></i> CETAK PDF</a>
                            <a href="<?= base_url("backend/cetak-perbaikan"); ?>" target="_blank" class="btn bg-purple btn-sm"><i class="fa fa-print"></i> CETAK</a>
                            <button onclick="reload_table()" class="btn bg-maroon btn-sm"><i class="fas fa-sync-alt"></i> REFRESH</button>
                            <br><br>
                            <h3 class="text-center"><?= strtoupper($title); ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="table table-responsive">
                                <table class="table table-bordered table-striped table-sm" id="table-perbaikan">
                                    <thead class="bg-secondary text-center">
                                        <tr>
                                            <th width="5%" nowrap>NO</th>
                                            <th nowrap>KODE BARANG</th>
                                            <th nowrap>NAMA BARANG</th>
                                            <th nowrap>TGL DIPERBAIKI</th>
                                            <th nowrap>NAMA MEMPERBAIKI</th>
                                            <th nowrap>NO HP</th>
                                            <th nowrap>HASIL PERBAIKAN</th>
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
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group row">
                            <label for="id_baranginv" class="col-md-4 col-form-label">BARANG <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="id_baranginv" id="id_baranginv" class="form-control required">
                                    <?php foreach($barang as $r): ?>
                                        <option value="<?= $r->id_baranginv; ?>"><?= $r->kode_inv.' - '.$r->barang; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl" class="col-md-4 col-form-label">TGL DIPERBAIKI <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="date" name="tgl" id="tgl" class="form-control required" placeholder="TGL DIPERBAIKI">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="siapa" class="col-md-4 col-form-label">NAMA YANG MEMPERBAIKI <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="siapa" id="siapa" maxlength="50" class="form-control required" placeholder="NAMA YANG MEMPERBAIKI">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="no_hp" class="col-md-4 col-form-label">NO HP YANG MEMPERBAIKI <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="no_hp" id="no_hp" maxlength="20" class="form-control required" placeholder="NO HP YANG MEMPERBAIKI">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="id_kondisi" class="col-md-4 col-form-label">HASIL PERBAIKAN <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="id_kondisi" id="id_kondisi" class="form-control required">
                                    <?php foreach($kondisi as $r): ?>
                                        <option value="<?= $r->id_kondisi; ?>"><?= $r->kondisi; ?></option>
                                    <?php endforeach; ?>
                                </select>
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
                <button type="button" id="btnSave" onclick="save_perbaikan()" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->