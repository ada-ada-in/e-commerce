<!-- Modal -->
<div class="modal fade" id="editmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="form-update-user">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Users</h1>
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
              <input type="text" name="id" class="form-control" placeholder="id" hidden required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary submit-update">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
