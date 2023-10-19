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
                    <button onclick="add_user()" class="btn bg-primary btn-sm"><i class="fa fa-plus"></i> TAMBAH USER</button>
                    <button onclick="reload_table()" class="btn bg-maroon btn-sm"><i class="fas fa-sync-alt"></i> REFRESH</button>
                    <br><br>
                    <h3 class="text-center"><?= strtoupper($title); ?></h3>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-bordered table-striped table-sm" id="table-users">
                            <thead class="bg-secondary text-center">
                                <tr>
                                    <th width="5%">NO</th>
                                    <th>NAMA</th>
                                    <th>NIP</th>
                                    <th>USERNAME</th>
                                    <th>EMAIL</th>
                                    <th>LEVEL</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
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
                    <input type="hidden" value="" name="id_user"/> 
                    <div class="form-body">
                        <div class="form-group row">
                            <label for="nama_tambah" class="col-md-3 col-form-label">NAMA <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type='text' name='nama' id="nama_tambah" maxlength="100" class='form-control required' placeholder='Nama'>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nip_tambah" class="col-md-3 col-form-label">NIP</label>
                            <div class="col-md-9">
                                <input type='text' name='nip' id="nip_tambah" maxlength="50" class='form-control' placeholder='NIP'>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username_tambah" class="col-md-3 col-form-label">USERNAME <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type='text' name='username' id="username_tambah" class='form-control sepasi required' minlength="5" maxlength="30" placeholder='Username' autocomplete="off">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password1_tambah" class="col-md-3 col-form-label">PASSWORD <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type='password' name='password1' id="password1_tambah" class='form-control sepasi required' minlength="5" maxlength="30" placeholder='Password' autocomplete="off">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password2_tambah" class="col-md-3 col-form-label">ULANG PASSWORD <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type='password' name='password2' id="password2_tambah" class='form-control sepasi required' minlength="5" maxlength="30" placeholder='Ulang Password' autocomplete="off">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_tambah" class="col-md-3 col-form-label">EMAIL <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type='email' name='email' id="email_tambah" minlength="5" maxlength="100" class='form-control sepasi required' placeholder='Email'>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="level_tambah" class="col-md-3 col-form-label">LEVEL USER <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="level" class="form-control" id="level_tambah">
                                    <option value="operator">Operator</option>
                                    <option value="ks">KS</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="is_active_tambah" class="col-md-3 col-form-label">STATUS AKTIF <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="is_active" class="form-control" id="is_active_tambah">
                                    <option value="1">Aktif</option>
                                    <option value="0">Non Aktif</option>
                                </select>
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
                <button type="button" id="btnSave" onclick="save_user()" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_edit" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_edit" class="form-horizontal">
                    <input type="hidden" value="" name="id_user"/> 
                    <div class="form-body">
                        <div class="form-group row">
                            <label for="nama_edit" class="col-md-3 col-form-label">NAMA <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type='text' name='nama' id="nama_edit" maxlength="100" class='form-control required' placeholder='Nama'>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nip_edit" class="col-md-3 col-form-label">NIP</label>
                            <div class="col-md-9">
                                <input type='text' name='nip' id="nip_edit" maxlength="50" class='form-control' placeholder='NIP'>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username_edit" class="col-md-3 col-form-label">USERNAME <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type='text' name='username' id="username_edit" class='form-control sepasi required' minlength="5" maxlength="30" placeholder='Username' autocomplete="off">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_edit" class="col-md-3 col-form-label">PASSWORD</label>
                            <div class="col-md-9">
                                <input type='password' name='password' id="password_edit" class='form-control sepasi' minlength="5" maxlength="30" placeholder='* Kosongkan jika password tidak ingin diganti.' autocomplete="off">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_edit" class="col-md-3 col-form-label">EMAIL <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type='email' name='email' id="email_edit" minlength="5" maxlength="100" class='form-control sepasi required' placeholder='Email'>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="level_edit" class="col-md-3 col-form-label">LEVEL USER <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="level" id="level_edit" class="form-control">
                                    <option value="operator">Operator</option>
                                    <option value="ks">KS</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="is_active_edit" class="col-md-3 col-form-label">STATUS AKTIF <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select name="is_active" id="is_active_edit" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Non Aktif</option>
                                </select>
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
                <button type="button" id="btnSaveEdit" onclick="save_user_edit()" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->