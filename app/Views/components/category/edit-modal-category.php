<div class="modal fade" id="editmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div class="basic-form">
                        <form id="form-update-category">
                            <input hidden id="edit-id" name="id">
                            
                            <div class="col-12 mt-3">
                                <input type="text" id="edit-category" name="name" class="form-control" placeholder="Kategori">
                            </div>

                            <div class="col-12 mt-3">
                                <input type="text" id="edit-description" name="description" class="form-control" placeholder="Deskripsi">
                            </div>

                            <div class="col-6 mt-3">
                                <img id="edit-preview" src="" width="200" height="200">
                                <input type="hidden" name="image_url" id="edit-image_url">
                            </div>

                           <div class="col-12 mt-3">
                                <label for="edit-productFile" class="form-label">Upload Gambar</label>
                                <input class="form-control" type="file" id="edit-productFile" name="image">
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