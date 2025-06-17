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
                    <form id="profile-form">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Username</label>
                                <input type="text" class="form-control" name="name" placeholder="Username">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Handphone</label>
                                <input type="number" class="form-control" name="phone" placeholder="Handphone">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Alamat</label>
                                <input type="text" class="form-control" name="address" placeholder="Alamat">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Password</label>
                                <input type="password" placeholder="Password" name="password" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Confirm Password</label>
                                <input type="password" placeholder="Confirm Password" name="confirm_password" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary profile-button">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const userId = localStorage.getItem('userId');
    function loadData() {
        $.ajax({
            url: '/api/v1/users/profile',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const user = response.data[0];
                console.log(user);
                $('input[name="name"]').val(user.name);
                $('input[name="email"]').val(user.email);
                $('input[name="phone"]').val(user.phone);
                $('input[name="address"]').val(user.address);
            },
            error: function(error) {
                console.error('Error fetching profile data.', error);
            }
        });
    }

    loadData();

    $(document).ready(function() {
        $('#profile-form').on('submit', function(e) {
            e.preventDefault(); // Prevent normal form submission

            const userId = localStorage.getItem('userId');
            const name = $('input[name="name"]').val();
            const email = $('input[name="email"]').val();
            const phone = $('input[name="phone"]').val();
            const address = $('input[name="address"]').val();
            const password = $('input[name="password"]').val();
            const confirm_password = $('input[name="confirm_password"]').val();

            if (password !== confirm_password) {
                alert('Passwords do not match!');
                return;
            }

            const formData = {
                name: name,
                email: email,
                phone: phone,
                address: address,
                password: password,
                confirm_password: confirm_password
            };

            $.ajax({
                url: '/api/v1/users/' + userId,
                type: 'PUT',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                processData: false,
                success: function(response) {
                    alert(response.message || 'Profile updated successfully!');
                    loadData();
                    window.location.href = '/auth/login';
                },
                error: function(error) {
                    console.error('Error updating profile.', error);
                    alert('Failed to update profile.');
                }
            });
        });
    });
</script>

<?= $this->endSection() ?> 

