<?= $this->extend('layouth/admin_layout') ?>
<?= $this->section('content') ?>

			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
                    <div class="row d-flex justify-content-between ">
                            <div class="col-md-6 col-sm-12">
                                <div class="title">
                                    <h4>Data Arsip</h4>
                                </div>
                                <nav aria-label="breadcrumb" role="navigation">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?= url_to('admin') ?>">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Arsip
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-md-2 col-sm-4 text-right">
                                <div class="form-group">
                                    <label>Datedpicker Range View</label>
                                    <input class="form-control datetimepicker-range" placeholder="Select Month" type="text" />
                                </div>
                            </div>
                        </div>

					</div>


					<div class="card-box mb-30">
						<div class="pb-20">
							<table class="data-table table stripe hover data-table-export nowrap">
								<thead>
									<tr>
										<th class="table-plus datatable-nosort">Name</th>
										<th>Age</th>
										<th>Office</th>
										<th>Address</th>
										<th>Start Date</th>
										<th class="datatable-nosort">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="table-plus">Gloria F. Mead</td>
										<td>25</td>
										<td>Sagittarius</td>
										<td>2829 Trainer Avenue Peoria, IL 61602</td>
										<td>29-03-2018</td>
										<td>
											<div class="grid gap-2">

													<a  href="" class="g-col-2"
														><i class="dw dw-eye "></i> View</a
													>
													<a  href="#" class="g-col-2 mx-3"
														><i class="dw dw-edit2"></i> Edit</a
													>
													<a  href="#" class="g-col-2"
														><i class="dw dw-delete-3"></i> Delete</a
													>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

<?= $this->endSection() ?> 