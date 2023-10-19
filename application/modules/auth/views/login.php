<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>APLIKASI MANAJEMEN BARANG SMK NEGERI 1 PURING</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?= base_url(); ?>assets/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/AdminLTE-3.0.2/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/AdminLTE-3.0.2/dist/css/adminlte.min.css">
  <style>
    #particles {
        width: 100%;
        height: 100%;
        overflow: hidden;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        position: absolute;
        z-index: -2;
    }
  </style>
</head>
<body class="hold-transition login-page">
    <div id="particles"></div>
        <div class="login-box">
            <div class="card">
                <div class="card-body login-card-body text-center">
                    <img src="<?= base_url(); ?>assets/img/logo_smkn1puring.png" width="150px" class="img img-responsive">
                    <p class="login-box-msg"><h5><b>APLIKASI MANAJEMEN BARANG<br>SMK NEGERI 1 PURING</b></h5></p>
                    <?php if($this->session->flashdata('msg-lg')) { ?>
                        <div class="alert alert-danger alert-message alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-exclamation-triangle"></i> <?= $this->session->flashdata('msg-lg'); ?>
                        </div>
                    <?php } ?>
                    <?php if(!empty($this->input->post('submit', TRUE))){ ?>
                        <?php if($this->form_validation->run() == FALSE){ ?>
                        <div class="callout callout-danger alert-message">
                            <p class="text-left"><?= form_error('username'); ?></p>
                            <p class="text-left"><?= form_error('password'); ?></p>
                        </div>
                        <?php } ?>
                    <?php } ?>
                
                    <?php echo form_open('auth/login'); ?>
                    <div class="input-group mb-3">
                        <input type="text" name="username" maxlength="30" minlength="5" class="form-control sepasi" placeholder="Username" autocomplete="off" value="<?= set_value('username'); ?>" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" maxlength="30" minlength="5" class="form-control sepasi" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="submit" value="Submit" class="btn btn-info text-white btn-block btn-flat"><i class="fa fa-sign-in-alt"></i> LOG IN</button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
        <p class="text-center">
            <?php
            $tahun_sekarang = '2020';
            $tahun_besok = date('Y');
            if($tahun_besok > $tahun_sekarang){ ?>
            &copy; <?= $tahun_sekarang; ?> - <?= $tahun_besok; ?>
            <?php }else{ ?>
            &copy; <?php echo $tahun_besok; ?>
            <?php } ?>
            by SMK NEGERI 1 PURING
        </p>
<script src="<?= base_url(); ?>assets/AdminLTE-3.0.2/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/AdminLTE-3.0.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/AdminLTE-3.0.2/dist/js/adminlte.min.js"></script>
<script src="<?= base_url(); ?>assets/js/login.js"></script>
</body>
</html>