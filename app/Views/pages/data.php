<?= $this->extend('layouth/main_layout') ?>
<?= $this->section('content') ?>

                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Data Page</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Delivery</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Data</a></li>
                        </ol>
                    </div>
                </div>

                <?= view('components/data/table-data')  ?>


<?= $this->endSection() ?> 