<section class="pb-5">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between my-4">
                    <h2 class="section-title">Products</h2>
                    <div class="d-flex align-items-center">
                        <a href="#" class="btn btn-primary rounded-1">View All</a>
                    </div>
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
                    <div class="product-item ">
                        <figure>
                            <a href="product-details.html?id=${product.id}" title="${product.name}">
                                <img src="/${product.image_url}" alt="${product.name}" class="tab-image img-fluid" height="200" width="200">
                            </a>
                        </figure>
                        <div class="d-flex flex-column text-center">
                            <h3 class="fs-6 fw-normal">${product.name}</h3>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <span class="text-dark fw-semibold">${product.price}</span>
                            </div>
                            <div class="button-area p-3 pt-0">
                                <div class="row g-1 mt-2">
                                    <div class="col-3">
                                        <input type="number" name="quantity" class="form-control border-dark-subtle input-number quantity" value="1" min="1">
                                    </div>
                                    <div class="col-7">
                                        <a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart" data-id="{product.id}">
                                            <svg width="18" height="18"><use xlink:href="#cart"></use></svg> Add to Cart
                                        </a>
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

    $(document).ready(function () {
        loadDataProduct();
    });
</script>