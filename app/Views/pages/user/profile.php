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
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Save Profile</button></div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
    

    <?= view('/pages/user/components/include/link') ?>


  </body>
</html>