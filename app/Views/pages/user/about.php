<?= view('pages/user/components/include/nav-header/head') ?>
<body>

    <!-- Navbar -->
    <?= view('pages/user/components/include/nav-header/cart') ?>
    <?= view('/pages/user/components/include/nav-header/header') ?>

    <!-- Hero Section -->
    <div class="container-fluid bg-light py-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Tentang Kami</h1>
            <p class="lead text-muted">Kami adalah platform e-commerce yang menyediakan produk berkualitas untuk kebutuhan Anda.</p>
        </div>
    </div>

    <!-- About Content -->
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <img src="images/mmbarokah-logo.png" alt="About Us" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
                <h2 class="fw-bold">Siapa Kami?</h2>
                <p>Kami adalah tim yang berdedikasi untuk memberikan pengalaman belanja online terbaik. Dengan berbagai produk berkualitas dan layanan pelanggan yang ramah, kami berkomitmen untuk memenuhi kebutuhan Anda.</p>
                <p>Visi kami adalah menjadi platform e-commerce terpercaya yang memberikan nilai tambah bagi pelanggan kami.</p>
                <p>Misi kami adalah menciptakan pengalaman belanja yang mudah, aman, dan menyenangkan untuk semua pelanggan kami.</p>
            </div>
        </div>
    </div>

    <!-- Mission Section -->
    <div class="container my-5">
        <h2 class="text-center fw-bold mb-4">Misi Kami</h2>
        <div class="row text-center">
            <div class="col-md-4">
                <i class="bi bi-box-seam fs-1 text-primary"></i>
                <h5 class="mt-3">Produk Berkualitas</h5>
                <p>Kami menyediakan produk terbaik dengan harga yang kompetitif.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-people fs-1 text-primary"></i>
                <h5 class="mt-3">Layanan Pelanggan</h5>
                <p>Tim kami selalu siap membantu Anda dengan layanan yang ramah dan cepat.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-globe fs-1 text-primary"></i>
                <h5 class="mt-3">Jangkauan Luas</h5>
                <p>Kami melayani pelanggan di seluruh Indonesia dengan pengiriman yang cepat dan aman.</p>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="container my-5">
        <h2 class="text-center fw-bold mb-4">Apa Kata Pelanggan Kami?</h2>
        <div class="row text-center">
            <div class="col-md-4">
                <div>
                    <img src="/images/woman-1.jpg" width="300" height="300" alt="Customer" class="img-fluid rounded-circle mb-3">
                    <h5>John Doe</h5>
                 </div>
                <blockquote class="blockquote">
                    <p>"Belanja di sini sangat mudah dan produknya berkualitas tinggi!"</p>
                    <footer class="blockquote-footer">Sarah, Jakarta</footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <div>
                    <img src="/images/man-1.jpg"  width="300" height="300"alt="Customer" class="img-fluid rounded-circle mb-3">
                    <h5>John Doe</h5>
                 </div>
                <blockquote class="blockquote">
                    <p>"Pengiriman cepat dan layanan pelanggan sangat membantu."</p>
                    <footer class="blockquote-footer">Andi, Surabaya</footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <div>
                    <img src="/images/woman-2.jpg" width="300" height="300" alt="Customer" class="img-fluid rounded-circle mb-3">
                    <h5>John Doe</h5>
                 </div>
                <blockquote class="blockquote">
                    <p>"Saya sangat puas dengan pengalaman belanja saya di sini."</p>
                    <footer class="blockquote-footer">Rina, Bandung</footer>
                </blockquote>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?= view('/pages/user/components/include/footer') ?>

</body>
</html>