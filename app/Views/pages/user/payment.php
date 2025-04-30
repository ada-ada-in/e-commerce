<?= view('pages/user/components/include/nav-header/head') ?>
  <body>

    <!-- navbar -->

    <?= view('pages/user/components/include/nav-header/cart') ?>
    
    <?= view('/pages/user/components/include/nav-header/header') ?>


        
<div class="container rounded bg-white mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-body position-relative">
            <!-- Tombol Cetak di Pojok Kanan Atas -->
            
            <!-- Judul -->
            
            <button class="btn btn-primary position-absolute top-0 end-0 m-3" onclick="printSelected()">
                <i class="bi bi-printer"></i> Cetak
            </button>
            <h4 class="card-title text-center mb-4">Detail Pembayaran</h4>
            <!-- Informasi Pembayaran -->
            <div class="mb-3">
                <h5 class="fw-bold">Nomor Pemesanan: <span class="text-primary">#ORD123456</span></h5>
            </div>
            <div class="mb-3">
                <p class="mb-1"><strong>Tanggal Pemesanan:</strong> 30 April 2025</p>
                <p class="mb-1"><strong>Status Pembayaran:</strong> <span class="badge bg-success">Berhasil</span></p>
                <p><strong>Total Pembayaran:</strong> <span class="text-success">Rp 1.000.000</span></p>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <a href="https://app.sandbox.midtrans.com/snap/v2/vtweb/TRANSACTION_ID" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-link-45deg"></i> Lihat Transaksi
                </a>
                <a href="<?= base_url('/inventory') ?>" target="_blank" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-box-seam"></i> Lihat Barang
                </a>
                <a href="<?= base_url('/delivery') ?>" target="_blank" class="btn btn-outline-info btn-sm">
                    <i class="bi bi-truck"></i> Lihat Pengiriman
                </a>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<div id="print-area" class="container rounded bg-white mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-body position-relative">
            <img src="/assets/organic/images/logo.svg" alt="logo" class="img-fluid">
            <hr>
            <h4 class="card-title text-center mb-4">Detail Pembayaran</h4>
            <div class="mb-3">
                <h5 class="fw-bold">Nomor Pemesanan: <span class="text-primary">#ORD123456</span></h5>
            </div>
            <div class="mb-3">
                <p class="mb-1"><strong>Tanggal Pemesanan:</strong> 30 April 2025</p>
                <p class="mb-1"><strong>Status Pembayaran:</strong>Berhasil</p>
                <p><strong>Total Pembayaran:</strong> Rp 1.000.000</p>
            </div>
            <hr>
        </div>
    </div>
</div>


<script>
    function printSelected() {
        const printContents = document.getElementById('print-area').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>

<style>
#print-area {
    display: none;
}

@media print {
    body * {
        visibility: hidden;
    }

    #print-area, #print-area * {
        visibility: visible;
    }

    #print-area {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        display: block;
    }
}
</style>



    

    <?= view('/pages/user/components/include/link') ?>


  </body>
</html>