<!-- Section Toko Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Edit Toko</span></h2>
    </div>
    <div class="row px-xl-5" style="display: flex; justify-content: center;">
        <div class="col-lg-7 mb-5">
            <div class="contact-form">
                <div id="success"></div>
                <?= form_open_multipart('toko/edit') ?>
                <input type="hidden" name="idToko" value="<?= $toko->idToko ?>" />
                <input type="hidden" name="logo_filename" value="<?= $toko->logo ?>" />
                <div class="control-group mb-3">
                    <input type="text" class="form-control" value="<?= set_value('namaToko', $toko->namaToko) ?>" id="name" name="namaToko" placeholder="Nama Toko" />
                    <span class="text-danger"><small><?= form_error('namaToko') ?></small></span>
                </div>
                <div class="control-group mb-3">
                    <input type="file" accept=".jpg,.jpeg,.png,.gif,.ico,.svg,.webp" class="form-control" value="<?= set_value('logo', $toko->logo) ?>" id="logo" name="logo" placeholder="Logo" />
                    <span class="text-danger"><small><?= form_error('logo') ?></small></span>
                </div>
                <div class="control-group mb-3">
                    <textarea class="form-control" rows="3" id="message" name="deskripsi" placeholder="Deskripsi"><?= set_value('deskripsi', $toko->deskripsi) ?></textarea>
                    <span class="text-danger"><small><?= form_error('deskripsi') ?></small></span>
                </div>
                <div>
                    <p class="text-danger"><?= $this->session->flashdata('error') ?></p>
                    <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Simpan Perubahan</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<!-- Section Toko End -->