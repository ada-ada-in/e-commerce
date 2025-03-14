<?= $this->extend('layouth/main_layout') ?>
<?= $this->section('content') ?>

                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Due Page</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Transactions</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Due</a></li>
                        </ol>
                    </div>
                </div>

                <?= view('components/due/table-due')  ?>


<?= $this->endSection() ?> 