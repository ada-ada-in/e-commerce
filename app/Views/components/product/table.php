
                <div class="row">
                    <div class="col-12">
                        <div class="card border border-0">
                            <div class="card-header bg-white">
                                <h4 class="card-title">Product Datatable</h4>
                                <div>
                                    <button type="button" class="btn btn-primary px-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    +
                                    </button>
                                    <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="icon-printer"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Excel</a></li>
                                    <li><a class="dropdown-item" href="#">PDF</a></li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            <div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display table table-striped table-responsive-sm" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Nama Produk</th>
                                                <th>Stok</th>
                                                <th>Harga</th>
                                                <th>Kategori</th>
                                                <th>Deskripsi</th>
                                                <th>Gambar</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id='product-data'>
                                           <!-- data product  -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <script>
                 $(function () {
                    $.ajax({
                        url: '/api/v1/products', 
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                        const products = response.data;
                        console.log(products)
                        const tbody = $('#product-data');
                        tbody.empty(); 

                        transactions.forEach(function (trx) {
                            const paymentMethod = trx.payment_methode || '-';
                            const orderId = trx.order_id || '-';
                            const status = trx.payment_status || 'unknown';
                            const createdAt = trx.created_at || '';

                            const row = `
                            <tr>
                                <td>${paymentMethod}</td>
                                <td>${orderId}</td>
                                <td>
                                <span class="badge badge-${getStatusClass(status)}">
                                    ${capitalize(status)}
                                </span>
                                </td>
                                <td>${formatDate(createdAt)}</td>
                            </tr>
                            `;
                            tbody.append(row);
                        });
                        },
                        error: function (xhr, status, error) {
                        console.error('Gagal mengambil data transaksi:', error);
                        }
                    });
                }
                </script>

<?= view('components/product/add-modal-product') ?>