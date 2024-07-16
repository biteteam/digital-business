 <div class="container-fluid pt-2 mb-5 pb-3">
     <div class="text-center mb-4">
         <h2 class="section-title px-5"><span class="px-2">Order Histori</span></h2>
     </div>
     <?php foreach ($orders as $order) : ?>
         <div class="row mx-xl-5 px-xl-2 py-4 mb-4 shadow-sm" style="background-color: aliceblue; border-radius: 8px;">
             <div class="col-lg-9">
                 <?php foreach ($order['detail'] as $idx => $detail) : ?>
                     <div class="bg-secondary shadow-sm  <?= $idx < count($order['detail']) - 1 ? "mb-3 pb-2" : ""  ?>" style="border-radius: 10px;">
                         <div class="flex-row p-2">
                             <div class="w-100">
                                 <?php foreach ($detail['items'] as $item) : ?>
                                     <div class="d-flex flex-col w-100 mb-2 p-2 position-relative" style="background-color: white; border-radius: 15px;">
                                         <a href="<?= base_url("/detail-produk/{$item['id']}") ?>" target="_blank" class="w-75 d-flex flex-row align-content-center align-items-center">
                                             <img class="img-fluid" src="<?= site_url("assets/foto_produk/{$item['foto']}") ?>" alt="" style="width: 80px; border-radius: 10px;">
                                             <div class="w-100 h-100 ml-3 d-flex flex-column justify-content-between py-2">
                                                 <h5 class="m-0 p-0 text-truncate"><?= $item['nama'] ?></h5>
                                                 <h6 class="m-0 p-0 mt-1 text-truncate font-weight-bold" style="opacity: 0.8;"><?= rp($item['harga']) ?></h6>
                                                 <p class="position-absolute mr-2 mt-2 font-weight-medium" style="font-size: small; top: 0; right: 0; margin: 0; padding: 5px; opacity: 0.8;"><span class="font-weight-semi-bold"><?= $item['qty'] ?></span> Qty</p>
                                             </div>
                                         </a>
                                         <div class="w-25">
                                         </div>
                                     </div>
                                 <?php endforeach ?>
                             </div>
                             <div class="w-100 d-flex flex-row justify-content-between">
                                 <div class="w-50 d-flex flex-column mx-2">
                                     <div class="w-100 py-1">
                                         <a class="d-flex flex-row align-items-center w-auto" href="<?= base_url("/produk/{$detail['idToko']}") ?>">
                                             <img class="img-fluid rounded-circle" src="<?= site_url("assets/logo_toko/{$detail['logoToko']}") ?>" alt="" style="height: 40px; width: auto;">
                                             <h6 class="font-weight-medium ml-2 p-0 m-0"><?= $detail['namaToko'] ?></h6>
                                         </a>
                                     </div>
                                     <div style="margin-top: auto; padding-bottom: 9px;">
                                         <div class="d-flex flex-row justify-content-between px-3">
                                             <h6 class="font-weight-medium">Dikirim dari</h6>
                                             <h6 class="font-weight-medium"><?= $detail['fromAddress'] ?></h6>
                                         </div>
                                         <div class="d-flex flex-row justify-content-between px-3">
                                             <h6 class="font-weight-medium">Diantar ke</h6>
                                             <h6 class="font-weight-medium"><?= $detail['toAddress'] ?></h6>
                                         </div>
                                         <div class="d-flex flex-row justify-content-between px-3">
                                             <h6 class="font-weight-medium">Dipesan pada</h6>
                                             <h6 class="font-weight-medium"><?= $detail['tanggalOrder'] ?></h6>
                                         </div>
                                         <?php if ($detail['tanggalOrder'] !== $detail['tanggalDiubah']) : ?>
                                             <div class="d-flex flex-row justify-content-between px-3">
                                                 <h6 class="font-weight-medium"><?= $detail['status'] ?> pada</h6>
                                                 <h6 class="font-weight-medium"><?= $detail['tanggalDiubah'] ?></h6>
                                             </div>
                                         <?php endif ?>
                                     </div>
                                 </div>
                                 <div class="flex-grow-1 d-flex flex-column pt-3 pb-2 rounded-lg shadow-sm" style="background-color: aliceblue;">
                                     <div class="d-flex flex-row justify-content-between px-3">
                                         <h6 class="font-weight-medium">Status</h6>
                                         <h6 class="font-weight-medium px-3 rounded" style="padding: 3px 4px 3px 4px; background-color: greenyellow;"><?= $detail['status'] ?></h6>
                                     </div>
                                     <div class="d-flex flex-row justify-content-between px-3">
                                         <h6 class="font-weight-medium">Kurir</h6>
                                         <h6 class="font-weight-medium"><?= $detail['kurir'] ?></h6>
                                     </div>
                                     <div class="d-flex flex-row justify-content-between px-3 mt-1">
                                         <h6 class="font-weight-medium">Ongkir</h6>
                                         <h6 class="font-weight-medium"><?= rp($detail['ongkir']) ?></h6>
                                     </div>
                                     <div class="d-flex flex-row justify-content-between px-3 mt-1">
                                         <h6 class="font-weight-medium">Subtotal</h6>
                                         <h6 class="font-weight-medium"><?= rp($detail['subTotal']) ?></h6>
                                     </div>
                                     <div class="d-flex flex-row justify-content-between align-items-center px-3 mt-1">
                                         <h6 class="font-weight-medium">Total</h6>
                                         <h5 class="font-weight-semi-bold"><?= rp($detail['total']) ?></h5>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 <?php endforeach ?>
             </div>
             <div class="col-lg-3 h-100 mt-2">
                 <div class="flex-column justify-content-center h-100 d-flex p-3 rounded-lg shadow-sm bg-secondary">
                     <div class="flex-grow-1 d-flex flex-column pt-3 pb-2 rounded-lg shadow-sm mb-3" style="background-color: aliceblue;">
                         <div class="d-flex flex-row justify-content-between px-3">
                             <h6 class="font-weight-medium">Total Berat</h6>
                             <h6 class="font-weight-medium"><?= convertWeight($order['totalBerat']) ?></h6>
                         </div>
                         <div class="d-flex flex-row justify-content-between px-3">
                             <h6 class="font-weight-medium">Estimasi Tiba</h6>
                             <h6 class="font-weight-medium"><?= $order['detail'][0]['etd'] ?> Hari</h6>
                         </div>
                         <div class="d-flex flex-row justify-content-between px-3 mt-1">
                             <h6 class="font-weight-medium">Total Ongkir</h6>
                             <h6 class="font-weight-medium"><?= rp($order['totalOngkir']) ?></h6>
                         </div>
                         <div class="d-flex flex-row justify-content-between px-3 mt-1">
                             <h6 class="font-weight-medium">Sub Total</h6>
                             <h6 class="font-weight-medium"><?= rp($order['subTotal']) ?></h6>
                         </div>
                     </div>
                     <span class="btn btn-secondary px-4 rounded font-weight-bold text-xl" style="background-color:skyblue;"><?= rp($order['total']) ?></span>
                 </div>
             </div>
         </div>
     <?php endforeach ?>
 </div>