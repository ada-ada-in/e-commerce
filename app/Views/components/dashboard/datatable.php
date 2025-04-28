<div class="row">
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="ct-pie-chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Transaksi Terbaru</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table student-data-table m-t-20">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Order Id</th>
                                                <th>Total Harga</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="latest-transactions">
                                            <!-- Data payment -->
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
                        url: '/api/v1/transactions/getlatesttransactions', 
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                        const transactions = response.data;
                        const tbody = $('#latest-transactions');
                        tbody.empty(); 

                        transactions.forEach(function (trx, i) {
                            const orderId = trx.order_id || '-';
                            const status = trx.status || 'unknown';
                            const total = trx.total_price || 'unknown';
                            const createdAt = trx.created_at || '';

                            const row = `
                            <tr>
                                <td>${i+1}</td>
                                <td>${orderId}</td>
                                <td>${total}</td>
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

                    function getStatusClass(status) {
                        switch (status.toLowerCase()) {
                        case 'settlement': return 'primary';
                        case 'pending': return 'warning';
                        case 'cancel': return 'danger';
                        default: return 'secondary';
                        }
                    }

                    function capitalize(text) {
                        return text ? text.charAt(0).toUpperCase() + text.slice(1) : '';
                    }

                    function formatDate(dateStr) {
                        if (!dateStr) return '-';
                        const date = new Date(dateStr);
                        return date.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                        });
                    }
                    });

                </script>
