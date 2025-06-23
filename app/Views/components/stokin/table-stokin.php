
<div class="row">
                    <div class="col-12">
                        <div class="card border border-0">
                            <div class="card-header bg-white">
                                
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="startDate" class="form-label">Start Date</label>
                                        <input type="date" id="startDate" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="endDate" class="form-label">End Date</label>
                                        <input type="date" id="endDate" class="form-control">
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button id="filterBtn" onclick="filter()" class="btn btn-primary w-100">Filter</button>
                                    </div>
                                </div>
                                
                                <h4 class="card-title">Inventory Datatable</h4>
                                <input type="text" id="searchInput" class="form-control w-25" placeholder="Cari produk...">
                                <div>
                                    <button type="button" class="btn btn-primary px-3" data-bs-toggle="modal" data-bs-target="#addmodal">
                                    +
                                    </button>
                                    <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="icon-printer"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                    <!-- <li><a class="dropdown-item" href="#">Excel</a></li> -->
                                    <li><a class="dropdown-item" id="downloadPdf" href="#">PDF</a></li>
                                    </ul>
                                </div>
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
                                                <th hidden>id</th>
                                                <th>Nomor</th>
                                                <th>Nama Produk</th>
                                                <th>Quantity</th>
                                                <th>Tanggal</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="users_data">
                                            <!-- tabel users  -->
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

<?= view('components/stokin/add-modal-stokin') ?>
<?= view('components/stokin/edit-modal-stokin') ?>
<?= view('components/stokin/script-stokin') ?>