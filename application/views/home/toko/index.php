<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Data Toko</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col-lg-12 mb-5">
            <a href="<?= site_url('toko/add'); ?>" class="btn btn-sm btn-info float-left">Buat Toko</a>
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Toko</th>
                        <th scope="col">Logo</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($toko as $tk) : ?>
                        <tr>
                            <th scope="row"><?= $no; ?></th>
                            <td><?= $tk->namaToko; ?></td>
                            <td><img src="<?= base_url('assets/logo_toko/' . $tk->logo); ?>" width="150" height="110"></td>
                            <td><?= $tk->deskripsi; ?></td>
                            <td>
                                <?php if ($tk->idKonsumen == $this->session->userdata("idKonsumen")) : ?>
                                    <a href="<?= site_url('toko/get-by-id/' . $tk->idToko) ?>" class="btn btn-secondary">Edit</a>
                                    <a href="<?= site_url('produk/' . $tk->idToko) ?>" class="btn btn-secondary">Kelola Toko</a>
                                    <a href="<?= site_url('toko/delete/' . $tk->idToko) ?>" onclick="return confirm('Yakin akan hapus data ini?')" class="btn btn-secondary">Hapus</a>
                                <?php else : ?>
                                    <a href="<?= site_url('produk/' . $tk->idToko) ?>" class="btn btn-secondary">Detail</a>
                                <?php endif ?>
                            </td>
                        </tr>
                        <?php $no++; ?>
                    <?php endforeach ?>
                </tbody>
            </table>

        </div>
    </div>
</div>