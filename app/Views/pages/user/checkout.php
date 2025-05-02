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
                        <div class="mb-3">
                            <p class="mb-1"><strong>Total Harga:</strong> <span id="total-price">Rp 0</span></p>
                            <p class="mb-1"><strong>Ongkos Kirim:</strong> Rp 10.000</p>
                            <p><strong>Total Pembayaran:</strong> <span class="text-success" id="final-price">Rp 10.000</span></p>
                            <select class="form-select">
                                <option selected>Pilih Pengantaran</option>
                                <option value="1">Diantar</option>
                                <option value="2">Ambil Sendiri</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary w-100" id="payment-button" disabled>Lanjutkan Pembayaran</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    let checkoutItems = [];
    let selectedItemIds = [];

    // Mengambil data cart
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

    
    function updateTotalPrice() {
        const selectedItems = checkoutItems.filter(item => selectedItemIds.includes(item.id));
        let totalPrice = selectedItems.reduce((sum, item) => sum + parseInt(item.total_price), 0);
        const deliveryOption = $('.form-select').val();
        const deliveryFee = deliveryOption === '1' ? 10000 : 0;
        
        $('#total-price').text(formatRupiah(totalPrice));
        $('#final-price').text(formatRupiah(totalPrice + deliveryFee));
    }
    
    function updateCartCount(count) {
        $('#select-all').next('.card-title').text(`Pilih Semua (${count})`);
        $('#cart-count').text(count);
    }
    
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
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

        // Pilih Semua
        $('#select-all').on('change', function () {
            const checked = $(this).is(':checked');
            $('.cart-checkbox').prop('checked', checked);

            selectedItemIds = checked ? checkoutItems.map(i => i.id) : [];
            updateCartCount(selectedItemIds.length);
            console.log(selectedItemIds);
            updateTotalPrice();
            $('#payment-button').prop('disabled', selectedItemIds.length === 0);

            $('.cart-checkbox').each(function () {
                const card = $(this).closest('.card');
                if (checked) {
                    card.addClass('cart-selected');
                } else {
                    card.removeClass('cart-selected');
                }
            });
        });

        // Checkbox individual
        $(document).on('change', '.cart-checkbox', function () {
            const id = parseInt($(this).data('id'));
            const card = $(this).closest('.card');

            if ($(this).is(':checked')) {
                if (!selectedItemIds.includes(id)) {
                    selectedItemIds.push(id);
                }
                card.addClass('cart-selected');
            } else {
                selectedItemIds = selectedItemIds.filter(itemId => itemId !== id);
                card.removeClass('cart-selected');
            }


            $('#select-all').prop('checked', selectedItemIds.length === checkoutItems.length);
            updateCartCount(selectedItemIds.length);
            updateTotalPrice();
            $('#payment-button').prop('disabled', selectedItemIds.length === 0);
        });
        
        $('.form-select').on('change', function () {
            updateTotalPrice();
        });
    });
    </script>

    <?= view('pages/user/components/include/link') ?>
</body>
</html>
