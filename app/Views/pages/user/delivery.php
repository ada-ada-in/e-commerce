<?= view('pages/user/components/include/nav-header/head') ?>
  <body>

    <!-- navbar -->

    <?= view('pages/user/components/include/nav-header/cart') ?>
    
    <?= view('/pages/user/components/include/nav-header/header') ?>


            
        <div class="container my-5">
            <div class="card">
                <div class="card-header">
                <h5 class="mb-0">Status Pengiriman</h5>
                <p>24-02-2025</p>
                </div>
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-center flex-fill">
                    <div class="mb-2">  
                        <i class="bi bi-cart-check fs-4 text-success"></i>
                    </div>
                    <p class="mb-0">Pesanan Dibuat</p>
                    </div>
                    <div class="flex-fill border-top border-5 mx-2" style="margin-top: 15px; border-color:rgb(60, 57, 57);"></div>
                    <div class="text-center flex-fill">
                    <div class="mb-2">
                        <i class="bi bi-credit-card fs-4 text-secondary"></i>
                    </div>
                    <p class="mb-0">Pesanan Dibayarkan</p>
                    </div>
                    <div class="flex-fill border-top border-5 mx-2" style="margin-top: 15px; border-color:rgb(60, 57, 57);"></div>
                    <div class="text-center flex-fill">
                    <div class="mb-2">
                        <i class="bi bi-truck fs-4 text-secondary"></i>
                    </div>
                    <p class="mb-0">Pesanan Dikirimkan</p>
                    </div>
                    <div class="flex-fill border-top border-5 mx-2" style="margin-top: 15px; border-color:rgb(60, 57, 57);"></div>
                    <div class="text-center flex-fill">
                    <div class="mb-2">
                        <i class="bi bi-check-circle-fill fs-4 text-secondary"></i>
                    </div>
                    <p class="mb-0">Pesanan Selesai</p>
                    </div>
                </div>
                </div>
            </div>
    </div>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    

    <?= view('/pages/user/components/include/link') ?>


  </body>
</html>