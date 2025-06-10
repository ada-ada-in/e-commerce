<?= view('pages/user/components/include/nav-header/head') ?>
<body>
  <!-- navbar -->
  <?= view('pages/user/components/include/nav-header/cart') ?>
  <?= view('/pages/user/components/include/nav-header/header') ?>

  <div class="container my-5">
    <div class="card shadow-sm">
      <div class="card-header">
        <h5 class="mb-0 fw-semibold">Status Pengiriman</h5>
        <small id="order-date" class="text-muted">--</small>
        <hr class="my-3" />
        <h6 class="fw-semibold mb-1">Tracking Number</h6>
        <p id="tracking-number" class="mb-0">--</p>
      </div>

      <div class="card-body">
        <div class="d-flex justify-content-between text-center">
          <!-- 1. dibuat -->
          <div class="flex-fill">
            <i id="icon-order" class="bi bi-cart-check fs-4 text-secondary" aria-label="Pesanan Dibuat"></i>
            <p class="small mb-0">Dibuat</p>
          </div>

          <div class="flex-fill border-top border-5 mx-2" style="margin-top:15px"></div>

          <!-- 2. dibayar -->
          <div class="flex-fill">
            <i id="icon-paid" class="bi bi-credit-card fs-4 text-secondary" aria-label="Pesanan Dibayarkan"></i>
            <p class="small mb-0">Dibayarkan</p>
          </div>

          <div class="flex-fill border-top border-5 mx-2" style="margin-top:15px"></div>

          <!-- 3. diproses / siap pickup -->
          <div class="flex-fill">
            <i id="icon-box" class="bi bi-box-seam fs-4 text-secondary" aria-label="Siap Pickup"></i>
            <p class="small mb-0">Ambil Di Tempat</p>
          </div>

          <div class="flex-fill border-top border-5 mx-2" style="margin-top:15px"></div>

          <!-- 4. dikirim -->
          <div class="flex-fill">
            <i id="icon-send" class="bi bi-truck fs-4 text-secondary" aria-label="Dikirim"></i>
            <p class="small mb-0">Dikirim</p>
          </div>

          <div class="flex-fill border-top border-5 mx-2" style="margin-top:15px"></div>

          <!-- 5. selesai -->
          <div class="flex-fill">
            <i id="icon-complete" class="bi bi-check-circle-fill fs-4 text-secondary" aria-label="Selesai"></i>
            <p class="small mb-0">Selesai</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- libs -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script>
    (function() {
      const urlParams = new URLSearchParams(window.location.search);
      const id = urlParams.get('id');

      // urutkan sesuai alur proses
      const STEP_ICONS = ['icon-order', 'icon-paid', 'icon-box', 'icon-send', 'icon-complete'];

      function highlightSteps(upto) {
        // reset
        STEP_ICONS.forEach(i => {
          document.getElementById(i).classList.replace('text-success', 'text-secondary');
        });
        // aktifkan sampai indeks 'upto' (inklusif)
        for (let i = 0; i <= upto; i++) {
          document.getElementById(STEP_ICONS[i]).classList.replace('text-secondary', 'text-success');
        }
      }

      $.when(
        $.getJSON(`/api/v1/transactions/${id}`),
        $.getJSON(`/api/v1/delivery/transactions/${id}`)
      )
      .done(function(txRes, dlRes) {
        const tx = txRes[0].data || {};
        const dl = dlRes[0].data || {};

        // Tanggal order dalam locale ID
        const createdAt = tx.created_at ? new Date(tx.created_at).toLocaleString('id-ID') : '--';
        $('#order-date').text(createdAt);

        // tracking number
        $('#tracking-number').text(dl.tracking_number || '--');

        let stepIndex = 0;
        if (tx.status === 'settlement') stepIndex = 1;
        if (dl.status === 'pickup') {
            stepIndex = 2;
             $('#icon-send').parent().hide()
        } 
        if (dl.status === 'send') {
            stepIndex = 3;
            $('#icon-box').parent().hide();
        }  
        if (dl.status === 'complete') stepIndex = 4;

        highlightSteps(stepIndex);
      })
      .fail(xhr => console.error('Gagal mengambil data:', xhr?.responseText));
    })();
  </script>

  <?= view('/pages/user/components/include/link') ?>
</body>
</html>
