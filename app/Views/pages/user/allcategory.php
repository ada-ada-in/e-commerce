<?= view('pages/user/components/include/nav-header/head') ?>
<body>

<!-- navbar -->
<?= view('pages/user/components/include/nav-header/cart') ?>
<?= view('/pages/user/components/include/nav-header/header') ?>

<section class="py-5 overflow-hidden">
  <div class="container-lg">
    <div class="row">
      <div class="col-md-12">
        <div class="section-header d-flex flex-wrap justify-content-between mb-5">
          <h2 class="section-title">Category</h2>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div id="category-data" class="d-flex flex-wrap justify-content-center">
          <!-- Categories will be injected here -->
        </div>
      </div>
    </div>
  </div>
</section>

<script>
    let categories = [];

    function displayTableProduct(data) {
        let html = '';
        data.forEach((category) => {
            html += `
            <div class="text-center m-3">
                <a href="productcategory?id=${category.id}" class="nav-link">
                    <img src="/${category.image_url}" class="rounded-circle" height="150" width="150" alt="${category.name}">
                    <h4 class="fs-6 mt-3 fw-normal category-title">${category.name}</h4>
                </a>
            </div>
            `;
        });

        $('#category-data').html(html);
    }

    function loadDataCategory() {
        $.ajax({
            url: '/api/v1/category',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                categories = response.data;
                displayTableProduct(categories);
            },
            error: function (xhr, status, error) {
                console.error('Gagal mengambil data category:', error);
            }
        });
    }

    $(document).ready(function () {
        loadDataCategory();
    });
</script>

<?= view('/pages/user/components/include/footer') ?>
</body>
</html>
