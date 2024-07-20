 <!-- Page Header Start -->
 <div class="container-fluid bg-secondary mb-5">
     <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
         <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>
         <div class="d-inline-flex">
             <p class="m-0"><a href="/">Home</a></p>
             <p class="m-0 px-2">-</p>
             <p class="m-0">Shop Detail</p>
         </div>
     </div>
 </div>
 <!-- Page Header End -->


 <!-- Shop Detail Start -->
 <div class="container-fluid py-5">
     <div class="row px-xl-5">
         <div class="col-lg-5 pb-5">
             <div id="product-carousel" class="carousel slide" data-ride="carousel">
                 <div class="carousel-inner border">
                     <div class="carousel-item active rounded-lg">
                         <img class="w-100 h-100 rounded-lg" src="<?= site_url('assets/foto_produk/' . $produk->foto) ?>" alt="Image">
                     </div>
                     <!-- <div class="carousel-item">
                         <img class="w-100 h-100" src="img/product-2.jpg" alt="Image">
                     </div> -->
                 </div>
                 <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                     <i class="fa fa-2x fa-angle-left text-dark"></i>
                 </a>
                 <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                     <i class="fa fa-2x fa-angle-right text-dark"></i>
                 </a>
             </div>
         </div>

         <div class="col-lg-7 pb-5">
             <h3 class="font-weight-semi-bold"><?= $produk->namaProduk ?></h3>
             <!-- <div class="d-flex mb-3">
                 <div class="text-primary mr-2">
                     <small class="fas fa-star"></small>
                     <small class="fas fa-star"></small>
                     <small class="fas fa-star"></small>
                     <small class="fas fa-star-half-alt"></small>
                     <small class="far fa-star"></small>
                 </div>
                 <small class="pt-1">(50 Reviews)</small>
             </div> -->
             <h3 class="font-weight-semi-bold mb-4"><span class="text-muted">Rp. </span><?= rp($produk->harga, true) ?></h3>
             <p class="mb-4"><?= $produk->deskripsiProduk ?></p>
             <div class="d-flex mb-3">
                 <p class="text-dark font-weight-medium mb-0 mr-3">Berat:</p>
                 <p><?= convertWeight($produk->berat) ?></span></p>
                 <!-- <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
                 <form>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" class="custom-control-input" id="size-1" name="size">
                         <label class="custom-control-label" for="size-1">XS</label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" class="custom-control-input" id="size-2" name="size">
                         <label class="custom-control-label" for="size-2">S</label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" class="custom-control-input" id="size-3" name="size">
                         <label class="custom-control-label" for="size-3">M</label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" class="custom-control-input" id="size-4" name="size">
                         <label class="custom-control-label" for="size-4">L</label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" class="custom-control-input" id="size-5" name="size">
                         <label class="custom-control-label" for="size-5">XL</label>
                     </div>
                 </form> -->
             </div>
             <div class="d-flex mb-4">
                 <!-- <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
                 <form>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" class="custom-control-input" id="color-1" name="color">
                         <label class="custom-control-label" for="color-1">Black</label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" class="custom-control-input" id="color-2" name="color">
                         <label class="custom-control-label" for="color-2">White</label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" class="custom-control-input" id="color-3" name="color">
                         <label class="custom-control-label" for="color-3">Red</label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" class="custom-control-input" id="color-4" name="color">
                         <label class="custom-control-label" for="color-4">Blue</label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" class="custom-control-input" id="color-5" name="color">
                         <label class="custom-control-label" for="color-5">Green</label>
                     </div>
                 </form> -->
                 <p class="text-dark font-weight-medium mb-0 mr-3">Ketersediaan:</p>
                 <p><?= $produk->stok ?> <span class="text-muted text-xs">unit</span></p>
             </div>
             <div class="d-flex align-items-center mb-4 pt-2">
                 <div class="input-group quantity mr-3" style="width: 130px;">
                     <div class="input-group-btn">
                         <button class="btn btn-primary btn-minus">
                             <i class="fa fa-minus"></i>
                         </button>
                     </div>
                     <input type="text" class="form-control bg-secondary text-center" value="1">
                     <div class="input-group-btn">
                         <button class="btn btn-primary btn-plus">
                             <i class="fa fa-plus"></i>
                         </button>
                     </div>
                 </div>
                 <form action="<?= site_url('cart/add') ?>" method="post">
                     <input type="hidden" name="id-produk" value="<?= $produk->idProduk ?>" />
                     <input type="hidden" name="qty" value="" /> <!-- TODO: add js to change qty -->
                     <button type="submit" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                 </form>
             </div>
             <div class="d-flex pt-2">
                 <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                 <div class="d-inline-flex">
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
                         <i class="fab fa-pinterest"></i>
                     </a>
                 </div>
             </div>
         </div>
     </div>
     <div class="row px-xl-5">
         <div class="col">
             <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                 <a class="nav-item nav-link" data-toggle="tab" href="#description">Description</a>
                 <a class="nav-item nav-link" data-toggle="tab" href="#information">Information</a>
                 <a class="nav-item nav-link" data-toggle="tab" href="#ratings">Reviews (<?= count($ratings) ?>)</a>
             </div>
             <div class="tab-content">
                 <div class="tab-pane fade" id="description">
                     <h4 class="mb-3">Product Description</h4>
                     <p><?= $produk->deskripsiProduk ?></p>
                 </div>
                 <div class="tab-pane fade" id="information">
                     <h4 class="mb-3">Additional Information</h4>
                     <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                     <div class="row">
                         <div class="col-md-6">
                             <ul class="list-group list-group-flush">
                                 <li class="list-group-item px-0">
                                     Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                 </li>
                                 <li class="list-group-item px-0">
                                     Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                 </li>
                                 <li class="list-group-item px-0">
                                     Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                 </li>
                                 <li class="list-group-item px-0">
                                     Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                 </li>
                             </ul>
                         </div>
                         <div class="col-md-6">
                             <ul class="list-group list-group-flush">
                                 <li class="list-group-item px-0">
                                     Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                 </li>
                                 <li class="list-group-item px-0">
                                     Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                 </li>
                                 <li class="list-group-item px-0">
                                     Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                 </li>
                                 <li class="list-group-item px-0">
                                     Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                 </li>
                             </ul>
                         </div>
                     </div>
                 </div>
                 <div class="tab-pane fade" id="ratings">
                     <div class="row">
                         <div class="col-md-6">
                             <h4 class="mb-4">1 review untuk "<?= $produk->namaProduk ?>"</h4>
                             <?php foreach ($ratings as $rating) : ?>
                                 <div class="media mb-4">
                                     <img src="<?= site_url('assets/home/img/user.jpg') ?>" alt="Image" class="img-fluid mr-3 mt-1 rounded-circle" style="width: 45px;">
                                     <div class="media-body">
                                         <h6><?= $rating->namaKonsumen ?><small> - <i><?= date_humanize($rating->rateAt) ?></i></small></h6>
                                         <?php
                                            $ratingsText = ['buruk', 'cukup-buruk', 'cukup-bagus', 'bagus', 'sangat-bagus'];
                                            $ratingValue = array_search($rating->rating, $ratingsText);
                                            ?>
                                         <div class="text-primary mb-2">
                                             <?php foreach ($ratingsText as $index => $rateStar) : ?>
                                                 <i class="<?= $index <= $ratingValue ? "fas" : "far" ?> fa-star"></i>
                                             <?php endforeach ?>
                                         </div>
                                         <p><?= $rating->review ?>.</p>
                                     </div>
                                 </div>
                             <?php endforeach ?>
                         </div>
                         <?php if (!empty($orderItemId)) : ?>
                             <div class="col-md-6">
                                 <div class="mb-4">
                                     <h4 class="">Rating Penilaian Produk</h4>
                                     <small>Beri rating produk yang sudah kamu beli</small>
                                 </div>
                                 <div class="d-flex my-3">
                                     <p class="mb-0 mr-2">Rating </p>
                                     <div class="text-primary rate-star" id="rate-star">
                                         <i class="fa fa-star"></i>
                                         <i class="far fa-star"></i>
                                         <i class="far fa-star"></i>
                                         <i class="far fa-star"></i>
                                         <i class="far fa-star"></i>
                                     </div>
                                     <span id="rate-preview" class="ml-2" style="font-size: small;"></span>
                                 </div>
                                 <form action="<?= base_url("order/rating") ?>" method="post">
                                     <div class="form-group">
                                         <label for="review">Review</label>
                                         <input type="hidden" name="order-item-id" value="<?= $orderItemId ?>">
                                         <input type="hidden" name="rating" value="buruk">
                                         <textarea id="review" name="review" cols="30" rows="5" class="form-control rounded"></textarea>
                                     </div>
                                     <div class="form-group mb-0">
                                         <button type="submit" class="btn btn-primary px-3">
                                             Beri Rating
                                         </button>
                                     </div>
                                 </form>
                             </div>


                             <script>
                                 const maxRating = 5;
                                 const ratings = ['buruk', 'cukup-buruk', 'cukup-bagus', 'bagus', 'sangat-bagus'];
                                 const ratingPreviewEl = document.querySelector('#rate-preview');
                                 const ratingEl = document.querySelector('input[name="rating"]');
                                 let rateStarEl = document.querySelector('#rate-star');
                                 let ratingValue = ratingEl.value;
                                 let ratingStar = ratings.indexOf(ratingValue);
                                 const toTitleCase = (str) => {
                                     return str.split(' ').map(word => {
                                         return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
                                     }).join(' ');
                                 }

                                 const changeRating = () => {
                                     let ratingInner = "";
                                     for (let i = 0; i < maxRating; i++) {
                                         const rateClass = i <= ratingStar ? 'fa' : 'far';
                                         ratingInner += `<i class="${rateClass} fa-star" star="${ratings[i]}"></i>`;
                                     }

                                     rateStarEl.innerHTML = ratingInner;
                                     ratingPreviewEl.innerHTML = toTitleCase(ratingValue.replace(/-/g, ' '));
                                     ratingEl.value = ratingValue;

                                     rateStarEl.querySelectorAll("i").forEach((starEl, index) => {
                                         starEl.addEventListener('click', () => {
                                             ratingStar = index;
                                             ratingValue = ratings[index];
                                             changeRating();
                                         });
                                     });
                                 }

                                 changeRating();
                             </script>
                         <?php endif ?>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Shop Detail End -->
 <script>
     const navTabsEl = document.querySelector('.nav-tabs')
     const tabsEl = document.querySelector('.tab-content')
     const tabActive = window.location.hash || "#description"

     for (const navTab of navTabsEl.children) {
         if (navTab.getAttribute("href") == tabActive) navTab.classList.add("active");
     }

     for (const tab of tabsEl.children) {
         if (`#${tab.getAttribute("id")}` == tabActive) {
             tab.classList.add("show");
             tab.classList.add("active");

             if (window.location.hash) tab.scrollIntoView({
                 behavior: "smooth"
             })
         }
     }
 </script>