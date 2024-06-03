<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Edit Profil</span></h2>
    </div>
    <div class="row px-xl-5 justify-content-center">
        <div class="col-lg-7 mb-5">
            <div class="contact-form">
                <div id="success"></div>
                <?= form_open('profile/edit') ?>
                <div class="control-group mb-3">
                    <input type="text" class="form-control" id="name" name="namaKonsumen" placeholder="Nama Lengkap" value="<?= set_value('namaKonsumen', $member->namaKonsumen) ?>" />
                    <small class="text-danger"><?= form_error('namaKonsumen') ?></small>
                </div>
                <div class="control-group mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= set_value('username', $member->username) ?>" />
                    <small class="text-danger"><?= form_error('username') ?></small>
                </div>
                <div class="control-group mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= set_value('email', $member->email) ?>" />
                    <small class="text-danger"><?= form_error('email') ?></small>
                </div>
                <div class="control-group mb-3">
                    <input type="tel" class="form-control" id="telepon" name="tlpn" placeholder="Telepon" value="<?= set_value('tlpn', $member->tlpn) ?>" />
                    <small class="text-danger"><?= form_error('tlpn') ?></small>
                </div>
                <div class="control-group mb-3">
                    <input type="number" class="form-control" id="idKota" name="idKota" placeholder="Id Kota" value="<?= set_value('idKota', $member->idKota) ?>" />
                    <small class="text-danger"><?= form_error('idKota') ?></small>
                </div>
                <div class="control-group mb-3">
                    <textarea class="form-control" rows="6" id="alamat" name="alamat" placeholder="Alamat"><?= set_value('alamat', $member->alamat) ?></textarea>
                    <small class="text-danger"><?= form_error('alamat') ?></small>
                </div>
                <p class="text-danger"><?= $this->session->flashdata('error') ?></p>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary py-2 px-4" type="submit" id="save">Simpan Perubahan</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>