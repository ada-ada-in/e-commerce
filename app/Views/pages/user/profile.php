<?= view('pages/user/components/include/nav-header/head') ?>
  <body>

    <!-- navbar -->

    <?= view('pages/user/components/include/nav-header/cart') ?>
    
    <?= view('/pages/user/components/include/nav-header/header') ?>


        
<div class="container rounded bg-white mb-5">
    <div class="row">
        <div class="col-md-12 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class=" shadow-sm mb-3">
                            <label class="labels">Username</label>
                            <input type="text" class="form-control shadow-sm" name="name" placeholder="enter username" >
                        </div>
                        <div class=" shadow-sm mb-3">
                            <label class="labels">Email</label>
                            <input type="email" class="form-control shadow-sm" name="email" placeholder="enter email">
                        </div>
                        <div class=" shadow-sm mb-3">
                            <label class="labels">Mobile Number</label>
                            <input type="number" class="form-control shadow-sm" name="phone" placeholder="enter phone number" value="">
                        </div>
                    </div>
                    <div class="col-md-6 shadow-sm gap">
                        <div class=" shadow-sm mb-3">
                            <label class="labels">Address</label>
                            <input type="text" class="form-control shadow-sm" name="address" placeholder="enter address">
                        </div>
                        <div class=" shadow-sm mb-3">
                            <label class="labels">Password</label>
                            <input type="password" class="form-control shadow-sm" name="password" placeholder="enter password">
                        </div>
                        <div class=" shadow-sm mb-3">
                            <label class="labels">Confirm Password</label>
                            <input type="password" class="form-control shadow-sm" name="confirm_password" placeholder="enter confirm password">
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Update Profile</button></div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
    <?= view('/pages/user/components/include/link') ?>


    <script>

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
                    console.error('Error fetching profile data. ', error);
                }
            });
        }

        loadData();

        $(document).ready(function() {
            $('.profile-button').on('click', function() {
                const id = localStorage.getItem('user_id');
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

                console.log('Form Data:', formData);    

                $.ajax({
                    url: '/api/v1/users/' + localStorage.getItem('userId'),
                    type: 'PUT',    
                    data: JSON.stringify(formData),
                    success: function(response) {
                        alert(response.message || 'Profile updated successfully!');
                        loadData(); 
                        window.location.href = '/auth/login'; 
                    },
                    error: function(error) {
                        console.error('Error updating profile. ', error);
                        alert('Failed to update profile.');
                    }
                });
            });
        });

    </script>

  </body>
</html>