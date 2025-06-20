<!-- Modal -->
<div class="modal fade" id="editmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="form-update-stok">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Inventory</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="basic-form">
            <div class="row">
              <input type="text" name="id" class="form-control" placeholder="id"
               hidden>
              <div class="col-sm-6 mt-3">
                <select name="product" class="form-select" required>
                </select>
              </div>
              <div class="col-sm-6 mt-3">
                <input type="text" name="quantity" class="form-control" placeholder="quantity">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
  
<script>
  $.ajax({
    url: '/api/v1/products',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
        const data = response.data;
        let options = '<option value="" disabled selected>Pilih Produk</option>';
        data.forEach(function(product) {
            options += `<option value="${product.id}">${product.name}</option>`;
        });
        $('select[name="product"]').html(options);
    },
    error: function(xhr, status, error) {
        console.error('Error fetching products:', error);
    }
  });

</script>