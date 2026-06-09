<?= $this->include('admin/layout/header') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0">
            <i class="fas fa-trophy text-primary me-2"></i>
            Edit Achievement: <?= esc($achievement->title) ?>
        </h2>
        <p class="text-muted">Update achievement information</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?= base_url('/admin/manage-achievements') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Achievements
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?= base_url('/admin/edit-achievement/' . $achievement->id) ?>">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('title') ? 'is-invalid' : '' ?>" 
                           id="title" name="title" value="<?= old('title', $achievement->title) ?>" required>
                    <?php if (isset($validation) && $validation->hasError('title')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('title') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="level_required" class="form-label">Level Required *</label>
                    <input type="number" class="form-control <?= isset($validation) && $validation->hasError('level_required') ? 'is-invalid' : '' ?>" 
                           id="level_required" name="level_required" value="<?= old('level_required', $achievement->level_required) ?>" min="1" required>
                    <?php if (isset($validation) && $validation->hasError('level_required')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('level_required') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description *</label>
                <textarea class="form-control <?= isset($validation) && $validation->hasError('description') ? 'is-invalid' : '' ?>" 
                          id="description" name="description" rows="3" required><?= old('description', $achievement->description) ?></textarea>
                <?php if (isset($validation) && $validation->hasError('description')): ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('description') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="category" class="form-label">Category *</label>
                    <select class="form-control <?= isset($validation) && $validation->hasError('category') ? 'is-invalid' : '' ?>" 
                            id="category" name="category" required>
                        <option value="level" <?= old('category', $achievement->category) === 'level' ? 'selected' : '' ?>>Level</option>
                        <option value="login_streak" <?= old('category', $achievement->category) === 'login_streak' ? 'selected' : '' ?>>Login Streak</option>
                        <option value="spend_points" <?= old('category', $achievement->category) === 'spend_points' ? 'selected' : '' ?>>Spend Points</option>
                        <option value="referral" <?= old('category', $achievement->category) === 'referral' ? 'selected' : '' ?>>Referral</option>
                        <option value="special" <?= old('category', $achievement->category) === 'special' ? 'selected' : '' ?>>Special</option>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('category')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('category') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="tier" class="form-label">Tier *</label>
                    <select class="form-control <?= isset($validation) && $validation->hasError('tier') ? 'is-invalid' : '' ?>" 
                            id="tier" name="tier" required>
                        <option value="bronze" <?= old('tier', $achievement->tier) === 'bronze' ? 'selected' : '' ?>>Bronze</option>
                        <option value="silver" <?= old('tier', $achievement->tier) === 'silver' ? 'selected' : '' ?>>Silver</option>
                        <option value="gold" <?= old('tier', $achievement->tier) === 'gold' ? 'selected' : '' ?>>Gold</option>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('tier')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('tier') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="image_path" class="form-label">Image Path</label>
                    <input type="text" class="form-control" 
                           id="image_path" name="image_path" value="<?= old('image_path', $achievement->image_path) ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Achievement
                    </button>
                    <a href="<?= base_url('/admin/manage-achievements') ?>" class="btn btn-secondary ms-2">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->include('admin/layout/footer') ?>