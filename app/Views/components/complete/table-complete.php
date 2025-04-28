
<div class="row">
                    <div class="col-12">
                        <div class="card border border-0">
                            <div class="card-header bg-white">
                                <h4 class="card-title">Complete Datatable</h4>
                                <input type="text" id="searchInput" class="form-control w-25" placeholder="Cari kategori...">
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
                                    <table class="display table table-striped table-responsive-sm" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>No. Order</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Handphone</th>
                                                <th>Total Harga</th>
                                                <th>Status</th>
                                                <th>Tanggal Transaksi</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="delivery-complete">
                                           
                                                <!-- data complete -->
                                            
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
