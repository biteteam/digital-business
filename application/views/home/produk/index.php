<div class="container-fluid pt-5">
    <div class="text-center d-flex flex-column justify-content-center align-items-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">
                <?php if ($toko->idKonsumen == $this->session->userdata("idKonsumen")) : ?>
                    Data Produk
                <?php else : ?>
                    Produk <?= $toko->namaToko ?>
                <?php endif ?>
            </span></h2>
        <img class="img-fluid" style="width: 10%;" src="<?= base_url("/assets/logo_toko/{$toko->logo}") ?>" alt="<?= $toko->namaToko ?>">
    </div>
    <div class="row px-xl-5">
        <div class="col-lg-12 mb-5">

            <?php if ($toko->idKonsumen == $this->session->userdata("idKonsumen")) : ?>
                <a href="<?= site_url('produk/add/' . $idToko) ?>" class="btn btn-sm btn-info float-left">Tambah Produk</a>
            <?php endif ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Berat</th>
                        <th scope="col">Deskripsi</th>
                        <?php if ($toko->idKonsumen == $this->session->userdata("idKonsumen")) : ?>
                            <th scope="col">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $num = 1 ?>
                    <?php foreach ($produk as $pd) : ?>
                        <tr>
                            <td scope="row"><?= $num ?></td>
                            <td><?= $pd->namaProduk ?></td>
                            <td>
                                <a href="<?= base_url("/detail-produk/{$pd->idProduk}") ?>">
                                    <img src="<?= base_url('assets/foto_produk/' . $pd->foto) ?>" width="100" height="auto" />
                                </a>
                            </td>
                            <td class="text-truncate"><?= rp($pd->harga) ?></td>
                            <td><?= $pd->stok ?></td>
                            <td><?= $pd->berat ?></td>
                            <td><?= $pd->deskripsiProduk ?></td>
                            <?php if ($toko->idKonsumen == $this->session->userdata("idKonsumen")) : ?>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a type="button" class="btn btn-secondary" href="<?= site_url("produk/{$pd->idToko}/edit/{$pd->idProduk}"); ?>">Edit</a>
                                        <a href="<?= site_url('produk/delete/' . $pd->idProduk . "/" . $pd->idToko); ?>" onclick="return confirm('Yakin Akan Hapus Data Ini?')">
                                            <button type="button" class="btn btn-secondary">Hapus</button>
                                        </a>
                                </td>
                            <?php endif ?>
                            <?php $num++ ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>