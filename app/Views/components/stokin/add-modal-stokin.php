<!-- Modal -->
<div class="modal fade" id="addmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="form-add-stok">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Inventory</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="basic-form">
            <div class="row">
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

          $('#form-add-stok').on('submit', function (e) {
            e.preventDefault();
            const form = $('#form-add-stok');
            const formData = {
                product_id: form.find('select[name="product"]').val(),
                quantity: form.find('input[name="quantity"]').val()
            };
            $.ajax({
                url: `/api/v1/stokin`,
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function (response) {
                    const message = response.message || 'Stok berhasil ditambahkan.';
                    alert(message)
                    $('#form-add-stok')[0].reset();
                    window.location.reload();
                },
                error: function (xhr, status, error) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        let errorMessage = '';
                        if (response.messages) {
                            for (const key in response.messages) {
                                if (response.messages.hasOwnProperty(key)) {
                                    errorMessage += `${response.messages[key]}\n`;
                                }
                            }
                        } else if (response.message) {
                            errorMessage = response.message;
                        } else {
                            errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
                        }
                        alert(errorMessage); 
                    } catch (e) {
                        console.error('Gagal parse response error:', e);
                        alert('Terjadi kesalahan saat memproses respons error.');
                    }
                }
            });
        });
</script>