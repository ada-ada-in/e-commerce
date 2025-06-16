<?= view('pages/user/components/include/nav-header/head') ?>
  <body>

    <!-- navbar -->

    <?= view('pages/user/components/include/nav-header/cart') ?>
    
    <?= view('/pages/user/components/include/nav-header/header') ?>


    <section class="pb-5">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between my-4">
                    <h2 class="section-title">Products</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5" id="product-data">
                    <!-- Product items will be injected here -->
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let product = [];

    function displayTableProduct(data) {
        let div = '';
        data.forEach((product) => {
            div += `
                <div class="col">
                    <div class="product-item">
                        <figure>
                            <a href="#" title="${product.name}">
                                <img src="/${product.image_url}" alt="${product.name}" class="tab-image img-fluid" height="200" width="200">
                            </a>
                        </figure>
                        <div class="d-flex flex-column text-center">
                            <h3 class="fs-6 fw-normal">${product.name}</h3>
                            <p>Stok : ${product.stock}</p>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <span class="text-dark fw-semibold">${product.price}</span>
                            </div>
                            <div class="button-area p-3 pt-0">
                                <div class="row g-1 mt-2">
                                    <div class="col-3">
                                        <input type="number" name="quantity" class="form-control border-dark-subtle input-number quantity" value="1" min="1">
                                    </div>
                                    <div class="col-7">
                                        <button type="button" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart" data-id="${product.id}">
                                            <svg width="18" height="18"><use xlink:href="#cart"></use></svg> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        $('#product-data').html(div);
    }

    function loadDataProduct() {
        $.ajax({
            url: '/api/v1/products',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                product = response.data;
                displayTableProduct(product);
            },
            error: function (xhr, status, error) {
                console.error('Failed to fetch product data:', error);
            }
        });
    }

    function addToCart(id, quantity) {

        const payload = {
        product_id: id, // Ensure this is the correct id
        quantity: quantity // Ensure this is a valid number
         };

        $.ajax({
            url: '/api/v1/cartitems',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify(payload),
            success: function (response) {

                    alert('Product added to cart successfully!');
                    if (typeof loadDataCart === 'function') loadDataCart();

            },  
            error: function (xhr, status, error) {
                console.error('Failed to add product to cart:', error);
                console.error('Response:', xhr.responseText); 

                try {
                    const res = JSON.parse(xhr.responseText);
                   
                    message = res.messages.quantity; 

                    alert(message)

                } catch (e) {
                    console.error('JSON parse error:', e);
                }
            }
        });
    }

    $(document).ready(function () {
        loadDataProduct();

        $(document).on('click', '.btn-cart', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            const quantityInput = $(this).closest('.row').find('input.quantity');
            const quantity = parseInt(quantityInput.val()) || 1;
            addToCart(id, quantity);
            console.log('Product ID:', id, 'Quantity:', quantity);
        });
    });
</script>

 

    <?= view('/pages/user/components/include/footer') ?>


  </body>
</html>