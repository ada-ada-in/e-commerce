<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart">
    <div class="offcanvas-header justify-content-center">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Your cart</span>
                <span class="badge bg-primary rounded-pill" id="cart-count">0</span>
                </span>
            </h4>
            <ul class="list-group mb-3" id="cart-data">
               <!-- Cart items will be dynamically injected here -->
            </ul>   

            <a href="<?= base_url('/checkout') ?>" class="w-100 btn btn-primary btn-lg text-white text-decoration-none">
                Continue to checkout
            </a>
        </div>
    </div>
</div>

<script>
    let cartItems = [];

    function loadDataCart() {
        $.ajax({
            url: '/api/v1/cartitems/user', 
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response && response.data) {
                    cartItems = response.data;
                    displayTableCart(cartItems);
                    updateCartCount(cartItems.length);
                } else {
                    console.error('No data found in the response.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Failed to fetch cart items:', error);
            }
        });
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

    function displayTableCart(data) {
        let div = '';
        data.forEach((item) => {
            div += `
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">${item.cart_product_name}</h6>
                        <small class="text-body-secondary">Quantity: ${item.quantity}</small>
                    </div>
                    <span class="text-body-secondary">Rp. ${item.total_price}</span>
                    <button class="btn-close" aria-label="Close" onclick="deleteCartItem(${item.id})"></button>
                </li>
            `;
        });

        $('#cart-data').html(div);
    }

    function updateCartCount(count) {
        $('#cart-count').text(count);
    }

    $(document).ready(function () {
        loadDataCart();
    });
</script>

