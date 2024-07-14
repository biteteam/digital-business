<!-- Cart Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-9 w-auto">
            <?php foreach ($carts['items'] as $idx => $cart) : ?>
                <div class="table-responsive <?= $idx == 0 ? "" : "pt-5" ?>">
                    <table class="table table-bordered text-center mb-0 pb-0">
                        <thead class="bg-secondary text-dark">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            <?php foreach ($cart['produk'] as $produk) : ?>
                                <tr>
                                    <td class="align-middle align-items-center justify-content-start d-flex">
                                        <a href="<?= base_url("/detail-produk/{$produk['idProduk']}") ?>"></a>
                                        <img src="<?= site_url('assets/foto_produk/' . $produk['fotoProduk']) ?>" alt="<?= $produk['namaProduk'] ?>" style="width: 50px; border-radius: 10px;">
                                        <p class="m-0 p-0 ml-3"><?= $produk['namaProduk'] ?></p>
                                    </td>
                                    <td class="align-middle text-truncate"><?= rp($produk['hargaProduk']) ?></td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <form action="<?= base_url("/cart/decrase-qty/{$produk['idCart']}") ?>" method="post">
                                                    <button <?= intval($produk['qty']) <= 1  ? "disabled" : ""  ?> type="submit" class="btn btn-sm btn-primary btn-minus">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <input type="text" class="form-control form-control-sm bg-secondary text-center" value="<?= $produk['qty'] ?>">
                                            <div class="input-group-btn">
                                                <form action="<?= base_url("/cart/increase-qty/{$produk['idCart']}") ?>" method="post">
                                                    <button <?= intval($produk['qty']) >= intval($produk['stokProduk'])  ? "disabled" : "" ?> type="submit" class="btn btn-sm btn-primary btn-plus">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-truncate"><?= rp($produk['hargaProdukTotal']) ?></td>
                                    <td class="align-middle"><a href="<?= base_url("/cart/delete/{$produk['idCart']}") ?>" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></a></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-secondary w-100" data-toggle="collapse" href="#detail-<?= $cart['toko']['id_toko'] ?>" style="height: 40px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Detail</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <div class="border bg-secondary border-width-2 border-gray px-2 mb-5 p-2 px-lg-4 pb-lg-4 pt-0 pb-4 collapse" id="detail-<?= $cart['toko']['id_toko'] ?>">
                    <div class="w-100 border-bottom border-width-2 border-primary pb-4">
                        <a href="<?= base_url("/produk/{$cart['toko']['id_toko']}") ?>" class="d-flex align-items-center">
                            <img src="<?= site_url('assets/logo_toko/' . $cart['toko']['logo_toko']) ?>" alt="<?= $cart['toko']['nama_toko'] ?>" style="width: 50px; border-radius: 10px;">
                            <div class="ml-2 d-flex align-items-center align-start">
                                <h5 class="font-weight-semi-bold"><?= $cart['toko']['nama_toko'] ?></h5>
                            </div>
                        </a>
                    </div>
                    <div class="w-100 pt-4 border-bottom border-width-2 border-primary">
                        <div class="d-flex justify-content-between mb-1 p-0">
                            <h6 class="font-weight-medium">Estimasi Tiba</h6>
                            <h6 class="font-weight-medium"><?= $cart['ongkir']['selected']['estimation'] ?> Hari</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-1 p-0">
                            <h6 class="font-weight-medium">Kurir</h6>
                            <h6 class="font-weight-medium"><?= $cart['ongkir']['selected']['description'] ?></h6>
                        </div>
                        <div class="d-flex justify-content-between mb-1 p-0">
                            <h6 class="font-weight-medium">Ubah Kurir</h6>
                            <h6 class="font-weight-medium"><?= $cart['ongkir']['selected']['code'] ?></h6>
                        </div>
                        <div class="d-flex justify-content-between mb-1 p-0">
                            <h6 class="font-weight-medium">Ubah Layananan Kurir</h6>
                            <h6 class="font-weight-medium"><?= $cart['ongkir']['selected']['service'] ?></h6>
                        </div>
                        <div class="d-flex justify-content-between mb-1 p-0">
                            <h6 class="font-weight-medium">Ubah Estimasi</h6>
                            <h6 class="font-weight-medium"><?= $cart['ongkir']['selected']['service'] ?></h6>
                        </div>
                    </div>
                    <div class="w-100 mt-3">
                        <div class="d-flex justify-content-between mb-1 p-0">
                            <h6 class="font-weight-medium">Dikirim dari</h6>
                            <h6 class="font-weight-medium"><?= $cart['kota_asal'] ?></h6>
                        </div>
                        <div class="d-flex justify-content-between mb-1 p-0">
                            <h6 class="font-weight-medium">Dikirim ke</h6>
                            <h6 class="font-weight-medium"><?= $cart['kota_tujuan'] ?></h6>
                        </div>
                        <div class="d-flex justify-content-between mb-1 p-0">
                            <h6 class="font-weight-medium">Total berat</h6>
                            <h6 class="font-weight-medium"><?= convertWeight($cart['total_berat'])  ?></h6>
                        </div>
                        <div class="d-flex justify-content-between mb-1 p-0">
                            <h6 class="font-weight-medium">Total ongkir</h6>
                            <h6 class="font-weight-medium"><?= rp($cart['ongkir']['selected']['value']) ?></h6>
                        </div>
                        <div class="d-flex justify-content-between mb-1 p-0">
                            <h6 class="font-weight-medium">Sub total</h6>
                            <h6 class="font-weight-medium"><?= rp($cart['sub_total']) ?></h6>
                        </div>
                        <div class="d-flex justify-content-between mt-2 border-primary border-top pt-3">
                            <h5 class="font-weight-semi-bold">Total</h5>
                            <h5 class="font-weight-semi-bold"><?= rp($cart['total_harga']) ?></h5>
                        </div>
                    </div>

                </div>
            <?php endforeach ?>

        </div>
        <div class="col-lg-3">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Total berat</h6>
                        <h6 class="font-weight-medium"><?= convertWeight($carts['total_berat'])  ?></h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Subtotal</h6>
                        <h6 class="font-weight-medium"><?= rp($carts['sub_total']) ?></h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Total Ongkir</h6>
                        <h6 class="font-weight-medium"><?= rp($carts['total_ongkir']) ?></h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Total</h5>
                        <h5 class="font-weight-bold"><?= rp($carts['total']) ?></h5>
                    </div>
                    <button class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                </div>
            </div>
            <form class="mb-5" action="">
                <div class="input-group">
                    <input type="text" class="form-control p-4" placeholder="Coupon Code">
                    <div class="input-group-append">
                        <button class="btn btn-primary">Apply Coupon</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Cart End -->