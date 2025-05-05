<?= view('pages/user/components/include/nav-header/head') ?>
  <body>

    <!-- navbar -->
    <?= view('pages/user/components/include/nav-header/cart') ?>
    <?= view('/pages/user/components/include/nav-header/header') ?>

    <div class="container my-5">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Status Pengiriman</h5>
                <p id="order-date">--</p>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-center flex-fill">
                        <div class="mb-2">  
                            <i id="icon-order" class="bi bi-cart-check fs-4 text-secondary"></i>
                        </div>
                        <p class="mb-0">Pesanan Dibuat</p>
                    </div>
                    <div class="flex-fill border-top border-5 mx-2" style="margin-top: 15px; border-color:rgb(60, 57, 57);"></div>
                    <div class="text-center flex-fill">
                        <div class="mb-2">
                            <i id="icon-paid" class="bi bi-credit-card fs-4 text-secondary"></i>
                        </div>
                        <p class="mb-0">Pesanan Dibayarkan</p>
                    </div>
                    <div class="flex-fill border-top border-5 mx-2" style="margin-top: 15px; border-color:rgb(60, 57, 57);"></div>
                    <div class="text-center flex-fill">
                        <div class="mb-2">
                            <i id="icon-send" class="bi bi-truck fs-4 text-secondary"></i>
                        </div>
                        <p class="mb-0">Pesanan Dikirimkan</p>
                    </div>
                    <div class="flex-fill border-top border-5 mx-2" style="margin-top: 15px; border-color:rgb(60, 57, 57);"></div>
                    <div class="text-center flex-fill">
                        <div class="mb-2">
                            <i id="icon-complete" class="bi bi-check-circle-fill fs-4 text-secondary"></i>
                        </div>
                        <p class="mb-0">Pesanan Selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');

        let transactionStatus = '';
        let deliveryStatus = '';
        let orderDate = '';

        function updateIcons(transactionStatus, deliveryStatus) {
            // Reset all icons
            ['icon-order', 'icon-paid', 'icon-send', 'icon-complete'].forEach(id => {
                document.getElementById(id).classList.remove('text-success');
                document.getElementById(id).classList.add('text-secondary');
            });

            // Always created
            document.getElementById('icon-order').classList.replace('text-secondary', 'text-success');

            if (transactionStatus === 'settlement') {
                document.getElementById('icon-paid').classList.replace('text-secondary', 'text-success');

                if (deliveryStatus === 'send') {
                    document.getElementById('icon-send').classList.replace('text-secondary', 'text-success');
                }

                if (deliveryStatus === 'complete') {
                    document.getElementById('icon-send').classList.replace('text-secondary', 'text-success');
                    document.getElementById('icon-complete').classList.replace('text-secondary', 'text-success');
                }
            } else if (transactionStatus === 'pending') {
                // Do nothing more (only icon-order stays green)
            }
        }

        // Fetch both transaction and delivery data
        $.when(
            $.getJSON('/api/v1/transactions/' + id),
            $.getJSON('/api/v1/delivery/transactions/' + id)
        ).done(function(transactionRes, deliveryRes) {
            const transaction = transactionRes[0].data;
            const delivery = deliveryRes[0].data;

            transactionStatus = transaction.status;
            deliveryStatus = delivery.status;
            orderDate = transaction.created_at;

            // Update date in UI
            document.getElementById('order-date').textContent = orderDate;

            // Update progress icons
            updateIcons(transactionStatus, deliveryStatus);

        }).fail(function(xhr) {
            console.error('Error fetching data:', xhr.responseText);
        });
    </script>

    <?= view('/pages/user/components/include/link') ?>
  </body>
</html>
