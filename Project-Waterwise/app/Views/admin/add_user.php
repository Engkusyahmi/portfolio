<?= $this->include('admin/layout/header') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0">
            <i class="fas fa-user-plus text-primary me-2"></i>
            Add New User
        </h2>
        <p class="text-muted">Create a new user account</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?= base_url('/admin/manage-users') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Users
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?= base_url('/admin/add-user') ?>">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fullname" class="form-label">Full Name *</label>
                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('fullname') ? 'is-invalid' : '' ?>" 
                           id="fullname" name="fullname" value="<?= old('fullname') ?>" required>
                    <?php if (isset($validation) && $validation->hasError('fullname')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('fullname') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">Username *</label>
                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" 
                           id="username" name="username" value="<?= old('username') ?>" required>
                    <?php if (isset($validation) && $validation->hasError('username')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('username') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" 
                           id="email" name="email" value="<?= old('email') ?>" required>
                    <?php if (isset($validation) && $validation->hasError('email')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('email') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="userlevel" class="form-label">User Level *</label>
                    <select class="form-control <?= isset($validation) && $validation->hasError('userlevel') ? 'is-invalid' : '' ?>" 
                            id="userlevel" name="userlevel" required>
                        <option value="">Select User Level</option>
                        <option value="user" <?= old('userlevel') === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= old('userlevel') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('userlevel')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('userlevel') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password *</label>
                    <input type="password" class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                           id="password" name="password" required>
                    <?php if (isset($validation) && $validation->hasError('password')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('password') ?>
                        </div>
                    <?php endif; ?>
                    <small class="form-text text-muted">Minimum 6 characters</small>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create User
                    </button>
                    <a href="<?= base_url('/admin/manage-users') ?>" class="btn btn-secondary ms-2">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->include('admin/layout/footer') ?>