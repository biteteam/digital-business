<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Form Tambah Kategori</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('kategori') ?>">Kategori</a></li>
                        <li class="breadcrumb-item active">Tambah Kategori</li>
                        </o1>
                </div>
            </div>
        </div> <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- Horizontal Form -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Data Kategori</h3>
                        </div>
                        <!-- FORM START -->
                        <!-- <form class="form-horizontal" method="post" action="<?= site_url('kategori/save'); ?>"> -->
                        <?= form_open('kategori/save') ?>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Nama Kategori</label>
                                <div class="col-sm-9">
                                    <input type="text" name="namaKat" class="form-control" id="namaKategori" value="<?= set_value('namaKat'); ?>" placeholder="Nama Kategori" />
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <span class="text-danger"><?= $this->session->flashdata('error') ? $this->session->flashdata('error') : form_error('namaKat')  ?></span>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info float-right">Simpan</button>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- </form> -->
                        <?= form_close() ?>
                        <!-- FORM END -->
                    </div>
                </div>
                <!-- /.row -->
            </div> <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>