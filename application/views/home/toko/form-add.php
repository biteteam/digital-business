<!-- Section Toko Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Tambah Toko</span></h2>
    </div>
    <div class="row px-xl-5" style="display: flex; justify-content: center;">
        <div class="col-lg-7 mb-5">
            <div class="contact-form">
                <div id="success"></div>
                <?= form_open_multipart('toko/save') ?>
                <div class="control-group mb-3">
                    <input type="text" class="form-control" id="name" name="namaToko" value="<?= set_value('namaToko') ?>" placeholder="Nama Toko" />
                    <span class="text-danger"><small><?= form_error('namaToko') ?></small></span>
                </div>
                <div class="control-group mb-3">
                    <input type="file" accept=".jpg,.jpeg,.png,.gif,.ico,.svg,.webp" class="form-control" id="logo" name="logo" value="<?= set_value('logo') ?>" />
                    <span class="text-danger"><small><?= form_error('logo') ?></small></span>
                </div>
                <div class="control-group mb-3">
                    <textarea class="form-control" rows="3" id="message" name="deskripsi" placeholder="Deskripsi"><?= set_value('deskripsi') ?></textarea>
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
<!-- Section Toko End -->