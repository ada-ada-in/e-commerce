<div class="modal fade" id="editmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div class="basic-form">
                        <form id="form-update-data">
                        <div class="row">
                            <div class="col-sm-6">
                            <input type="number" class="form-control" name="tracking_number" placeholder="Tracking Number" readonly>
                            </div>
                            <div class="col-sm-6 mt-2 mt-sm-0">
                            <input type="text" class="form-control" name="address" placeholder="alamat" readonly>
                            </div>
                            <div class="col-sm-6 mt-3">
                            <select id="status" name="status" class="form-select" aria-label="Default select example">
                                    <option disabled selected>Pilih Status</option>
                                    <option value="order">Order</option>
                                    <option value="send">Send</option>
                                    <option value="picku    p">Pick Up</option>
                                </select>
                            </div>
                            <div class="col-sm-6 mt-3">
                            <input type="text" class="form-control" name="created_at" placeholder="Tanggal Pengiriman" readonly>
                            </div> 
                                <input type="text" hidden class="form-control" name="id" placeholder="First name">
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