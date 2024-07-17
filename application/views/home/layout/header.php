<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EShopper - Bootstrap Shop Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="<?= site_url('assets/home/img/favicon.ico') ?>" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/ded8f6b2bd.js" crossorigin="anonymous"></script>
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet"> -->

    <!-- Libraries Stylesheet -->
    <link href="<?= site_url('assets/home/lib/owlcarousel/assets/owl.carousel.min.css') ?>" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= site_url('assets/home/css/style.css') ?>" rel="stylesheet">

    <!-- Sweatalert -->
    <link href="<?= site_url('assets/admin/plugins/sweetalert2/sweetalert2.min.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/admin/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="">FAQs</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Help</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Support</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-dark pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="/" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <?php if ($this->isAuthenticated && $this->header['shopOrderActionCount'] >= 1) : ?>
                    <a href="/toko/order" class="btn border">
                        <i class="fas fa-solid fa-shop text-primary"></i>
                        <span class="badge"><?= $this->header['shopOrderActionCount'] ?></span>
                    </a>
                <?php endif ?>
                <a href="/cart" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge"><?= $this->header['cartCount'] ?? "0" ?></span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <?php $this->load->view('home/layout/kategori') ?>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="/" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <?php if (empty($this->session->userdata('member'))) : ?>
                            <div class="navbar-nav mr-auto py-0">
                                <a href="<?= site_url('/') ?>" class="nav-item nav-link active">Home</a>
                                <a href="<?= site_url('/#product') ?>" class="nav-item nav-link">Shop</a>
                                <a href="<?= site_url('/#product') ?>" class="nav-item nav-link">Shop Detail</a>
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                                    <div class="dropdown-menu rounded-0 m-0">
                                        <a href="cart.html" class="dropdown-item">Shopping Cart</a>
                                        <a href="checkout.html" class="dropdown-item">Checkout</a>
                                    </div>
                                </div>
                                <a href="contact.html" class="nav-item nav-link">Contact</a>
                            </div>
                            <div class="navbar-nav ml-auto py-0">
                                <a href="<?= site_url('auth/login') ?>" class="nav-item nav-link">Login</a>
                                <a href="<?= site_url('auth/register') ?>" class="nav-item nav-link">Register</a>
                            </div>
                        <?php else : ?>
                            <div class="navbar-nav mr-auto py-0">
                                <?php $navs = [
                                    '/' => [
                                        'label' => 'Beranda',
                                        'activeOn' => ['/', '/home']
                                    ],
                                    '/shop' => [
                                        'label' => 'Belanja',
                                        'activeOn' => ['/shop', '/shop/category']
                                    ],
                                    '/toko' => [
                                        'label' => 'Toko',
                                        'activeOn' => ['/toko', '/toko/*']
                                    ],
                                    '/order' => [
                                        'label' => 'Transaksi',
                                        'activeOn' => [
                                            '/order', '/order/*'
                                        ]
                                    ],
                                ]; ?>
                                <?php foreach ($navs as $path => $nav) : ?>
                                    <a href="<?= site_url($path) ?>" class="nav-item nav-link <?= is_active($nav['activeOn']) ? "active" : "" ?>"><?= $nav['label'] ?></a>
                                <?php endforeach ?>
                            </div>
                            <div class="navbar-nav ml-auto py-0">
                                <a href="<?= site_url('profile/edit') ?>" class="nav-item nav-link">Edit Profil</a>
                                <a href="<?= site_url('auth/logout') ?>" class="nav-item nav-link">Logout</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </nav>
                <?php (empty($this->uri->segment('1'))) ? $this->load->view('home/slider') : "" ?>
            </div>
        </div>
    </div>
    <!-- Navbar End -->