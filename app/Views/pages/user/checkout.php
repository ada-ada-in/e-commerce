<?= view('pages/user/components/include/nav-header/head') ?>


<body>

    <!-- Navbar -->
    <?= view('pages/user/components/include/nav-header/cart') ?>
    <?= view('/pages/user/components/include/nav-header/header') ?>

    <div class="container rounded bg-white mb-5">
        <div class="row">
            <!-- Bagian Produk -->
            <div class="col-7">
                <div class="card shadow-sm border-1 mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                                <input type="checkbox" class="me-3" id="select-all">
                          <div class="card-title mb-0">Pilih Semua (0)</div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-1">
                    <div class="card-body position-relative">
                        <div class="d-flex align-items-center">
                        <input type="checkbox" class="me-3" id="select-all">
                            <img src="/uploads/1745340983_e8d92778108d474bcc62.png" height="100" width="100" alt="Product Image" class="img-thumbnail me-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Nama Produk</h6>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-outline-secondary btn-sm me-2">-</button>
                                    <span>1</span>
                                    <button class="btn btn-outline-success btn-sm ms-2">+</button>
                                </div>
                            </div>
                            <div class="text-end flex-grow-1">
                                <p class="mb-0">Rp 100.000</p>
                                <button class="btn btn-outline-danger btn-sm">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card shadow-sm border-1">
                    <div class="card-body position-relative">
                        <div class="d-flex align-items-center">
                        <input type="checkbox" class="me-3" id="select-all">
                            <img src="/uploads/1745340983_e8d92778108d474bcc62.png" height="100" width="100" alt="Product Image" class="img-thumbnail me-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Nama Produk</h6>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-outline-secondary btn-sm me-2">-</button>
                                    <span>1</span>
                                    <button class="btn btn-outline-success btn-sm ms-2">+</button>
                                </div>
                            </div>
                            <div class="text-end flex-grow-1">
                                <p class="mb-0">Rp 100.000</p>
                                <button class="btn btn-outline-danger btn-sm">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bagian Detail Pembayaran -->
            <div class="col-5">
                <div class="card shadow-sm border-1">
                    <div class="card-body">
                        <hr>
                        <h4 class="card-title text-center mb-4">Detail Pembayaran</h4>
                        <div class="mb-3">
                            <p class="mb-1"><strong>Total Harga:</strong> Rp 100.000</p>
                            <p class="mb-1"><strong>Ongkos Kirim:</strong> Rp 10.000</p>
                            <p><strong>Total Pembayaran:</strong> <span class="text-success">Rp 110.000</span></p>
                            <select class="form-select">
                            <option selected>Pilih Pengantaran</option>
                            <option value="1">Diantar</option>
                            <option value="2">Ambil Sendiri</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary w-100">Lanjutkan Pembayaran</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= view('/pages/user/components/include/link') ?>

    

</body>
</html>