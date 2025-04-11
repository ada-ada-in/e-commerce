<div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="ti-money text-success border-success"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Profit</div>
                                    <div class="stat-digit"><span id="profit"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="ti-user text-primary border-primary"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Customer</div>
                                    <div class="stat-digit">
                                        <span id="customers"></sp>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="ti-layout-grid2 text-pink border-pink"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Product</div>
                                    <div class="stat-digit">
                                        <span id="products"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="ti-link text-danger border-danger"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Orders</div>
                                    <div class="stat-digit"><span id="transactions"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <script>
                  $(function () {
                        $.ajax({
                            url: '/api/v1/users/countuser',
                            type: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                $('#customers').text(data.data.toLocaleString());
                            },
                            error: function (xhr, status, error) {
                                console.error('Gagal mengambil jumlah customer:', error);
                            }
                        });
                        $.ajax({
                            url: '/api/v1/products/countproduct',
                            type: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                $('#products').text(data.data.toLocaleString());
                            },
                            error: function (xhr, status, error) {
                                console.error('Gagal mengambil jumlah product:', error);
                            }
                        });
                        $.ajax({
                            url: '/api/v1/transactions/counttransactions',
                            type: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                $('#transactions').text(data.data.toLocaleString());
                            },
                            error: function (xhr, status, error) {
                                console.error('Gagal mengambil jumlah product:', error);
                            }
                        });
                        $.ajax({
                            url: '/api/v1/transactions/countprofit',
                            type: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                $('#profit').text(data.data.toLocaleString());
                            },
                            error: function (xhr, status, error) {
                                console.error('Gagal mengambil jumlah product:', error);
                            }
                        });
                    });
                </script>
