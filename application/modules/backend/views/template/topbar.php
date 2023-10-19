<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <img src="<?= base_url(); ?>assets/img/logo_smkn1puring.png" class="brand-image">
      <span class="d-block d-sm-none"><b>SMK N 1 PURING</b></span>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="nav navbar-nav">
          <li class="nav-item">
            <a href="<?= base_url(); ?>" class="nav-link">
              <?php 
              if($this->uri->segment('2') == '')
              { 
                echo'<span class="text-info text-bold"><i class="fa fa-home"></i> Home</span>'; }else{ echo'<i class="fa fa-home"></i> Home'; 
              } 
              ?>
            </a>
          </li>

          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
              <?php 
              if( ($this->uri->segment('2') == 'pengurusbarang') OR ($this->uri->segment('2') == 'edit-pengurusbarang') OR ($this->uri->segment('2') == 'tahun') OR ($this->uri->segment('2') == 'tambah-tahun') OR ($this->uri->segment('2') == 'edit-tahun') OR ($this->uri->segment('2') == 'ruang') OR ($this->uri->segment('2') == 'tambah-ruang') OR ($this->uri->segment('2') == 'edit-ruang') OR ($this->uri->segment('2') == 'tanah') OR ($this->uri->segment('2') == 'tambah-tanah') OR ($this->uri->segment('2') == 'edit-tanah') OR ($this->uri->segment('2') == 'gedung') OR ($this->uri->segment('2') == 'tambah-gedung') OR ($this->uri->segment('2') == 'edit-gedung') OR ($this->uri->segment('2') == 'kategori') OR ($this->uri->segment('2') == 'tambah-kategori') OR ($this->uri->segment('2') == 'edit-kategori') OR ($this->uri->segment('2') == 'kondisi') OR ($this->uri->segment('2') == 'tambah-kondisi') OR ($this->uri->segment('2') == 'edit-kondisi') OR ($this->uri->segment('2') == 'baranghp') OR ($this->uri->segment('2') == 'tambah-baranghp') OR ($this->uri->segment('2') == 'edit-baranghp') OR ($this->uri->segment('2') == 'form-baranghp')
              OR ($this->uri->segment('2') == 'baranginv') OR ($this->uri->segment('2') == 'tambah-baranginv') OR ($this->uri->segment('2') == 'edit-baranginv') OR ($this->uri->segment('2') == 'form-baranginv') )
              { 
                echo'<span class="text-info text-bold"><i class="fa fa-database"></i> Master Data</span>'; 
              }else
              { 
                echo'<i class="fa fa-database"></i> Master Data'; 
              } 
              ?>
            </a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="<?= base_url('backend/pengurusbarang'); ?>" class="dropdown-item">Pengurus Barang </a></li>
              <li><a href="<?= base_url('backend/tahun'); ?>" class="dropdown-item">Tahun</a></li>
              <li><a href="<?= base_url('backend/ruang'); ?>" class="dropdown-item">Ruang</a></li>
              <li><a href="<?= base_url('backend/tanah'); ?>" class="dropdown-item">Tanah</a></li>
              <li><a href="<?= base_url('backend/gedung'); ?>" class="dropdown-item">Gedung</a></li>
              <li><a href="<?= base_url('backend/kategori'); ?>" class="dropdown-item">Kategori Barang</a></li>
              <li><a href="<?= base_url('backend/baranghp'); ?>" class="dropdown-item">Barang Habis Pakai</a></li>
              <li><a href="<?= base_url('backend/baranginv'); ?>" class="dropdown-item">Barang Inventaris</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
              <?php 
              if( ($this->uri->segment('2') == 'barangmasukhp') OR ($this->uri->segment('2') == 'tambah-barangmasukhp') OR ($this->uri->segment('2') == 'edit-barangmasukhp') OR ($this->uri->segment('2') == 'pengambilan') OR ($this->uri->segment('2') == 'detail-pengambilan') OR ($this->uri->segment('2') == 'pemindahan') OR ($this->uri->segment('2') == 'detail-pemindahan') )
              { 
                echo'<span class="text-info text-bold"><i class="fa fa-cubes"></i> Manajemen Barang</span>'; 
              }else
              { 
                echo'<i class="fa fa-cubes"></i> Manajemen Barang'; 
              } 
              ?>
            </a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="<?= base_url('backend/barangmasukhp'); ?>" class="dropdown-item">Barang Masuk Habis Pakai</a></li>
              <li><a href="<?= base_url('backend/pengambilan'); ?>" class="dropdown-item">Ambil Barang Habis Pakai</a></li>
              <li><a href="<?= base_url('backend/pemindahan'); ?>" class="dropdown-item">Pindah Barang Habis Inventaris</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
              <?php 
              if( ($this->uri->segment('2') == 'laporan-stok') OR ($this->uri->segment('2') == 'laporan-pembelian') OR ($this->uri->segment('2') == 'laporan-pengambilan') OR ($this->uri->segment('2') == 'laporan-pemindahan') OR ($this->uri->segment('2') == 'daftar-barang-per-ruang') OR ($this->uri->segment('2') == 'rekap-barang-per-ruang') )
              { 
                echo'<span class="text-info text-bold"><i class="fa fa-book"></i> Laporan</span>'; 
              }else
              { 
                echo'<i class="fa fa-book"></i> Laporan'; 
              } 
              ?> 
            </a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="<?= base_url('backend/laporan-stok'); ?>" class="dropdown-item">Laporan Stok Barang</a></li>
              <li><a href="<?= base_url('backend/laporan-pembelian'); ?>" class="dropdown-item">Laporan Pembelian</a></li>
              <li><a href="<?= base_url('backend/laporan-pengambilan'); ?>" class="dropdown-item">Laporan Pengambilan Barang</a></li>
              <li><a href="<?= base_url('backend/laporan-pemindahan'); ?>" class="dropdown-item">Laporan Pemindahan Barang</a></li>
              <li><a href="<?= base_url('backend/daftar-barang-per-ruang'); ?>" class="dropdown-item">Daftar Barang Per Ruang</a></li>
              <li><a href="<?= base_url('backend/rekap-barang-per-ruang'); ?>" class="dropdown-item">Rekap Barang Per Ruang</a></li>
            </ul>
          </li>
          
          <?php if($this->session->userdata('level') == 'superadmin'){ ?>
            <li class="nav-item dropdown">
              <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
                <?php 
                if( ($this->uri->segment('2') == 'user') OR ($this->uri->segment('2') == 'tambah-user') OR ($this->uri->segment('2') == 'edit-user') )
                { 
                  echo'<span class="text-info text-bold"><i class="fa fa-users"></i> Manajemen Users</span>'; 
                }else
                { 
                  echo'<i class="fa fa-users"></i> Manajemen Users'; 
                } 
                ?> 
              </a>
              <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <li><a href="<?= base_url('backend/user'); ?>" class="dropdown-item">Master Users</a></li>
              </ul>
            </li>
          <?php } ?>
          
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
              <?php 
              if( ($this->uri->segment('2') == 'perbaikan') OR ($this->uri->segment('2') == 'tambah-perbaikan') OR ($this->uri->segment('2') == 'edit-perbaikan') )
              { 
                echo'<span class="text-info text-bold"><i class="fa fa-medkit"></i> Perawatan</span>'; 
              }else
              { 
                echo'<i class="fa fa-medkit"></i> Perawatan'; 
              } 
              ?>
            </a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="<?= base_url('backend/perbaikan'); ?>" class="dropdown-item">Perbaikan Barang</a></li>
              <li><a href="<?= base_url('backend/backup'); ?>" class="dropdown-item">Backup Database</a></li>
            </ul>
          </li>
        </ul>
        
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle bg-danger"><i class="fa fa-user ml-2"></i></a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="https://bit.ly/2XMsUJj" class="dropdown-item"><i class="fas fa-bug"></i> REPORT BUGS/ERROR</a></li>
              <li><a href="javascript:void(0)" onclick="edit_profil(<?= $this->session->userdata('id_user'); ?>)" class="dropdown-item"><i class="fas fa-user"></i> EDIT PROFIL</a></li>
              <li><a href="javascript:void(0)" onclick="ganti_password(<?= $this->session->userdata('id_user'); ?>)" class="dropdown-item"><i class="fas fa-key"></i> GANTI PASSWORD</a></li>
              <li><a href="<?= base_url('auth/logout'); ?>" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> LOG OUT</a></li>
            </ul>
          </li>
        </ul>
      </div>
  </nav>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_profil" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_profil" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group row">
                            <label for="nama" class="col-md-3 col-form-label">NAMA <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type='text' name='nama' id="nama" maxlength="100" class='form-control required' placeholder='Nama'>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nip" class="col-md-3 col-form-label">NIP</label>
                            <div class="col-md-9">
                                <input type='text' name='nip' id="nip" maxlength="50" class='form-control' placeholder='NIP'>
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-md-3 col-form-label">USERNAME <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type='text' name='username' id="username" class='form-control sepasi required' minlength="5" maxlength="30" placeholder='Username' autocomplete="off">
                                <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label">EMAIL <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type='email' name='email' id="email" minlength="5" maxlength="100" class='form-control sepasi required' placeholder='Email'>
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
                <button type="button" id="btnSaveProfil" onclick="save_profil(<?= $this->session->userdata('id_user'); ?>)" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_password" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_password" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group row">
                            <label for="username_c" class="col-md-4 col-form-label">USERNAME <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                              <input type="text" name="username" id="username_c" minlength="5" maxlength="30" readonly class="form-control sepasi required">
                              <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pass1_c" class="col-md-4 col-form-label">PASSWORD BARU <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                              <input type="password" name="pass1" id="pass1_c" minlength="5" maxlength="30" placeholder="Password Baru" class="form-control sepasi required">
                              <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pass2_c" class="col-md-4 col-form-label">ULANG PASSWORD BARU <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                              <input type="password" name="pass2" id="pass2_c" minlength="5" maxlength="30" placeholder="Ketik Ulang Password Baru" class="form-control sepasi required">
                              <span class="help-block text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pass3_c" class="col-md-4 col-form-label">PASSWORD LAMA <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                              <input type="password" name="pass3" id="pass3_c" minlength="5" maxlength="30" placeholder="Password Lama" class="form-control sepasi required">
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
                <button type="button" id="btnSavePassword" onclick="save_password(<?= $this->session->userdata('id_user'); ?>)" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<script>
  function edit_profil(id_user)
  {
      $('#form_profil')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string

      $.ajax({
          url : base_url + "backend/get_user_by_id/"+id_user,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
              $('[name="id_user"]').val(data.id_user);
              $('[name="nama"]').val(data.nama);
              $('[name="nip"]').val(data.nip);
              $('[name="username"]').val(data.username);
              $('[name="email"]').val(data.email); 
              $('#modal_form_profil').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Form Edit Profil'); 
          },
          error: function (request)
          {
              alert_gagal('An error occurred during your request: ' +  request.status + ' ' + request.statusText);
          }
      });
  }

  function save_profil(id_user)
  {
      $('#btnSaveProfil').text('saving...'); //change button text
      $('#btnSaveProfil').attr('disabled',true); //set button disable 

      $.ajax({
          url : base_url + "backend/edit-profil/"+id_user,
          type: "POST",
          data: $('#form_profil').serialize(),
          dataType: "JSON",
          success: function(data)
          {
              if(data.status == true) 
              {
                  $('#modal_form_profil').modal('hide');
                  alert_sukses(data.message);
              }else
              {
                  for (let i = 0; i < data.inputerror.length; i++) 
                  {
                      $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                      $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                  }
              }
              $('#btnSaveProfil').html('<i class="fa fa-check"></i> Save'); //change button text
              $('#btnSaveProfil').attr('disabled',false); //set button enable 
          },
          error: function (request)
          {
              alert_gagal('Data Gagal Diupdate!' + request.status + ' ' + request.statusText);
              $('#btnSaveProfil').html('<i class="fa fa-check"></i> Save'); //change button text
              $('#btnSaveProfil').attr('disabled',false); //set button enable 
          }
      });
  }

  function ganti_password(id_user)
  {
      $('#form_password')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string

      $.ajax({
          url : base_url + "backend/get_user_by_id/"+id_user,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
              $('[name="username"]').val(data.username);
              $('#modal_form_password').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Form Ganti Password'); 
          },
          error: function (request)
          {
              alert_gagal('An error occurred during your request: ' +  request.status + ' ' + request.statusText);
          }
      });
  }

  function save_password(id_user)
  {
      $('#btnSavePassword').text('saving...'); //change button text
      $('#btnSavePassword').attr('disabled',true); //set button disable 

      $.ajax({
          url : base_url + "backend/ganti-password/"+id_user,
          type: "POST",
          data: $('#form_password').serialize(),
          dataType: "JSON",
          success: function(data)
          {
              if(data.status == true) 
              {
                  $('#modal_form_password').modal('hide');
                  swal("Password berhasil dirubah, silahkan login kembali")
                  .then((value) => {
                    window.location.replace("<?= base_url('auth/logout'); ?>");
                  });                 
              }else
              {
                  for (let i = 0; i < data.inputerror.length; i++) 
                  {
                      $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                      $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                  }
              }
              $('#btnSavePassword').html('<i class="fa fa-check"></i> Save'); //change button text
              $('#btnSavePassword').attr('disabled',false); //set button enable 
          },
          error: function (request)
          {
              alert_gagal('Password Gagal Diupdate!' + request.status + ' ' + request.statusText);
              $('#btnSavePassword').html('<i class="fa fa-check"></i> Save'); //change button text
              $('#btnSavePassword').attr('disabled',false); //set button enable 
          }
      });
  }

  function alert_sukses(str)
  {
      setTimeout(function () { 
          swal({
              position: 'top-end',
              icon: 'success',
              title: str,
              timer: 1500
          });
      },2000); 
  }

  function alert_gagal(str)
  {
      setTimeout(function () { 
          swal({
              position: 'top-end',
              icon: 'error',
              title: str,
              timer: 5000
          });
      },2000); 
  }
</script>