<script>
    $(function () {
        let users = [];
        let currentPage = 1;
        const rowsPerPage = 10;
        let filteredUsers = []; // Ensure filteredUsers is declared properly

        function displayTable(data) {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedItems = data.slice(start, end);

            let row = '';
            paginatedItems.forEach((stok, i) => {
                row += `
                    <tr>
                        <td hidden>${stok.id}</td>
                        <td>${start + i + 1}</td>
                        <td>${stok.product_name}</td>
                        <td>${stok.quantity}</td>
                        <td>${stok.created_at}</td>
                        <td>
                            <button type="button" class="btn btn-primary px-3 btn-update" data-bs-toggle="modal" data-bs-target="#editmodal" data-id="${stok.id}">Edit</button>
                            |
                            <button class="btn btn-danger btn-delete" data-id="${stok.id}">Hapus</button>
                        </td>
                    </tr>
                `;
            });

            $('#users_data').html(row);
            $('#pageInfo').text(`Page ${currentPage} of ${Math.ceil(data.length / rowsPerPage)}`);
        }

        function loadStok() {
            $.ajax({
                url: '/api/v1/stokin',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    users = response.data;
                    filteredUsers = users; // Initialize filteredUsers with all users
                    currentPage = 1;
                    displayTable(filteredUsers);
                },
                error: function (xhr, status, error) {
                    console.error('Gagal mengambil data users:', error);
                }
            });
        }

        loadStok();

        $('#searchInput').on('input', function () {
            const keyword = $(this).val().toLowerCase();
            filteredUsers = users.filter(stok =>
                stok.product_name.toLowerCase().includes(keyword) 
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
            if (confirm('Apakah kamu yakin ingin menghapus stok ini?')) {
                $.ajax({
                    url: `/api/v1/stokin/${id}`,
                    type: 'DELETE',
                    success: function () {
                        alert('stok berhasil dihapus!');
                        loadStok(); 
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
                url: `/api/v1/stokin/${id}`,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    const updateData = response.data 
                    console.log(updateData);
                    $('#editmodal input[name="id"]').val(updateData.id);
                    $('#editmodal select[name="product"]').val(updateData.product_id);
                    $('#editmodal input[name="quantity"]').val(updateData.quantity);
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



        $('#form-update-stok').on('submit', function (e) {
            e.preventDefault();
            const id = $('input[name="id"]').val()
            const form = $('#form-update-stok');
            const formData = {
                product_id: form.find('select[name="product"]').val(),
                quantity: form.find('input[name="quantity"]').val()
            };
            $.ajax({
                url: `/api/v1/stokin/${id}`,
                type: 'PUT',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function (response) {
                    const message = response.message 
                    alert(message)
                    $('#form-update-stok')[0].reset();
                    loadStok(); 
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

        // Excel export functionality
        $('#downloadExcel').on('click', function (e) {
            e.preventDefault();
            const ws_data = [
                ["No", "Nama", "Email", "Telepon", "Alamat", "Role"]
            ];

            filteredUsers.forEach((stok, index) => {
                ws_data.push([
                    index + 1,
                    stok.name,
                    stok.email,
                    stok.phone,
                    stok.address,
                    stok.role
                ]);
            });

            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(ws_data);
            XLSX.utils.book_append_sheet(wb, ws, "Users");

            XLSX.writeFile(wb, "users-data.xlsx");
        });

       $('#downloadPdf').on('click', function () {
            window.open('/api/v1/users/print', '_blank');
        });

    });
</script>
