<!-- Shop Start -->
<div class="container-fluid pt-2">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <!-- Kategori Filter Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Filter berdasarkan kategori</h5>
                <div>
                    <?php foreach ($categories as $kategori) : ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="category-<?= $kategori->idKat ?>">
                            <label class="custom-control-label" for="category-<?= $kategori->idKat ?>"><?= $kategori->namaKat ?></label>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <!-- Kategori Filter End -->

            <!-- Toko Filter Start -->
            <div class="mb-5">
                <h5 class="font-weight-semi-bold mb-4">Filter berdasarkan toko</h5>
                <div>
                    <?php foreach ($stores as $toko) : ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="store-<?= $toko->idToko ?>">
                            <label class="custom-control-label" for="store-<?= $toko->idToko ?>"><?= $toko->namaToko ?></label>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <!-- Toko Filter End -->
        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-12">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <form class="w-50" action="">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="<?= $this->input->get('search') ?>" placeholder="Cari produk berdasarkan nama">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent text-primary">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="dropdown ml-4">
                            <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Sort by
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                <a class="dropdown-item" href="#">Latest</a>
                                <a class="dropdown-item" href="#">Popularity</a>
                                <a class="dropdown-item" href="#">Best Rating</a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (count($products) == 0) : ?>
                    <div class="col-12 mt-4  pb-1 text-center">
                        <h4>Produk tidak ditemukan</h4>
                    </div>
                <?php endif ?>

                <?php foreach ($products as $produk) : ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0" style="border-top-right-radius: 12px; border-top-left-radius: 12px;">
                                <a href="<?= site_url('/detail-produk/' . $produk->idProduk) ?>">
                                    <img class="img-fluid w-100" src="<?= site_url('assets/foto_produk/' . $produk->fotoProduk) ?>" alt="<?= $produk->namaProduk ?>">
                                </a>
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3"><?= $produk->namaProduk ?></h6>
                                <div class="d-flex justify-content-center">
                                    <h6><?= rp($produk->hargaProduk) ?></h6>
                                </div>
                                <div class="border-top mt-3">
                                    <div class="px-4 mt-2 d-flex align-items-center">
                                        <a href="<?= base_url("/produk/{$produk->idToko}") ?>" style="width: 20%;" class="position-relative overflow-hidden bg-transparent border p-0 rounded-circle">
                                            <img class="img-fluid h-100 w-100" src="<?= site_url('assets/logo_toko/' . $produk->logoToko) ?>" alt="<?= $produk->namaToko ?>">
                                        </a>
                                        <div class="mt-4 ml-2 p-0">
                                            <h5 class="p-0 m-0" style="font-size: medium;"><?= $produk->namaToko ?></h5>
                                            <p class="p-0" style="font-size: small"><?= $produk->alamatToko ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="<?= site_url('/detail-produk/' . $produk->idProduk) ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                <?php if (intval($produk->idSeller) == intval($this->session->userdata("idKonsumen"))) : ?>
                                    <a href="<?= site_url('produk/' . $produk->idToko . "/edit/" . $produk->idProduk) ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-edit text-primary mr-1"></i>Edit Produk</a>
                                <?php else : ?>
                                    <form action="<?= site_url('cart/add') ?>" method="post">
                                        <input type="hidden" name="id-produk" value="<?= $produk->idProduk ?>">
                                        <button type="submit" class="btn btn-sm text-dark p-0">
                                            <i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart
                                        </button>
                                    </form>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
                <!-- <div class="col-12 pb-1">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mb-3">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div> -->
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->



<script>
    const customControls = document.querySelectorAll('.custom-control-input');
    const url = window.location;
    const params = new URLSearchParams(url.search);

    customControls.forEach(controlEL => {
        const controlElKey = controlEL.getAttribute('id').split("-")[0];
        const controlElId = controlEL.getAttribute('id').split("-")[1];
        const paramsElArr = params.get(controlElKey)?.split(',');
        if (paramsElArr?.includes(controlElId)) controlEL.setAttribute('checked', true);

        controlEL.addEventListener('click', (e) => {
            const control = e.target;
            control.hasAttribute('checked') ? control.removeAttribute('checked') : control.setAttribute('checked', true);

            const controlAttr = control.getAttribute('id').split("-");
            const key = controlAttr[0]
            const value = controlAttr[1]
            let valueGroup = params.get(key)?.split(',') ?? []

            if (control.hasAttribute('checked') && !valueGroup?.includes(value)) {
                valueGroup.push(value);
            } else if (!control.hasAttribute('checked') && valueGroup?.includes(value)) {
                valueGroup = valueGroup.filter(val => val !== value);
            }
            params.set(key, valueGroup.join(","));
            if (valueGroup.length <= 0) params.delete(key)

            let redirectUri = url.origin + url.pathname + "?" + params.toString()
            redirectUri = redirectUri.replace(/%2C/g, ",").replace("=.", "=")
            window.location.replace(redirectUri)
        })
    })
</script>