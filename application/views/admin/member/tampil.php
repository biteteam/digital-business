<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Simple Tables</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Simple Tables</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- <div class="row">
        <div class="col-md-6">
          
      </div> -->
      <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Member</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Username</th>
                  <th>Nama Konsumen</th>
                  <th>Email</th>
                  <th>No Telepon</th>
                  <th>Alamat</th>
                  <th>Status Aktif</th>
                  <th style="width: 200px">Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php $no=1; ?>
              <?php foreach ($member as $konsumen): ?>
                <tr>
                  <td><?= $no ?></td>
                  <td><?= $konsumen->username ?></td>
                  <td><?= $konsumen->namaKonsumen ?></td>
                  <td><?= $konsumen->email ?></td>
                  <td><?= $konsumen->tlpn ?></td>
                  <td><?= $konsumen->alamat ?></td>
                  <td><?= ($konsumen->statusAktif == "Y") ? "Aktif" : "Tidak Aktif" ?></td>
                  <td>
                    <div class="btn-group">
                      <a href="<?= site_url('member/ubah_status/' . $konsumen->idKonsumen) ?>" class="btn btn-warning">Ubah Status</a>  
                      <a href="<?= site_url('member/delete/' . $konsumen->idKonsumen) ?>" onclick="return confirm('Yakin akan hapus data ini?')" class="btn btn-danger">Hapus</a>
                    </div>
                  </td>
                </tr>
                <?php $no++; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <a href="<?= site_url('kategori/add') ?>" class="btn btn-info">Tambah Kategori</a>
            <ul class="pagination pagination-sm m-0 float-right">
              <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
          </div>
        </div>
        <!-- /.card -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->]