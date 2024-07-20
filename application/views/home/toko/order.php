 <div class="container-fluid pt-2 mb-5 pb-3">
     <div class="d-flex flex-column justify-content-center align-items-center mb-4">
         <div class="text-center">
             <h2 class="section-title px-5">
                 <?php if (!empty($toko)) : ?>
                     <span class="px-2">Orderan Toko <?= $toko->namaToko ?></span>
                 <?php else : ?>
                     <span class="px-2">Orderan Toko</span>
                 <?php endif ?>
             </h2>
         </div>
         <?php if (!empty($toko)) : ?>
             <img class="img-fluid" style="width: 10%;" src="<?= base_url("/assets/logo_toko/{$toko->logo}") ?>" alt="<?= $toko->namaToko ?>">
         <?php endif ?>
     </div>
     <?php foreach ($orders as $order) : ?>
         <div class="row mx-xl-5 px-xl-2 py-4 mb-4 shadow-sm" style="background-color: aliceblue; border-radius: 8px;">
             <div class="col-lg-8">
                 <div class="bg-secondary shadow-sm py-2" style="border-radius: 10px;">
                     <div class="flex-row p-2">
                         <div class="w-100">
                             <?php foreach ($order->items as $item) : ?>
                                 <div class="d-flex flex-col w-100 mb-2 p-2 position-relative" style="background-color: white; border-radius: 15px;">
                                     <a href="<?= base_url("/detail-produk/{$item->id}") ?>" target="_blank" class="w-75 d-flex flex-row align-content-center align-items-center">
                                         <img class="img-fluid" src="<?= site_url("assets/foto_produk/{$item->foto}") ?>" alt="" style="width: 80px; border-radius: 10px;">
                                         <div class="w-100 h-100 ml-3 d-flex flex-column justify-content-between py-2">
                                             <h5 class="m-0 p-0 text-truncate"><?= $item->nama ?></h5>
                                             <div class="d-flex flex-row mt-1 w-100">
                                                 <h6 class="m-0 p-0 text-truncate font-medium" style="opacity: 0.8;"><?= rp($item->harga) ?></h6>
                                                 <h6 class="m-0 p-0 text-truncate font-weight-bold ml-4" style="opacity: 0.8;"><?= rp($item->harga * $item->qty) ?></h6>
                                             </div>
                                             <p class="position-absolute mr-2 mt-2 font-weight-medium" style="font-size: small; top: 0; right: 0; margin: 0; padding: 5px; opacity: 0.8;"><span class="font-weight-semi-bold"><?= $item->qty ?></span> Qty</p>
                                         </div>
                                     </a>
                                     <div class="w-25">
                                     </div>
                                 </div>
                             <?php endforeach ?>
                         </div>
                         <div class="w-100 d-flex flex-row justify-content-between">
                             <?php if (!empty($toko)) : ?>
                                 <div class="w-50 d-flex flex-column mx-2 py-1 px-3 rounded-lg"></div>
                             <?php else : ?>
                                 <div class="w-50 d-flex flex-column mx-2 shadow-sm py-1 px-3 rounded-lg" style="background-color: aliceblue;">
                                     <div class="w-100 py-1">
                                         <a class="d-flex flex-row align-items-center w-auto" href="<?= base_url("/produk/{$order->toko->id}") ?>">
                                             <img class="img-fluid rounded-circle" src="<?= site_url("assets/logo_toko/{$order->toko->logo}") ?>" alt="" style="height: 40px; width: auto;">
                                             <h6 class="font-weight-medium ml-2 p-0 m-0"><?= $order->toko->nama ?></h6>
                                         </a>
                                     </div>
                                 </div>
                             <?php endif ?>
                             <div class="d-flex flex-column mr-2 align-items-end justify-content-end">
                                 <div>
                                     <span class="font-weight-medium mr-1">Total</span>
                                     <span class="font-weight-semi-bold"><?= rp($order->total) ?></span>
                                 </div>
                                 <div>
                                     <span class="font-weight-medium mr-1">Dipesan pada</span>
                                     <span class="font-weight-semi-bold"><?= $order->tanggalDipesan ?></span>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-4 h-100 mt-2">
                 <?php if ($order->shipping->resi == null && ($order->status == 'Dikemas' || $order->status == 'Dikirim')) : ?>
                     <form action="" method="post" class="d-flex w-100 flex-column justify-content-center h-100 d-flex px-3 py-4 rounded-lg shadow-sm bg-secondary">
                         <input type="hidden" id="action" name="action" value="update-resi">
                         <input type="hidden" id="orderDetailId" name="orderDetailId" value="<?= $order->orderDetailId ?>">
                         <div class="control-group mb-3">
                             <input type="text" class="form-control px-3 py-4 rounded" id="resi" name="resi" value="<?= set_value($order->shipping->resi ?? '') ?>" placeholder="Resi <?= $order->shipping->kurir ?>" />
                             <span class="text-danger"><small><?= form_error('resi') ?></small></span>
                         </div>
                         <?php if ($order->shipping->resi == null) : ?>
                             <button type="submit" class="btn btn-secondary px-4 rounded font-weight-medium text-lg text-light" style="background-color: steelblue;">Kirim Pesanan</button>

                         <?php else : ?>
                             <button type="submit" class="btn btn-secondary px-4 rounded font-weight-medium text-lg text-light" style="background-color:cadetblue;">Update Resi</button>
                         <?php endif ?>
                     </form>
                 <?php endif ?>

                 <div class="flex-column justify-content-center h-100 d-flex mt-4">
                     <?php if ($order->status !== 'Dikemas' && $order->status !== 'Dikirim') : ?>
                         <div class="d-flex flex-row justify-content-between px-1">
                             <h6 class="font-weight-medium">Resi</h6>
                             <h6 class="font-weight-medium text-truncate"><?= $order->shipping->resi ?></h6>
                         </div>
                     <?php endif ?>
                     <div class="d-flex flex-row justify-content-between px-1">
                         <h6 class="font-weight-medium">Alamat</h6>
                         <h6 class="font-weight-medium text-truncate"><?= $order->shipping->toAddress ?></h6>
                     </div>
                     <div class="d-flex flex-row justify-content-between px-1">
                         <h6 class="font-weight-medium">Kurir</h6>
                         <h6 class="font-weight-medium"><?= $order->shipping->kurir ?></h6>
                     </div>
                     <div class="d-flex flex-row justify-content-between px-1">
                         <h6 class="font-weight-medium">Ongkir</h6>
                         <h6 class="font-weight-medium"><?= rp($order->shipping->ongkir) ?></h6>
                     </div>
                     <div class="d-flex flex-row justify-content-between px-1">
                         <h6 class="font-weigh  t-medium">Status</h6>
                         <?php $statusColor = ['Belum Dibayar' => 'gray', 'Dikemas' => 'chocolate', 'Dikirim' => 'cadetblue', 'Diterima' => 'cornflowerblue', 'Dibatalkan' => 'crimson']; ?>
                         <h6 class="font-weight-medium px-3 rounded text-light" style="padding: 4px; background-color: <?= $statusColor[$order->status] ?>;"><?= $order->status == "Dikemas" && $order->shipping->resi == null ? "Perlu Dikirim" : $order->status ?></h6>
                     </div>
                 </div>
             </div>
         </div>
     <?php endforeach ?>
 </div>