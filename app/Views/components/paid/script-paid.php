<script>
    $(function () {
        let product = [];
        let currentPage = 1;
        const rowsPerPage = 10;
        let filteredData = []; 

        function displayTable(data) {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedItems = data.slice(start, end);

            let row = '';
            paginatedItems.forEach((product, i) => {
                row += `
                    <tr>
                        <td hidden>${product.id}</td>
                        <td>${start + i + 1}</td>
                        <td>${product.name}</td>
                        <td>${product.stock}</td>
                        <td>${product.price}</td>
                        <td>${product.category_name}</td>
                        <td>${product.description}</td>
                        <td><img src="/${product.image_url}" width="100" height="100"></td>
                        <td>
                            <button type="button" class="btn btn-primary px-3 btn-update" data-bs-toggle="modal" data-bs-target="#editmodal" data-id="${product.id}">Edit</button>
                            |
                            <button class="btn btn-danger btn-delete" data-id="${product.id}">Hapus</button>
                        </td>
                    </tr>
                `;
            });

            $('#transactions-paid-data').html(row);
            $('#pageInfo').text(`Page ${currentPage} of ${Math.ceil(data.length / rowsPerPage)}`);
        }

        function loadData() {
            $.ajax({
                url: '/api/v1/transactions/paid',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    products = response.data;
                    filteredData = products;
                    currentPage = 1;
                    displayTable(filteredData);
                },
                error: function (xhr, status, error) {
                    console.error('Gagal mengambil data products:', error);
                }
            });
        }

        loadData();

        $('#category-add').on('click', function () {
        $.ajax({
            url: '/api/v1/category',
            type: 'GET',
            success: function (response) {
                const categoryData = response.data;
                const selectElement = $('#category-add');

                selectElement.find('option:not(:first)').remove();

                categoryData.forEach(function (category) {
                    const option = $('<option>', {
                        value: category.id,
                        text: category.name
                    });
                    selectElement.append(option);
                });
            },
            error: function () {
                console.error('Gagal memuat data kategori.');
            }
        });
    });

    $('#category-edit').on('click', function () {
        $.ajax({
            url: '/api/v1/category',
            type: 'GET',
            success: function (response) {
                const categoryData = response.data;
                const selectElement = $('#category-edit');

                selectElement.find('option:not(:first)').remove();

                categoryData.forEach(function (category) {
                    const option = $('<option>', {
                        value: category.id,
                        text: category.name
                    });
                    selectElement.append(option);
                });
            },
            error: function () {
                console.error('Gagal memuat data kategori.');
            }
        });
    });



        $('#searchInput').on('input', function () {
            const keyword = $(this).val().toLowerCase();
            filteredData = products.filter(product =>
                product.name.toLowerCase().includes(keyword) ||
                product.description.toLowerCase().includes(keyword) ||
                product.category_name.toLowerCase().includes(keyword)
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
            if (confirm('Apakah kamu yakin ingin menghapus produk ini?')) {
                $.ajax({
                    url: `/api/v1/products/${id}`,
                    type: 'DELETE',
                    success: function () {
                        alert('product berhasil dihapus!');
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
                url: `/api/v1/products/${id}`,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    const updateData = response.data 
                    $('#editmodal input[name="id"]').val(updateData.id);
                    $('#editmodal input[name="name"]').val(updateData.name);    
                    $('#editmodal input[name="price"]').val(updateData.price);    
                    $('#editmodal input[name="stock"]').val(updateData.stock);    
                    $('#editmodal input[name="image_url"]').val(updateData.image_url);    
                    $('#edit-preview').attr('src', '/' + updateData.image_url);
                    $('#editmodal input[name="description"]').val(updateData.description);  
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

        $('#form-update-product').on('submit', function (e) {
            e.preventDefault();

            const id = $('#edit-id').val();
            const formData = new FormData();

            formData.append('name', $('#edit-name').val());
            formData.append('stock', $('#edit-stock').val());
            formData.append('price', $('#edit-price').val());
            formData.append('category_id', $('#category-edit').val());
            formData.append('description', $('#edit-description').val());

            const imageFile = $('#productFile')[0].files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }

            // Debugging isi FormData
            for (var pair of formData.entries()) {
                console.log(pair[0]+ ': ' + pair[1]);
            }

            $.ajax({
                url: `/api/v1/products/${id}`,
                type: 'PUT',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(formdata)
                    alert(response.message);
                    $('#form-update-product')[0].reset();
                    loadData();
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



        $('#form-add-product').on('submit', function (e) {
    e.preventDefault();

    const form = $('#form-add-product')[0];
    const formData = new FormData();

    formData.append('name', form.name.value);
    formData.append('stock', form.stock.value);
    formData.append('price', form.price.value);
    formData.append('category_id', $('#category-selected').val());
    formData.append('description', form.description.value);

    const imageFile = form.image.files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }

    $.ajax({
        url: `/api/v1/products`,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            const message = response.message;
            alert(message);
            $('#form-add-product')[0].reset();
            loadData();
            $('#staticBackdrop').modal('hide');
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
    })

            $('#productFile').on('change', function () {
            const fileName = $(this).val().split('\\').pop();
            $('#fileLabel').text(fileName);
        });

</script>
