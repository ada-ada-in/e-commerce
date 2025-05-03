<?= view('pages/user/components/include/nav-header/head') ?>

<style>
    .cart-selected {
        background-color: #e6f7ff;
    }
</style>

<body>

    <?= view('pages/user/components/include/nav-header/cart') ?>
    <?= view('pages/user/components/include/nav-header/header') ?>

    <div class="container rounded bg-white mb-5">
        <div class="row">
            <div class="col-7">
                <div class="card shadow-sm border-1 mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" class="me-3" id="select-all">
                            <div class="card-title mb-0">Pilih Semua (0)</div>
                        </div>
                    </div>
                </div>

                <div id="checkout-data">
                    <!-- Data keranjang akan dimuat di sini -->
                </div>
            </div>

            <div class="col-5">
                <div class="card shadow-sm border-1">
                    <div class="card-body">
                        <hr>
                        <h4 class="card-title text-center mb-4">Detail Pembayaran</h4>
                        <div class="mb-3" id="payment-details">
                            <!-- Rincian item akan muncul di sini -->
                        </div>
                        <form>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Total Harga:</strong> <span id="total-price">Rp 0</span></p>
                                <p class="mb-1"><strong>Ongkos Kirim:</strong> Rp 10.000</p>
                                <p><strong>Total Pembayaran:</strong> <span class="text-success" id="final-price">Rp 10.000</span></p>
                                <select class="form-select" required id="delivery-option" aria-label="Default select example">
                                    <option selected disabled>Pilih Metode Pengantaran</option>
                                    <option value="order">Diantar</option>
                                    <option value="pickup">Ambil Sendiri</option>
                                </select>
                                <label for="delivery-note" class="form-label"><strong>Alamat Pengiriman :</strong></label>
                                <textarea required class="form-control mb-3 shadow-sm" rows="3" id="delivery-note" placeholder="Contoh: Jl. Raya No. 123, Jambi"></textarea>
                                </div>
                            <div class="text-center">
                                <button class="btn btn-primary w-100" id="payment-button" disabled>Lanjutkan Pembayaran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    let checkoutItems = [];
    let selectedItemIds = [];

    function loadDataCart() {
        $.ajax({
            url: '/api/v1/cartitems/user',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response && response.data) {
                    checkoutItems = response.data;
                    selectedItemIds = [];
                    displayTableCart(checkoutItems);
                    updateCartCount(0);
                    updateTotalPrice();
                    $('#select-all').prop('checked', false);
                } else {
                    console.error('No data found in the response.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Failed to fetch cart items:', error);
            }
        });
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    }

    function updateCartCount(count) {
        $('#select-all').next('.card-title').text(`Pilih Semua (${count})`);
        $('#cart-count').text(count);
    }

    function getSelectedItems() {
        return checkoutItems.filter(item => selectedItemIds.includes(parseInt(item.id)));
    }

    function updateTotalPrice() {
        const selectedItems = getSelectedItems();
        let total = 0;
        let detailHTML = '';

        selectedItems.forEach(item => {
            total += parseInt(item.total_price);
            detailHTML += `
                <div class="d-flex justify-content-between">
                    <span>${item.cart_product_name}</span>
                    <span>${item.quantity} x ${formatRupiah(item.total_price / item.quantity)}</span>
                </div>
            `;
        });

        const deliveryOption = $('#delivery-option').val();
        const deliveryFee = deliveryOption === 'order' ? 10000 : 0;

        $('#total-price').text(formatRupiah(total));
        $('#final-price').text(formatRupiah(total + deliveryFee));
        $('#payment-details').html(detailHTML);

        return total + deliveryFee;
    }

    function displayTableCart(data) {
        let div = '';
        data.forEach((item) => {
            div += `
                <div class="card shadow-sm border-1 mb-3" data-id="${item.id}">
                    <div class="card-body position-relative">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" class="me-3 cart-checkbox" data-id="${item.id}">
                            <img src="${item.cart_product_image_url}" height="100" width="100" alt="Product Image" class="img-thumbnail me-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">${item.cart_product_name}</h6>
                                <div class="d-flex align-items-center">
                                    <input 
                                        type="number" 
                                        min="1" 
                                        value="${item.quantity}" 
                                        onchange="updateQuantityFromInput(${item.id}, this.value)" 
                                        class="form-control form-control-sm w-50"
                                    >
                                </div>
                            </div>
                            <div class="text-end flex-grow-1">
                                <p class="mb-0" id="price-item-${item.id}">${formatRupiah(item.total_price)}</p>
                                <button class="btn btn-outline-danger btn-sm" onclick="deleteCartItem(${item.id})">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        $('#checkout-data').html(div);
    }

    function updateQuantity(id, newQuantity) {
        if (newQuantity < 1) return;
        const item = checkoutItems.find(i => i.id == id);
        if (!item) return;

        const payload = {
            product_id: item.product_id,
            user_id: item.user_id,
            quantity: newQuantity
        };

        $.ajax({
            url: `/api/v1/cartitems/${id}`,
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify(payload),
            success: function () {
                loadDataCart();
            },
            error: function (xhr, status, error) {
                console.error('Error updating quantity:', error);
            }
        });
    }

    function updateQuantityFromInput(id, newQuantity) {
        newQuantity = parseInt(newQuantity);
        if (isNaN(newQuantity) || newQuantity < 1) return;
        updateQuantity(id, newQuantity);
    }

    function deleteCartItem(id) {
        $.ajax({
            url: `/api/v1/cartitems/${id}`,
            type: 'DELETE',
            dataType: 'json',
            success: function (response) {
                if (response && response.status) {
                    loadDataCart();
                } else {
                    console.error('Failed to delete cart item:', response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Failed to delete cart item:', error);
            }
        });
    }

    $(document).ready(function () {
        loadDataCart();

        $('#select-all').on('change', function () {
            const checked = $(this).is(':checked');
            $('.cart-checkbox').prop('checked', checked);

            selectedItemIds = checked ? checkoutItems.map(i => parseInt(i.id)) : [];

            updateCartCount(selectedItemIds.length);
            updateTotalPrice();
            $('#payment-button').prop('disabled', selectedItemIds.length === 0);

            $('.cart-checkbox').each(function () {
                const card = $(this).closest('.card');
                checked ? card.addClass('cart-selected') : card.removeClass('cart-selected');
            });
        });

        $(document).on('change', '.cart-checkbox', function () {
            const id = parseInt($(this).data('id'));
            const card = $(this).closest('.card');
            const isChecked = $(this).is(':checked');

            if (isChecked) {
                if (!selectedItemIds.includes(id)) {
                    selectedItemIds.push(id);
                }
                card.addClass('cart-selected');
            } else {
                selectedItemIds = selectedItemIds.filter(itemId => itemId !== id);
                card.removeClass('cart-selected');
            }

            updateCartCount(selectedItemIds.length);
            updateTotalPrice();
            $('#payment-button').prop('disabled', selectedItemIds.length === 0);
            $('#select-all').prop('checked', selectedItemIds.length === checkoutItems.length);
        });

        $('.form-select').on('change', function () {
            updateTotalPrice();
        });

        $('#payment-button').on('click', function (e) {
            e.preventDefault();
            const totalInfo = updateTotalPrice();
            const deliveryNote = $('#delivery-note').val();
            const deliveryOption = $('.form-select').val();

            const payload = {
                total_price: totalInfo,
                address: deliveryNote,
                cart_items_ids: selectedItemIds,
                status_delivery: deliveryOption
            };

            $.ajax({
                url: '/api/v1/transactions',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                success: function (response) {
                    const paymentUrl = response.redirect_url;
                    alert('checkout berhasil, silahkan lakukan pembayaran!');
                    window.location.href = `${paymentUrl}`;
                },
                error: function (xhr, status, error) {
                    console.error('Error during checkout:', error);
                }
            });
        });
    });
    </script>

    <?= view('pages/user/components/include/link') ?>
</body>
</html>
