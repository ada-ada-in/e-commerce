<script>
    $(function () {
        let category = [];
        let currentPage = 1;
        const rowsPerPage = 10;
        let filteredData = []; 

        function displayTable(data) {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedItems = data.slice(start, end);

            let row = '';
            paginatedItems.forEach((category, i) => {
                row += `
                    <tr>
                        <td hidden>${category.id}</td>
                        <td>${start + i + 1}</td>
                        <td>${category.name}</td>
                        <td>${category.description}</td>
                        <td>
                            <img src="/${category.image_url}" alt="${category.name}" class="img-thumbnail" style="width: 80px; height: 8    0px;">
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary px-3 btn-update" data-bs-toggle="modal" data-bs-target="#editmodal" data-id="${category.id}">Edit</button>
                            |
                            <button class="btn btn-danger btn-delete" data-id="${category.id}">Hapus</button>
                        </td>
                    </tr>
                `;
            });


            $('#category-data').html(row);
            $('#pageInfo').text(`Page ${currentPage} of ${Math.ceil(data.length / rowsPerPage)}`);
        }

        function loadData() {
            $.ajax({
                url: '/api/v1/category',
                type: 'GET',
                processData: false,     
                contentType: false,                 
                 success: function (response) {
                    category = response.data;
                    filteredData = category;
                    currentPage = 1;
                    displayTable(filteredData);
                },
                error: function (xhr, status, error) {
                    console.error('Gagal mengambil data products:', error);
                }
            });
        }

        loadData();

        $('#searchInput').on('input', function () {
            const keyword = $(this).val().toLowerCase();
            filteredData = category.filter(category =>
                category.name.toLowerCase().includes(keyword) ||
                category.description.toLowerCase().includes(keyword)
            );
            currentPage = 1;
            displayTable(filteredData);
        });

        $('#prevPage').on('click', function () {
            if (currentPage > 1) {
                currentPage--;
                displayTable(filteredData);
            }
        });

        $('#nextPage').on('click', function () {
            if (currentPage < Math.ceil(filteredData.length / rowsPerPage)) {
                currentPage++;
                displayTable(filteredData);
            }
        });

        $(document).on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            if (confirm('Apakah kamu yakin ingin menghapus kategori ini?')) {
                $.ajax({
                    url: `/api/v1/category/${id}`,
                    type: 'DELETE',
                    success: function () {
                        alert('Kategori berhasil dihapus!');
                        loadData(); 
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
                url: `/api/v1/category/${id}`,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    const updateData = response.data 
                    $('#editmodal input[name="id"]').val(updateData.id);
                    $('#editmodal input[name="name"]').val(updateData.name);
                    $('#editmodal input[name="description"]').val(updateData.description)
                    $('#edit-preview').attr('src', '/' + updateData.image_url);; 
                    $('#editmodal input[name="image_url"]').val(updateData.image_url);    
 
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

        $('#form-add-category').on('submit', function (e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            $.ajax({
                url: `/api/v1/category`,
                type: 'POST',
                data: formData,
                processData: false, 
                contentType: false,
                success: function (response) {
                    alert(response.message);
                    $('#form-add-category')[0].reset(); 
                    loadData();  
                    $('#staticBackdrop').modal('hide'); 
                },
                error: function (xhr, status, error) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        let errorMessage = '';
                        if (response.messages) {
                            for (const key in response.messages) {
                                errorMessage += `${response.messages[key]}\n`;
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


    $('#form-update-category').on('submit', function (e) {
        e.preventDefault();
        const id = $('#edit-id').val();
        const formData = new FormData();

        formData.append('name', $('#edit-category').val());
        formData.append('description', $('#edit-description').val());
        const input = document.getElementById('edit-productFile');
        const imageFile = input && input.files.length > 0 ? input.files[0] : null;

            if (imageFile) {
                formData.append('image', imageFile);
            }

        $.ajax({
            url: `/api/v1/category/${id}`,
            type: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                alert(response.message);
                loadData();
                $('#form-update-category')[0].reset();
            },
            error: function (xhr) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    let errorMessage = '';
                    if (response.messages) {
                        for (const key in response.messages) {
                            errorMessage += `${response.messages[key]}\n`;
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

    $('#productFile').on('change', function () {
        const fileName = this.files[0] ? this.files[0].name : 'Choose file';
        $('#fileLabel').text(fileName);
    });

    $('#productFile').on('change', function () {
    const file = this.files[0];
    if (file) {
        console.log("Nama file:", file.name);
        console.log("Tipe file:", file.type);
        console.log("Ukuran file:", file.size);
    } else {
        console.log("Tidak ada file dipilih.");
    }
});


        // Excel export functionality
        $('#downloadExcel').on('click', function (e) {
            e.preventDefault();
            const ws_data = [
                ["No", "Nama", "Email", "Telepon", "Alamat", "Role"]
            ];

            filteredUsers.forEach((user, index) => {
                ws_data.push([
                    index + 1,
                    user.name,
                    user.email,
                    user.phone,
                    user.address,
                    user.role
                ]);
            });

            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(ws_data);
            XLSX.utils.book_append_sheet(wb, ws, "Users");

            XLSX.writeFile(wb, "users-data.xlsx");
        });

        // PDF export functionality
        $('#downloadPdf').on('click', function () {
            const doc = new jsPDF();
            doc.setFontSize(12);
            doc.text('Users Data', 20, 20);

            let yOffset = 30;
            filteredUsers.forEach((user, index) => {
                doc.text(`${index + 1}. ${user.name} | ${user.email} | ${user.phone} | ${user.address} | ${user.role}`, 20, yOffset);
                yOffset += 10;
            });

            doc.save('users-data.pdf');
        });
    });

    $('#downloadPdf').on('click', function () {
            window.open('/api/v1/category/print', '_blank');
        });
</script>
