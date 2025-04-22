<div class="modal fade" id="editmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div class="basic-form">
                        <form id="form-update-product">
                        <input type="hidden" name="id" id="edit-id">
                            <div class="row">
                                <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" id="edit-name" placeholder="Nama Barang" required>
                                </div>
                                <div class="col-sm-6 mt-2 mt-sm-0">
                                <input type="number" name="stock" class="form-control" id="edit-stock" placeholder="Stok Barang" required>
                                </div>
                                <div class="col-sm-6 mt-3">
                                <input type="number" class="form-control" name="price" id="edit-price" placeholder="Harga per pcs" required>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <select required  id="category-edit" class="form-select" aria-label="Default select example">
                                        <option disabled selected>Pilih Kategori</option>
                                        <!-- data category -->
                                    </select>
                                </div>
                                <div class="col-sm-12 mt-3">
                                <input type="text" name="description" class="form-control" id="edit-description" placeholder="Deskripsi" required>
                                </div>
                                <div class="col-6 mt-3">
                                <img id="edit-preview" src="" width="200" height="200">
                                <input type="hidden" name="image_url" id="edit-image_url">
                                </div>
                                <div class="input-group col-6 mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="productFile">
                                    <label class="custom-file-label" for="productFile" id="fileLabel">Choose file</label>
                                </div>
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