<section class="py-5 overflow-hidden">
  <div class="container-lg">
    <div class="row">
      <div class="col-md-12">
        <div class="section-header d-flex flex-wrap justify-content-between mb-5">
          <h2 class="section-title">Category</h2>
          <div class="d-flex align-items-center">
            <a href="#" class="btn btn-primary me-2">View All</a>
            <div class="swiper-buttons">
              <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
              <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="category-carousel swiper">
          <div class="swiper-wrapper" id="category-data">
            <!-- Categories will be injected here -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
    let category = [];

    function displayTable(data) {
        let div = '';
        data.forEach((category) => {
            div += `
                <a href="category.html" class="nav-link swiper-slide text-center">
                    <img src="/${category.image_url}" class="rounded-circle" height="150" width="150" alt="${category.name}">
                    <h4 class="fs-6 mt-3 fw-normal category-title">${category.name}</h4>
                </a>
            `;
        });

        $('#category-data').html(div);
    }

    function loadDataCategory() {
        $.ajax({
            url: '/api/v1/category',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                category = response.data;
                displayTable(category);
            },
            error: function (xhr, status, error) {
                console.error('Gagal mengambil data category:', error);
            }
        });
    }

    loadDataCategory();
</script>
