
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>MM Barokah 4 Putra</title>
    <link href="/assets/focus2/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign up your account</h4>
                                    <form id="form-register">
                                        <div class="form-group">
                                            <label><strong>Username</strong></label>
                                            <input type="text" name="name" class="form-control" placeholder="username">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Alamat</strong></label>
                                            <input type="text" name="address" class="form-control" placeholder="Kota Baru">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" placeholder="hello@example.com">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Handphone</strong></label>
                                            <input type="number" name="phone" class="form-control" placeholder="08xxxxxxxxx">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control" placeholder="password">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Confirm Password</strong></label>
                                            <input type="password" name="confirm_password" class="form-control" placeholder="confirm password">
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Already have an account? <a class="text-primary" href="<?= base_url('auth/login') ?>">Sign in</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= view('auth/script-auth') ?>

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="/assets/focus2/vendor/global/global.min.js"></script>
    <script src="/assets/focus2/js/quixnav-init.js"></script>
    <!--endRemoveIf(production)-->
</body>

</html>