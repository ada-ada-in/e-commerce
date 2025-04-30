<?= view('pages/user/components/include/nav-header/head') ?>
  <body>

    <!-- navbar -->

    <?= view('pages/user/components/include/nav-header/cart') ?>
    
    <?= view('/pages/user/components/include/nav-header/header') ?>


            
        <div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Items</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Item Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Price Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contoh Data -->
                    <tr>
                        <th scope="row">1</th>
                        <td>
                            <img src="https://via.placeholder.com/50" alt="Item 1" class="img-thumbnail">
                        </td>
                        <td>Item 1</td>
                        <td>2</td>
                        <td>Rp 500.000</td>
                        <td>Rp 1.000.000</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>
                            <img src="https://via.placeholder.com/50" alt="Item 2" class="img-thumbnail">
                        </td>
                        <td>Item 2</td>
                        <td>1</td>
                        <td>Rp 300.000</td>
                        <td>Rp 300.000</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>
                            <img src="https://via.placeholder.com/50" alt="Item 3" class="img-thumbnail">
                        </td>
                        <td>Item 3</td>
                        <td>3</td>
                        <td>Rp 200.000</td>
                        <td>Rp 600.000</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Price Total:</th>
                        <th>Rp 1.900.000</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    

    <?= view('/pages/user/components/include/link') ?>


  </body>
</html>