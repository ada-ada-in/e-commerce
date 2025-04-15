
                <div class="row">
                    <div class="col-12">
                        <div class="card border border-0">
                            <div class="card-header bg-white">
                                <h4 class="card-title">Users Datatable</h4>
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
                                    <table id="example" class="display table table-striped table-responsive-sm" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th hidden>id</th>
                                                <th>Nomor</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="users_data">
                                            <!-- tabel users  -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                          $(function () {
                        function loadUsers() {
                            $.ajax({
                                url: '/api/v1/users',
                                type: 'GET',
                                dataType: 'json',
                                success: function (response) {
                                    const data = response.data;
                                    let row = '';

                                    data.forEach((user, i) => {
                                        row += `
                                            <tr>
                                                <td hidden>${user.id}</td>
                                                <td>${i + 1}</td>
                                                <td>${user.name}</td>
                                                <td>${user.email}</td>
                                                <td>${user.phone}</td>
                                                <td>${user.address}</td>
                                                <td>${user.role}</td>
                                                <td>
                                                    <button class="btn btn-primary">Edit</button>
                                                    |
                                                    <button class="btn btn-danger btn-delete" data-id="${user.id}">Hapus</button>
                                                </td>
                                            </tr>
                                        `;
                                    });

                                    $('#users_data').html(row);
                                },
                                error: function (xhr, status, error) {
                                    console.error('Gagal mengambil data users:', error);
                                }
                            });
                        }

                        loadUsers();

                        $(document).on('click', '.btn-delete', function () {
                            const id = $(this).data('id');
                            if (confirm('Apakah kamu yakin ingin menghapus user ini?')) {
                                $.ajax({
                                    url: `/api/v1/users/${id}`,
                                    type: 'DELETE',
                                    success: function () {
                                        alert('User berhasil dihapus!');
                                        loadUsers(); 
                                    },
                                    error: function (xhr, status, error) {
                                        console.error('Gagal menghapus user:', error);
                                        alert('Gagal menghapus user');
                                    }
                                });
                            }
                        });
                    });
                </script>

<?= view('components/users/add-modal-users') ?>