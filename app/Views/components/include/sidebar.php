
<div class="quixnav">
            <div class="quixnav-scroll">
                <ul class="metismenu" id="menu">

                <li class="nav-label">Dashboard</li>
                    <li>
                        <a href="<?= base_url('admin/dashboard') ?>" aria-expanded="false">
                            <i class="icon icon-single-04"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon-bag"></i><span class="nav-text">Market</span></a>
                        <ul aria-expanded="false">
                            <li><a href="<?= base_url('admin/product') ?>">Product</a></li>
                            <li><a href="./chart-morris.html">Category</a></li>
                        </ul>
                    </li>

                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-chart-bar-33"></i><span class="nav-text">Transactions</span></a>
                        <ul aria-expanded="false">
                            <li><a href="./chart-flot.html">Paid</a></li>
                            <li><a href="./chart-morris.html">Pending</a></li>
                            <li><a href="./chart-morris.html">Due</a></li>
                        </ul>
                    </li>

                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon-rocket"></i><span class="nav-text">Delivery</span></a>
                        <ul aria-expanded="false">
                            <li><a href="./chart-flot.html">Data</a></li>
                            <li><a href="./chart-morris.html">Order</a></li>
                            <li><a href="./chart-morris.html">Send</a></li>
                            <li><a href="./chart-morris.html">Pick Up</a></li>

                        </ul>
                    </li>

                    <li class="mt-2">
                        <a href="<?= base_url('admin/users') ?>" aria-expanded="false">
                            <i class="icon-docs"></i>
                            <span class="nav-text">Report</span>
                        </a>
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