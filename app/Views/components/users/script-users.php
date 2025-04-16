<script>

    
                          $(function () {
                            
                            let users = [];
                            let currentPage = 1;
                            const rowsPerPage = 10;
                            let filteredUsers = [];

                            function displayTable(data) {
                                const start = (currentPage - 1) * rowsPerPage;
                                const end = start + rowsPerPage;
                                const paginatedItems = data.slice(start, end);

                                let row = '';
                                paginatedItems.forEach((user, i) => {
                                    row += `
                                        <tr>
                                            <td hidden>${user.id}</td>
                                            <td>${start + i + 1}</td>
                                            <td>${user.name}</td>
                                            <td>${user.email}</td>
                                            <td>${user.phone}</td>
                                            <td>${user.address}</td>
                                            <td>${user.role}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary px-3 btn-update" data-bs-toggle="modal" data-bs-target="#editmodal" data-id="${user.id}">Edit</button>
                                                |
                                                <button class="btn btn-danger btn-delete" data-id="${user.id}">Hapus</button>
                                            </td>
                                        </tr>
                                    `;
                                });

                                $('#users_data').html(row);
                                $('#pageInfo').text(`Page ${currentPage} of ${Math.ceil(data.length / rowsPerPage)}`);
                            }

                        function loadUsers() {
                            $.ajax({
                                url: '/api/v1/users',
                                type: 'GET',
                                dataType: 'json',
                                success: function (response) {
                                    users = response.data;
                                    filteredUsers = users;
                                    currentPage = 1;
                                    displayTable(filteredUsers);
                                },
                                error: function (xhr, status, error) {
                                    console.error('Gagal mengambil data users:', error);
                                }
                            });
                        }

                        loadUsers();

                        $('#searchInput').on('input', function () {
                            const keyword = $(this).val().toLowerCase();
                            filteredUsers = users.filter(user =>
                                user.name.toLowerCase().includes(keyword) ||
                                user.email.toLowerCase().includes(keyword)
                            );
                            currentPage = 1;
                            displayTable(filteredUsers);
                        });


                        $('#prevPage').on('click', function () {
                                if (currentPage > 1) {
                                    currentPage--;
                                    displayTable(filteredUsers);
                                }
                            });

                            $('#nextPage').on('click', function () {
                                if (currentPage < Math.ceil(filteredUsers.length / rowsPerPage)) {
                                    currentPage++;
                                    displayTable(filteredUsers);
                                }
                            });



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
                                        try {
                                            const response = JSON.parse(xhr.responseText);
                                            let errorMessage = '';

                                            if (response.messages) {
                                                for (const key in response.messages) {
                                                    if (response.messages.hasOwnProperty(key)) {
                                                        errorMessage += `${response.messages[key]}\n`;
                                                    }
                                                }
                                            } else if (response.message) {
                                                errorMessage = response.message;
                                            } else {
                                                errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
                                            }

                                            alert(errorMessage); 
                                        } catch (e) {
                                            console.error('Gagal parse response error:', e);
                                            alert('Terjadi kesalahan saat memproses respons error.');
                                        }
                                    }
                                });
                            }
                        });

                        $(document).on('click', '.btn-update', function () {
                            const id = $(this).data('id');
                                $.ajax({
                                    url: `/api/v1/users/${id}`,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function (response) {
                                        const updateData = response.data 
                                        $('#editmodal input[name="id"]').val(updateData.id);
                                        $('#editmodal input[name="name"]').val(updateData.name);
                                        $('#editmodal input[name="email"]').val(updateData.email);
                                        $('#editmodal input[name="phone"]').val(updateData.phone);
                                        $('#editmodal input[name="address"]').val(updateData.address);
                                        $('#editmodal select[name="role"]').val(updateData.role);                                       
                                    },
                                    error: function (xhr, status, error) {
                                        try {
                                            const response = JSON.parse(xhr.responseText);
                                            let errorMessage = '';

                                            if (response.messages) {
                                                for (const key in response.messages) {
                                                    if (response.messages.hasOwnProperty(key)) {
                                                        errorMessage += `${response.messages[key]}\n`;
                                                    }
                                                }
                                            } else if (response.message) {
                                                errorMessage = response.message;
                                            } else {
                                                errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
                                            }

                                            alert(errorMessage); 
                                        } catch (e) {
                                            console.error('Gagal parse response error:', e);
                                            alert('Terjadi kesalahan saat memproses respons error.');
                                        }
                                    }
                                });
                        });


                        $('#form-add-user').on('submit', function (e) {
                            e.preventDefault();
                                const form = $('#form-add-user');
                                const formData = {
                                    name: form.find('input[name="name"]').val(),
                                    email: form.find('input[name="email"]').val(),
                                    phone: form.find('input[name="phone"]').val(),
                                    address: form.find('input[name="address"]').val(),
                                    role: form.find('select[name="role"]').val(),
                                    password: form.find('input[name="password"]').val(),
                                    confirm_password: form.find('input[name="confirm_password"]').val(),
                                };
                                $.ajax({
                                    url: `/api/v1/auth/register`,
                                    type: 'POST',
                                    dataType: 'json',
                                    contentType: 'application/json',
                                    data: JSON.stringify(formData),
                                    success: function (response) {
                                        const message = response.message 
                                        alert(message)
                                        $('#form-add-user')[0].reset();
                                        loadUsers();   
                                    },
                                    error: function (xhr, status, error) {
                                        try {
                                            const response = JSON.parse(xhr.responseText);
                                            let errorMessage = '';

                                            if (response.messages) {
                                                for (const key in response.messages) {
                                                    if (response.messages.hasOwnProperty(key)) {
                                                        errorMessage += `${response.messages[key]}\n`;
                                                    }
                                                }
                                            } else if (response.message) {
                                                errorMessage = response.message;
                                            } else {
                                                errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
                                            }

                                            alert(errorMessage); 
                                        } catch (e) {
                                            console.error('Gagal parse response error:', e);
                                            alert('Terjadi kesalahan saat memproses respons error.');
                                        }
                                    }

                                });
                        });

                        $('#form-update-user').on('submit', function (e) {
                            e.preventDefault();
                                const id =  $('input[name="id"]').val()
                                const form = $('#form-update-user');
                                const formData = {
                                    name: form.find('input[name="name"]').val(),
                                    email: form.find('input[name="email"]').val(),
                                    phone: form.find('input[name="phone"]').val(),
                                    address: form.find('input[name="address"]').val(),
                                    role: form.find('select[name="role"]').val(),
                                    password: form.find('input[name="password"]').val(),
                                    confirm_password: form.find('input[name="confirm_password"]').val(),
                                };
                                $.ajax({
                                    url: `/api/v1/users/${id}`,
                                    type: 'PUT',
                                    dataType: 'json',
                                    contentType: 'application/json',
                                    data: JSON.stringify(formData),
                                    success: function (response) {
                                        const message = response.message 
                                        alert(message)
                                        $('#form-update-user')[0].reset();
                                        loadUsers(); 
                                    },
                                    error: function (xhr, status, error) {
                                        try {
                                            const response = JSON.parse(xhr.responseText);
                                            let errorMessage = '';

                                            if (response.messages) {
                                                for (const key in response.messages) {
                                                    if (response.messages.hasOwnProperty(key)) {
                                                        errorMessage += `${response.messages[key]}\n`;
                                                    }
                                                }
                                            } else if (response.message) {
                                                errorMessage = response.message;
                                            } else {
                                                errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
                                            }

                                            alert(errorMessage); 
                                        } catch (e) {
                                            console.error('Gagal parse response error:', e);
                                            alert('Terjadi kesalahan saat memproses respons error.');
                                        }
                                    }
                                });
                        });

                        
                    });
                </script>