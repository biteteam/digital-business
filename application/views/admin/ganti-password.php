<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Reset Password</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/dist/css/adminlte.min.css') ?>">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Reset Password</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Ganti password</p>

                <!-- START FORM -->
                <?= form_open('adminpanel/ganti-password'); ?>
                <div class="mb-4">
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" value="<?= set_value('password'); ?>" placeholder="Password Saat Ini">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <small class="text-danger"><?= form_error('password') ?></small>
                </div>
                <div class="mb-2">
                    <div class="input-group">
                        <input type="password" name="new_password" class="form-control" value="<?= set_value('new_password'); ?>" placeholder="Password Baru">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <small class="text-danger"><?= form_error('new_password') ?></small>
                </div>
                <div class="mb-2">
                    <div class="input-group">
                        <input type="password" name="retype_new_password" class="form-control" value="<?= set_value('retype_new_password'); ?>" placeholder="Ulangi Password Baru">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <small class="text-danger"><?= form_error('retype_new_password') ?></small>
                </div>
                <p class="text-danger"><?= $this->session->flashdata('error') ?></p>

                <div class="row justify-content-end">
                    <!-- /.col -->
                    <div class="col-6 pt-2">
                        <button type="submit" class="btn btn-primary btn-block">Ganti Password</button>
                    </div>
                    <!-- /.col -->
                </div>
                <?= form_close() ?>

                <!-- END FORM -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url('assets/admin/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/admin/dist/js/adminlte.min.js') ?>"></script>
</body>

</html>