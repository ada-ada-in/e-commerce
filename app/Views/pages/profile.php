<?= $this->extend('layouth/main_layout') ?>
<?= $this->section('content') ?>

                <div class="row page-titles mx-0">
                    <div class="col-sm-12 p-md-0">
                        <div class="welcome-text">
                            <h4>Profile Page</h4>
                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Horizontal Form</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">
                                                    <form>

                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label>First Name</label>
                                                                <input type="text" class="form-control" placeholder="1234 Main St">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Email</label>
                                                                <input type="email" class="form-control" placeholder="Email">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Password</label>
                                                                <input type="password" class="form-control" placeholder="Password">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>City</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-4">
                                                                <label>State</label>
                                                                <select id="inputState" class="form-control">
                                                                    <option selected>Choose...</option>
                                                                    <option>Option 1</option>
                                                                    <option>Option 2</option>
                                                                    <option>Option 3</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label>Zip</label>
                                                                <input type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox">
                                                                <label class="form-check-label">
                                                                    Check me out
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Sign in</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                    </div>
                </div>

<?= $this->endSection() ?> 