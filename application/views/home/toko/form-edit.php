<!-- Section Toko Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Edit Toko</span></h2>
    </div>
    <div class="row px-xl-5" style="display: flex; justify-content: center;">
        <div class="col-lg-7 mb-5">
            <div class="contact-form">
                <div id="success"></div>
                <form name="sentMessage" method="post" action="<?= base_url('toko/edit') ?>" enctype="multipart/form-data">
                    <input type="hidden" name="idToko" value="<?= $toko->idToko ?>" />
                    <input type="hidden" name="logo_filename" value="<?= $toko->logo ?>" />
                    <div class="control-group">
                        <input type="text" class="form-control" value="<?= $toko->namaToko ?>" id="name" name="namaToko" placeholder="Nama Toko" required="required" data-validation-required-message="Please enter your toko name" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="file" accept=".png,.png,.jpeg" class="form-control" value="<?= $toko->logo ?>" id="logo" name="logo" placeholder="Logo" data-validation-required-message="Please enter your toko logo" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <textarea class="form-control" rows="3" id="message" name="deskripsi" placeholder="Deskripsi" data-validation-required-message="Please enter your toko deskripsi"><?= $toko->deskripsi ?></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Section Toko End -->