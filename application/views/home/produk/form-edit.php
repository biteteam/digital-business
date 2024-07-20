<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Form Edit Produk</span></h2>
    </div>
    <div class="row px-xl-5" style="display: flex; justify-content: center;">
        <div class="col-lg-7 mb-5">
            <div class="contact-form">
                <div id="success"></div>
                <?= form_open_multipart("produk/{$idToko}/edit/{$produk->idProduk}") ?>
                <input type="hidden" name="id-toko" value="<?= $idToko ?>" />
                <input type="hidden" name="id-produk" value="<?= $produk->idProduk ?>" />
                <div class="control-group mb-3">
                    <select class="form-control" name="id-kategori">
                        <?php foreach ($kategori as $kt) : ?>
                            <option value="<?= $kt->idKat ?>" <?= $kt->idKat == $produk->idKat ? "selected" : "" ?>><?= $kt->namaKat ?></option>
                        <?php endforeach ?>
                    </select>
                    <span class="text-danger"><small><?= form_error('kategori') ?></small></span>
                </div>
                <div class="control-group mb-3">
                    <input type="text" class="form-control" id="name" name="nama" value="<?= set_value('nama', $produk->namaProduk) ?>" placeholder="Nama Produk" />
                    <span class="text-danger"><small><?= form_error('nama') ?></small></span>
                </div>
                <div class="control-group mb-3">
                    <input type="file" accept=".jpg,.jpeg,.png,.gif,.ico,.svg,.webp" class="form-control" id="foto" name="foto" value="<?= set_value('foto', $produk->foto) ?>" />
                    <span class="text-danger"><small><?= form_error('foto') ?></small></span>
                </div>
                <div class="control-group mb-3">
                    <input type="number" min="1000" step="any" class="form-control" id="harga" name="harga" value="<?= set_value('harga', $produk->harga) ?>" placeholder="Harga" />
                    <span class="text-danger"><small><?= form_error('harga') ?></small></span>
                </div>
                <div class="control-group mb-3">
                    <input type="number" min="0" step="any" class="form-control" id="jumlah" name="stok" value="<?= set_value('stok', $produk->stok) ?>" placeholder="Jumlah Produk" />
                    <span class="text-danger"><small><?= form_error('stok') ?></small></span>
                </div>
                <div class="control-group mb-3">
                    <input type="number" type="number" min="0" step="any" class="form-control" id="berat" name="berat" value="<?= set_value('berat', $produk->berat) ?>" placeholder="Berat Produk" />
                    <span class="text-danger"><small><?= form_error('berat') ?></small></span>
                </div>
                <div class="control-group mb-3">
                    <textarea class="form-control" rows="3" id="deskripsiProduk" name="deskripsi" placeholder="Deskripsi"><?= set_value('deskripsi', $produk->deskripsiProduk) ?></textarea>
                    <span class="text-danger"><small><?= form_error('deskripsi') ?></small></span>
                </div>
                <div>
                    <p class="text-danger"><?= $this->session->flashdata('error') ?></p>
                    <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Simpan</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>