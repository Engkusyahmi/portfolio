<?= $this->include('admin/layout/header') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0">
            <i class="fas fa-gift text-primary me-2"></i>
            Add New Reward
        </h2>
        <p class="text-muted">Create a new reward</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?= base_url('/admin/manage-rewards') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Rewards
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?= base_url('/admin/add-reward') ?>">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('name') ? 'is-invalid' : '' ?>" 
                           id="name" name="name" value="<?= old('name') ?>" required>
                    <?php if (isset($validation) && $validation->hasError('name')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('name') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="cost_ecopoints" class="form-label">Cost (EcoPoints) *</label>
                    <input type="number" class="form-control <?= isset($validation) && $validation->hasError('cost_ecopoints') ? 'is-invalid' : '' ?>" 
                           id="cost_ecopoints" name="cost_ecopoints" value="<?= old('cost_ecopoints') ?>" min="1" required>
                    <?php if (isset($validation) && $validation->hasError('cost_ecopoints')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('cost_ecopoints') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description *</label>
                <textarea class="form-control <?= isset($validation) && $validation->hasError('description') ? 'is-invalid' : '' ?>" 
                          id="description" name="description" rows="3" required><?= old('description') ?></textarea>
                <?php if (isset($validation) && $validation->hasError('description')): ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('description') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label">Type *</label>
                    <select class="form-control <?= isset($validation) && $validation->hasError('type') ? 'is-invalid' : '' ?>" 
                            id="type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="avatar" <?= old('type') === 'avatar' ? 'selected' : '' ?>>Avatar</option>
                        <option value="badge" <?= old('type') === 'badge' ? 'selected' : '' ?>>Badge</option>
                        <option value="booster" <?= old('type') === 'booster' ? 'selected' : '' ?>>Booster</option>
                        <option value="theme" <?= old('type') === 'theme' ? 'selected' : '' ?>>Theme</option>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('type')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('type') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="image_path" class="form-label">Image Path</label>
                    <input type="text" class="form-control" 
                           id="image_path" name="image_path" value="<?= old('image_path') ?>" 
                           placeholder="/images/rewards/default.png">
                    <small class="form-text text-muted">Leave blank for default image</small>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="available" name="available" value="1" 
                           <?= old('available') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="available">
                        Available for purchase
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create Reward
                    </button>
                    <a href="<?= base_url('/admin/manage-rewards') ?>" class="btn btn-secondary ms-2">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->include('admin/layout/footer') ?>