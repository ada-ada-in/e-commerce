<?= $this->extend('layouth/main_layout') ?>
<?= $this->section('content') ?>

                <div class="row page-titles mx-0">
                    <div class="col-sm-12 p-md-0">
                        <div class="welcome-text">
                            <h4>Profile Page</h4>
                        </div>
                                        <div class="card my-5">
                                            <div class="card-body">
                                                <div class="basic-form">
                                                    <form>

                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>Username</label>
                                                                <input type="text" class="form-control" placeholder="Username">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Email</label>
                                                                <input type="email" class="form-control" placeholder="Email">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Handphone</label>
                                                                <input type="number" class="form-control" placeholder="handphone">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Alamat</label>
                                                                <input type="text" class="form-control" placeholder="Alamat">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Passowrd</label>
                                                                <input type="password" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Confirn Password</label>
                                                                <input type="confirm_password" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-4">
                                                                <label>Role</label>
                                                                <select id="inputState" class="form-control">
                                                                    <option selected disabled>Pilih Role...</option>
                                                                    <option value="admin">Admin</option>
                                                                    <option value="users">Users</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Sign in</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                    </div>
                </div>

<?= $this->endSection() ?> 

<script>
    $.ajax({
        url: '/api/v1/users/profile',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data)
            // // Populate the form with the fetched data
            $('input[name="username"]').val(data.username);
            $('input[name="email"]').val(data.email);
            $('input[name="handphone"]').val(data.handphone);
            $('input[name="alamat"]').val(data.alamat);
            // Handle other fields similarly
        },
        error: function(xhr, status, error) {
            console.error('Error fetching profile data:', error);
        }
    });
</script>