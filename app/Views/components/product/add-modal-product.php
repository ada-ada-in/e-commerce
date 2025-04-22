<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="basic-form">
                    <form id="form-add-product">
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" name="name" class="form-control" placeholder="Nama Barang">
                            </div>
                            <div class="col-sm-6 mt-2 mt-sm-0">
                                <input type="text" name="stock" class="form-control" placeholder="Stok Barang">
                            </div>
                            <div class="col-sm-6 mt-3">
                                <input type="number" name="price" class="form-control" placeholder="Harga">
                            </div>
                            <div class="col-sm-6 mt-3">
                                <select id="category-add" class="form-select" aria-label="Default select example">
                                    <option disabled selected>Pilih Kategori</option>
                                    <!-- data category -->
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="text" name="description" class="form-control" placeholder="Deskripsi">
                            </div>
                            <div class="input-group mt-3">
                                <label class="input-group-text" for="productFile">Upload</label>
                                <input type="file" name="image" class="form-control" id="productFile">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
