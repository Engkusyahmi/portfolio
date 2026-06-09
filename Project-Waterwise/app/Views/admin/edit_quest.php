<?= $this->include('admin/layout/header') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="mb-0">
            <i class="fas fa-tasks text-primary me-2"></i>
            Edit Quest: <?= esc($quest->title) ?>
        </h2>
        <p class="text-muted">Update quest information</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?= base_url('/admin/manage-quests') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Quests
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?= base_url('/admin/edit-quest/' . $quest->id) ?>">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('title') ? 'is-invalid' : '' ?>" 
                           id="title" name="title" value="<?= old('title', $quest->title) ?>" required>
                    <?php if (isset($validation) && $validation->hasError('title')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('title') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="type" class="form-label">Type *</label>
                    <select class="form-control <?= isset($validation) && $validation->hasError('type') ? 'is-invalid' : '' ?>" 
                            id="type" name="type" required>
                        <option value="daily" <?= old('type', $quest->type) === 'daily' ? 'selected' : '' ?>>Daily</option>
                        <option value="weekly" <?= old('type', $quest->type) === 'weekly' ? 'selected' : '' ?>>Weekly</option>
                        <option value="special" <?= old('type', $quest->type) === 'special' ? 'selected' : '' ?>>Special</option>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('type')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('type') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description *</label>
                <textarea class="form-control <?= isset($validation) && $validation->hasError('description') ? 'is-invalid' : '' ?>" 
                          id="description" name="description" rows="3" required><?= old('description', $quest->description) ?></textarea>
                <?php if (isset($validation) && $validation->hasError('description')): ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('description') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="xp_reward" class="form-label">XP Reward *</label>
                    <input type="number" class="form-control <?= isset($validation) && $validation->hasError('xp_reward') ? 'is-invalid' : '' ?>" 
                           id="xp_reward" name="xp_reward" value="<?= old('xp_reward', $quest->xp_reward) ?>" min="1" required>
                    <?php if (isset($validation) && $validation->hasError('xp_reward')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('xp_reward') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="ecopoints_reward" class="form-label">EcoPoints Reward *</label>
                    <input type="number" class="form-control <?= isset($validation) && $validation->hasError('ecopoints_reward') ? 'is-invalid' : '' ?>" 
                           id="ecopoints_reward" name="ecopoints_reward" value="<?= old('ecopoints_reward', $quest->ecopoints_reward) ?>" min="1" required>
                    <?php if (isset($validation) && $validation->hasError('ecopoints_reward')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('ecopoints_reward') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Quest
                    </button>
                    <a href="<?= base_url('/admin/manage-quests') ?>" class="btn btn-secondary ms-2">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->include('admin/layout/footer') ?>