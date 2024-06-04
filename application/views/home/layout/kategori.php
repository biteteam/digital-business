<div class="col-lg-3 d-none d-lg-block">
    <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
        <h6 class="m-0">Categories</h6>
        <i class="fa fa-angle-down text-dark"></i>
    </a>
    <nav class="collapse <?= (empty($this->uri->segment('1'))) ? 'show' : '' ?> navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
        <div class="navbar-nav w-100 overflow-hidden">
            <?php foreach ($kategori as $kt) : ?>
                <a href="<?= site_url('produk-by-kategori/' . $kt->idKat) ?>" class="nav-item nav-link"><?= $kt->namaKat ?></a>
            <?php endforeach ?>
        </div>
    </nav>
</div>