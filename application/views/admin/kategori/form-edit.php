<form class="form-horizontal" method="post" action="<?= site_url('kategori/edit') ?>">
    <input type="hidden" name="id" value="<?= $kategori->idKat; ?>">
    <div class="card-body">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 col-form-label">Nama Kategori</label>
            <div class="col-sm-9">
                <input type="text" name="namaKat" value="<?= $kategori->namaKat; ?>" class="form-control" id="namaKat" placeholder="Nama Kategori">
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="btn btn-info float-right">Simpan</button>
    </div>
    <!-- /.card-footer -->
</form>