<?= view('pages/user/components/include/nav-header/head') ?>
<body>

  <!-- navbar -->
  <?= view('pages/user/components/include/nav-header/cart') ?>
  <?= view('/pages/user/components/include/nav-header/header') ?>

  <style>
  @media (max-width: 576px) {
    .btn {
      font-size: 14px;
      padding: 8px 12px;
    }
    h3 {
      font-size: 1.25rem;
    }
  }
</style>


  <div class="container rounded bg-white mb-5">
    <div class="card shadow-sm border-0" id="payment-data">
      <!-- payment data will be injected here -->
    </div>
  </div>

  <script>
function printSelected(id) {
    const printContents = document.getElementById('print-area-' + id).innerHTML;
    const printWindow = window.open('', '', 'height=800,width=800');

    printWindow.document.write('<html><head><title>Cetak Pembayaran</title>');
    // Bootstrap CDN
    printWindow.document.write(`
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <style>
            body {
                padding: 20px;
                font-family: Arial, sans-serif;
            }
            img {
                max-width: 100%;
                height: auto;
                margin-bottom: 20px;
            }
        </style>
    `);
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContents);
    printWindow.document.write('</body></html>');

    printWindow.document.close();
    printWindow.focus();
    printWindow.onload = function () {
        printWindow.print();
        printWindow.close();
    };
}


    function displayTablePayment(data) {
        let div = '';
        data.forEach((item, i) => {
            div += `
            <div class="card-body position-relative mb-5">
                <button class="btn btn-primary position-absolute top-0 end-0 m-3" onclick="printSelected(${item.id})">
                    <i class="bi bi-printer"></i> Cetak
                </button>
                <h4 class="card-title text-center mb-4">Detail Pembayaran</h4>
                <div class="mb-3">
                    <h5 class="fw-bold">Nomor Pemesanan: <span class="text-primary">#${item.order_id}</span></h5>
                </div>
                <div class="mb-3">
                    <p class="mb-1"><strong>Tanggal Pemesanan:</strong> ${item.updated_at}</p>
                    <p class="mb-1">
                        <strong>Status Pembayaran:</strong>
                        <span class="badge ${getStatusBadgeClass(item.status)}">${item.status}</span>
                    </p>
                    <p><strong>Total Pembayaran:</strong> <span class="text-success">${formatRupiah(item.total_price)}</span></p>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="https://app.sandbox.midtrans.com/snap/v2/vtweb/${item.snap_token}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-link-45deg"></i> Lihat Transaksi
                    </a>
                    <a href="javascript:void(0)" class="btn btn-outline-secondary btn-sm" onclick="viewItems(${item.id})">
                        <i class="bi bi-box-seam"></i> Lihat Barang
                    </a>
                    <a href="/delivery?id=${item.id}" target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-truck"></i> Lihat Pengiriman
                    </a>
                </div>
            </div>

            <div id="print-area-${item.id}" class="d-none">
                <div class="container rounded bg-white my-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <img src="/assets/organic/images/logo.svg" alt="logo" class="img-fluid mb-3">
                            <hr>
                            <h4 class="card-title text-center mb-4">Detail Pembayaran</h4>
                            <div class="mb-3">
                                <h5 class="fw-bold">Nomor Pemesanan: <span class="text-primary">#${item.order_id}</span></h5>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Tanggal Pemesanan:</strong> ${item.updated_at}</p>
                                <p class="mb-1">
                                    <strong>Status Pembayaran:</strong>
                                    <span class="badge ${getStatusBadgeClass(item.status)}">${item.status}</span>
                                </p>
                                <p><strong>Total Pembayaran:</strong> ${formatRupiah(item.total_price)}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
        });

        $('#payment-data').html(div);
    }

    function loadData() {
        $.ajax({
            url: '/api/v1/transactions/user',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                const order = response.data;
                displayTablePayment(order);
            },
            error: function (xhr, status, error) {
                console.error('Gagal mengambil data pembayaran:', error);
            }
        });
    }

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    function getStatusBadgeClass(status) {
        switch (status.toLowerCase()) {
            case 'pending':
                return 'bg-warning';
            case 'cancel':
                return 'bg-danger';
            case 'settlement':
                return 'bg-primary';
            default:
                return 'bg-secondary';
        }
    }

    function viewItems(id) {
        $.ajax({
            url: '/api/v1/transactionsitems/inventory/' + id, 
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response.data);
                    displayItems(response.data); 
            },
            error: function(xhr, status, error) {
                console.error('Gagal mengambil data barang:', error);
                alert('Terjadi kesalahan, coba lagi nanti.');
            }
        });
    }

    function displayItems(items) {
    let totalHarga = 0;
    let html = `
        <div class="container-fluid px-2 px-md-5 mt-5">
        <h3 class="text-center mb-4">Daftar Barang</h3>
        <div class="text-end mb-3">
            <button class="btn btn-primary" onclick="window.location.reload()">Kembali</button>
        </div>
        <div class="table-responsive">
            <table id="itemsTable" class="table table-bordered table-striped">
            <thead class="table-dark text-center align-middle">
                <tr>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
    `;

    items.forEach(function(item) {
        const subtotal = item.items_price * item.quantity;
        totalHarga += subtotal;

        html += `
        <tr>
            <td class="text-center"><img src="${item.item_image_url}" alt="${item.productitems_name}" class="img-fluid" style="max-width: 80px;"></td>
            <td>${item.productitems_name}</td>
            <td>${formatRupiah(item.items_price)}</td>
            <td>${item.quantity}</td>
            <td>${formatRupiah(subtotal)}</td>
        </tr>
        `;
    });

    html += `
            </tbody>
            </table>
        </div>
        <div class="text-end fw-bold mt-3">
            Total Harga: ${formatRupiah(totalHarga)}
        </div>
        </div>
    `;

    $('#payment-data').html(html); 
    $('#itemsTable').DataTable();
    }




    loadData();
  </script>

  <?= view('/pages/user/components/include/link') ?>
</body>
</html>