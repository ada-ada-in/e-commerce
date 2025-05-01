
<div class="quixnav">
            <div class="quixnav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="mt-3">
                        <a href="<?= base_url('admin/dashboard') ?>" aria-expanded="false">
                            <i class="icon icon-single-04"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon-bag"></i><span class="nav-text">Market</span></a>
                        <ul aria-expanded="false">
                            <li><a href="<?= base_url('admin/product') ?>">Product</a></li>
                            <li><a href="<?= base_url('admin/category') ?>">Category</a></li>
                        </ul>
                    </li>

                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-chart-bar-33"></i><span class="nav-text">Transactions</span></a>
                        <ul aria-expanded="false">
                            <li><a href="<?= base_url('admin/data') ?>">Data</a></li>
                            <li><a href="<?= base_url('admin/paid') ?>">Paid</a></li>
                            <li><a href="<?= base_url('admin/pending') ?>">Pending</a></li>
                            <li><a href="<?= base_url('admin/cancel') ?>">Cancel</a></li>
                        </ul>
                    </li>

                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon-rocket"></i><span class="nav-text">Delivery</span></a>
                        <ul aria-expanded="false">
                            <li><a href="<?= base_url('admin/order') ?>">Order</a></li>
                            <li><a href="<?= base_url('admin/send') ?>">Send</a></li>
                            <li><a href="<?= base_url('admin/complete') ?>">Complete Delivery</a></li>

                        </ul>
                    </li>

                    <li class="mt-2">
                        <a href="<?= base_url('admin/users') ?>" aria-expanded="false">
                            <i class="icon icon-single-04"></i>
                            <span class="nav-text">Users</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>