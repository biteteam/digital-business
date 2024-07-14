<?php
$sliders = [
    ["src" => "assets/home/img/carousel/samsung.webp"],
    ["src" => "assets/home/img/carousel/tanggal-tua.webp"],
    ["src" => "assets/home/img/carousel/gratis-ongkir.webp"],
    ["src" => "assets/home/img/carousel/flash-sale.webp"],
    ["src" => "assets/home/img/carousel/samsung-buds.webp"],
    ["src" => "assets/home/img/carousel/jaminan-harga-terbaik.webp"],
    ["src" => "assets/home/img/carousel/beli-lokal.webp"],
    ["src" => "assets/home/img/carousel/flash-sale-sekolah.webp"],
    ["src" => "assets/home/img/carousel/cashback.webp"],
    ["src" => "assets/home/img/carousel/exclusive-bundle.webp"]
]
?>


<div id="header-carousel" class="carousel slide" data-ride="carousel" style="height: 410px;">
    <div class="carousel-inner" style="border-radius: 15px;">
        <?php foreach ($sliders as $idx => $slider) : ?>
            <div class="carousel-item <?= $idx == 0 ? "active" : "" ?>" style="height: auto;">
                <a href="#">
                    <img class="img-fluid" src="<?= site_url($slider['src']) ?>" alt="Image" style="width: 100%;">
                </a>
            </div>
        <?php endforeach ?>
        <button class="carousel-control-prev" style="border:none;background: transparent;" href="#header-carousel" data-slide="prev">
            <div class="btn btn-dark" style="width: 45px; height: 45px; opacity: 0.2; border-radius: 10px;" onmouseout="this.style.opacity=0.2" onmouseover="this.style.opacity=0.7">
                <span class="carousel-control-prev-icon mb-n2"></span>
            </div>
        </button>
        <button class="carousel-control-next" style="border:none;background: transparent;" href="#header-carousel" data-slide="next">
            <div class="btn btn-dark" style="width: 45px; height: 45px; opacity: 0.2; border-radius: 10px;" onmouseout="this.style.opacity=0.2" onmouseover="this.style.opacity=0.7">
                <span class="carousel-control-next-icon mb-n2"></span>
            </div>
        </button>
    </div>
</div>