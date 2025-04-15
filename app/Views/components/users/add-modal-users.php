<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="form-add-user">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Users</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="basic-form">
            <div class="row">
              <div class="col-sm-6">
                <input type="text" name="name" class="form-control" placeholder="Nama" required>
              </div>
              <div class="col-sm-6 mt-2 mt-sm-0">
                <input type="email" name="email" class="form-control" placeholder="Email">
              </div>
              <div class="col-sm-6 mt-3">
                <input type="number" class="form-control" name="phone" placeholder="Handphone">
              </div>
              <div class="col-sm-6 mt-3">
                <select name="role" class="form-select" required>
                  <option value="" disabled selected>Pilih Role</option>
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                </select>
              </div>
              <div class="col-sm-6 mt-3">
                <input type="password" name="password" class="form-control" placeholder="Password">
              </div>
              <div class="col-sm-6 mt-3">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
              </div>
              <div class="col-sm-12 mt-3">
                <input type="text" name="address" class="form-control" placeholder="Alamat">
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

<!-- JS -->
<script>
  $(function () {
    $('#form-add-user').on('submit', function (e) {
      e.preventDefault();

      const formData = {
        name: $('input[name="name"]').val(),
        email: $('input[name="email"]').val(),
        phone: $('input[name="phone"]').val(),
        address: $('input[name="address"]').val(),
        role: $('select[name="role"]').val(),
        password: $('input[name="password"]').val(),
        confirm_password: $('input[name="confirm_password"]').val()
      };

      $.ajax({
            url: '/api/v1/auth/register',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function (response) {
                const message = response.message;
                alert(message);
                loadUsers();               
            },
            error: function (xhr) {
                const response = xhr.message;
                const errorMessage = response && response.message ? response.message : 'Gagal menambahkan user.';

                alert(errorMessage);
                console.error(xhr.responseText);
            }
            });

    });
  });
</script>
