
                <div class="row">
                    <div class="col-12">
                        <div class="card border border-0">
                            <div class="card-header bg-white">
                                <h4 class="card-title">Order Datatable</h4>
                                <input type="text" id="searchInput" class="form-control w-25" placeholder="Cari pengiriman...">
                                <div>
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
                                    <table class="display table table-striped table-responsive-sm" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th hidden>id</th>
                                                <th>Tracking Number</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                                <th>Tanggal Delivery</th>
                                                <th>Detail</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="order-data">
                                            
                                        </tbody>
                                    </table>
                                    <div>
                                        <button id="prevPage" class="btn btn-outline-primary btn-sm">Prev</button>
                                        <span id="pageInfo" class="mx-2"></span>
                                        <button id="nextPage" class="btn btn-outline-primary btn-sm">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<?= view('components/order/script-order') ?>
<?= view('components/order/transaction-items-data') ?>
<?= view('components/order/edit-modal-order') ?>